<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';
    protected $fillable = [
        'name', 'code', 'parent_id', 'type', 'category', 'balance', 'is_active', 'branch_id'
    ];

    // العلاقة مع الحسابات الفرعية
    public function children()
    {
        return $this->hasMany(Account::class, 'parent_id');
    }

    // العلاقة مع الحساب الرئيسي
    public function parent()
    {
        return $this->belongsTo(Account::class, 'parent_id');
    }

    // العلاقة مع المعاملات
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'account_id');
    }

    // العلاقة مع الحسابات التابعة للفرع
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // العلاقة مع الموظفين
    public function salesManager()
    {
        return $this->belongsToMany(Employee::class);
    }

    // العلاقة مع الحسابات التابعة للموظفين الذين يحصلون عليها صلاحية التصريح

public function customer()
{
    return $this->belongsTo(Client::class);
}

}
