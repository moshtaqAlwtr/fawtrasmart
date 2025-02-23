<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManufacturOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:manufactur_orders,code,' . $this->id,
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'account_id' => 'required|exists:accounts,id',
            'employee_id' => 'nullable|exists:employees,id',
            'client_id' => 'nullable|exists:clients,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'production_material_id' => 'nullable|exists:production_materials,id',
            'production_path_id' => 'nullable|exists:production_paths,id',
            'last_total_cost' => 'nullable|numeric|min:0',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',

            // قواعد للحقول الديناميكية
            'raw_product_id' => 'required|array|min:1',
            'raw_product_id.*' => 'required|exists:products,id',
            'raw_quantity' => 'required|array|min:1',
            'raw_quantity.*' => 'required|numeric|min:1',
            'raw_unit_price' => 'required|array|min:1',
            'raw_unit_price.*' => 'required|numeric|min:0',
            'raw_total' => 'required|array|min:1',
            'raw_total.*' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'الاسم مطلوب.',
            'code.required' => 'الكود مطلوب.',
            'code.unique' => 'هذا الكود مستخدم بالفعل.',
            'from_date.required' => 'تاريخ البداية مطلوب.',
            'to_date.required' => 'تاريخ النهاية مطلوب.',
            'to_date.after_or_equal' => 'يجب أن يكون تاريخ النهاية بعد أو يساوي تاريخ البداية.',
            'account_id.required' => 'الحساب مطلوب.',
            'account_id.exists' => 'الحساب المحدد غير موجود.',
            'product_id.required' => 'المنتج مطلوب.',
            'product_id.exists' => 'المنتج المحدد غير موجود.',
            'quantity.required' => 'الكمية مطلوبة.',
            'quantity.numeric' => 'الكمية يجب أن تكون رقمية.',
            'quantity.min' => 'الكمية يجب أن تكون على الأقل 1.',

            // رسائل للحقول الديناميكية
            'raw_product_id.required' => 'يجب إضافة صف واحد على الأقل في المواد الخام.',
            'raw_product_id.min' => 'يجب إضافة صف واحد على الأقل في المواد الخام.',
            'raw_product_id.*.required' => 'يجب تحديد المادة الخام.',
            'raw_product_id.*.exists' => 'المادة الخام المحددة غير موجودة.',
            'raw_quantity.required' => 'يجب إضافة صف واحد على الأقل في المواد الخام.',
            'raw_quantity.min' => 'يجب إضافة صف واحد على الأقل في المواد الخام.',
            'raw_quantity.*.required' => 'كمية المادة الخام مطلوبة.',
            'raw_quantity.*.numeric' => 'كمية المادة الخام يجب أن تكون رقمية.',
            'raw_quantity.*.min' => 'كمية المادة الخام يجب أن تكون على الأقل 1.',
            'raw_unit_price.required' => 'يجب إضافة صف واحد على الأقل في المواد الخام.',
            'raw_unit_price.min' => 'يجب إضافة صف واحد على الأقل في المواد الخام.',
            'raw_unit_price.*.required' => 'سعر الوحدة للمادة الخام مطلوب.',
            'raw_unit_price.*.numeric' => 'سعر الوحدة للمادة الخام يجب أن يكون رقمية.',
            'raw_unit_price.*.min' => 'سعر الوحدة للمادة الخام يجب أن يكون على الأقل 0.',
            'raw_total.required' => 'يجب إضافة صف واحد على الأقل في المواد الخام.',
            'raw_total.min' => 'يجب إضافة صف واحد على الأقل في المواد الخام.',
            'raw_total.*.required' => 'الإجمالي للمادة الخام مطلوب.',
            'raw_total.*.numeric' => 'الإجمالي للمادة الخام يجب أن يكون رقمية.',
            'raw_total.*.min' => 'الإجمالي للمادة الخام يجب أن يكون على الأقل 0.',
        ];
    }
}
