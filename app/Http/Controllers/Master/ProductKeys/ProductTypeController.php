<?php

namespace App\Http\Controllers\Master\ProductKeys;

use App\Http\Controllers\Controller;
use App\Models\Master\ProductKeys\ProductType;
use Illuminate\Http\Request;

class ProducttypeController extends Controller
{
    public function index()
    {
        $items = ProductType::paginate(50);
        return view('master.product_keys.producttypes.index', compact('items'));
    }
}
