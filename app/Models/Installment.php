<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;


    protected $table = 'installments'; // اسم جدول القسط
    protected $fillable = [
        'invoice_id',       // معرف الفاتورة
        'amount',           // مبلغ القسط
        'installment_number', // رقم القسط
        'due_date',         // تاريخ الاستحقاق
    ];

    // تعريف العلاقة مع نموذج الفاتورة
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
