<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('sales.dashboard.index');
    }
}
