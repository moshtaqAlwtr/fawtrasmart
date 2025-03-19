<?php

// مثال في AttendanceRecordsController
namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Employee;

class AttendanceRecordsController extends Controller
{
    public function index()
    {
        $employees = Employee::select('id',  'first_name','middle_name',)->get();
        return view('attendance.attendance_records.index',compact('employees'));
    }

    public function create()
    {
        return view('attendance.attendance_records.create');
    }
}
