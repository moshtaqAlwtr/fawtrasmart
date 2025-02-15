<?php

namespace App\Http\Controllers\TargetSales;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Commission_Products;
use App\Models\SalesCommission;
use Illuminate\Http\Request;

class SalesCommissionController extends Controller
{
public function index()
    {
        $SalesCommissions = SalesCommission::all();
        return view('target_sales.sales_commission.index',compact('SalesCommissions'));
    }
    public function show($id){
        $SalesCommission     = SalesCommission::find($id);
        $comissions = Commission::find($SalesCommission->commission_id);
        $SalesCommission_Products = SalesCommission::where('id', $id)->get();
        return view('target_sales.sales_commission.show',compact('SalesCommission','comissions','SalesCommission_Products'));

    }

}
