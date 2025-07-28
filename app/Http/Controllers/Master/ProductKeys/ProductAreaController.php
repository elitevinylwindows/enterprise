<?php

namespace App\Http\Controllers\Master\ProductKeys;

use App\Http\Controllers\Controller;
use App\Models\Master\ProductKeys\ProductArea;
use Illuminate\Http\Request;

class ProductAreaController extends Controller
{
    public function index()
    {
        $items = Productarea::paginate(50);
        return view('master.product_keys.productareas.index', compact('items'));
    }
}
