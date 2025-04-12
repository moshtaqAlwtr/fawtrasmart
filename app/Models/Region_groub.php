<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region_groub extends Model
{

    //
// في نموذج Region_groub (App\Models\Region_groub)
public function neighborhoods()
{
    return $this->hasMany(Neighborhood::class, 'region_id');
}
public function clients(){

    return $this->hasMany(Client::class);
}
}
