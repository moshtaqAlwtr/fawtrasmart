<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        return view('pos.reports.index');
    }
    public function Category()
    {
        return view('pos.reports.category_sales');
    }
    public function Product()
    {
        return view('pos.reports.product_sales');
    }
    public function Shift()
    {
        return view('pos.reports.shift_sales');
    }
    public function Detailed()
    {
        return view('pos.reports.detailed_shift_transactions');
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
