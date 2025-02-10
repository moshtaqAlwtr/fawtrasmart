<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('Manufacturing.settings.index');
    }
    public function General()
    {
        return view('Manufacturing.settings.General');
    }
    public function Paths()
    {
        return view('Manufacturing.settings.Paths.index');
    }
    public function Machines()
    {
        return view('Manufacturing.settings.Paths.create');
    }
    public function Manual()
    {
        return view('Manufacturing.settings.Manual');
    }
}
