<?php

namespace App\Http\Controllers\Sitting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BackupController extends Controller
{
    public function index()
    {
         return "backub";
        return view('sitting.accountInfo.Backup');
    }
}
