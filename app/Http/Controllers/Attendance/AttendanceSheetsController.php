<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceSheetsRequest;
use App\Models\AttendanceSheets;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use App\Models\JopTitle;
use App\Models\Shift;
use App\Models\Log as ModelsLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceSheetsController extends Controller
{
    public function index()
    {
        $attendanceSheets = AttendanceSheets::select()->orderBy('id','DESC')->get();

        $uniqueEmployees = $attendanceSheets->flatMap(function ($sheet) {
            return $sheet->employees->map(function ($employee) use ($sheet) {
                $employee->from_date = $sheet->from_date;
                $employee->to_date = $sheet->to_date;
                return $employee;
            });
        })->unique('id');


        return view('attendance.attendance_sheets.index',compact('attendanceSheets'));
    }
    public function create()
    {
        $employees = Employee::select('id',  'first_name','middle_name')->get();
        $branches = Branch::select('id','name')->get();
        $departments = Department::select('id','name')->get();
        $job_titles = JopTitle::select('id','name')->get();
        $shifts = Shift::select('id','name')->get();
        return view('attendance.attendance_sheets.create',compact('employees','branches','departments','job_titles','shifts'));
    }

    public function store(AttendanceSheetsRequest $request)
    {
        try {
            DB::beginTransaction();
            if ($request['use_rules'] === 'employees') {
                $attendance = AttendanceSheets::create([
                    'from_date' => $request['from_date'],
                    'to_date' => $request['to_date'],
                    'use_rules' => 2,
                ]);

            } elseif ($request['use_rules'] === 'rules') {
                $attendance = AttendanceSheets::create([
                    'from_date' => $request['from_date'],
                    'to_date' => $request['to_date'],
                    'branch_id' => $request['branch_id'],
                    'department_id' => $request['department_id'],
                    'job_title_id' => $request['job_title_id'],
                    'shift_id' => $request['shifts_id'],
                    'use_rules' => 1,
                ]);
            }




            $attendance->employees()->attach($request['employee_id']);

            ModelsLog::create([
    'type' => 'struct_log',
    'type_id' => $attendance->id, // ID النشاط المرتبط
    'type_log' => 'log', // نوع النشاط
    'description' => 'تم اضافة دفتر حضور',
    'created_by' => auth()->id(), // ID المستخدم الحالي
]);
            DB::commit();

            return redirect()->route('attendance_sheets.index')->with( ['success'=>'تم اضافه الحضور بنجاج !!']);

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with(['error' => 'حدث خطا ما يرجى المحاوله لاحقا']);
        }
    }

    public function edit($id)
    {
        $employees = Employee::select('id',  'first_name','middle_name')->get();
        $branches = Branch::select('id','name')->get();
        $departments = Department::select('id','name')->get();
        $job_titles = JopTitle::select('id','name')->get();
        $shifts = Shift::select('id','name')->get();
        $attendanceSheet = AttendanceSheets::findOrFail($id);
        return view('attendance.attendance_sheets.edit',compact('attendanceSheet','employees','branches','departments','job_titles','shifts'));
    }

    public function update(AttendanceSheetsRequest $request,$id)
    {
        try {
            DB::beginTransaction();
            $attendance = AttendanceSheets::findOrFail($id);
            if ($request['use_rules'] === 'employees') {
                $attendance->update([
                    'from_date' => $request['from_date'],
                    'to_date' => $request['to_date'],
                    'use_rules' => 2,
                ]);
            } elseif ($request['use_rules'] === 'rules') {
                $attendance->update([
                    'from_date' => $request['from_date'],
                    'to_date' => $request['to_date'],
                    'branch_id' => $request['branch_id'],
                    'department_id' => $request['department_id'],
                    'job_title_id' => $request['job_title_id'],
                    'shift_id' => $request['shifts_id'],
                    'use_rules' => 1,
                ]);
            }
            $attendance->employees()->sync($request['employee_id']);

                       ModelsLog::create([
    'type' => 'struct_log',
    'type_id' => $attendance->id, // ID النشاط المرتبط
    'type_log' => 'log', // نوع النشاط
    'description' => 'تم اضافة تعديل دفتر حضور',
    'created_by' => auth()->id(), // ID المستخدم الحالي
]);
            DB::commit();
            return redirect()->route('attendance_sheets.index')->with(['success' => 'تم تعديل الحضور بنجاح !!']);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with(['error' => 'حدث خطا ما يرجى المحاوله لاحقا']);
        }
    }

    public function delete($id)
    {
        $attendance = AttendanceSheets::findOrFail($id);
                               ModelsLog::create([
    'type' => 'struct_log',
    'type_id' => $attendance->id, // ID النشاط المرتبط
    'type_log' => 'log', // نوع النشاط
    'description' => 'تم  حذف دفتر حضور',
    'created_by' => auth()->id(), // ID المستخدم الحالي
]);
        if($attendance->status == 1){
            return redirect()->route('attendance_sheets.index')->with( ['error'=>'لا يمكن حذف دفتر الحضور الموافق عليه !!']);
        }
        $attendance->employees()->detach();
        $attendance->delete();
        return redirect()->route('attendance_sheets.index')->with( ['error'=>'تم حذف دفتر الحضور بنجاج !!']);
    }

}
