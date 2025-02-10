<?php

namespace App\Http\Controllers\OrganizationalStructure;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Exports\DepartmentsExport;
use Maatwebsite\Excel\Facades\Excel;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::select()->orderByDesc('id')->get();

        return view('organizational_structure.department.index', compact('departments'));
    }

    public function create()
    {
        $departments = Department::all();
        $employees = Employee::select('id', 'first_name', 'middle_name')->get();
        return view('organizational_structure.department.create', compact('employees', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'short_name' => 'nullable|string|max:50',
                'status' => 'required|in:0,1',
                'description' => 'nullable|string',
                'employee_id' => 'nullable|array',
                'employee_id.*' => 'exists:employees,id',
            ],
            [
                'name.required' => 'الرجاء إدخال اسم القسم.',
                'status.required' => 'الرجاء تحديد الحالة.',
                'status.in' => 'الحالة يجب أن تكون نشط أو غير نشط.',
            ],);

            $department = Department::create([
                'name' => $request->name,
                'short_name' => $request->short_name,
                'status' => $request->status,
                'description' => $request->description,
            ]);

            if ($request->has('employee_id')) {
                $department->employees()->sync($request->employee_id);
            }

            return redirect()->route('department.index')->with(['success' => 'تم اضافه قسم بنجاج !!']);
    }

    public function show($id)
    {
        $department = Department::findOrFail($id);
        return view('organizational_structure.department.show', compact('department'));
    }
    public function edit($id)
    {
        $department = Department::findOrFail($id);
        $employees = Employee::select('id', 'first_name', 'middle_name')->get();
        $selectedEmployees = $department->employees->pluck('id')->toArray();
        return view('organizational_structure.department.edit', compact('employees', 'department', 'selectedEmployees'));
    }

    public function update(Request $request,$id)
    {

        $department = Department::find($id);
        if (!$department) {
            return redirect()->route('departments.index')->with(['error' => 'القسم غير موجود']);
        }

        $request->validate(
            [
                'name' => 'required|string|max:255',
                'short_name' => 'nullable|string|max:50',
                'status' => 'required|in:0,1',
                'description' => 'nullable|string',
                'employee_id' => 'nullable|array',
                'employee_id.*' => 'exists:employees,id',
            ],
            [
                'name.required' => 'الرجاء إدخال اسم القسم.',
                'status.required' => 'الرجاء تحديد الحالة.',
                'status.in' => 'الحالة يجب أن تكون نشط أو غير نشط.',
            ],
        );

            $department->update([
                'name' => $request->name,
                'short_name' => $request->short_name,
                'status' => $request->status,
                'description' => $request->description,
            ]);

            if ($request->has('employee_id')) {
                $department->employees()->sync($request->employee_id);
            }

            return redirect()->route('department.index')->with(['success' => 'تم تحديث بيانات القسم بنجاح']);
    }

    public function delete($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return redirect()->route('departments.index')->with(['error' => 'القسم غير موجود']);
        }

        $department->delete();

        return redirect()->route('department.index')->with(['error'=>'تم حذف القسم بنجاح']);
    }

    public function updateStatus($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return redirect()->route('department.show',$id)->with(['error' => ' القسم غير موجود!']);
        }

        $department->update(['status' => !$department->status]);

        return redirect()->route('department.show',$id)->with(['success' => 'تم تحديث حالة القسم بنجاح!']);
    }

    public function export_view()
    {
        return view('organizational_structure.department.export');
    }

    public function export(Request $request)
    {

        $fields = $request->input('fields', []);

        if (empty($fields)) {
            return redirect()->back()->with(['error' => 'يرجى تحديد الحقول للتصدير!']);
        }

        return Excel::download(new DepartmentsExport($fields), 'departments.xlsx');
    }

}
