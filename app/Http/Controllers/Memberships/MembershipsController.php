<?php

namespace App\Http\Controllers\Memberships;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class MembershipsController extends Controller
{
    public function index()
    {
        return view('Memberships_subscriptions.mang_memberships.index');
    }
    public function create()
    {
$clients = Client::all();
        return view('Memberships_subscriptions.mang_memberships.create',compact('clients'));
    }
    public function show()
    {
        return view('Memberships_subscriptions.mang_memberships.show');
    }
    public function edit()
    {
        return view('Memberships_subscriptions.mang_memberships.edit');
    }
}
