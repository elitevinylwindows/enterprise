<?php

namespace App\Http\Controllers\Master\Products\ProductMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Products\ProductMaster\GlassInsert;

class GlassInsertController extends Controller
{
    public function index()
    {
        $items = GlassInsert::all();
        return view('master.products.productmaster.glassinsert.index', compact('items'));
    }
}
