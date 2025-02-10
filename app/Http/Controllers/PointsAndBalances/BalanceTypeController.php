<?php

namespace App\Http\Controllers\PointsAndBalances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BalanceTypeController extends Controller
{
    public function index()
    {
        return view('pointsAndBalances.sitting.balanceType.index');
    }
    public function create()
    {
        return view('pointsAndBalances.sitting.balanceType.create');
    }
    public function show()
    {
        return view('pointsAndBalances.sitting.balanceType.show');
    }
    public function edit()
    {
        return view('pointsAndBalances.sitting.balanceType.edit');
    }
}
