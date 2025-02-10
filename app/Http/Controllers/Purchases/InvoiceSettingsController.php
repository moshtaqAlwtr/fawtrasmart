<?php

namespace App\Http\Controllers\Purchases;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceSettingsController extends Controller
{
    public function index()
    {
        return view('purchases.invoice_settings.index');
    }
    public function create()
    {
        return view('purchases.invoice_settings.create');
    }
}
