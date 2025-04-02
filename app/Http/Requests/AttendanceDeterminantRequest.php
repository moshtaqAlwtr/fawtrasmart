<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceDeterminantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
            'capture_employee_image' => 'nullable|in:0,1',
            'image_investigation' => 'required_if:capture_employee_image,1|in:1,2',
            'enable_ip_verification' => 'nullable|in:0,1',
            'ip_investigation' => 'required_if:enable_ip_verification,1|in:1,2',
            'allowed_ips' => 'nullable|string',
            'enable_location_verification' => 'nullable|in:0,1',
            'location_investigation' => 'required_if:enable_location_verification,1|in:1,2',
        ];

        if ($this->enable_location_verification == 1) {
            $rules['radius'] = 'required|numeric|min:0.1';
            $rules['radius_type'] = 'required|in:1,2';
            $rules['latitude'] = 'required|numeric';
            $rules['longitude'] = 'required|numeric';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم محدد الحضور مطلوب',
            'status.required' => 'حالة محدد الحضور مطلوبة',
            'image_investigation.required_if' => 'نوع التحقق للصورة مطلوب عند تفعيل التقاط الصورة',
            'ip_investigation.required_if' => 'نوع التحقق لـ IP مطلوب عند تفعيل التحقق من IP',
            'location_investigation.required_if' => 'نوع التحقق للموقع مطلوب عند تفعيل التحقق من الموقع',
            'radius.required' => 'نطاق التوقيع مطلوب',
            'radius_type.required' => 'نوع المقياس مطلوب',
            'latitude.required' => 'خط العرض مطلوب',
            'longitude.required' => 'خط الطول مطلوب',
        ];
    }
}
