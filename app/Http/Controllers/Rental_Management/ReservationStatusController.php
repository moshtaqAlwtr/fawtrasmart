<?php

namespace App\Http\Controllers\Rental_Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationStatusController extends Controller
{
    public function index(){
        return view('rental_management.Settings.reservation-status.index');
    }
    public function create(){
        return view('rental_management.Settings.reservation-status.create');
    }
}
