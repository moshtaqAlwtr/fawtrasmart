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
    public function Settings()
    {
        return view('orders.Settings.index');
    }
    public function type()
    {
        return view('orders.Settings.type');
    }
    public function create()
    {
        return view('orders.Settings.create');
    }
}
