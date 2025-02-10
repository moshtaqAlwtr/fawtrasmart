<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SittingInvoiceController extends Controller
{
    public function index()
    {
        return view('sales.sitting.index');
    }
}
