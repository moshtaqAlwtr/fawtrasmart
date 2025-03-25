<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Notification;
use App\Models\notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VisitController extends Controller
{

    // عرض جميع الزيارات
    public function index()
    {
        $visits = Visit::with(['employee', 'client'])
                      ->orderBy('visit_date', 'desc')
                      ->get();
        return response()->json($visits);
    }

    // عرض تفاصيل زيارة معينة
    public function show($id)
    {
        $visit = Visit::with(['employee', 'client'])->find($id);
        if ($visit) {
            return response()->json($visit);
        }
        return response()->json(['message' => 'الزيارة غير موجودة'], 404);
    }

    // تسجيل زيارة جديدة يدويًا
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'client_id' => 'required|exists:clients,id',
            'visit_date' => 'required|date',
            'status' => 'required|in:present,absent',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $client = Client::find($request->client_id);
        $clientLocation = $client->locations()->latest()->first();

        if ($clientLocation) {
            $distance = $this->calculateDistance(
                $clientLocation->latitude,
                $clientLocation->longitude,
                $request->latitude,
                $request->longitude
            );

            if ($distance < 100) {
                $visit = Visit::create([
                    'employee_id' => $request->employee_id,
                    'client_id' => $request->client_id,
                    'visit_date' => $request->visit_date,
                    'status' => $request->status,
                    'employee_latitude' => $request->latitude,
                    'employee_longitude' => $request->longitude,
                    'arrival_time' => now(),
                    'notes' => 'تم تسجيل الزيارة يدوياً'
                ]);

                $this->sendNotificationToManager($visit, 'visit_arrival');
                return response()->json($visit, 201);
            } else {
                return response()->json(['message' => 'أنت لست قريبًا من العميل (يجب أن تكون ضمن 100 متر)'], 400);
            }
        }

        return response()->json(['message' => 'العميل ليس لديه موقع مسجل'], 400);
    }

    // حساب المسافة بين نقطتين (بالمتر)
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // نصف قطر الأرض بالمتر

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(
            pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)
        )); // تم إصلاح الأقواس هنا

        return $angle * $earthRadius;
    }

    // إرسال إشعار للمدير
    private function sendNotificationToManager($visit, $type)
    {
        $title = '';
        $description = '';

        if ($type === 'visit_arrival') {
            $title = 'وصول موظف';
            $description = 'الموظف ' . $visit->employee->name . ' قام بزيارة العميل ' . $visit->client->trade_name . ' في ' . $visit->arrival_time;
        } elseif ($type === 'visit_departure') {
            $title = 'انصراف موظف';
            $description = 'الموظف ' . $visit->employee->name . ' انصرف من زيارة العميل ' . $visit->client->trade_name . ' في ' . $visit->departure_time;
        }

        notifications::create([
            'type' => 'visit',
            'title' => $title,
            'description' => $description,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Log::info('Notification sent to manager', [
            'type' => $type,
            'visit_id' => $visit->id
        ]);
    }
    public function storeEmployeeLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $employee = Auth::user();
        $employeeId = $employee->id;

        // تحديث موقع الموظف
        $location = Location::updateOrCreate(
            ['employee_id' => $employeeId],
            [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'recorded_at' => now()
            ]
        );

        // التحقق من الزيارات التلقائية
        $this->checkDistanceAndLogVisit($employeeId, $request->latitude, $request->longitude);
        $this->checkExitAndLogDeparture($employeeId, $request->latitude, $request->longitude);

        return response()->json([
            'message' => 'تم تحديث الموقع بنجاح',
            'location' => $location,
        ], 200);
    }

    /**
     * التحقق من المسافة وتسجيل الزيارة تلقائيًا
     */
    private function checkDistanceAndLogVisit($employeeId, $latitude, $longitude)
    {
        $clients = Client::with(['locations' => function($query) {
            $query->latest()->limit(1);
        }])->has('locations')->get();

        foreach ($clients as $client) {
            $clientLocation = $client->locations->first();
            if (!$clientLocation) continue;

            $distance = $this->calculateDistance(
                $clientLocation->latitude,
                $clientLocation->longitude,
                $latitude,
                $longitude
            );

            if ($distance < 100) {
                $lastVisit = Visit::where('employee_id', $employeeId)
                    ->where('client_id', $client->id)
                    ->whereDate('visit_date', today())
                    ->latest()
                    ->first();

                // شروط إنشاء زيارة جديدة
                $shouldCreateNew = !$lastVisit ||
                                 ($lastVisit->departure_time && now()->diffInMinutes($lastVisit->departure_time) > 30) ||
                                 (!$lastVisit->departure_time && now()->diffInMinutes($lastVisit->arrival_time) > 120);

                if ($shouldCreateNew) {
                    if ($lastVisit && !$lastVisit->departure_time) {
                        $this->closeVisit($lastVisit, 'تم إغلاق الزيارة السابقة تلقائياً لبدء زيارة جديدة');
                    }

                    $visit = $this->createNewAutoVisit($employeeId, $client->id, $latitude, $longitude);
                    $this->sendVisitNotification($visit, 'زيارة جديدة', "تم تسجيل وصول الموظف {$visit->employee->name} إلى {$visit->client->trade_name}");
                }
            }
        }
    }

    /**
     * التحقق من الخروج من نطاق العميل وتسجيل الانصراف
     */
    private function checkExitAndLogDeparture($employeeId, $latitude, $longitude)
    {
        $activeVisits = Visit::with(['client.locations' => function($query) {
            $query->latest()->limit(1);
        }])
        ->where('employee_id', $employeeId)
        ->whereDate('visit_date', today())
        ->whereNotNull('arrival_time')
        ->whereNull('departure_time')
        ->get();

        foreach ($activeVisits as $visit) {
            if ($visit->client->locations->isEmpty()) continue;

            $clientLoc = $visit->client->locations->first();
            $distance = $this->calculateDistance(
                $clientLoc->latitude,
                $clientLoc->longitude,
                $latitude,
                $longitude
            );

            $shouldCloseVisit = $distance > 100 || now()->diffInMinutes($visit->arrival_time) > 180;

            if ($shouldCloseVisit) {
                $this->closeVisit($visit, 'تم تسجيل المغادرة تلقائياً ' . ($distance > 100 ? 'بسبب الابتعاد عن الموقع' : 'بسبب انتهاء المدة'));
                $this->sendVisitNotification($visit, 'انتهاء زيارة', "تم تسجيل مغادرة الموظف {$visit->employee->name} من {$visit->client->trade_name}");
            }
        }
    }

    /**
     * إنشاء زيارة تلقائية جديدة
     */
    private function createNewAutoVisit($employeeId, $clientId, $lat, $lng)
    {
        return Visit::create([
            'employee_id' => $employeeId,
            'client_id' => $clientId,
            'visit_date' => now(),
            'status' => 'present',
            'employee_latitude' => $lat,
            'employee_longitude' => $lng,
            'arrival_time' => now(),
            'notes' => 'زيارة تلقائية - ' . now()->format('H:i')
        ]);
    }

    /**
     * إغلاق زيارة موجودة
     */
    private function closeVisit($visit, $reason)
    {
        $visit->update([
            'departure_time' => now(),
            'notes' => ($visit->notes ?? '') . "\n" . $reason . ' - ' . now()->format('H:i')
        ]);
    }

    /**
     * إرسال إشعارات الزيارة
     */
    private function sendVisitNotification($visit, $title, $description)
    {
        Notification::create([
            'user_id' => $visit->employee->manager_id ?? null, // إرسال للمدير
            'type' => 'visit_auto',
            'title' => $title,
            'description' => $description,
            'related_id' => $visit->id,
            'related_type' => 'visit',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // يمكنك إضافة إرسال إشعارات push هنا إذا كان متوفراً
        Log::info('Visit Notification Sent', [
            'visit_id' => $visit->id,
            'title' => $title,
            'description' => $description
        ]);
    }


    // تحديث زيارة معينة
    public function update(Request $request, $id)
    {
        $visit = Visit::find($id);
        if (!$visit) {
            return response()->json(['message' => 'الزيارة غير موجودة'], 404);
        }

        $request->validate([
            'employee_id' => 'sometimes|exists:users,id',
            'client_id' => 'sometimes|exists:clients,id',
            'visit_date' => 'sometimes|date',
            'status' => 'sometimes|in:present,absent',
            'employee_latitude' => 'sometimes|numeric',
            'employee_longitude' => 'sometimes|numeric',
            'arrival_time' => 'sometimes|date',
            'departure_time' => 'sometimes|date|after:arrival_time',
            'notes' => 'sometimes|string'
        ]);

        $visit->update($request->all());
        return response()->json($visit);
    }

    // حذف زيارة معينة
    public function destroy($id)
    {
        $visit = Visit::find($id);
        if (!$visit) {
            return response()->json(['message' => 'الزيارة غير موجودة'], 404);
        }

        $visit->delete();
        return response()->json(['message' => 'تم حذف الزيارة بنجاح']);
    }

    // الحصول على زيارات الموظف الحالي
    public function myVisits()
    {
        $visits = Visit::with('client')
            ->where('employee_id', auth()->id())
            ->orderBy('visit_date', 'desc')
            ->get();

        return response()->json($visits);
    }
}
