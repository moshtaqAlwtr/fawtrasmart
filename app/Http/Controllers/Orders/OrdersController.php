<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        return view('orders.management.index');
    }
    public function create()
    {
        return view('orders.management.create');
    }
}
