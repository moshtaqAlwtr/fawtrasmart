<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
   public function Region()
{
    return $this->belongsTo(Region_groub::class, 'region_id');
}

}
