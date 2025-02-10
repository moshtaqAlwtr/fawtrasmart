<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\LeavePermissions;
use Illuminate\Http\Request;

class LeavePermissionsController extends Controller
{
    public function index()
    {
        $leavePermissions = LeavePermissions::select()->orderBy('id','DESC')->get();
        return view('attendance.leave-permissions.index',compact('leavePermissions'));
    }
    public function create()
    {
        $employees = Employee::select('id',  'first_name','middle_name')->get();
        return view('attendance.leave-permissions.create',compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'type' => 'required',
            'leave_type' => 'required',
        ]);

        $leavePermissions = new LeavePermissions();

        $leavePermissions->employee_id = $request->employee_id;
        $leavePermissions->start_date = $request->start_date;
        $leavePermissions->end_date = $request->end_date;
        $leavePermissions->type = $request->type;
        $leavePermissions->leave_type = $request->leave_type;
        $leavePermissions->submission_date = $request->submission_date;
        $leavePermissions->notes = $request->notes;

        if ($request->hasFile('attachments')) {
            $leavePermissions->attachments = $this->UploadImage('assets/uploads/leave_permissions', $request->attachments);
        }

        $leavePermissions->save();

        return redirect()->route('leave_permissions.index')->with(['success'=>'تم انشاء اذن الاجازة بنجاح']);
    }

    public function edit($id)
    {
        $leavePermission = LeavePermissions::findOrFail($id);
        $employees = Employee::select('id',  'first_name','middle_name')->get();
        return view('attendance.leave-permissions.edit',compact('leavePermission','employees'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'employee_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'type' => 'required',
            'leave_type' => 'required',
        ]);

        $leavePermission = LeavePermissions::findOrFail($id);

        $leavePermission->employee_id = $request->employee_id;
        $leavePermission->start_date = $request->start_date;
        $leavePermission->end_date = $request->end_date;
        $leavePermission->type = $request->type;
        $leavePermission->leave_type = $request->leave_type;
        $leavePermission->submission_date = $request->submission_date;
        $leavePermission->notes = $request->notes;

        if ($request->hasFile('attachments')) {
            if ($leavePermission->attachments != null) {
                unlink('assets/uploads/leave_permissions/'.$leavePermission->attachments);
            }
            $leavePermission->attachments = $this->UploadImage('assets/uploads/leave_permissions', $request->attachments);
        }

        $leavePermission->update();

        return redirect()->route('leave_permissions.index')->with(['success'=>'تم تعديل اذن الاجازة بنجاح']);
    }

    public function show($id)
    {
        $leavePermission = LeavePermissions::findOrFail($id);
        return view('attendance.leave-permissions.show',compact('leavePermission'));
    }

    public function delete($id)
    {
        $leavePermission = LeavePermissions::findOrFail($id);
        if ($leavePermission->attachments != null) {
            unlink('assets/uploads/leave_permissions/'.$leavePermission->attachments);
        }
        $leavePermission->delete();
        return redirect()->route('leave_permissions.index')->with(['success'=>'تم حذف اذن الاجازة بنجاح']);
    }


    # Helpper
    function uploadImage($folder,$image)
    {
        $fileExtension = $image->getClientOriginalExtension();
        $fileName = time().rand(1,99).'.'.$fileExtension;
        $image->move($folder,$fileName);

        return $fileName;
    }#end of uploadImage


}
