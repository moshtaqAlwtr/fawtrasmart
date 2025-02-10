<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index(){
        return view('manufacturing.orders.index');
    }
    public function create(){
        return view('manufacturing.orders.create');
    }
}
