<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class notifications extends Model // تغيير notifications إلى Notification (أفضل ممارسة)
{
    protected $table = 'notifications';
    protected $fillable = [
        'user_id', // أضف هذا الحقل
        'title',
        'description',
        'read',
        'type'
    ];

    // علاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
