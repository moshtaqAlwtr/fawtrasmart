<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryManagementController extends Controller
{
    public function index()
    {
        return view('stock.inventory_management.index');
    }
}
