<?php

namespace App\Http\Controllers\PointsAndBalances;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class PackageManagementController extends Controller
{
 public function index()
 {
  return view('pointsAndBalances.package_management.index');
 }
public function create()
{
$employees = Employee::all();
 return view('pointsAndBalances.package_management.create', compact('employees'));
}
public function show()
{
 return view('pointsAndBalances.package_management.show');
}
public function edit()
{
 return view('pointsAndBalances.package_management.edit');
}
}
