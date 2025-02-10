<?php

namespace App\Http\Controllers\Attendance\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FlagsController extends Controller
{
    public function index()
    {
        return view('attendance.settings.flags.index');
    }
    public function create()
    {
        return view('attendance.settings.flags.create');
    }
}
