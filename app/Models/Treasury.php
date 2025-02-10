<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treasury extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'type', 'status', 'description', 'bank_name', 'account_number', 'currency',
        'deposit_permissions', 'withdraw_permissions', 'value_of_deposit_permissions',
        'value_of_withdraw_permissions', 'created_at', 'updated_at'
    ];

    public function payments()
    {
        return $this->hasMany(ClientPayment::class, 'treasury_id'); // المفتاح الأساسي يجب أن يكون 'id'
    }

}
