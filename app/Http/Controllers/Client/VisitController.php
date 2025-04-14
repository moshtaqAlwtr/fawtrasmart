<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientRelation;
use App\Models\Invoice;
use App\Models\Location;
use App\Models\notifications;
use App\Models\PaymentsProcess;
use App\Models\Region_groub;
use App\Models\User;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VisitController extends Controller
{
    // ثوابت النظام المعدلة
    private const ARRIVAL_DISTANCE = 100; // مسافة الوصول بالمتر (تم تخفيضها)
    private const DEPARTURE_DISTANCE = 150; // مسافة الانصراف بالمتر (تم تخفيضها)
    private const MIN_DEPARTURE_MINUTES = 3; // أقل مدة للانصراف (تم تخفيضها)
    private const AUTO_DEPARTURE_TIMEOUT = 60; // مهلة الانصراف التلقائي (تم تخفيضها)
    private const VISIT_COOLDOWN = 30; // مدة الانتظار بين الزيارات (دقيقة)

    // عرض جميع الزيارات
    public function index()
    {
        $visits = Visit::with(['employee', 'client'])
            ->orderBy('visit_date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $visits,
            'count' => $visits->count()
        ]);
    }

    // عرض تفاصيل زيارة
    public function show($id)
    {
        $visit = Visit::with(['employee', 'client'])->find($id);

        if (!$visit) {
            return response()->json([
                'success' => false,
                'message' => 'الزيارة غير موجودة'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $visit
        ]);
    }

    // تسجيل زيارة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'visit_date' => 'required|date',
            'status' => 'required|in:present,absent',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'notes' => 'nullable|string'
        ]);

        $employeeId = Auth::id();
        $client = Client::findOrFail($request->client_id);

        // التحقق من قرب الموظف من العميل
        if (!$this->checkClientProximity($request->latitude, $request->longitude, $client->id, self::ARRIVAL_DISTANCE)) {
            return response()->json([
                'success' => false,
                'message' => 'يجب أن تكون ضمن '.self::ARRIVAL_DISTANCE.' متر من العميل لتسجيل الزيارة'
            ], 400);
        }

        $visit = Visit::create([
            'employee_id' => $employeeId,
            'client_id' => $client->id,
            'visit_date' => $request->visit_date,
            'status' => $request->status,
            'employee_latitude' => $request->latitude,
            'employee_longitude' => $request->longitude,
            'arrival_time' => now(),
            'notes' => $request->notes ?? 'تم تسجيل الزيارة يدوياً',
            'departure_notification_sent' => false,
        ]);

        $this->sendVisitNotifications($visit, 'arrival');
        $this->sendEmployeeNotification($employeeId, 'تم تسجيل وصولك للعميل ' . $client->trade_name, 'وصول يدوي');

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الزيارة بنجاح',
            'data' => $visit
        ], 201);
    }

    // تسجيل الانصراف يدوياً
    public function manualDeparture(Request $request, $visitId)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'notes' => 'nullable|string'
        ]);

        $visit = Visit::findOrFail($visitId);
        $employeeId = Auth::id();

        if ($visit->employee_id != $employeeId) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح لك بتسجيل الانصراف لهذه الزيارة'
            ], 403);
        }

        if ($visit->departure_time) {
            return response()->json([
                'success' => false,
                'message' => 'تم تسجيل الانصراف مسبقاً لهذه الزيارة'
            ], 400);
        }

        $visit->update([
            'departure_time' => now(),
            'departure_latitude' => $request->latitude,
            'departure_longitude' => $request->longitude,
            'notes' => ($visit->notes ?? '') . "\n" . ($request->notes ?? 'تم تسجيل الانصراف يدوياً'),
            'departure_notification_sent' => true,
        ]);

        $this->sendVisitNotifications($visit, 'departure');
        $this->sendEmployeeNotification(
            $employeeId,
            'تم تسجيل انصرافك من العميل ' . $visit->client->trade_name,
            'انصراف يدوي'
        );

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الانصراف بنجاح',
            'data' => $visit
        ]);
    }

    // تخزين موقع الموظف تلقائياً (محدثة)
    public function storeLocationEnhanced(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'accuracy' => 'nullable|numeric',
            'isExit' => 'nullable|boolean'
        ]);

        $employeeId = Auth::id();
        $now = now();

        try {
            // تسجيل موقع الموظف
            $location = Location::updateOrCreate(
                ['employee_id' => $employeeId],
                [
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'accuracy' => $request->accuracy,
                    'recorded_at' => $now,
                ]
            );

            Log::info('Employee location updated', [
                'employee_id' => $employeeId,
                'location' => $location,
                'isExit' => $request->isExit
            ]);

            // التحقق من الانصراف في جميع الحالات
            $this->checkForDepartures($employeeId, $request->latitude, $request->longitude);

            // إذا كانت نقاط خروج
            if ($request->isExit) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم تسجيل موقع الخروج بنجاح',
                    'location' => $location,
                    'departures_checked' => true
                ]);
            }

            // البحث عن العملاء القريبين (فقط إذا لم تكن نقاط خروج)
            $nearbyClients = $this->getNearbyClients(
                $request->latitude,
                $request->longitude,
                self::ARRIVAL_DISTANCE
            );

            Log::info('Nearby clients found', [
                'count' => count($nearbyClients),
                'clients' => $nearbyClients->pluck('id')
            ]);

            // تسجيل الزيارات للعملاء القريبين
            $recordedVisits = [];
            foreach ($nearbyClients as $client) {
                $visit = $this->recordVisitAutomatically(
                    $employeeId,
                    $client->id,
                    $request->latitude,
                    $request->longitude
                );

                if ($visit) {
                    $recordedVisits[] = $visit;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الموقع بنجاح',
                'nearby_clients' => count($nearbyClients),
                'recorded_visits' => $recordedVisits,
                'location' => $location,
                'departures_checked' => true
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update location: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث الموقع: ' . $e->getMessage()
            ], 500);
        }
    }

    // تسجيل زيارة تلقائية (محدثة)
    private function recordVisitAutomatically($employeeId, $clientId, $latitude, $longitude)
    {
        $now = now();
        $today = $now->toDateString();

        $lastVisit = Visit::where('employee_id', $employeeId)
            ->where('client_id', $clientId)
            ->whereDate('visit_date', $today)
            ->orderBy('visit_date', 'desc')
            ->first();

        if (!$lastVisit) {
            return $this->createNewVisit($employeeId, $clientId, $latitude, $longitude, 'زيارة تلقائية - أول زيارة اليوم');
        }

        if (!$lastVisit->departure_time) {
            Log::info('Skipping new visit - previous visit has no departure', [
                'visit_id' => $lastVisit->id,
                'arrival_time' => $lastVisit->arrival_time
            ]);
            return null;
        }

        $minutesSinceDeparture = $now->diffInMinutes($lastVisit->departure_time);

        if ($minutesSinceDeparture > self::VISIT_COOLDOWN) {
            return $this->createNewVisit($employeeId, $clientId, $latitude, $longitude, 'زيارة تلقائية - عودة بعد انصراف');
        }

        Log::info('Skipping new visit - recent departure', [
            'visit_id' => $lastVisit->id,
            'minutes_since_departure' => $minutesSinceDeparture
        ]);

        return null;
    }

    // إنشاء زيارة جديدة
    private function createNewVisit($employeeId, $clientId, $latitude, $longitude, $notes)
    {
        $client = Client::find($clientId);

        $visit = Visit::create([
            'employee_id' => $employeeId,
            'client_id' => $clientId,
            'visit_date' => now(),
            'status' => 'present',
            'employee_latitude' => $latitude,
            'employee_longitude' => $longitude,
            'arrival_time' => now(),
            'notes' => $notes,
            'departure_notification_sent' => false,
        ]);

        Log::info('New visit created automatically', [
            'visit_id' => $visit->id,
            'client_id' => $clientId,
            'employee_id' => $employeeId
        ]);

        $this->sendVisitNotifications($visit, 'arrival');
        $this->sendEmployeeNotification(
            $employeeId,
            'تم تسجيل وصولك للعميل ' . $client->trade_name,
            'وصول تلقائي'
        );

        return $visit;
    }

    // التحقق من الانصراف (محدثة)
    private function checkForDepartures($employeeId, $latitude, $longitude)
    {
        $activeVisits = Visit::where('employee_id', $employeeId)
            ->whereDate('visit_date', now()->toDateString())
            ->whereNotNull('arrival_time')
            ->whereNull('departure_time')
            ->with(['client' => function($query) {
                $query->with(['locations' => function($q) {
                    $q->latest()->limit(1);
                }]);
            }])
            ->get();

        Log::info('Checking for departures - Active visits count: ' . $activeVisits->count(), [
            'employee_id' => $employeeId,
            'current_location' => [$latitude, $longitude],
            'active_visits' => $activeVisits->pluck('id')
        ]);

        foreach ($activeVisits as $visit) {
            try {
                $this->processVisitDeparture($visit, $latitude, $longitude);
            } catch (\Exception $e) {
                Log::error('Error processing visit departure', [
                    'visit_id' => $visit->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }
    }

    // معالجة انصراف الزيارة (محدثة)
    private function processVisitDeparture($visit, $latitude, $longitude)
    {
        // الحصول على أحدث موقع للعميل أو استخدام موقع الوصول كبديل
        $clientLocation = $visit->client->locations()->latest()->first();

        if (!$clientLocation) {
            // إذا لم يكن هناك موقع مسجل للعميل، نستخدم موقع الوصول للزيارة
            $clientLat = $visit->employee_latitude;
            $clientLng = $visit->employee_longitude;
            Log::warning('Using visit arrival location as client location', [
                'visit_id' => $visit->id,
                'client_id' => $visit->client_id
            ]);
        } else {
            $clientLat = $clientLocation->latitude;
            $clientLng = $clientLocation->longitude;
        }

        $distance = $this->calculateDistance(
            $clientLat,
            $clientLng,
            $latitude,
            $longitude
        );

        $minutesSinceArrival = now()->diffInMinutes($visit->arrival_time);

        Log::info('Visit departure check details', [
            'visit_id' => $visit->id,
            'client_id' => $visit->client_id,
            'distance' => round($distance, 2) . ' meters',
            'distance_threshold' => self::DEPARTURE_DISTANCE,
            'minutes_since_arrival' => $minutesSinceArrival,
            'min_departure_minutes' => self::MIN_DEPARTURE_MINUTES,
            'auto_departure_timeout' => self::AUTO_DEPARTURE_TIMEOUT,
            'client_location' => [$clientLat, $clientLng],
            'current_location' => [$latitude, $longitude]
        ]);

        // الانصراف عند الابتعاد (مع وقت كافٍ)
        if ($distance > self::DEPARTURE_DISTANCE && $minutesSinceArrival > self::MIN_DEPARTURE_MINUTES) {
            $this->recordDeparture($visit, $latitude, $longitude, round($distance), 'auto_distance');
            return;
        }

        // الانصراف بعد مدة طويلة (بغض النظر عن الموقع)
        if ($minutesSinceArrival > self::AUTO_DEPARTURE_TIMEOUT) {
            $this->recordDeparture($visit, $latitude, $longitude, $minutesSinceArrival, 'auto_timeout');
            return;
        }

        Log::debug('Visit does not meet departure conditions yet', [
            'visit_id' => $visit->id,
            'reason' => 'Neither distance nor timeout conditions met'
        ]);
    }

    // تسجيل الانصراف
    private function recordDeparture($visit, $latitude, $longitude, $value, $type)
    {
        $notes = [
            'auto_distance' => 'تم تسجيل الانصراف تلقائياً عند الابتعاد عن العميل بمسافة '.$value.' متر',
            'auto_timeout' => 'تم تسجيل الانصراف تلقائياً بعد مضي '.$value.' دقيقة على الوصول'
        ];

        $visit->update([
            'departure_time' => now(),
            'departure_latitude' => $latitude,
            'departure_longitude' => $longitude,
            'departure_notification_sent' => true,
            'notes' => ($visit->notes ?? '')."\n".$notes[$type],
        ]);

        Log::info('Departure recorded: '.$type, [
            'visit_id' => $visit->id,
            'value' => $value
        ]);

        $this->sendVisitNotifications($visit, 'departure');
        $this->sendEmployeeNotification(
            $visit->employee_id,
            'تم تسجيل انصرافك من العميل ' . $visit->client->trade_name,
            'انصراف تلقائي'
        );
    }

    // البحث عن العملاء القريبين
    private function getNearbyClients($latitude, $longitude, $radius)
    {
        return Client::with('locations')
            ->whereHas('locations', function($query) use ($latitude, $longitude, $radius) {
                $query->whereRaw("
                    ST_Distance_Sphere(
                        POINT(longitude, latitude),
                        POINT(?, ?)
                    ) <= ?
                ", [$longitude, $latitude, $radius]);
            })
            ->get();
    }

    // التحقق من قرب الموظف من العميل
    private function checkClientProximity($latitude, $longitude, $clientId, $maxDistance)
    {
        $client = Client::with('locations')->findOrFail($clientId);
        $clientLocation = $client->locations()->latest()->first();

        if (!$clientLocation) {
            return false;
        }

        $distance = $this->calculateDistance(
            $clientLocation->latitude,
            $clientLocation->longitude,
            $latitude,
            $longitude
        );

        return $distance <= $maxDistance;
    }

    // حساب المسافة بين نقطتين
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(
            pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)
        ));

        return $angle * $earthRadius;
    }

    // إرسال إشعارات الزيارة
    private function sendVisitNotifications($visit, $type)
    {
        $employeeName = $visit->employee->name ?? 'غير معروف';
        $clientName = $visit->client->trade_name ?? 'غير معروف';
        $time = $type === 'arrival'
            ? Carbon::parse($visit->arrival_time)->format('H:i')
            : Carbon::parse($visit->departure_time)->format('H:i');

        // إرسال إشعار داخلي
        notifications::create([
            'user_id' => $visit->employee_id,
            'type' => 'visit',
            'title' => $type === 'arrival' ? 'وصول إلى عميل' : 'انصراف من عميل',
            'message' => $type === 'arrival'
                ? "تم تسجيل وصولك إلى العميل: $clientName"
                : "تم تسجيل انصرافك من العميل: $clientName",
            'read' => false,
            'data' => [
                'visit_id' => $visit->id,
                'client_id' => $visit->client_id,
                'type' => $type
            ]
        ]);

        // إرسال إشعار إلى المدير
        $managers = User::role('manager')->get();
        foreach ($managers as $manager) {
            notifications::create([
                'user_id' => $manager->id,
                'type' => 'visit',
                'title' => $type === 'arrival' ? 'وصول موظف إلى عميل' : 'انصراف موظف من عميل',
                'message' => $type === 'arrival'
                    ? "الموظف $employeeName وصل إلى العميل $clientName"
                    : "الموظف $employeeName انصرف من العميل $clientName",
                'read' => false,
                'data' => [
                    'visit_id' => $visit->id,
                    'employee_id' => $visit->employee_id,
                    'client_id' => $visit->client_id,
                    'type' => $type
                ]
            ]);
        }

        // إرسال إشعار عبر التليجرام
        $this->sendTelegramNotification($visit, $type);
    }

    // إرسال إشعار للموظف
    private function sendEmployeeNotification($employeeId, $message, $title)
    {
        notifications::create([
            'user_id' => $employeeId,
            'type' => 'visit_notification',
            'title' => $title,
            'message' => $message,
            'read' => false,
            'data' => [
                'type' => 'visit_update'
            ]
        ]);
    }

    // إرسال إشعار التليجرام
    private function sendTelegramNotification($visit, $type)
    {
        $employeeName = $visit->employee->name ?? 'غير معروف';
        $clientName = $visit->client->trade_name ?? 'غير معروف';
        $time = $type === 'arrival'
            ? Carbon::parse($visit->arrival_time)->format('H:i')
            : Carbon::parse($visit->departure_time)->format('H:i');

        $message = "🔄 *حركة زيارة عملاء*\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━\n";
        $message .= $type === 'arrival' ? "✅ *وصول*" : "🛑 *انصراف*\n";
        $message .= "👤 *الموظف:* `$employeeName`\n";
        $message .= "🏢 *العميل:* `$clientName`\n";
        $message .= "⏱ *الوقت:* `$time`\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━\n";

        try {
            $telegramApiUrl = 'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMessage';

            Http::post($telegramApiUrl, [
                'chat_id' => env('TELEGRAM_CHANNEL_ID'),
                'text' => $message,
                'parse_mode' => 'Markdown',
                'timeout' => 60,
            ]);
        } catch (\Exception $e) {
            Log::error('فشل إرسال إشعار التليجرام: ' . $e->getMessage());
        }
    }

    // تحديث زيارة
    public function update(Request $request, $id)
    {
        $visit = Visit::find($id);

        if (!$visit) {
            return response()->json([
                'success' => false,
                'message' => 'الزيارة غير موجودة'
            ], 404);
        }

        $request->validate([
            'status' => 'sometimes|in:present,absent',
            'arrival_time' => 'sometimes|date',
            'departure_time' => 'sometimes|date|after:arrival_time',
            'notes' => 'sometimes|string',
        ]);

        if ($visit->employee_id != Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح لك بتعديل هذه الزيارة'
            ], 403);
        }

        $visit->update($request->all());

        if ($request->has('departure_time')) {
            $this->sendVisitNotifications($visit, 'departure');
            $this->sendEmployeeNotification(
                $visit->employee_id,
                'تم تحديث وقت انصرافك من العميل ' . $visit->client->trade_name,
                'تحديث انصراف'
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الزيارة بنجاح',
            'data' => $visit
        ]);
    }

    // حذف زيارة
    public function destroy($id)
    {
        $visit = Visit::find($id);

        if (!$visit) {
            return response()->json([
                'success' => false,
                'message' => 'الزيارة غير موجودة'
            ], 404);
        }

        if ($visit->employee_id != Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح لك بحذف هذه الزيارة'
            ], 403);
        }

        $visit->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الزيارة بنجاح'
        ]);
    }

    // زيارات الموظف الحالي
    public function myVisits()
    {
        $visits = Visit::with('client')
            ->where('employee_id', Auth::id())
            ->orderBy('visit_date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $visits,
            'count' => $visits->count()
        ]);
    }

    // زيارات اليوم
    public function getTodayVisits()
    {
        $today = now()->toDateString();

        $visits = Visit::with(['employee', 'client'])
            ->whereDate('visit_date', $today)
            ->orderBy('visit_date', 'desc')
            ->get()
            ->map(function ($visit) {
                return [
                    'id' => $visit->id,
                    'client_name' => $visit->client->trade_name ?? 'غير معروف',
                    'employee_name' => $visit->employee->name ?? 'غير معروف',
                    'arrival_time' => $visit->arrival_time ? $visit->arrival_time->format('H:i') : '--:--',
                    'departure_time' => $visit->departure_time ? $visit->departure_time->format('H:i') : '--:--',
                    'status' => $visit->status,
                    'created_at' => $visit->created_at->toDateTimeString(),
                ];
            });

        return response()->json([
            'success' => true,
            'visits' => $visits,
            'count' => $visits->count()
        ]);
    }

    // تحليلات حركة الزيارات
    public function tracktaff()
    {
        $groups = Region_groub::with('clients')->get();

        // بداية جزء حساب التاريخ الأدنى
        $invoiceDate = Invoice::min('created_at');
        $paymentDate = PaymentsProcess::min('created_at');
        $noteDate = ClientRelation::min('created_at');
        $visitDate = Visit::min('created_at');

        $minDate = collect([$invoiceDate, $paymentDate, $noteDate, $visitDate])
            ->filter()
            ->min();
        // نهاية جزء حساب التاريخ الأدنى

        $start = \Carbon\Carbon::parse($minDate)->startOfWeek();
        $now = now()->endOfWeek();
        $totalWeeks = $start->diffInWeeks($now) + 1;

        $weeks = [];
        for ($i = 0; $i < $totalWeeks; $i++) {
            $weeks[] = [
                'start' => $start->copy()->addWeeks($i)->format('Y-m-d'),
                'end' => $start->copy()->addWeeks($i)->endOfWeek()->format('Y-m-d'),
            ];
        }

        return view('reports.sals.traffic_analytics', compact('groups', 'weeks'));
    }
}
