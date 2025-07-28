<?php

namespace App\Http\Controllers\Master\ProductKeys;

use App\Http\Controllers\Controller;
use App\Models\Master\ProductKeys\ShapeCatalog;
use Illuminate\Http\Request;

class ShapeCatalogController extends Controller
{
    public function index()
    {
        $items = ShapeCatalog::paginate(50);
        return view('master.product_keys.shapecatalog.index', compact('items'));
    }
}
