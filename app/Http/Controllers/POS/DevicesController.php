<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DevicesController extends Controller

{

    public function index()
    {
        return view('pos.settings.devices.index');
    }
    public function Create()
    {
        return view('pos.settings.devices.create');
    }
}
