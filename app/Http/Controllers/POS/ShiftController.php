<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShiftController extends Controller

{

    public function index()
    {
        return view('pos.settings.shift.index');
    }
    public function Create()
    {
        return view('pos.settings.shift.create');
    }
}
