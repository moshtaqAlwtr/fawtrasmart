<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceDaysRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_id' => 'required|exists:employees,id',
            'attendance_date' => 'required|date',
            'status' => 'required|in:present,absent,late',
            'start_shift' => 'nullable|date_format:H:i|required_if:status,present',
            'end_shift' => 'nullable|date_format:H:i|required_if:status,present',
            'login_time' => 'nullable|date_format:H:i|required_if:status,present',
            'logout_time' => 'nullable|date_format:H:i|required_if:status,present',
            'absence_type' => 'nullable|in:1,2|required_if:status,absent',
            'absence_balance' => 'nullable|integer|min:0|required_if:status,absent',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'يجب اختيار الموظف.',
            'employee_id.exists' => 'الموظف المحدد غير موجود.',
            'attendance_date.required' => 'يجب تحديد تاريخ الحضور.',
            'attendance_date.date' => 'التاريخ غير صالح.',
            'status.required' => 'يجب اختيار الحالة.',
            'status.in' => 'الحالة المختارة غير صحيحة.',
            'start_shift.required_if' => 'بداية الوردية مطلوبة عندما تكون الحالة حاضر.',
            'end_shift.required_if' => 'نهاية الوردية مطلوبة عندما تكون الحالة حاضر.',
            'login_time.required_if' => 'تسجيل الدخول مطلوب عندما تكون الحالة حاضر.',
            'logout_time.required_if' => 'تسجيل الخروج مطلوب عندما تكون الحالة حاضر.',
            'absence_type.required_if' => 'نوع الإجازة مطلوب عندما تكون الحالة إجازة.',
            'absence_balance.required_if' => 'رصيد الإجازة مطلوب عندما تكون الحالة إجازة.',
        ];
    }
}
