<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use App\Models\Client;
use App\Models\Employee;

use App\Models\Location;
use App\Models\notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitController extends Controller
{
    // عرض جميع الزيارات
    public function index()
    {
        $visits = Visit::with(['employee', 'client'])->get();
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

    // تسجيل زيارة جديدة
    public function store(Request $request)
    {
        // تحقق من البيانات المرسلة
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'client_id' => 'required|exists:clients,id',
            'visit_date' => 'required|date',
            'status' => 'required|in:present,absent',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // جلب بيانات العميل
        $client = Client::find($request->client_id);

        // جلب أحدث موقع مسجل للعميل
        $clientLocation = $client->locations()->latest()->first();

        // إذا كان العميل عنده موقع مسجل
        if ($clientLocation) {
            // حساب المسافة بين موقع الموظف وموقع العميل
            $distance = $this->calculateDistance(
                $clientLocation->latitude, $clientLocation->longitude,
                $request->latitude, $request->longitude
            );

            // إذا كان الموظف داخل نطاق 100 متر من العميل
            if ($distance < 100) {
                // تسجيل الزيارة
                $visit = Visit::create([
                    'employee_id' => $request->employee_id,
                    'client_id' => $request->client_id,
                    'visit_date' => $request->visit_date,
                    'status' => $request->status,
                    'employee_latitude' => $request->latitude,
                    'employee_longitude' => $request->longitude,
                ]);

                // إرسال إشعار للمدير
                $this->sendNotificationToManager($visit);

                return response()->json($visit, 201);
            } else {
                return response()->json(['message' => 'أنت لست قريبًا من العميل'], 400);
            }
        }

        return response()->json(['message' => 'العميل ليس لديه موقع مسجل'], 400);
    }

    // تخزين موقع الموظف تلقائيًا
    public function storeEmployeeLocation(Request $request)
    {
        // تحقق من البيانات المرسلة
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // البحث عن سجل الموظف الحالي أو إنشائه إذا لم يكن موجودًا
        $location = Location::updateOrCreate(
            ['employee_id' => auth()->id()], // الشرط: البحث باستخدام employee_id
            [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]
        );

        // التحقق من المسافة وتسجيل الزيارة تلقائيًا
        $this->checkDistanceAndLogVisit(auth()->id(), $request->latitude, $request->longitude);

        return response()->json([
            'message' => 'تم تحديث الموقع بنجاح',
            'location' => $location,
        ], 200);
    }

    // التحقق من المسافة وتسجيل الزيارة تلقائيًا
    private function checkDistanceAndLogVisit($employeeId, $latitude, $longitude)
    {
        // جلب جميع العملاء
        $clients = Client::all();

        foreach ($clients as $client) {
            // جلب أحدث موقع مسجل للعميل
            $clientLocation = $client->locations()->latest()->first();

            if ($clientLocation) {
                // حساب المسافة بين موقع الموظف وموقع العميل
                $distance = $this->calculateDistance(
                    $clientLocation->latitude, $clientLocation->longitude,
                    $latitude, $longitude
                );

                // إذا كان الموظف داخل نطاق 100 متر من العميل
                if ($distance < 100) {
                    // التحقق من وجود زيارة سابقة لنفس الموظف ونفس العميل في نفس اليوم
                    $existingVisit = Visit::where('employee_id', $employeeId)
                        ->where('client_id', $client->id)
                        ->whereDate('visit_date', now()->toDateString())
                        ->first();

                    // إذا لم تكن هناك زيارة مسجلة في نفس اليوم
                    if (!$existingVisit) {
                        // تسجيل الزيارة
                        $visit = Visit::create([
                            'employee_id' => $employeeId,
                            'client_id' => $client->id,
                            'visit_date' => now(),
                            'status' => 'present',
                            'employee_latitude' => $latitude,
                            'employee_longitude' => $longitude,
                            'notes' => 'تم تسجيل الزيارة تلقائيًا عند المرور بالقرب من العميل.', // إضافة ملاحظات
                        ]);

                        // إرسال إشعار للمدير
                        $this->sendNotificationToManager($visit);
                    }
                }
            }
        }
    }

    // دالة لحساب المسافة بين نقطتين
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // نصف قطر الأرض بالمتر

        // تحويل الدرجات إلى راديان
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        // حساب الفروق بين الإحداثيات
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        // حساب المسافة باستخدام صيغة هافرساين
        $angle = 2 * asin(sqrt(
            pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)
        ));

        return $angle * $earthRadius; // المسافة بالمتر
    }
    // إرسال إشعار للمدير عند تسجيل زيارة
    private function sendNotificationToManager($visit)
    {
        // جلب المدير

        notifications::create([
            'type' => 'visit', // نوع الإشعار
            'title' => 'زيارة جديدة', // عنوان الإشعار
            'description' => "تم تسجيل زيارة جديدة من قبل الموظف: {$visit->employee->name} لعميل: {$visit->client->trade_name}", // وصف الإشعار
        ]);
    }

    // تحديث زيارة معينة
    public function update(Request $request, $id)
    {
        $visit = Visit::find($id);
        if ($visit) {
            $request->validate([
                'employee_id' => 'sometimes|exists:users,id',
                'client_id' => 'sometimes|exists:clients,id',
                'visit_date' => 'sometimes|date',
                'status' => 'sometimes|in:present,absent',
                'latitude' => 'sometimes|numeric',
                'longitude' => 'sometimes|numeric',
            ]);

            $visit->update($request->all());
            return response()->json($visit);
        }
        return response()->json(['message' => 'الزيارة غير موجودة'], 404);
    }

    // حذف زيارة معينة
    public function destroy($id)
    {
        $visit = Visit::find($id);
        if ($visit) {
            $visit->delete();
            return response()->json(['message' => 'تم حذف الزيارة بنجاح']);
        }
        return response()->json(['message' => 'الزيارة غير موجودة'], 404);
    }
}
