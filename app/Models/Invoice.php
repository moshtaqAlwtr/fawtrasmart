<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invoice extends Model
{
    protected $fillable = ['client_id', 'treasury_id', 'payment', 'invoice_date', 'issue_date', 'payment_terms', 'payment_status', 'currency', 'total', 'grand_total', 'due_value', 'employee_id', 'advance_payment', 'remaining_amount', 'is_paid', 'payment_method', 'reference_number', 'notes', 'code', 'discount_amount', 'discount_type', 'shipping_cost', 'shipping_tax', 'tax_type', 'tax_total', 'attachments', 'type', 'created_by', 'updated_by'];

    protected $casts = [
        'invoice_date' => 'date',
        'issue_date' => 'date',
        'is_paid' => 'boolean',
        'total' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'advance_payment' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'shipping_tax' => 'decimal:2',
        'tax_total' => 'decimal:2',
    ];

    // العلاقة مع العميل
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    // العلاقة مع الخزينة
    public function treasury(): BelongsTo
    {
        return $this->belongsTo(Treasury::class);
    }
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    // العلاقة مع المستخدم الذي أنشأ الفاتورة
    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // العلاقة مع المستخدم الذي قام بتحديث الفاتورة
    public function updatedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // العلاقة مع عناصر الفاتورة

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }

    // العلاقة مع جميع عمليات الدفع
    public function payments(): HasMany
    {
        return $this->hasMany(PaymentsProcess::class)->where('type', 'client payments');
    }

    // العلاقة مع آخر عملية دفع فقط
    public function lastPayment(): HasOne
    {
        return $this->hasOne(PaymentsProcess::class)->where('type', 'client payments')->latest();
    }

    // دالة لحساب المبلغ المتبقي
    public function calculateRemainingAmount(): float
    {
        $totalPaid = $this->payments()->sum('amount');
        return $this->grand_total - $totalPaid;
    }

    // دالة لتحديث حالة الدفع
    public function updatePaymentStatus(): void
    {
        $remainingAmount = $this->calculateRemainingAmount();

        if ($remainingAmount <= 0) {
            $this->payment_status = 1; // مدفوع بالكامل
            $this->is_paid = true;
        } elseif ($remainingAmount < $this->grand_total) {
            $this->payment_status = 2; // مدفوع جزئياً
            $this->is_paid = false;
        } else {
            $this->payment_status = 3; // غير مدفوع
            $this->is_paid = false;
        }

        $this->remaining_amount = max(0, $remainingAmount);
        $this->save();
    }
    public function payments_process()
    {
        return $this->hasMany(PaymentsProcess::class, 'invoice_id');
    }
    public function journalEntries()
    {
        return $this->hasMany(JournalEntry::class, 'reference_id');
    }
    // في نموذج Invoice
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    // في نموذج InvoiceItem
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
