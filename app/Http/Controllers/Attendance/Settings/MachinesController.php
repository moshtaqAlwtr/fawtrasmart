<?php

namespace App\Http\Controllers\Attendance\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MachinesController extends Controller
{
    public function index()
    {
        return view('attendance.settings.machines.index');
    }
    public function create()
    {    
        return view('attendance.settings.machines.create');
    }
}
