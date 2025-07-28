<?php

namespace App\Http\Controllers\Master\Products\ProductMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Products\ProductMaster\Materials;

class MaterialsController extends Controller
{
    public function index()
    {
        $items = Materials::all();
        return view('master.products.product_master.materials.index', compact('items'));
    }
}
