<?php

namespace App\Http\Controllers\Sitting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentMethodsController extends Controller
{
    public function index()
    {
        return view('sitting.paymentMethod.index');
    }
    public function create()
    {
        return view('sitting.paymentMethod.create');
    }
}
