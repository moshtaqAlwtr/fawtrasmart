<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;

class ClientInvoiceController extends Controller
{
    public function getInvoices(Client $client)
    {
        return response()->json($client->invoices);
    }
}
