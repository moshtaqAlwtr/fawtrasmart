<?php

namespace App\Http\Controllers\SupplyOrders;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Employee;
use Illuminate\Http\Request;

class SupplyOrdersController extends Controller
{
    public function index()
    {
        $clients = Client::all();
$employees = Employee::all();
        return view('supplyOrders.index', compact('clients','employees'));
    }
public function create(){
    $clients = Client::all();
    return view('supplyOrders.create', compact('clients'));
}
public  function show(){
    return view('supplyOrders.show');
}
public function edit(){
    return view('supplyOrders.edit');
}
public function edit_status(){
    return view('supplyOrders.edit_status');
}

}
