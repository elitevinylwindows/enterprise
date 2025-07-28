<?php

namespace App\Http\Controllers\Master\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Products\BasicProducts;

class BasicProductsController extends Controller
{
    public function index()
    {
        $items = BasicProducts::all();
        return view('master.products.basicproducts.index', compact('items'));
    }
}
