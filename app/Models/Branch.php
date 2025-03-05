<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    // تعيين الحقول القابلة للتحديث بشكل جماعي
    protected $fillable = [
        'name',
        'code',
        'phone',
        'mobile',
        'address1',
        'address2',
        'city',
        'status',
        'region',
        'country',
        'work_hours',
        'description',
        'location'
    ];
    public function settings()
    {
        return $this->belongsToMany(BranchSetting::class, 'branch_setting_branch')
            ->withPivot('status');
    }
    
    public function employees()
    {
        return $this->hasMany(Employee::class, 'branch_id');
    }

    
}
