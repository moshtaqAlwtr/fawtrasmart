<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardSalesController extends Controller
{
    public function index()
    {
        return view('dashboard.sales.index');
    }
}
