<?php

namespace App\Http\Controllers\Salaries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalarySittingController extends Controller
{
    public function index()
    {
        return view('salaries.sitting.index');
    }

}
