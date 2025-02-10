<?php

namespace App\Http\Controllers\TargetSales;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class CommissionRulesController extends Controller
{
   public function index(){
       return view('target_sales.commission_rules.index');
   }
public function create(){
$employees = Employee::all();
    return view('target_sales.commission_rules.create',compact('employees'));
}
public function show(){
    return view('target_sales.commission_rules.show');
}
public function edit(){
    $employees = Employee::all();
    return view('target_sales.commission_rules.edit',compact('employees'));
}

}
