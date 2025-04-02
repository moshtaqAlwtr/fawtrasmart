<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'client_id', 'attendance_determinant_id', 'radius_type', 'radius', 'latitude', 'longitude'];

    // علاقة كثير إلى واحد مع جدول الموظفين (employees)
    public function employee()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة كثير إلى واحد مع جدول العملاء (clients)
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    // في ملف App\Models\Location.php
    public function attendanceDeterminant()
{
    return $this->belongsTo(AttendanceDeterminant::class);
    // إزالة العلاقة hasMany لأننا غيرناها إلى hasOne
}
}
