<?php

namespace App\Http\Controllers\Master\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Products\GrillePatterns;

class GrillePatternsController extends Controller
{
    public function index()
    {
        $items = GrillePatterns::all();
        return view('master.products.grillepatterns.index', compact('items'));
    }
}
