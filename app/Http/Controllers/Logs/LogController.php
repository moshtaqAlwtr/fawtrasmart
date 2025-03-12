<?php

namespace App\Http\Controllers\Logs;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
  public function index(Request $request)
{
    $search = $request->input('search');

    $logs = Log::where('type_log', 'log')
        ->when($search, function ($query) use ($search) {
            return $query->where('description', 'like', '%' . $search . '%');
        })
        ->orderBy('created_at', 'desc')
        ->get()
        ->filter(function ($log) {
            return !is_null($log) && !is_bool($log); // التأكد من أن السجل ليس null أو false
        })
        ->groupBy(function ($log) {
            return optional($log->created_at)->format('Y-m-d'); // التأكد أن created_at ليس null
        });

    return view('Log.index', compact('logs'));
}

}
