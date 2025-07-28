<?php

namespace App\Http\Controllers\Master\ProductKeys;

use App\Http\Controllers\Controller;
use App\Models\Master\ProductKeys\SpecialShapeMacro;
use Illuminate\Http\Request;

class SpecialshapemacroController extends Controller
{
    public function index()
    {
        $items = SpecialShapeMacro::paginate(50);
        return view('master.product_keys.specialshapemacros.index', compact('items'));
    }
}
