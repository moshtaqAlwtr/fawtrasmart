<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceDaysRequest;
use App\Models\AttendanceDays;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use App\Models\JopTitle;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceDaysController extends Controller
{
    public function index()
    {
        $attendance_days = AttendanceDays::select()->orderBy('id','DESC')->get();
        return view('Attendance.attendance_days.index',compact('attendance_days'));
    }

    public function create()
    {
        $employees = Employee::select('id',  'first_name','middle_name')->get();
        return view('Attendance.attendance_days.create',compact('employees'));
    }

    public function store(AttendanceDaysRequest $request)
    {
        $attendance = new AttendanceDays();
        $attendance->employee_id = $request->employee_id;
        $attendance->attendance_date = $request->attendance_date;
        $attendance->status = $request->status; // حاضر أو غائب أو إجازة

        if ($request->status === 'present') {
            $attendance->start_shift = $request->start_shift;
            $attendance->end_shift = $request->end_shift;
            $attendance->login_time = $request->login_time;
            $attendance->logout_time = $request->logout_time;
        } elseif ($request->status === 'absent') {
            $attendance->absence_type = $request->absence_type;
            $attendance->absence_balance = $request->absence_balance;
        }

        $attendance->notes = $request->notes ?? null;

        $attendance->save();

        return redirect()->route('attendanceDays.index')->with(['success'=>'تم انشاء ايام الحضور بنجاح']);
    }

    public function edit($id)
    {
        $employees = Employee::select('id',  'first_name','middle_name')->get();
        $attendanceDay = AttendanceDays::findOrFail($id);
        return view('Attendance.attendance_days.edit',compact('employees','attendanceDay'));
    }

    public function update(AttendanceDaysRequest $request, $id)
    {
        $attendance = AttendanceDays::findOrFail($id);
        $attendance->employee_id = $request->employee_id;
        $attendance->attendance_date = $request->attendance_date;
        $attendance->status = $request->status; // حاضر أو غائب أو إجازة

        if ($request->status === 'present') {
            $attendance->start_shift = $request->start_shift;
            $attendance->end_shift = $request->end_shift;
            $attendance->login_time = $request->login_time;
            $attendance->logout_time = $request->logout_time;
        } elseif ($request->status === 'absent') {
            $attendance->absence_type = $request->absence_type;
            $attendance->absence_balance = $request->absence_balance;
        }

        $attendance->notes = $request->notes ?? null;

        $attendance->update();

        return redirect()->route('attendanceDays.index')->with(['success'=>'تم تعديل ايام الحضور بنجاح']);
    }

    public function show($id)
    {
        $attendance_day = AttendanceDays::findOrFail($id);
        return view('Attendance.attendance_days.show',compact('attendance_day'));
    }

    public function delete($id)
    {
        $attendance = AttendanceDays::findOrFail($id);
        $attendance->delete();
        return redirect()->route('attendanceDays.index')->with(['error'=>'تم حذف ايام الحضور بنجاح']);
    }

    public function calculation()
    {
        $employees = Employee::select('id',  'first_name','middle_name')->get();
        $branches = Branch::select('id','name')->get();
        $departments = Department::select('id','name')->get();
        $job_titles = JopTitle::select('id','name')->get();
        $shifts = Shift::select('id','name')->get();
        return view('Attendance.attendance_days.Calculation',compact('employees','branches','departments','job_titles','shifts'));
    }

    public function calculateAttendance(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $employees = Employee::query();

        if ($request->has('department_id')) {
            $employees->where('department_id', $request->input('department_id'));
        }
        if ($request->has('job_title')) {
            $employees->where('job_title', $request->input('job_title'));
        }
        if ($request->has('employee_id')) {
            $employees->where('id', $request->input('employee_id'));
        }

        $employees = $employees->get();

        foreach ($employees as $employee) {
            $attendanceDays = AttendanceDays::where('employee_id', $employee->id)
                ->whereBetween('attendance_date', [$startDate, $endDate])
                ->get();

            $presentDays = $attendanceDays->where('status', 'present')->count();
            $absentDays = $attendanceDays->where('status', 'absent')->count();

            // إخراج النتائج (أو تخزينها)
            echo "Employee: {$employee->name}, Present: $presentDays, Absent: $absentDays";
        }
    }



    /* Helpers --------------------------------------------------------------*/

    public function calculateWorkHours($loginTime, $logoutTime)
    {
        $login = Carbon::parse($loginTime);
        $logout = Carbon::parse($logoutTime);

        $totalDuration = $login->diff($logout);

        $hours = $totalDuration->h;
        $minutes = $totalDuration->i;

        return [
            'hours' => $hours,
            'minutes' => $minutes,
        ];
    }



}
