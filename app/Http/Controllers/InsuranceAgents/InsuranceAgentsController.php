<?php

namespace App\Http\Controllers\InsuranceAgents;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class InsuranceAgentsController extends Controller
{
    public function index()
    {
        return view('Insurance_Agents.index');
    }
    public function create()
    {
        return view('Insurance_Agents.create');
    }
}
