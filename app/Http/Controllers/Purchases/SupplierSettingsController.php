<?php

namespace App\Http\Controllers\Purchases;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierSettingsController extends Controller
{
    public function index()
    {
        return view('purchases.supplier_settings.index');
    }
}
