<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'client_id',
        'visit_date',
        'status',
        'employee_latitude',
        'employee_longitude',
        'client_latitude',
        'client_longitude',
        'distance',
        'duration',
        'notes',
        'start_time',
        'end_time',
        'visit_type',
        'signature',
        'photos'
    ];

    protected $casts = [
        'visit_date' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'photos' => 'array'
    ];

    // علاقة كثير إلى واحد مع جدول الموظفين (employees)
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    // علاقة كثير إلى واحد مع جدول العملاء (clients)
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // حساب المسافة بين موظف والعميل

    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // نصف قطر الأرض بالمتر

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(
            pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)
        ));

        return $angle * $earthRadius;
    }

    // scope للزيارات القريبة
    public function scopeNearby($query, $latitude, $longitude, $radius = 1000)
    {
        return $query->whereRaw("
            ST_Distance_Sphere(
                point(client_longitude, client_latitude),
                point(?, ?)
            ) <= ?
        ", [$longitude, $latitude, $radius]);
    }
}
