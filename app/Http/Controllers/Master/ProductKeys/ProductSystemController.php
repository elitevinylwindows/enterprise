<?php

namespace App\Http\Controllers\Master\ProductKeys;

use App\Http\Controllers\Controller;
use App\Models\Master\ProductKeys\ProductSystem;
use Illuminate\Http\Request;

class ProductsystemController extends Controller
{
    public function index()
    {
        $items = ProductSystem::paginate(50);
        return view('master.product_keys.productsystems.index', compact('items'));
    }
}
