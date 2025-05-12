<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientRelation;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Location;
use App\Models\notifications;
use App\Models\PaymentsProcess;
use App\Models\Receipt;
use App\Models\Region_groub;
use App\Models\User;
use App\Models\Visit;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use TCPDF;

class VisitController extends Controller
{
    // ثوابت النظام المعدلة
    private const ARRIVAL_DISTANCE = 100; // مسافة الوصول بالمتر (تم تخفيضها)
    private const DEPARTURE_DISTANCE = 150; // مسافة الانصراف بالمتر (تم تخفيضها)
    private const MIN_DEPARTURE_MINUTES = 3; // أقل مدة للانصراف (تم تخفيضها)
    private const AUTO_DEPARTURE_TIMEOUT = 10; // مهلة الانصراف التلقائي (تم تعديلها إلى 10 دقائق)
    private const VISIT_COOLDOWN = 30; // مدة الانتظار بين الزيارات (دقيقة)
    private const FORCE_AUTO_DEPARTURE = true; // إضافة خاصية تفعيل الانصراف التلقائي

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

            // معالجة الزيارات التي تحتاج انصراف تلقائي
            $this->processAutoDepartures($employeeId, $request->latitude, $request->longitude);

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
                    // جدولة الانصراف التلقائي للزيارة الجديدة
                    $this->scheduleAutoDeparture($visit);
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

    // جدولة الانصراف التلقائي (دالة جديدة)
    private function scheduleAutoDeparture($visit)
    {
        // إضافة معلومات للسجل
        Log::info('Auto departure scheduled', [
            'visit_id' => $visit->id,
            'client_id' => $visit->client_id,
            'employee_id' => $visit->employee_id,
            'scheduled_time' => now()->addMinutes(self::AUTO_DEPARTURE_TIMEOUT)->format('Y-m-d H:i:s')
        ]);
    }

    // معالجة الانصراف التلقائي للزيارات (دالة جديدة)
    private function processAutoDepartures($employeeId, $latitude, $longitude)
    {
        $activeVisits = Visit::where('employee_id', $employeeId)
            ->whereDate('visit_date', now()->toDateString())
            ->whereNotNull('arrival_time')
            ->whereNull('departure_time')
            ->get();

        Log::info('Processing auto departures', [
            'employee_id' => $employeeId,
            'active_visits_count' => $activeVisits->count(),
            'current_time' => now()->format('Y-m-d H:i:s')
        ]);

        foreach ($activeVisits as $visit) {
            $minutesSinceArrival = now()->diffInMinutes($visit->arrival_time);

            Log::info('Checking visit for auto departure', [
                'visit_id' => $visit->id,
                'arrival_time' => $visit->arrival_time,
                'minutes_since_arrival' => $minutesSinceArrival,
                'auto_departure_timeout' => self::AUTO_DEPARTURE_TIMEOUT
            ]);

            if ($minutesSinceArrival >= self::AUTO_DEPARTURE_TIMEOUT) {
                $this->recordDeparture($visit, $latitude, $longitude, $minutesSinceArrival, 'auto_timeout');
            }
        }
    }
    // التحقق من الانصراف (محدثة)
    private function checkForDepartures($employeeId, $latitude, $longitude)
{
    $activeVisits = Visit::where('employee_id', $employeeId)
        ->whereDate('visit_date', now()->toDateString())
        ->whereNotNull('arrival_time')
        ->whereNull('departure_time')
        ->with(['client.locations'])
        ->get();

    foreach ($activeVisits as $visit) {
        try {
            // حساب الوقت المنقضي
            $minutesSinceArrival = now()->diffInMinutes($visit->arrival_time);

            // التحقق من المسافة
            $clientLocation = $visit->client->locations()->latest()->first();
            $distance = $this->calculateDistance(
                $clientLocation->latitude,
                $clientLocation->longitude,
                $latitude,
                $longitude
            );

            // تسجيل الانصراف في أي من الحالتين:
            if ($minutesSinceArrival >= 10 || $distance >= 100) {
                $reason = $minutesSinceArrival >= 10 ? 'بعد 10 دقائق' : 'بعد الابتعاد بمسافة 100 متر';

                $this->recordDeparture($visit, $latitude, $longitude, $minutesSinceArrival, $reason);
            }
        } catch (\Exception $e) {
            Log::error('Error processing visit departure', [
                'visit_id' => $visit->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
    // معالجة انصراف الزيارة (محدثة)
    private function processVisitDeparture($visit, $latitude, $longitude)
{
    // الحصول على موقع العميل
    $clientLocation = $visit->client->locations()->latest()->first();

    if (!$clientLocation) {
        $clientLat = $visit->employee_latitude;
        $clientLng = $visit->employee_longitude;
    } else {
        $clientLat = $clientLocation->latitude;
        $clientLng = $clientLocation->longitude;
    }

    // حساب المسافة
    $distance = $this->calculateDistance(
        $clientLat,
        $clientLng,
        $latitude,
        $longitude
    );

    // حساب الوقت المنقضي
    $minutesSinceArrival = now()->diffInMinutes($visit->arrival_time);

    // تسجيل الانصراف في أي من الحالتين:
    if ($minutesSinceArrival >= 10 || $distance >= 100) {
        $reason = $minutesSinceArrival >= 10 ? 'بعد 10 دقائق' : 'بعد الابتعاد بمسافة 100 متر';

        $this->recordDeparture($visit, $latitude, $longitude, $minutesSinceArrival, $reason);
    }
}

    // تسجيل الانصراف
    private function recordDeparture($visit, $latitude, $longitude, $value, $reason)
    {
        if ($visit->departure_time) {
            return;
        }

        $visit->update([
            'departure_time' => now(),
            'departure_latitude' => $latitude,
            'departure_longitude' => $longitude,
            'departure_notification_sent' => true,
            'notes' => ($visit->notes ?? '') . "\nانصراف تلقائي: $reason"
        ]);

        // إرسال الإشعارات
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
        $groups = Region_groub::with(['neighborhoods.client' => function($query) {
            $query->with(['invoices', 'payments', 'appointmentNotes', 'visits', 'accounts.receipts']);
        }])->get();

        // تحديد آخر 4 أسابيع
        $now = now();
        $weeks = [];

        for ($i = 3; $i >= 0; $i--) {
            $startDate = $now->copy()->subWeeks($i)->startOfWeek();
            $endDate = $now->copy()->subWeeks($i)->endOfWeek();

            $weeks[] = [
                'start' => $startDate->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d'),
                'month_year' => $startDate->translatedFormat('F Y'),
                'week_number' => 4 - $i // رقم الأسبوع (1 إلى 4)
            ];
        }

        return view('reports.sals.traffic_analytics', compact('groups', 'weeks'));
    }

    public function getWeeksData(Request $request)
    {
        $offset = $request->input('offset', 0);
        $now = now();
        $weeks = [];

        for ($i = 3 + $offset; $i >= 0 + $offset; $i--) {
            $startDate = $now->copy()->subWeeks($i)->startOfWeek();
            $endDate = $now->copy()->subWeeks($i)->endOfWeek();

            $weeks[] = [
                'start' => $startDate->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d'),
                'month_year' => $startDate->translatedFormat('F Y'),
                'week_number' => (4 + $offset) - $i
            ];
        }

        return response()->json(['weeks' => $weeks]);
    }

    public function getTrafficData(Request $request)
    {
        $weeks = $request->input('weeks');
        $groupIds = $request->input('group_ids', []);

        // هنا يمكنك تنفيذ الاستعلامات للحصول على البيانات حسب الأسابيع المحددة
        // هذا مثال مبسط، يجب تعديله حسب هيكل قاعدة البيانات الخاص بك

        $groups = Region_groub::when(!empty($groupIds), function($query) use ($groupIds) {
                return $query->whereIn('id', $groupIds);
            })
            ->with(['neighborhoods.client' => function($query) use ($weeks) {
                $query->with([
                    'invoices' => function($q) use ($weeks) {
                        $q->whereBetween('created_at', [$weeks[0]['start'], end($weeks)['end']]);
                    },
                    'payments' => function($q) use ($weeks) {
                        $q->whereBetween('created_at', [$weeks[0]['start'], end($weeks)['end']]);
                    },
                    'appointmentNotes' => function($q) use ($weeks) {
                        $q->whereBetween('created_at', [$weeks[0]['start'], end($weeks)['end']]);
                    },
                    'visits' => function($q) use ($weeks) {
                        $q->whereBetween('created_at', [$weeks[0]['start'], end($weeks)['end']]);
                    },
                    'accounts.receipts' => function($q) use ($weeks) {
                        $q->whereBetween('created_at', [$weeks[0]['start'], end($weeks)['end']]);
                    }
                ]);
            }])
            ->get();

        return response()->json([
            'groups' => $groups,
            'weeks' => $weeks
        ]);
    }

    public function sendDailyReport()
    {
        $date = Carbon::today();

        // جلب فقط الموظفين الذين لديهم دور employee
        $users = User::where('role', 'employee')->get();

        foreach ($users as $user) {
            // الفواتير التي أنشأها الموظف اليوم
            $invoices = Invoice::where('created_by', $user->id)
                ->whereDate('created_at', $date)
                ->get();

            // جلب أرقام الفواتير
            $invoiceIds = $invoices->pluck('id')->toArray();

            // المدفوعات المرتبطة بهذه الفواتير
            $payments = PaymentsProcess::whereIn('invoice_id', $invoiceIds)
                ->whereDate('payment_date', $date)
                ->get();

            // الزيارات التي قام بها الموظف اليوم
            $visits = Visit::with('client')
            ->where('employee_id', $user->id)
            ->whereDate('created_at', $date)
            ->get();
            // الإيصالات التي أنشأها الموظف اليوم
            $receipts = Receipt::where('created_by', $user->id)
                ->whereDate('created_at', $date)
                ->get();

            // المصروفات التي أنشأها الموظف اليوم
            $expenses = Expense::where('created_by', $user->id)
                ->whereDate('created_at', $date)
                ->get();

            // الملاحظات التي أنشأها الموظف اليوم للعملاء (مباشرة بدون علاقة بالفواتير)
            $notes = ClientRelation::with('client')
                ->where('employee_id', $user->id) // فقط ملاحظات الموظف الحالي
                ->whereDate('created_at', $date)
                ->get();

            // إنشاء ملف PDF للموظف الحالي
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetCreator('Your Application');
            $pdf->SetAuthor('Your Name');
            $pdf->SetTitle('Daily Employee Report - ' . $user->name);
            $pdf->SetSubject('Daily Report');
            $pdf->AddPage();

            // محتوى التقرير للموظف الحالي
            $html = view('reports.daily_employee_single', [
                'user' => $user,
                'invoices' => $invoices,
                'visits' => $visits,
                'payments' => $payments,
                'receipts' => $receipts,
                'expenses' => $expenses,
                'notes' => $notes,
                'total_payments' => $payments->sum('amount'),
                'total_invoices' => $invoices->sum('total_amount'),
                'date' => $date->format('Y-m-d'),
            ])->render();

            $pdf->writeHTML($html, true, false, true, false, 'R');

            // حفظ الملف باسم فريد لكل موظف
            $pdfPath = storage_path('app/public/daily_report_'.$user->id.'_'.$date->format('Y-m-d').'.pdf');
            $pdf->Output($pdfPath, 'F');

            // إرسال إلى Telegram
            $botToken = '7642508596:AAHQ8sST762ErqUpX3Ni0f1WTeGZxiQWyXU';
            $chatId = '@Salesfatrasmart';

            $response = Http::attach('document', file_get_contents($pdfPath), 'daily_report_'.$user->name.'.pdf')
                ->post("https://api.telegram.org/bot{$botToken}/sendDocument", [
                    'chat_id' => $chatId,
                    'caption' => "📊 تقرير الموظف اليومي - ".$user->name." - ".$date->format('Y-m-d'),
                ]);

            // if ($response->successful()) {
            //     $this->info('✅ تم إرسال تقرير الموظف '.$user->name.' بنجاح إلى Telegram');
            // } else {
            //     $this->error('❌ فشل إرسال تقرير الموظف '.$user->name.': '.$response->body());
            // }

            // حذف الملف بعد الإرسال
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }
        }
    }
    public function sendWeeklyReport()
{
    // تحديد تاريخ بداية ونهاية الأسبوع (من الأحد إلى السبت)
    $endDate = Carbon::today();
    $startDate = $endDate->copy()->subDays(6); // الأسبوع الماضي

    // جلب فقط الموظفين الذين لديهم دور employee
    $users = User::where('role', 'employee')->get();

    foreach ($users as $user) {
        // الفواتير التي أنشأها الموظف خلال الأسبوع
        $invoices = Invoice::where('created_by', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // جلب أرقام الفواتير
        $invoiceIds = $invoices->pluck('id')->toArray();

        // المدفوعات المرتبطة بهذه الفواتير خلال الأسبوع
        $payments = PaymentsProcess::whereIn('invoice_id', $invoiceIds)
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->get();

        // الزيارات التي قام بها الموظف خلال الأسبوع
        $visits = Visit::with('client')
            ->where('employee_id', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // الإيصالات التي أنشأها الموظف خلال الأسبوع
        $receipts = Receipt::where('created_by', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // المصروفات التي أنشأها الموظف خلال الأسبوع
        $expenses = Expense::where('created_by', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // الملاحظات التي أنشأها الموظف خلال الأسبوع
        $notes = ClientRelation::with('client')
            ->where('employee_id', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // إنشاء ملف PDF للموظف الحالي
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Your Application');
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Weekly Employee Report - ' . $user->name);
        $pdf->AddPage();

        // محتوى التقرير للموظف الحالي
        $html = view('reports.weekly_employee', [
            'user' => $user,
            'invoices' => $invoices,
            'visits' => $visits,
            'payments' => $payments,
            'receipts' => $receipts,
            'expenses' => $expenses,
            'notes' => $notes,
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
        ])->render();

        $pdf->writeHTML($html, true, false, true, false, 'R');

        // حفظ الملف باسم فريد لكل موظف
        $pdfPath = storage_path('app/public/weekly_report_'.$user->id.'_'.$startDate->format('Y-m-d').'_to_'.$endDate->format('Y-m-d').'.pdf');
        $pdf->Output($pdfPath, 'F');

        // إرسال إلى Telegram
        $botToken = '7642508596:AAHQ8sST762ErqUpX3Ni0f1WTeGZxiQWyXU';
        $chatId = '@Salesfatrasmart';

        $response = Http::attach('document', file_get_contents($pdfPath), 'weekly_report_'.$user->name.'.pdf')
            ->post("https://api.telegram.org/bot{$botToken}/sendDocument", [
                'chat_id' => $chatId,
                'caption' => "📊 تقرير الموظف الأسبوعي - ".$user->name." - من ".$startDate->format('Y-m-d')." إلى ".$endDate->format('Y-m-d'),
            ]);

        // حذف الملف بعد الإرسال
        if (file_exists($pdfPath)) {
            unlink($pdfPath);
        }
    }
}
public function sendMonthlyReport()
{
    // تحديد تاريخ بداية ونهاية الشهر
    $endDate = Carbon::today();
    $startDate = $endDate->copy()->startOfMonth();

    // جلب الموظفين
    $users = User::where('role', 'employee')->get();

    foreach ($users as $user) {
        // الفواتير الشهرية
        $invoices = Invoice::where('created_by', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $invoiceIds = $invoices->pluck('id')->toArray();

        // المدفوعات الشهرية
        $payments = PaymentsProcess::whereIn('invoice_id', $invoiceIds)
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->get();

        // الزيارات الشهرية مع تجميع عدد الزيارات لكل عميل
        $visits = Visit::with('client')
            ->where('employee_id', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // حساب عدد الزيارات لكل عميل
        $clientVisitsCount = $visits->groupBy('client_id')->map->count();

        // الإيصالات الشهرية
        $receipts = Receipt::where('created_by', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // المصروفات الشهرية
        $expenses = Expense::where('created_by', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // الملاحظات الشهرية
        $notes = ClientRelation::with('client')
            ->where('employee_id', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // إنشاء ملف PDF
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Your Application');
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Monthly Employee Report - ' . $user->name);
        $pdf->AddPage();

        // محتوى التقرير
        $html = view('reports.monthly_employee', [
            'user' => $user,
            'invoices' => $invoices,
            'visits' => $visits,
            'clientVisitsCount' => $clientVisitsCount,
            'payments' => $payments,
            'receipts' => $receipts,
            'expenses' => $expenses,
            'notes' => $notes,
            'startDate' => Carbon::parse($startDate), // تحويل إلى كائن Carbon
            'endDate' => Carbon::parse($endDate),
        ])->render();

        $pdf->writeHTML($html, true, false, true, false, 'R');

        // حفظ الملف
        $pdfPath = storage_path('app/public/monthly_report_'.$user->id.'_'.$startDate->format('Y-m').'.pdf');
        $pdf->Output($pdfPath, 'F');

        // إرسال إلى Telegram
        $botToken = '7642508596:AAHQ8sST762ErqUpX3Ni0f1WTeGZxiQWyXU';
        $chatId = '@Salesfatrasmart';

        $response = Http::attach('document', file_get_contents($pdfPath), 'monthly_report_'.$user->name.'.pdf')
            ->post("https://api.telegram.org/bot{$botToken}/sendDocument", [
                'chat_id' => $chatId,
                'caption' => "📊 تقرير الموظف الشهري - ".$user->name." - لشهر ".$startDate->format('Y-m'),
            ]);

        // حذف الملف بعد الإرسال
        if (file_exists($pdfPath)) {
            unlink($pdfPath);
        }
    }
}

}
