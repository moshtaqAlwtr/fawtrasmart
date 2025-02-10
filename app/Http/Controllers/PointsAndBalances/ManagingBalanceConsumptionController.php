<?php

namespace App\Http\Controllers\PointsAndBalances;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ManagingBalanceConsumptionController extends Controller
{
    public function index()
    {
        return view('pointsAndBalances.Managing_balance_consumption.index');
    }
    public function create()
    {
$clients = Client::all();
        return view('pointsAndBalances.Managing_balance_consumption.create', compact('clients'));
    }
    public function show()
    {
        return view('pointsAndBalances.Managing_balance_consumption.show');
    }
    public function edit()
    {
        return view('pointsAndBalances.Managing_balance_consumption.edit');
    }
}
