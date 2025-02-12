<?php

namespace App\Http\Controllers\Installments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InstallmentsController extends Controller
{
    public function index()
    {
        return view('installments.index');
    }
    public function agreement()
    {
        return view('installments.agreement_installments');
    }
}
