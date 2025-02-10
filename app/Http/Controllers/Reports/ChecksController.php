<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChecksController extends Controller
{
    public function index()
    {
        return view('reports.Checks.index');
    }
    public function delivered()
    {
        return view('reports.Checks.delivered-checks');
    }
    public function received()
    {
        return view('reports.Checks.received-checks');
    }
}
