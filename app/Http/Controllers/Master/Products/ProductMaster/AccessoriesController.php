<?php

namespace App\Http\Controllers\Master\Products\ProductMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Products\ProductMaster\Accessories;

class AccessoriesController extends Controller
{
    public function index()
    {
        $items = Accessories::all();
       return view('master.products.productmaster.accessories.index', compact('items'));


    }
}
