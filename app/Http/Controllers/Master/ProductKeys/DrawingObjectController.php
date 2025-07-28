<?php

namespace App\Http\Controllers\Master\ProductKeys;

use App\Http\Controllers\Controller;
use App\Models\Master\ProductKeys\DrawingObject;
use Illuminate\Http\Request;

class DrawingobjectController extends Controller
{
    public function index()
    {
        $items = DrawingObject::paginate(50);
        return view('master.product_keys.drawingobjects.index', compact('items'));
    }
}
