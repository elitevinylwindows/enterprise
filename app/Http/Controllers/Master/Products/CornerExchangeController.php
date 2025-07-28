<?php

namespace App\Http\Controllers\Master\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Products\CornerExchange;

class CornerExchangeController extends Controller
{
    public function index()
    {
        $items = CornerExchange::all();
        return view('master.products.cornerexchange.index', compact('items'));
    }
}
