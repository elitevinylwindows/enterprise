<?php

namespace App\Http\Controllers\Master\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Products\SystemColor;

class SystemColorController extends Controller
{
    public function index()
    {
        $items = SystemColor::all();
        return view('master.products.systemcolor.index', compact('items'));
    }
}
