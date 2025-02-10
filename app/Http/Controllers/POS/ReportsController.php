<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        return view('pos.Reports.index');
    }
    public function Category()
    {
        return view('pos.Reports.Category_Sales');
    }
    public function Product()
    {
        return view('pos.Reports.Product_Sales');
    }
    public function Shift()
    {
        return view('pos.Reports.Shift_Sales');
    }
    public function Detailed()
    {
        return view('pos.Reports.Detailed_Shift_Transactions');
    }
    public function Prof()
    {
        return view('pos_Reports.Shift_Profitability');
    }
    public function Cate()
    {
        return view('pos_Reports.Category_Profitability');
    }
    public function Prod()
    {
        return view('pos_Reports.Product_Profitability');
    }
}
