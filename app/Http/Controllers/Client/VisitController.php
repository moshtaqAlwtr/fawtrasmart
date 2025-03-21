<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function store(Request $request)
    {
        // تحقق من البيانات المرسلة
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'client_id' => 'required|exists:clients,id',
            'visit_date' => 'required|date',
            'status' => 'required|in:present,absent',
            'latitude' => 'required|numeric', // خط العرض
            'longitude' => 'required|numeric', // خط الطول
        ]);

        // تسجيل الزيارة
        $visit = Visit::create([
            'employee_id' => $request->employee_id,
            'client_id' => $request->client_id,
            'visit_date' => $request->visit_date,
            'status' => $request->status,
            'employee_latitude' => $request->latitude, // خط العرض
            'employee_longitude' => $request->longitude, // خط الطول
        ]);

        return response()->json($visit, 201);
    }
}
