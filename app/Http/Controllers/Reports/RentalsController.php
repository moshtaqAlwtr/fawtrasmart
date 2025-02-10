<?php
namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;

class RentalsController extends Controller
{
    public function index()
    {
        return view('Reports.Rentals.index');
    }

    public function AvailableUnits()
    {
        return view('Reports.Rentals.Available_Units');
    }

    public function UnitPricing()
    {
        return view('reports.Rentals.Unit_Pricing');
    }

    public function Subscriptions()
    {
        return view('reports.Rentals.subscriptions');
    }
}
