<?php

namespace App\Http\Controllers\Attendance\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceDeterminantRequest;
use App\Models\AttendanceDeterminant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AttendanceDeterminantsController extends Controller
{
    public function index()
    {

        $attendance_determinants = AttendanceDeterminant::select()->orderBy('id', 'DESC')->get();
        return view('attendance.settings.determinants.index', compact('attendance_determinants'));
    }
    public function create()
    {
        return view('attendance.settings.determinants.create');
    }

    public function store(AttendanceDeterminantRequest $request): RedirectResponse
    {
        // تعيين القيم الافتراضية للحقول الاختيارية
        $data = $request->validated();
        $data['capture_employee_image'] = $data['capture_employee_image'] ?? 0;
        $data['enable_ip_verification'] = $data['enable_ip_verification'] ?? 0;
        $data['enable_location_verification'] = $data['enable_location_verification'] ?? 0;

        // إنشاء محدد الحضور
        $determinant = AttendanceDeterminant::create($data);

        // معالجة بيانات الموقع إذا كان مفعلاً
        if ($determinant->enable_location_verification) {
            $locationData = [
                'attendance_determinant_id' => $determinant->id,
                'radius_type' => $request->radius_type,
                'radius' => $request->radius,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                // employee_id أو client_id إذا لزم الأمر
            ];

            // إنشاء أو تحديث الموقع المرتبط
            $determinant->location()->updateOrCreate(['attendance_determinant_id' => $determinant->id], $locationData);
        } elseif ($determinant->location) {
            // إذا تم تعطيل التحقق من الموقع ولكن يوجد موقع مسجل مسبقاً
            $determinant->location()->delete();
        }

        return redirect()->route('attendance_determinants.index')->with('success', 'تم إنشاء محدد الحضور بنجاح');
    }

    public function edit($id)
    {
        $attendance_determinants = AttendanceDeterminant::find($id);
        return view('attendance.settings.determinants.edit', compact('attendance_determinants'));
    }

    public function update(AttendanceDeterminantRequest $request, $id): RedirectResponse
    {
        // البحث عن محدد الحضور المطلوب
        $determinant = AttendanceDeterminant::findOrFail($id);

        // تعيين القيم الافتراضية للحقول الاختيارية
        $data = $request->validated();
        $data['capture_employee_image'] = $data['capture_employee_image'] ?? 0;
        $data['enable_ip_verification'] = $data['enable_ip_verification'] ?? 0;
        $data['enable_location_verification'] = $data['enable_location_verification'] ?? 0;

        // تحديث محدد الحضور
        $determinant->update($data);

        // معالجة بيانات الموقع إذا كان مفعلاً
        if ($determinant->enable_location_verification) {
            $locationData = [
                'attendance_determinant_id' => $determinant->id,
                'radius_type' => $request->radius_type,
                'radius' => $request->radius,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                // employee_id أو client_id إذا لزم الأمر
            ];

            // إنشاء أو تحديث الموقع المرتبط
            $determinant->location()->updateOrCreate(['attendance_determinant_id' => $determinant->id], $locationData);
        } elseif ($determinant->location) {
            // إذا تم تعطيل التحقق من الموقع ولكن يوجد موقع مسجل مسبقاً
            $determinant->location()->delete();
        }

        return redirect()->route('attendance_determinants.index')->with('success', 'تم تعديل محدد الحضور بنجاح');
    }
    public function show($id)
    {
        $attendance_determinant = AttendanceDeterminant::find($id);
        return view('attendance.settings.determinants.show', compact('attendance_determinant'));
    }

    public function updateStatus($id)
    {
        $attendance_determinant = AttendanceDeterminant::find($id);

        if (!$attendance_determinant) {
            return redirect()
                ->route('attendance_determinants.show', $id)
                ->with(['error' => 'محدد الحضور غير موجودة!']);
        }

        $attendance_determinant->status = !$attendance_determinant->status;
        $attendance_determinant->save();

        return redirect()
            ->route('attendance_determinants.show', $id)
            ->with(['success' => 'تم تغيير حالة محدد الحضور بنجاح']);
    }

    public function delete($id)
    {
        $attendance_determinants = AttendanceDeterminant::find($id);
        $attendance_determinants->delete();
        return redirect()
            ->route('attendance_determinants.index')
            ->with(['error' => 'تم حذف محدد الحضور بنجاح']);
    }
}
