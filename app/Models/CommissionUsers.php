<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionUsers extends Model
{
    protected $table = 'commission_users';
    protected $fillable = [
        'commission_id','employee_id'
    ];
}
