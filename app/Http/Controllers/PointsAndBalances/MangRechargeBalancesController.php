<?php

namespace App\Http\Controllers\PointsAndBalances;

use App\Http\Controllers\Controller;
use App\Models\BalanceCharge;
use App\Models\BalanceType;
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
        $balanceTypes = BalanceType::all();
        return view('pointsAndBalances.mangRechargeBalances.create', compact('clients', 'balanceTypes'));
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'status' => 'required|exists:balance_types,id',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'required|string',
            'contract_type' => 'boolean',
        ]);

        // Create a new BalanceCharge record
        BalanceCharge::create($validatedData);

        // Redirect back with a success message
        return redirect()->route('MangRechargeBalances.index')->with('success', 'Balance charge added successfully.');
    }

    public function update(Request $request, $id)
    {
        // Find the BalanceCharge record by ID
        $balanceCharge = BalanceCharge::findOrFail($id);

        // Validate the incoming request data
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'status' => 'required|exists:balance_types,id',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'required|string',
            'contract_type' => 'boolean',
        ]);

        // Update the BalanceCharge record
        $balanceCharge->update($validatedData);

        // Redirect back with a success message
        return redirect()->route('MangRechargeBalances.index')->with('success', 'Balance charge updated successfully.');
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
    public function destroy($id)
    {
        // Find the BalanceCharge record by ID
        $balanceCharge = BalanceCharge::findOrFail($id);

        // Delete the BalanceCharge record
        $balanceCharge->delete();

        // Redirect back with a success message
        return redirect()->route('mangRechargeBalances.index')->with('success', 'Balance charge deleted successfully.');
    }
}

