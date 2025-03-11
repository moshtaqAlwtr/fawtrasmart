<?php

namespace App\Http\Controllers\logs;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        $logs = Log::all();
        return view('Log.index',compact('logs'));
    }
}
