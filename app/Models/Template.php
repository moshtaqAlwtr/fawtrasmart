<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
      protected $fillable = [
        'name',
        'type',
        'content', // أضف هذا الحقل
        'thumbnail',
        'is_default'
    ];
}
