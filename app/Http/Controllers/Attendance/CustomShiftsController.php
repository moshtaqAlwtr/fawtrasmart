<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomShiftRequest;
use App\Models\Branch;
use App\Models\CustomShift;
use App\Models\Department;
use App\Models\Employee;
use App\Models\JopTitle;
use App\Models\Shift;
use App\Models\Log as ModelsLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomShiftsController extends Controller
{
    public function index()
    {
        $custom_shifts = CustomShift::select()->orderBy('id', 'desc')->get();
        return view('Attendance.custom_shifts.index', compact('custom_shifts'));
    }
    public function create()
    {
        $employees = Employee::select('id',  'first_name','middle_name')->get();
        $branches = Branch::select('id','name')->get();
        $departments = Department::select('id','name')->get();
        $job_titles = JopTitle::select('id','name')->get();
        $shifts = Shift::select('id','name')->get();
        return view('Attendance.custom_shifts.create',compact('employees','branches','departments','job_titles','shifts'));
    }

    public function store(CustomShiftRequest $request)
    {
        try {
            DB::beginTransaction();
            if ($request['use_rules'] === 'employees') {
                $custom_shift = CustomShift::create([
                    'name' => $request['name'],
                    'from_date' => $request['from_date'],
                    'to_date' => $request['to_date'],
                    'shift_id' => $request['shift_id'],
                    'use_rules' => 2,
                ]);

            } elseif ($request['use_rules'] === 'rules') {
                $custom_shift = CustomShift::create([
                    'name' => $request['name'],
                    'from_date' => $request['from_date'],
                    'to_date' => $request['to_date'],
                    'shift_id' => $request['shift_id'],
                    'branch_id' => $request['branch_id'],
                    'department_id' => $request['department_id'],
                    'job_title_id' => $request['job_title_id'],
                    'shift_rule_id' => $request['shift_rule_id'],
                    'use_rules' => 1,
                ]);
            }

            $custom_shift->employees()->attach($request['employee_id']);
            
                 ModelsLog::create([
    'type' => 'atendes_log',
    'type_id' => $custom_shift->id, // ID النشاط المرتبط
    'type_log' => 'log', // نوع النشاط
    'description' => 'تم   اضافة وردية متخصصة',
    'created_by' => auth()->id(), // ID المستخدم الحالي
]);
            DB::commit();

            return redirect()->route('custom_shifts.index')->with( ['success'=>'تم اضافه الحضور بنجاج !!']);

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with(['error' => 'حدث خطا ما يرجى المحاوله لاحقا']);
        }
    }

    public function edit($id)
    {
        $custom_shift = CustomShift::findOrFail($id);
        $employees = Employee::select('id',  'first_name','middle_name')->get();
        $branches = Branch::select('id','name')->get();
        $departments = Department::select('id','name')->get();
        $job_titles = JopTitle::select('id','name')->get();
        $shifts = Shift::select('id','name')->get();
        return view('Attendance.custom_shifts.edit',compact('custom_shift','employees','branches','departments','job_titles','shifts'));
    }

    public function update(CustomShiftRequest $request,$id)
    {
        try {
            DB::beginTransaction();
            $custom_shift = CustomShift::findOrFail($id);
            if ($request['use_rules'] === 'employees') {
                $custom_shift->update([
                    'name' => $request['name'],
                    'from_date' => $request['from_date'],
                    'to_date' => $request['to_date'],
                    'shift_id' => $request['shift_id'],
                    'use_rules' => 2,
                ]);
            } elseif ($request['use_rules'] === 'rules') {
                $custom_shift->update([
                    'name' => $request['name'],
                    'from_date' => $request['from_date'],
                    'to_date' => $request['to_date'],
                    'shift_id' => $request['shift_id'],
                    'branch_id' => $request['branch_id'],
                    'department_id' => $request['department_id'],
                    'job_title_id' => $request['job_title_id'],
                    'shift_rule_id' => $request['shift_rule_id'],
                    'use_rules' => 1,
                ]);
            }
            $custom_shift->employees()->sync($request['employee_id']);
                         ModelsLog::create([
    'type' => 'atendes_log',
    'type_id' => $custom_shift->id, // ID النشاط المرتبط
    'type_log' => 'log', // نوع النشاط
    'description' => 'تم   تعديل وريدة متخصصة',
    'created_by' => auth()->id(), // ID المستخدم الحالي
]);
            DB::commit();
            return redirect()->route('custom_shifts.index')->with(['success' => 'تم تعديل الحضور بنجاح !!']);

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with(['error' => 'حدث خطا ما يرجى المحاوله لاحقا']);
        }
    }

    public function show($id)
    {
        $custom_shift = CustomShift::findOrFail($id);

        return view('attendance.custom_shifts.show',compact('custom_shift'));
    }

    public function delete($id)
    {
        $custom_shift = CustomShift::findOrFail($id);
                                       ModelsLog::create([
    'type' => 'atendes_log',
    'type_id' => $custom_shift->id, // ID النشاط المرتبط
    'type_log' => 'log', // نوع النشاط
    'description' => 'تم   حذف وريدة متخصصة',
    'created_by' => auth()->id(), // ID المستخدم الحالي
]);
        $custom_shift->employees()->detach();
        $custom_shift->delete();
        return redirect()->route('custom_shifts.index')->with( ['error'=>'تم حذف الورديه بنجاج !!']);
    }


}
