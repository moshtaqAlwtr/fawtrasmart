<?php

namespace App\Http\Controllers\Memberships;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SittingController extends Controller
{
  public function index() {
    return view('Memberships.sitting_memberships.index');
  }
  public function sitting()
  {
    return view('Memberships.sitting_memberships.sitting');
  }
}
