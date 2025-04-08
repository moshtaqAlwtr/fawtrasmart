<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{

    protected $table = 'clients';
    protected $primaryKey = 'id';
    public $timestamps = true;

    // الحقول القابلة للتعبئة
    protected $fillable = ['trade_name','classification_id ', 'first_name', 'last_name', 'phone', 'mobile','cat', 'street1', 'street2', 'category', 'city', 'region','visit_type', 'postal_code', 'country', 'tax_number', 'commercial_registration', 'credit_limit', 'credit_period', 'printing_method', 'opening_balance', 'opening_balance_date', 'code', 'currency', 'email', 'client_type', 'notes', 'attachments', 'employee_id','status_id','branch_id' ];

    // العلاقة مع المواعيد
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // في ملف Client.php
public function latestStatus()
{
    return $this->hasOne(ClientRelation::class, 'client_id')->latest();
}
public function branch()
{
    return $this->belongsTo(Branch::class);
}
public function Neighborhoodname()
{
    return $this->hasOne(Neighborhood::class, 'client_id');
}

public function Balance()
{
    return Account::where('client_id', $this->id)->sum('balance');
}
    public function getFullAddressAttribute()
    {
        $address = [];
        if ($this->street1) {
            $address[] = $this->street1;
        }
        if ($this->street2) {
            $address[] = $this->street2;
        }
        if ($this->city) {
            $address[] = $this->city;
        }
        if ($this->region) {
            $address[] = $this->region;
        }
        if ($this->postal_code) {
            $address[] = $this->postal_code;
        }
        if ($this->country) {
            $address[] = $this->country;
        }

        return implode(', ', $address);
    }
     public function accounts(): HasMany
    {
        return $this->hasMany(Account::class, 'client_id');
    }
    // العلاقة مع ملاحظات المواعيد
    public function appointmentNotes()
    {
        return $this->hasMany(AppointmentNote::class);
    }

    // العلاقات
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'client_id');
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class, 'client_id', 'id');
    }



    public function cheques()
    {
        return $this->hasMany(ChequesCycle::class, 'client_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    // العلاقة مع CreditNotification
    public function creditNotifications()
    {
        return $this->hasMany(CreditNotification::class, 'client_id');
    }

    // العلاقة مع JournalEntry
    public function journalEntries()
    {
        return $this->hasMany(JournalEntry::class, 'client_id', 'id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
    // Accessors
    public function getBalanceAttribute()
    {
        $invoicesTotal = $this->invoices()->sum('grand_total') ?? 0;
        $paymentsTotal = $this->payments()->sum('amount') ?? 0;
        return $invoicesTotal - $paymentsTotal;
    }
    public function supplyOrders()
    {
        return $this->hasMany(SupplyOrder::class, 'client_id');
    }

    public function getTotalInvoicesAttribute()
    {
        return $this->invoices()->sum('grand_total') ?? 0;
    }

    public function getTotalPaymentsAttribute()
    {
        return $this->payments()->sum('amount') ?? 0;
    }

    public function getStatusAttribute()
    {
        // التحقق من حالة العميل باستخدام حقل deleted_at
        // إذا كان deleted_at فارغ فالعميل نشط
        return $this->deleted_at === null;
    }

    public function notes()
{
    return $this->hasMany(AppointmentNote::class);
}
 
    // دالة لجلب حركة الحساب
    public function getTransactionsAttribute()
    {
        $transactions = collect();

        // إضافة الفواتير
        $this->invoices->each(function ($invoice) use ($transactions) {
            $transactions->push([
                'date' => $invoice->invoice_date,
                'type' => 'فاتورة',
                'number' => $invoice->invoice_number,
                'amount' => $invoice->grand_total,
                'balance' => 0, // سيتم حسابه لاحقاً
                'notes' => $invoice->notes,
            ]);
        });

        // إضافة المدفوعات
        $this->payments->each(function ($payment) use ($transactions) {
            $transactions->push([
                'date' => $payment->payment_date,
                'type' => 'دفعة',
                'number' => $payment->payment_number,
                'amount' => -$payment->amount, // سالب لأنها دفعة
                'balance' => 0, // سيتم حسابه لاحقاً
                'notes' => $payment->notes,
            ]);
        });

        // ترتيب المعاملات حسب التاريخ
        $transactions = $transactions->sortBy('date');

        // حساب الرصيد التراكمي
        $balance = $this->opening_balance ?? 0;
        $transactions->transform(function ($transaction) use (&$balance) {
            $balance += $transaction['amount'];
            $transaction['balance'] = $balance;
            return $transaction;
        });

        return $transactions;
    }

    // Boot method to handle cascading deletes
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($client) {
            // حذف الفواتير المرتبطة
            $client->invoices()->delete();

            // حذف السندات المرتبطة
            // $client->receipts()->delete();

            // حذف المدفوعات المرتبطة
            $client->payments()->delete();

            // حذف الشيكات المرتبطة

            // حذف إشعارات الائتمان المرتبطة
            $client->creditNotifications()->delete();

            // حذف مدخلات المجلة المرتبطة
            $client->journalEntries()->delete();
        });
    }


    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
    public function category()
    {
        return $this->hasMany(CategoriesClient::class, 'classification_id');
    }
    public function employees()
    {
        return $this->belongsToMany(
            Employee::class,      // النموذج المرتبط
            'client_employee',    // اسم الجدول الوسيط
            'client_id',          // المفتاح الأجنبي للنموذج الحالي
            'employee_id'         // المفتاح الأجنبي للنموذج المرتبط
        )->withTimestamps();      // إضافة طوابع زمنية
    }
    public function payments()
{
    return $this->hasManyThrough(PaymentsProcess::class, Invoice::class);
}
// في Client model
public function clientEmployees()
{
    return $this->hasMany(ClientEmployee::class);
}

public function locations()
{
    return $this->hasOne(Location::class, 'client_id');
}


public function visits()
{
    return $this->hasMany(Visit::class, 'client_id');
}

public function status_client()
{
    return $this->belongsTo(Statuses::class, 'status_id');
}
// في ملف app/Models/Client.php
public function status()
{
    return $this->belongsTo(Statuses::class)->withDefault([
        'name' => 'غير محدد',
        'color' => '#CCCCCC'
    ]);
}
}
