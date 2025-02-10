<?php

namespace App\Http\Controllers\PointsAndBalances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SittingController extends Controller
{
public function index()
{
    return view('pointsAndBalances.sitting.index');
}
}
