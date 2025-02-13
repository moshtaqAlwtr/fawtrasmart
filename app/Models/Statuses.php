<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'statuses';

    protected $fillable = [
        'name',
        'color',
        'state',
        'supply_order_id', // Include the foreign key in fillable properties
    ];

    // Define the relationship to the Order model
    public function supplyOrder()
    {
        return $this->belongsTo(SupplyOrder::class);
    }
}
