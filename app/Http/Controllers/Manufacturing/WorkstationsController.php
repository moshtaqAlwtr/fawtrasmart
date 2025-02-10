<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkstationsController extends Controller
{
    public function index(){
        return view('manufacturing.workstations.index');
    }   
    public function create(){
        return view('manufacturing.workstations.create');
    }   
}
