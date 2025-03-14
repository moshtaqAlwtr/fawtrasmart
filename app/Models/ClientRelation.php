<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRelation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'status',
        'process',
        'time',
        'date',
        'description',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
