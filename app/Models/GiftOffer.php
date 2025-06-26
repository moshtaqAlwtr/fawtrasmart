<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class GiftOffer extends Model
{
    protected $fillable = [
        'name',
        'target_product_id',
        'min_quantity',
        'gift_product_id',
        'gift_quantity',
        'start_date',
        'end_date',
        'is_for_all_clients',
    ];

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_gift_offer');
    }
   

    public function targetProduct()
    {
        return $this->belongsTo(Product::class, 'target_product_id');
    }

    public function giftProduct()
    {
        return $this->belongsTo(Product::class, 'gift_product_id');
    }
}
