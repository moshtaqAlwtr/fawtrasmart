<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['number_suply', 'trade_name', 'first_name', 'last_name', 'phone', 'mobile', 'email', 'street1', 'street2', 'city', 'region', 'postal_code', 'country', 'tax_number', 'commercial_registration', 'opening_balance', 'opening_balance_date', 'currency', 'notes', 'attachments', 'created_by', 'updated_by'];

    protected $casts = [
        'opening_balance' => 'decimal:2',
        'opening_balance_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // العلاقة مع جدول المستخدمين (من أنشأ السجل)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    // العلاقة مع جدول المستخدمين (من عدل السجل)
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // العلاقة مع جدول جهات الاتصال
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    // دالة للحصول على الاسم الكامل
    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    // دالة للحصول على العنوان الكامل
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

    // دالة لحفظ المرفقات
    public function setAttachmentsAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['attachments'] = json_encode($value);
        }
    }

    // دالة لاسترجاع المرفقات
    public function getAttachmentsAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    // نطاق البحث
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($query) use ($term) {
            $query
                ->where('trade_name', 'like', "%{$term}%")
                ->orWhere('first_name', 'like', "%{$term}%")
                ->orWhere('last_name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('phone', 'like', "%{$term}%")
                ->orWhere('mobile', 'like', "%{$term}%")
                ->orWhere('tax_number', 'like', "%{$term}%")
                ->orWhere('commercial_registration', 'like', "%{$term}%");
        });
    }

    // نطاق التصفية حسب البلد
    public function scopeByCountry($query, $country)
    {
        return $query->where('country', $country);
    }

    // نطاق للموردين النشطين (الذين لديهم معاملات حديثة)
    public function scopeActive($query)
    {
        return $query->whereHas('transactions', function ($query) {
            $query->where('created_at', '>=', now()->subMonths(6));
        });
    }

    // Boot method للتعامل مع الأحداث
    protected static function boot()
    {
        parent::boot();

        // تسجيل المستخدم الذي أنشأ السجل
        static::creating(function ($supplier) {
            if (auth()->check()) {
                $supplier->created_by = auth()->id();
            }
        });

        // تسجيل المستخدم الذي عدل السجل
        static::updating(function ($supplier) {
            if (auth()->check()) {
                $supplier->updated_by = auth()->id();
            }
        });
    }
}
