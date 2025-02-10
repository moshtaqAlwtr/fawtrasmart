<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    // اسم الجدول
    protected $table = 'expenses';

    // الحقول القابلة للتعبئة
    protected $fillable = ['id', 'code', 'amount', 'description', 'date', 'unit_id', 'expenses_category_id',
        'vendor_id', 'seller', 'store_id', 'sup_account', 'is_recurring', 'recurring_frequency', 'end_date',
        'tax1', 'tax2', 'tax1_amount', 'tax2_amount', 'attachments', 'cost_centers_enabled', 'created_at', 'updated_at'];

    // العلاقات
    public function expenses_category()
    {
        return $this->belongsTo(ExpensesCategory::class, 'expenses_category_id');
    }
    
}
