<?php

namespace App\Http\Controllers\Sitting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class SmsController extends Controller
{
    public function index()
    {

        return view('sitting.sms.index');
    }

   
}
