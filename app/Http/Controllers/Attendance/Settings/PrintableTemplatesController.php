<?php

namespace App\Http\Controllers\Attendance\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrintableTemplatesController extends Controller
{
    public function index()
    {
        return view('attendance.settings.printable-templates.index');
    }
    public function create()
    {    
        return view('attendance.settings.printable-templates.create');
    }
}
