<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Treasury;
use Illuminate\Http\Request;

class TreasuryController extends Controller
{
    public function index()
    {
        $treasuries = Treasury::orderBy('id','DESC')->paginate(10);
        return view('finance.treasury.index',compact('treasuries'));
    }

    public function create()
    {
        $employees = Employee::select()->get();
        return view('finance.treasury.carate',compact('employees'));
    }

    public function store(Request $request)
    {
        $treasury = new Treasury();

        $treasury->name = $request->name;
        $treasury->type = 0 ; # خزينه
        $treasury->status = $request->status;
        $treasury->description = $request->description;
        $treasury->deposit_permissions = $request->deposit_permissions;
        $treasury->withdraw_permissions = $request->withdraw_permissions;
        $treasury->value_of_deposit_permissions = $request->value_of_deposit_permissions;
        $treasury->value_of_withdraw_permissions = $request->value_of_withdraw_permissions;

        #permissions-----------------------------------

        # view employee
        if(($request->deposit_permissions == 1)){
            $treasury->value_of_deposit_permissions = $request->v_employee_id;
        }
        # view functional_role
        elseif(($request->deposit_permissions == 2)){
            $treasury->value_of_deposit_permissions = $request->v_functional_role_id	;
        }
        # view branch
        else{
            $treasury->value_of_deposit_permissions = $request->v_branch_id	;
        }


        # view employee
        if(($request->withdraw_permissions == 1)){
            $treasury->value_of_withdraw_permissions = $request->c_employee_id;
        }
        # view functional_role
        elseif(($request->withdraw_permissions == 2)){
            $treasury->value_of_withdraw_permissions = $request->c_functional_role_id	;
        }
        # view branch
        else{
            $treasury->value_of_withdraw_permissions = $request->c_branch_id	;
        }

        $treasury->save();
        return redirect()->route('treasury.index')->with(key: ['success'=>'تم اضافه الخزينة بنجاج !!']);

    }

    public function edit($id)
    {
        $treasury = Treasury::findOrFail($id);
        $employees = Employee::select()->get();
        return view('finance.treasury.edit',compact('treasury','employees'));
    }

    public function update(Request $request ,$id)
    {
        $treasury = Treasury::findOrFail($id);

        $treasury->name = $request->name;
        $treasury->type = 0 ; # خزينه
        $treasury->status = $request->status;
        $treasury->description = $request->description;
        $treasury->deposit_permissions = $request->deposit_permissions;
        $treasury->withdraw_permissions = $request->withdraw_permissions;
        $treasury->value_of_deposit_permissions = $request->value_of_deposit_permissions;
        $treasury->value_of_withdraw_permissions = $request->value_of_withdraw_permissions;

        #permissions-----------------------------------

        # view employee
        if(($request->deposit_permissions == 1)){
            $treasury->value_of_deposit_permissions = $request->v_employee_id;
        }
        # view functional_role
        elseif(($request->deposit_permissions == 2)){
            $treasury->value_of_deposit_permissions = $request->v_functional_role_id	;
        }
        # view branch
        else{
            $treasury->value_of_deposit_permissions = $request->v_branch_id	;
        }


        # view employee
        if(($request->withdraw_permissions == 1)){
            $treasury->value_of_withdraw_permissions = $request->c_employee_id;
        }
        # view functional_role
        elseif(($request->withdraw_permissions == 2)){
            $treasury->value_of_withdraw_permissions = $request->c_functional_role_id	;
        }
        # view branch
        else{
            $treasury->value_of_withdraw_permissions = $request->c_branch_id	;
        }

        $treasury->update();
        return redirect()->route('treasury.index')->with(key: ['success'=>'تم تحديث الخزينة بنجاج !!']);
    }

    public function create_account_bank()
    {
        $employees = Employee::select()->get();
        return view('finance.treasury.create_account_bank',compact('employees'));
    }

    public function store_account_bank(Request $request)
    {
        $treasury = new Treasury();

        $treasury->name = $request->name;
        $treasury->type = 1 ; # حساب بنكي
        $treasury->bank_name = $request->bank_name;
        $treasury->account_number = $request->account_number;
        $treasury->currency = $request->currency;
        $treasury->status = $request->status;
        $treasury->description = $request->description;
        $treasury->deposit_permissions = $request->deposit_permissions;
        $treasury->withdraw_permissions = $request->withdraw_permissions;
        $treasury->value_of_deposit_permissions = $request->value_of_deposit_permissions;
        $treasury->value_of_withdraw_permissions = $request->value_of_withdraw_permissions;

        #permissions-----------------------------------

        # view employee
        if(($request->deposit_permissions == 1)){
            $treasury->value_of_deposit_permissions = $request->v_employee_id;
        }
        # view functional_role
        elseif(($request->deposit_permissions == 2)){
            $treasury->value_of_deposit_permissions = $request->v_functional_role_id	;
        }
        # view branch
        else{
            $treasury->value_of_deposit_permissions = $request->v_branch_id	;
        }


        # view employee
        if(($request->withdraw_permissions == 1)){
            $treasury->value_of_withdraw_permissions = $request->c_employee_id;
        }
        # view functional_role
        elseif(($request->withdraw_permissions == 2)){
            $treasury->value_of_withdraw_permissions = $request->c_functional_role_id	;
        }
        # view branch
        else{
            $treasury->value_of_withdraw_permissions = $request->c_branch_id	;
        }

        $treasury->save();
        return redirect()->route('treasury.index')->with(key: ['success'=>'تم اضافه الحساب بنجاج !!']);

    }

    public function edit_account_bank($id)
    {
        $treasury = Treasury::findOrFail($id);
        $employees = Employee::select()->get();
        return view('finance.treasury.edit_account_bank',compact('treasury','employees'));
    }

    public function update_account_bank(Request $request ,$id)
    {
        $treasury = Treasury::findOrFail($id);

        $treasury->name = $request->name;
        $treasury->type = 1 ; # حساب بنكي
        $treasury->status = $request->status;
        $treasury->bank_name = $request->bank_name;
        $treasury->account_number = $request->account_number;
        $treasury->currency = $request->currency;
        $treasury->description = $request->description;
        $treasury->deposit_permissions = $request->deposit_permissions;
        $treasury->withdraw_permissions = $request->withdraw_permissions;
        $treasury->value_of_deposit_permissions = $request->value_of_deposit_permissions;
        $treasury->value_of_withdraw_permissions = $request->value_of_withdraw_permissions;

        #permissions-----------------------------------

        # view employee
        if(($request->deposit_permissions == 1)){
            $treasury->value_of_deposit_permissions = $request->v_employee_id;
        }
        # view functional_role
        elseif(($request->deposit_permissions == 2)){
            $treasury->value_of_deposit_permissions = $request->v_functional_role_id	;
        }
        # view branch
        else{
            $treasury->value_of_deposit_permissions = $request->v_branch_id	;
        }


        # view employee
        if(($request->withdraw_permissions == 1)){
            $treasury->value_of_withdraw_permissions = $request->c_employee_id;
        }
        # view functional_role
        elseif(($request->withdraw_permissions == 2)){
            $treasury->value_of_withdraw_permissions = $request->c_functional_role_id	;
        }
        # view branch
        else{
            $treasury->value_of_withdraw_permissions = $request->c_branch_id	;
        }

        $treasury->update();
        return redirect()->route('treasury.index')->with(key: ['success'=>'تم تحديث الحساب بنجاج !!']);
    }

    public function show($id)
    {
        $treasury = Treasury::findOrFail($id);
        return view('finance.treasury.show',compact('treasury'));
    }

}
