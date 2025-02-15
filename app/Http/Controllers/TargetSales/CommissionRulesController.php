<?php

namespace App\Http\Controllers\TargetSales;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Commission_Products;
use App\Models\CommissionUsers;
use App\Models\Employee;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CommissionRulesController extends Controller
{
   public function index(){
       $commissions = Commission::all();
       return view('target_sales.commission_rules.index',compact('commissions'));
   }
public function create(){
         $employees  = User::select('id', 'name')->get();
         $products   = Product::select('id','name')->get();
         return view('commission.create', compact('employees','products'));
// $employees = Employee::all();
//     return view('target_sales.commission_rules.create',compact('employees'));
}
public function show($id){
     $commission = Commission::find($id);
     $commissionUsers = CommissionUsers::where('commission_id', $id)->get();
     $CommissionProducts = Commission_Products::where('commission_id',$id)->get();
    return view('target_sales.commission_rules.show',compact('commission','commissionUsers','CommissionProducts'));
}
public function edit(){
    $employees = Employee::all();
    return view('target_sales.commission_rules.edit',compact('employees'));
}

}
