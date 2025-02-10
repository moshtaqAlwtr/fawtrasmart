<?php

namespace App\Http\Controllers\TargetSales;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class SalesPeriodsController extends Controller
{
public function index()
{
$employees = Employee::all();
    return view('target_sales.salesPeriods.index',compact('employees'));

}
public function create()
{
$employees = Employee::all();
    return view('target_sales.salesPeriods.create',compact('employees'));
}
public function show()
{
$employees = Employee::all();
    return view('target_sales.salesPeriods.show',compact('employees'));
}

}

