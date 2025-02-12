<?php

namespace App\Http\Controllers\Commission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index()
    {
         return "test1";
    }

    public function create()
    {
         return view('commission.create');
    }

    public function store(Request $request)
    {

    }

    public function update(Request $request ,$id)
    {

    }
    public function show($id)
    {

    }
    public function edit($id)
    {

    }
    public function delete($id)
    {

    }
}
