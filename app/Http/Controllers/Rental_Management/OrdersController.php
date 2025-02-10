<?php

namespace App\Http\Controllers\Rental_Management;

use App\Http\Controllers\Controller;
use App\Models\UnitType;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        return view('rental_management.orders.index');
    }
    
    
        public function create()
        {
            $unitTypes = UnitType::with('pricingRule')->get(); // جلب البيانات مع قواعد التسعير
            return view('rental_management.orders.create', compact('unitTypes'));
        }
        
    }
    

