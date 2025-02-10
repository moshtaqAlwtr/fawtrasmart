<?php

namespace App\Http\Controllers\Rental_Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('rental_management.settings.index');
    }   
}
