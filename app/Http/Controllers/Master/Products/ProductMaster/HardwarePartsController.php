<?php

namespace App\Http\Controllers\Master\Products\ProductMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Products\ProductMaster\HardwareParts;

class HardwarePartsController extends Controller
{
    public function index()
    {
        $items = HardwareParts::all();
        return view('master.products.product_master.hardwareparts.index', compact('items'));
    }
}
