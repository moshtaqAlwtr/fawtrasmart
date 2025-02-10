<?php

namespace App\Http\Controllers\PointsAndBalances;

use App\Http\Controllers\Controller;
use App\Models\Client;

use Illuminate\Http\Request;

class MangRechargeBalancesController extends Controller
{
    public function index()
    {
        return view('pointsAndBalances.mangRechargeBalances.index');
    }
    public function create()
    {
        $clients = Client::all();
        return view('pointsAndBalances.mangRechargeBalances.create', compact('clients'));
    }
    public function show()
    {
        return view('pointsAndBalances.mangRechargeBalances.show');
    }
    public function edit()
    {
        $clients = Client::all();
        return view('pointsAndBalances.mangRechargeBalances.edit', compact('clients'));
    }
}
