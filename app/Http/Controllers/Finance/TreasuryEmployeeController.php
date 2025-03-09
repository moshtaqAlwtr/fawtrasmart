<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Employee;
use App\Models\Treasury;
use App\Models\TreasuryEmployee;
use Illuminate\Http\Request;

class TreasuryEmployeeController extends Controller
{
    public function index()
    {
        $treasury_employees = TreasuryEmployee::orderBy('id','DESC')->paginate(10);
        $employees = Employee::select('id',  'first_name','middle_name','nickname')->get();
        // $treasuries = Treasury::select('id','name')->get();
        $treasuries = Account::whereIn('parent_id', [13, 15])
        ->orderBy('id', 'DESC')
        ->paginate(10);
        return view('finance.treasury_employee.index',compact('treasury_employees','treasuries','employees'));
    }
    public function create()
    {
        $employees = Employee::select('id',  'first_name','middle_name','nickname')->get();
        $treasuries = Account::whereIn('parent_id', [13, 15])
        ->orderBy('id', 'DESC')
        ->paginate(10);
        return view('finance.treasury_employee.create',compact('treasuries','employees'));
    }

    public function store(Request $request)
    {
        TreasuryEmployee::create([
            'treasury_id' => $request->treasury_id,
            'employee_id' => $request->employee_id
        ]);
        return redirect()->route('finance_settings.treasury_employee')->with( ['success'=>'تم اضافه خزينة الموظف بنجاج !!']);
    }

    public function edit($id)
    {
        $treasury_employee = TreasuryEmployee::findOrFail($id);
        $employees = Employee::select('id',  'first_name','middle_name')->get();
        $treasuries = Account::whereIn('parent_id', [13, 15])
        ->orderBy('id', 'DESC')
        ->paginate(10);
        return view('finance.treasury_employee.edit',compact('treasury_employee','treasuries','employees'));
    }

    public function update(Request $request ,$id)
    {
        TreasuryEmployee::findOrFail($id)->update([
            'treasury_id' => $request->treasury_id,
            'employee_id' => $request->employee_id
        ]);
        return redirect()->route('finance_settings.treasury_employee')->with( ['success'=>'تم تحديث خزينة الموظف بنجاج !!']);
    }

    public function delete($id)
    {
        TreasuryEmployee::findOrFail($id)->delete();
        return redirect()->route('finance_settings.treasury_employee')->with( ['error'=>'تم حذف خزينة الموظف بنجاج !!']);
    }

}
