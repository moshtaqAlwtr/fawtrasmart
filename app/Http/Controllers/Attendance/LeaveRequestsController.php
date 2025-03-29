<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LeaveRequestsController extends Controller
{
    public function index()
    {
        return view('attendance.leave_requests.index');
    }
    public function create()    
    {
        return view('attendance.leave_requests.create');
    }
}
