<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region_groub extends Model
{
    public function neighborhoods()
    {
        return $this->hasMany(Neighborhood::class, 'region_id');
    }

    // علاقة للوصول إلى العملاء عن طريق الأحياء

}
