<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class BOMController extends Controller
{
    public function index()
    {
        return view('Manufacturing.BOM.index');
    }
    public function create()
    {
        $products = Product::select()->get();
        return view('Manufacturing.BOM.create', compact('products'));
    }
}
