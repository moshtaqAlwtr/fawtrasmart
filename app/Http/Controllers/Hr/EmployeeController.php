<?php

namespace App\Http\Controllers\Hr;

use App\Exports\EmployeesExport;
use App\Models\Client;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Branch;
use App\Models\Department;
use App\Models\FunctionalLevels;
use App\Models\JobRole;
use App\Models\JopTitle;
use App\Models\Shift;
use App\Models\TypesJobs;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        $employees = Employee::select()->orderBy('id','DESC')->get();
        return view('hr.employee.index', compact('clients', 'employees'));
    }

    public function create()
    {
        $shifts = Shift::select('id','name')->get();
        $branches = Branch::select('id','name')->get();
        $job_types = TypesJobs::select('id','name')->get();
        $job_levels = FunctionalLevels::select('id','name')->get();
        $job_titles = JopTitle::select('id','name')->get();
        $departments = Department::select('id','name')->get();
        $job_roles = JobRole::select('id','role_name','role_type')->get();
        $employees = Employee::select('id','first_name','middle_name')->get();
        return view('hr.employee.create',compact('employees','job_roles','departments','job_titles','job_levels','job_types','branches','shifts'));
    }

    public function store(EmployeeRequest $request)
    {
        try{
            DB::beginTransaction();
            $employee_data = $request->except('_token','allow_system_access','send_credentials');

            $employee_data['created_by'] = auth()->user()->id;

            $employee = new Employee();

            if ($request->hasFile('employee_photo')) {
                $employee->employee_photo = $this->UploadImage('assets/uploads/employee',$request->employee_photo);
            }

            if($request->has('allow_system_access')){
                $employee->allow_system_access = 1;
            }

            if($request->has('send_credentials')){
                $employee->send_credentials = 1;
            }

            $new_employee = $employee->create($employee_data);

            if($request->has('phone_number')){

            }
            $user = User::create([
                'name' => $new_employee->full_name,
                'email' => $request->email,
                'phone' => $request->phone_number,
                'role' => 'employee',
                'employee_id' => $new_employee->id,
                'password' => Hash::make($request->phone_number),
            ]);

            $role = JobRole::where('id',$request->Job_role_id)->first();
            $role_name = $role->role_name;

            $user->assignRole($role_name);

            DB::commit();
            return redirect()->route('employee.show',$new_employee->id)->with( ['success'=>'تم اضافه الموظف بنجاج !!']);
        }catch(\Exception $exception){
            DB::rollback();
            return redirect()->route('employee.index')->with( ['error'=>$exception]);
        }

    }

    public function edit($id)
    {
        $shifts = Shift::select('id','name')->get();
        $branches = Branch::select('id','name')->get();
        $jobTypes = TypesJobs::select('id','name')->get();
        $jobLevels = FunctionalLevels::select('id','name')->get();
        $jobTitles = JopTitle::select('id','name')->get();
        $departments = Department::select('id','name')->get();
        $employees = Employee::select('id','first_name','middle_name')->get();
        $employee = Employee::findOrFail($id);
        return view('hr.employee.edit',compact('employee','employees','departments','jobTitles','jobLevels','jobTypes','branches','shifts'));
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        $employee_email = $employee->email;
        $user = User::where('email', $employee_email)->first();
        return view('hr.employee.show',compact('employee','user'));
    }

    public function update(EmployeeRequest $request,$id)
    {
        try{
            DB::beginTransaction();
            $employee_data = $request->except('_token','allow_system_access','send_credentials');

            $employee = Employee::findOrFail($id);

            if ($request->hasFile('employee_photo')) {
                $employee->employee_photo = $this->UploadImage('assets/uploads/employee',$request->employee_photo);
            }

            if($request->has('allow_system_access')){
                $employee->allow_system_access = 1;
            }

            if($request->has('send_credentials')){
                $employee->send_credentials = 1;
            }

            $employee->update($employee_data);

            User::where('employee_id',$id)->update([
                'name' => $employee->full_name,
                'email' => $request->email,
                'phone' => $request->phone_number,
                'role' => 'employee',
            ]);

            DB::commit();
            return redirect()->route('employee.show',$id)->with( ['success'=>'تم تحديث الموظف بنجاج !!']);
        }catch(\Exception $exception){
            DB::rollback();
            return redirect()->route('employee.index')->with( ['error'=>$exception]);
        }

    }

    public function delete($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return redirect()->back()->with( ['error'=>'تم حذف الموظف بنجاج !!']);
    }

    public function updatePassword(Request $request,$id)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'يرجى إدخال كلمة المرور الجديدة.',
            'password.min' => 'كلمة المرور يجب أن تحتوي على 8 أحرف على الأقل.',
            'password.confirmed' => 'تأكيد كلمة المرور لا يتطابق.',
        ]);
        $employee_email = Employee::findOrFail($id)->email;
        $user = User::where('email', $employee_email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with( ['success'=>'تم تغيير كلمة المرور بنجاح.']);
    }

    public function login_to($id)
    {
        if (!Auth::user()->role === 'manager') {
            abort(403, 'غير مسموح لك.');
        }

        $user = User::findOrFail($id);

        Auth::logout();
        Auth::login($user);
        return redirect()->route('dashboard_sales.index');
    }

    public function employee_management()
    {
        return view('hr.employee.employees_management');
    }

    public function manage_shifts()
    {
        return view('hr.employee.manage_shifts');
    }

    public function add_shift()
    {
        return view('hr.employee.add_shift');
    }

    public function add_new_role()
    {
        return view('hr.employee.add_new_role');
    }


    public function export_view()
    {
        return view('hr.employee.export');
    }

    public function export(Request $request)
    {

        $fields = $request->input('fields', []);

        if (empty($fields)) {
            return redirect()->back()->with(['error' => 'يرجى تحديد الحقول للتصدير!']);
        }

        return Excel::download(new EmployeesExport($fields), 'departments.xlsx');
    }





    # Helper Function
    function uploadImage($folder,$image)
    {
        $fileExtension = $image->getClientOriginalExtension();
        $fileName = time().rand(1,99).'.'.$fileExtension;
        $image->move($folder,$fileName);

        return $fileName;
    }//end of uploadImage

}
