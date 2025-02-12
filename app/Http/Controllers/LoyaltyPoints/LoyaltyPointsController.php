<?php

namespace App\Http\Controllers\LoyaltyPoints;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class LoyaltyPointsController extends Controller
{
    public function index()
    {
        return view('loyalty_points.index');
    }
    public function create()
    {
        return view('loyalty_points.create');
    }
    public function Settings()
    {
        return view('loyalty_points.settings');
    }
}
