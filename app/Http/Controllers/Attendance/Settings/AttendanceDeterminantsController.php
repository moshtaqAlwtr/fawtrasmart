<?php

namespace App\Http\Controllers\Attendance\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceDeterminantRequest;
use App\Models\AttendanceDeterminant;
use Illuminate\Http\Request;

class AttendanceDeterminantsController extends Controller
{
    public function index()
    {
        $attendance_determinants = AttendanceDeterminant::select()->orderBy('id','DESC')->get();
        return view('attendance.settings.determinants.index',compact('attendance_determinants'));
    }
    public function create()
    {
        return view('attendance.settings.determinants.create');
    }

    public function store(AttendanceDeterminantRequest $request)
    {
        $attendance_determinants = new AttendanceDeterminant();

        $attendance_determinants->create([
            'name' => $request->name,
            'status' => $request->status,
            'capture_employee_image' => $request->capture_employee_image ?? 0,
            'image_investigation' => $request->image_investigation,
            'allowed_ips' => $request->allowed_ips,
            'enable_location_verification' => $request->enable_location_verification ?? 0,
            'enable_ip_verification' => $request->enable_ip_verification ?? 0,
            'location_investigation' => $request->location_investigation,
            'radius' => $request->radius,
            'radius_type' => $request->radius_type,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('attendance_determinants.index')->with(['success'=>'تمت اضافة المحدد بنجاح']);
    }

    public function edit($id)
    {
        $attendance_determinants = AttendanceDeterminant::find($id);
        return view('attendance.settings.determinants.edit',compact('attendance_determinants'));
    }

    public function update(AttendanceDeterminantRequest $request,$id)
    {
        $attendance_determinants = AttendanceDeterminant::find($id);

        $attendance_determinants->update([
            'name' => $request->name,
            'status' => $request->status,
            'capture_employee_image' => $request->capture_employee_image ?? 0,
            'image_investigation' => $request->image_investigation,
            'allowed_ips' => $request->allowed_ips,
            'enable_location_verification' => $request->enable_location_verification ?? 0,
            'enable_ip_verification' => $request->enable_ip_verification ?? 0,
            'location_investigation' => $request->location_investigation,
            'radius' => $request->radius,
            'radius_type' => $request->radius_type,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('attendance_determinants.index')->with(['success'=>'تم تعديل المحدد بنجاح']);
    }

    public function show($id)
    {
        $attendance_determinant = AttendanceDeterminant::find($id);
        return view('attendance.settings.determinants.show',compact('attendance_determinant'));
    }

    public function updateStatus($id)
    {
        $attendance_determinant = AttendanceDeterminant::find($id);

        if (!$attendance_determinant) {
            return redirect()->route('attendance_determinants.show',$id)->with(['error' => 'محدد الحضور غير موجودة!']);
        }

        $attendance_determinant->status = !$attendance_determinant->status;
        $attendance_determinant->save();

        return redirect()->route('attendance_determinants.show',$id)->with(['success' => 'تم تغيير حالة محدد الحضور بنجاح']);
    }

    public function delete($id)
    {
        $attendance_determinants = AttendanceDeterminant::find($id);
        $attendance_determinants->delete();
        return redirect()->route('attendance_determinants.index')->with(['error'=>'تم حذف محدد الحضور بنجاح']);
    }
}
