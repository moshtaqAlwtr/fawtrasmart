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

    // تخزين موقع الموظف تلقائيًا والتحقق من الحضور/الانصراف
    public function storeEmployeeLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $employeeId = auth()->id();

        Log::info('Employee location update', [
            'employee_id' => $employeeId,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'time' => now()
        ]);

        // تحديث أو إنشاء موقع الموظف
        $location = Location::updateOrCreate(
            ['employee_id' => $employeeId],
            [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'recorded_at' => now()
            ]
        );

        // التحقق من الحضور التلقائي
        $this->checkDistanceAndLogVisit($employeeId, $request->latitude, $request->longitude);

        // التحقق من الانصراف التلقائي
        $this->checkExitAndLogDeparture($employeeId, $request->latitude, $request->longitude);

        return response()->json([
            'message' => 'تم تحديث الموقع بنجاح',
            'location' => $location,
        ], 200);
    }

    // التحقق من المسافة وتسجيل الزيارة تلقائيًا
    private function checkDistanceAndLogVisit($employeeId, $latitude, $longitude)
    {
        Log::info('Checking distance for automatic visit logging', [
            'employee_id' => $employeeId,
            'latitude' => $latitude,
            'longitude' => $longitude
        ]);

        $clients = Client::has('locations')->get();

        foreach ($clients as $client) {
            $clientLocation = $client->locations()->latest()->first();

            $distance = $this->calculateDistance(
                $clientLocation->latitude,
                $clientLocation->longitude,
                $latitude,
                $longitude
            );

            Log::info('Distance calculation result', [
                'client_id' => $client->id,
                'distance' => $distance,
                'threshold' => 100
            ]);

            if ($distance < 100) {
                $existingVisit = Visit::where('employee_id', $employeeId)
                    ->where('client_id', $client->id)
                    ->whereDate('visit_date', now()->toDateString())
                    ->whereNull('departure_time')
                    ->first();

                if (!$existingVisit) {
                    $visit = Visit::create([
                        'employee_id' => $employeeId,
                        'client_id' => $client->id,
                        'visit_date' => now(),
                        'status' => 'present',
                        'employee_latitude' => $latitude,
                        'employee_longitude' => $longitude,
                        'arrival_time' => now(),
                        'notes' => 'تم تسجيل الحضور تلقائياً عند الاقتراب من العميل'
                    ]);

                    Log::info('New visit created automatically', [
                        'visit_id' => $visit->id,
                        'arrival_time' => $visit->arrival_time
                    ]);

                    $this->sendNotificationToManager($visit, 'visit_arrival');
                } else {
                    if (is_null($existingVisit->arrival_time)) {
                        $existingVisit->update([
                            'arrival_time' => now(),
                            'employee_latitude' => $latitude,
                            'employee_longitude' => $longitude,
                            'notes' => 'تم تحديث وقت الحضور تلقائياً'
                        ]);

                        Log::info('Existing visit updated with arrival time', [
                            'visit_id' => $existingVisit->id,
                            'arrival_time' => $existingVisit->arrival_time
                        ]);
                    }
                }
            }
        }
    }

    // التحقق من الخروج من نطاق العميل وتسجيل الانصراف
    private function checkExitAndLogDeparture($employeeId, $latitude, $longitude)
    {
        Log::info('Checking for automatic departure logging', ['employee_id' => $employeeId]);

        $activeVisits = Visit::where('employee_id', $employeeId)
            ->whereDate('visit_date', now()->toDateString())
            ->whereNotNull('arrival_time')
            ->whereNull('departure_time')
            ->get();

        Log::info('Active visits found', ['count' => $activeVisits->count()]);

        foreach ($activeVisits as $visit) {
            $clientLocation = $visit->client->locations()->latest()->first();

            if ($clientLocation) {
                $currentDistance = $this->calculateDistance(
                    $clientLocation->latitude,
                    $clientLocation->longitude,
                    $latitude,
                    $longitude
                );

                Log::info('Current distance from client', [
                    'visit_id' => $visit->id,
                    'distance' => $currentDistance
                ]);

                if ($currentDistance > 100) {
                    $visit->update([
                        'departure_time' => now(),
                        'notes' => ($visit->notes ?? '') . "\nتم تسجيل الانصراف تلقائياً عند الابتعاد عن العميل"
                    ]);

                    Log::info('Departure time recorded', [
                        'visit_id' => $visit->id,
                        'departure_time' => $visit->departure_time
                    ]);

                    $this->sendNotificationToManager($visit, 'visit_departure');
                }
            }
        }
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
