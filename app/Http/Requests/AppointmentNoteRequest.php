<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentNoteRequest extends FormRequest
{
    public function authorize()
    {
        return true; // تأكد من أن المستخدم مصرح له
    }

    public function rules()
    {
        return [
            'user_id' => 'nullable|exists:users,id',
            'client_id' => 'required|exists:clients,id',
            'appointment_id' => 'required|exists:appointments,id',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'notes' => 'nullable|string',
            // 'attachments' => 'mimes:jpeg,png,jpg,gif,svg', 'max:2048',
            'share_with_client' => 'boolean', // تأكد من أن هذه القاعدة موجودة
        ];
    }

    public function messages()
    {
        return [
            'action_type.required' => 'يرجى تحديد نوع الإجراء.',
            'share_with_client.required' => 'يجب تحديد ما إذا كنت ترغب في مشاركة الملاحظة مع العميل.',
        ];
    }
}
