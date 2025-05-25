<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRelation extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'status', 'process', 'time', 'date', 'employee_id', 'description', 'location_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // داخل ClientRelation.php
    public function location()
    {
        return $this->hasOne(Location::class, 'client_relation_id');
    }
    public function employee()
    {
        return $this->belongsTo(User::class);
    }
}
