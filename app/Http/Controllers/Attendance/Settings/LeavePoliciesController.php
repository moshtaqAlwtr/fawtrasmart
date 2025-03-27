<?php

namespace App\Http\Controllers\Attendance\Settings;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use App\Models\JopTitle;
use App\Models\LeavePolicy;
use App\Models\LeavePolicyCustomize;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeavePoliciesController extends Controller
{
    public function index()
    {
        $leave_policies = LeavePolicy::select()->orderBy('id','DESC')->get();



        return view('attendance.settings.leave_policies.index',compact('leave_policies'));
    }
    public function create ()
    {
        $leave_types = LeaveType::select('id','name')->get();
        return view('attendance.settings.leave_policies.create',compact('leave_types'));
    }

    public function store(Request $request)
    {
        try{
            DB::beginTransaction();

            $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|in:0,1',
                'leave_type_id' => 'required|array',
                'leave_type_id.*' => 'required|integer|exists:leave_types,id',

            ]);

            $leave_policy = LeavePolicy::create([
                'name' => $request->name,
                'status' => $request->status,
                'description' => $request->description
            ]);

            $leave_policy->leaveType()->attach($request->leave_type_id);

            DB::commit();
            return redirect()->route('leave_policy.index')->with(['success'=>'تمت اضافة سياسة الاجازات بنجاح']);
        }
        catch(\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with(['error'=>$exception->getMessage()]);
        }
    }

    public function edit($id)
    {
        $leave_policy = LeavePolicy::findOrFail($id);
        $leave_types = LeaveType::select('id','name')->get();
        return view('attendance.settings.leave_policies.edit',compact('leave_policy','leave_types'));
    }

    public function update(Request $request, $id)
    {
        try{
            DB::beginTransaction();

            $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|in:0,1',
                'leave_type_id' => 'required|array',
                'leave_type_id.*' => 'required|integer|exists:leave_types,id',

            ]);

            $leave_policy = LeavePolicy::findOrFail($id);

            $leave_policy->update([
                'name' => $request->name,
                'status' => $request->status,
                'description' => $request->description
            ]);

            $leave_policy->leaveType()->sync($request->leave_type_id);

            DB::commit();
            return redirect()->route('leave_policy.index')->with(['success'=>'تمت اضافة سياسة الاجازات بنجاح']);
        }
        catch(\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with(['error'=>$exception->getMessage()]);
        }
    }

    public function show($id)
    {
        $leave_policy = LeavePolicy::findOrFail($id);
        return view('attendance.settings.leave_policies.show',compact('leave_policy'));
    }

    public function delete($id)
    {
        $leave_policy = LeavePolicy::findOrFail($id);
        $leave_policy->delete();
        return redirect()->route('leave_policy.index')->with(['error'=>'تم حذف سياسة الاجازات بنجاح']);
    }

    public function updateStatus($id)
    {
        $leave_policy = LeavePolicy::find($id);

        if (!$leave_policy) {
            return redirect()->route('leave_policy.show',$id)->with(['error' => 'سياسة الاجازات غير موجودة!']);
        }

        $leave_policy->status = !$leave_policy->status;
        $leave_policy->save();

        return redirect()->route('leave_policy.show',$id)->with(['success' => 'تم تغيير حالة سياسة الاجازات بنجاح']);
    }

    public function leave_policy_employees($id)
    {
        $leave_policy = LeavePolicy::find($id);
        $employees = Employee::select('id',  'first_name','middle_name')->get();
        $branches = Branch::select('id','name')->get();
        $departments = Department::select('id','name')->get();
        $job_titles = JopTitle::select('id','name')->get();
        return view('attendance.settings.leave_policies.leave_policy_employees',compact('leave_policy','employees','branches','departments','job_titles'));
    }

    public function add_leave_policy_employees(Request $request,$id)
    {
        try {
            DB::beginTransaction();
            // LeavePolicyCustomize::where('leave_policy_id', $id)->first();

            if ($request['use_rules'] === 'employees') {
                $holiday_list_customize = LeavePolicyCustomize::updateOrCreate([
                    'leave_policy_id' => $id,
                    'use_rules' => 2,
                ]);

            } elseif ($request['use_rules'] === 'rules') {
                $holiday_list_customize = LeavePolicyCustomize::updateOrCreate([
                    'leave_policy_id' => $id,
                    'branch_id' => $request['branch_id'],
                    'department_id' => $request['department_id'],
                    'job_title_id' => $request['job_title_id'],
                    'use_rules' => 1,
                ]);
            }

            $holiday_list_customize->employees()->sync($request['employee_id']);
            DB::commit();

            return redirect()->route('leave_policy.show',$id)->with(['success'=>'تمت اضافة الموظفين لقايمة العطلات بنجاح']);

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with(['error' => $exception->getMessage()]);
        }
    }

}
