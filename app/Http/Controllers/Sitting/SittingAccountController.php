<?php

namespace App\Http\Controllers\Sitting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SittingAccountController extends Controller
{
    public function index()
    {
        return view('sitting.sittingAccount.index');
    }
}
