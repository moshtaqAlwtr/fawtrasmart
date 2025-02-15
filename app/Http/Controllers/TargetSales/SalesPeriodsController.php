<?php

namespace App\Http\Controllers\TargetSales;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\SalesCommission;
use App\Models\User;
use Illuminate\Http\Request;

class SalesPeriodsController extends Controller
{
public function index()
{
    $employees = User::all();
    // $SalesCommission_periods = SalesCommission::all();
    $SalesCommission_periods = SalesCommission::with('employee', 'commission')
                                          ->selectRaw('employee_id, sum(sales_amount) as total_sales, sum(ratio) as total_ratio')
                                          ->groupBy('employee_id')
                                          ->get();


    return view('target_sales.salesPeriods.index',compact('SalesCommission_periods','employees'));

}
public function create()
{
$employees = Employee::all();
    return view('target_sales.salesPeriods.create',compact('employees'));
}
public function show($id)
{
    $employees = Employee::all();
    $SalesCommission_periods = SalesCommission::find($id);
    return view('target_sales.salesPeriods.show',compact('employees'));
}

}

