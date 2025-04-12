<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region_groub extends Model
{

     public function neighborhoods()
     {
         return $this->hasMany(Neighborhood::class, 'region_id');
     }

public function clients()
{
    return $this->belongsTo(Client::class);

}
}
