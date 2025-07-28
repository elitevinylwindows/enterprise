<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\Log;

class LogController extends Controller
{
    public function index()
    {
        $logs = Log::all();
        return view('inventory.logs.index', compact('logs'));
    }
}
