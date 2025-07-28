<?php

namespace App\Http\Controllers\Master\Products\ProductMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Products\ProductMaster\Units;

class UnitsController extends Controller
{
    public function index()
    {
        $items = Units::all();
        return view('master.products.product_master.units.index', compact('items'));
    }
}
