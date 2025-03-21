<?php
namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Client;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    // دالة تسجيل زيارة جديدة
    public function store(Request $request)
    {
        // تحقق من البيانات المرسلة
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
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

                return response()->json($visit, 201);
            } else {
                return response()->json(['message' => 'أنت لست قريبًا من العميل'], 400);
            }
        }

        return response()->json(['message' => 'العميل ليس لديه موقع مسجل'], 400);
    }

    // دالة لحساب المسافة بين نقطتين
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // نصف قطر الأرض بالمتر

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }
}
