<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'client_id',
        'phone',
        'password',
        'role',
        'branch_id',
        'employee_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isManager()
    {
        return $this->role === 'manager';
    }
    public function currentBranch()
    {
        return Branch::find($this->branch_id);
    }
public function invoices()
{
    return $this->hasMany(Invoice::class, 'created_by');
}
    public function target()
{
    return $this->hasOne(EmployeeTarget::class);
}
public function receipts()
{
    return $this->hasMany(Receipt::class, 'created_by');
}
public function employeeClients()
{
    return $this->hasMany(ClientEmployee::class, 'employee_id');
}

    public function isEmployee()
    {
        return $this->role === 'employee';
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

// داخل App\Models\User
public function employee()
{
    return $this->belongsTo(Employee::class, 'employee_id');
}


    public function notifications()
{
    return $this->hasMany(Notification::class);
}
}
