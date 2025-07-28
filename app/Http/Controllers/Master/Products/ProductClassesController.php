<?php

namespace App\Http\Controllers\Master\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Products\ProductClasses;

class ProductClassesController extends Controller
{
    public function index()
    {
        $items = ProductClasses::all();
        return view('master.products.productclasses.index', compact('items'));
    }
}
