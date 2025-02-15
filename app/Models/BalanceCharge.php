<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceCharge extends Model
{
    use HasFactory;

    protected $table = 'balance_charges';

    protected $fillable = [
        'client_id',
        'status',
        'value',
        'start_date',
        'end_date',
        'description',
        'contract_type',
    ];

    // Define relationships if needed
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function balanceType()
    {
        return $this->belongsTo(BalanceType::class, 'balance_type_id');
    }
}
