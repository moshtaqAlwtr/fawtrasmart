<?php

namespace App\Http\Controllers\Sitting;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class SittingAccountController extends Controller
{
    public function index()
    {
        
        $client = Client::where('user_id',auth()->user()->id)->first();
        return view('sitting.sittingAccount.index',compact('client'));
    }

}
