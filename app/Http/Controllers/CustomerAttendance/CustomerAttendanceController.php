<?php

namespace App\Http\Controllers\CustomerAttendance;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CustomerAttendanceController extends Controller
{
    public function index(){
        return view('customer_attendance.index');
    }
}
