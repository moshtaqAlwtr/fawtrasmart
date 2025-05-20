<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Region_groub extends Model
{
    protected $table = 'region_groubs';
    protected $fillable = [ 'name'  , 'branch_id','directions_id' ];


     public function neighborhoods()
     {
         return $this->hasMany(Neighborhood::class, 'region_id');
     }

public function clients()
{
    return $this->belongsTo(Client::class);

}
public function branch()
{
    return $this->belongsTo(Branch::class , 'branch_id');
}
public function direction()
{
    return $this->belongsTo(Direction::class, 'directions_id');
    // لاحظ تغيير اسم الدالة إلى direction (مفرد) لأنها علاقة belongsTo
}
 public function employees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'employee_group')
                    ->withPivot('expires_at')
                    ->withTimestamps();
    }
}
