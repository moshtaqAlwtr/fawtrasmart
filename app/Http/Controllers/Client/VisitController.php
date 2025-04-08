<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientRelation;
use App\Models\Invoice;
use App\Models\PaymentsProcess;
use App\Models\Visit;
use App\Models\Client;
use App\Models\User;
use App\Models\Location;
use App\Models\Notification;
use App\Models\Region_groub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class VisitController extends Controller
{
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

    // عرض تفاصيل زيارة معينة
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

    // تسجيل زيارة جديدة يدويًا
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
        $isNearby = $this->checkClientProximity(
            $request->latitude,
            $request->longitude,
            $client->id
        );

        if (!$isNearby) {
            return response()->json([
                'success' => false,
                'message' => 'يجب أن تكون ضمن 100 متر من العميل لتسجيل الزيارة'
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

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الزيارة بنجاح',
            'data' => $visit
        ], 201);
    }

    // تخزين موقع الموظف تلقائيًا (الوظيفة المحسنة)
    public function storeLocationEnhanced(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'accuracy' => 'nullable|numeric'
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

            // البحث عن العملاء القريبين
            $nearbyClients = $this->getNearbyClients(
                $request->latitude,
                $request->longitude
            );

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

            // التحقق من الانصراف للزيارات القديمة
            $this->checkForDepartures($employeeId, $request->latitude, $request->longitude);

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الموقع بنجاح',
                'nearby_clients' => count($nearbyClients),
                'recorded_visits' => $recordedVisits,
                'location' => $location
            ]);

        } catch (\Exception $e) {
            Log::error('فشل في تحديث الموقع: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث الموقع'
            ], 500);
        }
    }

    // تحديث زيارة معينة
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

        // التحقق من صلاحية المستخدم لتعديل هذه الزيارة
        if ($visit->employee_id != Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح لك بتعديل هذه الزيارة'
            ], 403);
        }

        $visit->update($request->all());

        if ($request->has('departure_time')) {
            $this->sendVisitNotifications($visit, 'departure');
        }

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الزيارة بنجاح',
            'data' => $visit
        ]);
    }

    // حذف زيارة معينة
    public function destroy($id)
    {
        $visit = Visit::find($id);

        if (!$visit) {
            return response()->json([
                'success' => false,
                'message' => 'الزيارة غير موجودة'
            ], 404);
        }

        // التحقق من صلاحية المستخدم لحذف هذه الزيارة
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

    // الحصول على زيارات الموظف الحالي
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

    // الحصول على زيارات اليوم
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

    // ======== الدوال المساعدة ======== //

    /**
     * البحث عن العملاء القريبين من موقع الموظف
     */
    private function getNearbyClients($latitude, $longitude, $radius = 100)
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

    /**
     * التحقق من قرب الموظف من عميل معين
     */
    private function checkClientProximity($latitude, $longitude, $clientId, $maxDistance = 100)
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

    /**
     * تسجيل زيارة تلقائية عند الاقتراب من العميل
     */
    private function recordVisitAutomatically($employeeId, $clientId, $latitude, $longitude)
{
    $today = now()->toDateString();
    $now = now();

    $existingVisit = Visit::where('employee_id', $employeeId)
        ->where('client_id', $clientId)
        ->whereDate('visit_date', $today)
        ->first();

    if (!$existingVisit) {
        $visit = Visit::create([
            'employee_id' => $employeeId,
            'client_id' => $clientId,
            'visit_date' => $now,
            'status' => 'present',
            'employee_latitude' => $latitude,
            'employee_longitude' => $longitude,
            'arrival_time' => $now,
            'notes' => 'زيارة تلقائية',
            'departure_notification_sent' => false,
        ]);

        $this->sendVisitNotifications($visit, 'arrival');
        return $visit;
    }
    elseif (is_null($existingVisit->arrival_time)) {
        $existingVisit->update([
            'arrival_time' => $now,
            'employee_latitude' => $latitude,
            'employee_longitude' => $longitude,
            'notes' => 'تحديث وقت الوصول',
        ]);
        return $existingVisit;
    }

    return null;
}

    /**
     * التحقق من الانصراف عند الابتعاد عن العملاء
     */
    private function checkForDepartures($employeeId, $latitude, $longitude)
    {
        $activeVisits = Visit::where('employee_id', $employeeId)
            ->whereDate('visit_date', now()->toDateString())
            ->whereNotNull('arrival_time')
            ->whereNull('departure_time')
            ->with('client.locations')
            ->get();

        foreach ($activeVisits as $visit) {
            $clientLocation = $visit->client->locations()->latest()->first();

            if ($clientLocation) {
                $distance = $this->calculateDistance(
                    $clientLocation->latitude,
                    $clientLocation->longitude,
                    $latitude,
                    $longitude
                );

                if ($distance > 100) { // إذا ابتعد أكثر من 100 متر
                    $visit->update([
                        'departure_time' => now(),
                        'departure_notification_sent' => true,
                        'notes' => ($visit->notes ?? '') . "\nتم تسجيل الانصراف تلقائياً عند الابتعاد عن العميل",
                    ]);

                    $this->sendVisitNotifications($visit, 'departure');
                }
            }
        }
    }

    /**
     * حساب المسافة بين نقطتين (بالمتر)
     */
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
        ));

        return $angle * $earthRadius;
    }

    /**
     * إرسال إشعارات الزيارة
     */
    private function sendVisitNotifications($visit, $type)
    {
        $employeeName = $visit->employee->name ?? 'غير معروف';
        $clientName = $visit->client->trade_name ?? 'غير معروف';
        $visitDate = Carbon::parse($visit->visit_date)->format('Y-m-d H:i');

        // إرسال إشعار داخلي
        Notification::create([
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
            Notification::create([
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

    /**
     * إرسال إشعار التليجرام
     */
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
    }public function tracktaff()
    {
        // جلب كل المجموعات مع العملاء
        $groups = Region_groub::with('clients')->get();
    
        // أقدم تاريخ عملية موجودة (نحتاج ناخذه من أقدم فاتورة أو سند أو زيارة أو ملاحظة)
        $minDate = $this->getMinOperationDate();
    
        // نحسب كم أسبوع من أول عملية إلى الآن
        $start = \Carbon\Carbon::parse($minDate)->startOfWeek();
        $now = now()->endOfWeek();
        $totalWeeks = $start->diffInWeeks($now) + 1;
    
        // نبني الأسابيع
        $weeks = [];
        for ($i = 0; $i < $totalWeeks; $i++) {
            $weeks[] = [
                'start' => $start->copy()->addWeeks($i)->format('Y-m-d'),
                'end' => $start->copy()->addWeeks($i)->endOfWeek()->format('Y-m-d'),
            ];
        }
    
        return view('reports.sals.traffic_analytics', compact('groups', 'weeks'));
    }
    private function getMinOperationDate()
    {
        $invoiceDate = Invoice::min('created_at');
        $paymentDate = PaymentsProcess::min('created_at');
        $noteDate = ClientRelation::min('created_at');
        $visitDate = Visit::min('created_at');
    
        return collect([$invoiceDate, $paymentDate, $noteDate, $visitDate])
            ->filter()
            ->min();
    }
        
}
