<?php

namespace App\Http\Controllers\Master\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Products\HardwareTypes;

class HardwareTypesController extends Controller
{
    public function index()
    {
        $items = HardwareTypes::all();
        return view('master.products.hardwaretypes.index', compact('items'));
    }
}
