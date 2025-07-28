<?php

namespace App\Http\Controllers\Master\Products\ProductMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Products\ProductMaster\HardwareVariant;

class HardwareVariantController extends Controller
{
    public function index()
    {
        $items = HardwareVariant::all();
        return view('master.products.product_master.hardwarevariant.index', compact('items'));
    }
}
