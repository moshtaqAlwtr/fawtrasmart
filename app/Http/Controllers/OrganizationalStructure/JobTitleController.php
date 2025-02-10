<?php

namespace App\Http\Controllers\OrganizationalStructure;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\JopTitle;
use Illuminate\Http\Request;

class JobTitleController extends Controller
{
    public function index()
    {
        $titles = JopTitle::select()->orderBy('id', 'desc')->get();
        return view('organizational_structure.JobTitle.index',compact('titles'));
    }

    public function create()
    {
        $departments = Department::select('id', 'name')->get();
        return view('organizational_structure.JobTitle.create',compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
        ]);

        $title = new JopTitle();
        $title->name = $request->name;
        $title->description = $request->description;
        $title->status = $request->status;
        $title->department_id = $request->department_id;
        $title->save();

        return redirect()->route('JobTitles.index')->with( ['success'=>'تم اضافه مسميه وظيفي بنجاج !!']);
    }

    public function show($id)
    {
        $title = JopTitle::find($id);
        return view('organizational_structure.JobTitle.show',compact('title'));
    }
    public function edit($id)
    {
        $departments = Department::select('id', 'name')->get();
        $title = JopTitle::find($id);
        return view('organizational_structure.JobTitle.edit',compact('title','departments'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
        ]);

        $title = JopTitle::find($id);
        $title->name = $request->name;
        $title->description = $request->description;
        $title->status = $request->status;
        $title->department_id = $request->department_id;
        $title->save();

        return redirect()->route('JobTitles.index')->with( ['success'=>'تم تعديل مسمى وظيفي بنجاج !!']);
    }

    public function delete($id)
    {
        $title = JopTitle::find($id);
        $title->delete();
        return redirect()->route('JobTitles.index')->with( ['error'=>'تم حذف مسمى وظيفي بنجاج !!']);
    }

    public function updateStatus($id)
    {
        $title = JopTitle::find($id);

        if (!$title) {
            return redirect()->route('JobTitles.show',$id)->with(['error' => 'نوع الوظيفة غير موجود!']);
        }

        $title->update(['status' => !$title->status]);

        return redirect()->route('JobTitles.show',$id)->with(['success' => 'تم تحديث حالة نوع وظيفة بنجاح!']);
    }

}
