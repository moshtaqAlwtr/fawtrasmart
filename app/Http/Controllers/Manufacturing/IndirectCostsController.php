<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndirectCostsController extends Controller
{
    public function index()
    {
        return view('manufacturing.indirectcosts.index');
    }
    public function create()
    {
        return view('manufacturing.indirectcosts.create');
    }
}
