<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndirectCostsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules()
    {
        return [
            'account_id' => 'required|exists:accounts,id',
            'from_date' => 'required|date|before_or_equal:to_date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'based_on' => 'required',
            'restriction_id.*' => 'required',
            'restriction_total.*' => 'required|numeric|min:0',
            'manufacturing_order_id.*' => 'required|exists:manufactur_orders,id',
            'manufacturing_price.*' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'account_id.required' => 'حقل الحساب مطلوب.',
            'account_id.exists' => 'الحساب المحدد غير صالح.',
            'from_date.required' => 'حقل التاريخ من مطلوب.',
            'from_date.date' => 'حقل التاريخ من يجب أن يكون تاريخًا صالحًا.',
            'from_date.before_or_equal' => 'حقل التاريخ من يجب أن يكون قبل أو يساوي التاريخ إلى.',
            'to_date.required' => 'حقل التاريخ إلى مطلوب.',
            'to_date.date' => 'حقل التاريخ إلى يجب أن يكون تاريخًا صالحًا.',
            'to_date.after_or_equal' => 'حقل التاريخ إلى يجب أن يكون بعد أو يساوي التاريخ من.',
            'based_on.required' => 'حقل بناءً على الكمية مطلوب إذا لم يتم تحديد بناءً على التكلفة.',


            'restriction_id.*.required' => 'حقل القيد مطلوب.',
            'restriction_id.*.exists' => 'القيد المحدد غير صالح.',
            'restriction_total.*.required' => 'حقل المبلغ مطلوب.',
            'restriction_total.*.numeric' => 'حقل المبلغ يجب أن يكون رقمًا.',
            'restriction_total.*.min' => 'حقل المبلغ يجب أن يكون على الأقل 0.',
            'manufacturing_order_id.*.required' => 'حقل أمر التصنيع مطلوب.',
            'manufacturing_order_id.*.exists' => 'أمر التصنيع المحدد غير صالح.',
            'manufacturing_price.*.required' => 'حقل سعر التصنيع مطلوب.',
            'manufacturing_price.*.numeric' => 'حقل سعر التصنيع يجب أن يكون رقمًا.',
            'manufacturing_price.*.min' => 'حقل سعر التصنيع يجب أن يكون على الأقل 0.',
        ];
    }

}
