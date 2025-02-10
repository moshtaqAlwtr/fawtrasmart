<?php

namespace App\Http\Controllers\TargetSales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesCommissionController extends Controller
{
public function index()
    {
        return view('target_sales.sales_commission.index');
    }
    public function show(){
        return view('target_sales.sales_commission.show');

    }

}
