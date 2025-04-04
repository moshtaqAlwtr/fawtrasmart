<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'client_id','branch_id', 'latitude', 'longitude'];

    // علاقة كثير إلى واحد مع جدول الموظفين (employees)
    public function employee()
    {
        return $this->belongsTo(User::class);
    }
public function branch()
{
    return $this->belongsTo(Branch::class, 'branch_id');
}

    // علاقة كثير إلى واحد مع جدول العملاء (clients)
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

}
