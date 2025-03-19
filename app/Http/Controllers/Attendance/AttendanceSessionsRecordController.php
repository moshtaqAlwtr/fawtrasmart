<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceSessionsRecordController extends Controller
{
    public function index()
    {
        return view('attendance.attendance-sessions-record.index');
}
}
