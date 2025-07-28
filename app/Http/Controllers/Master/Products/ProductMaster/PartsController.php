<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Parts;

class PartsController extends Controller
{
    public function index()
    {
        $items = Parts::all();
        return view('master.parts.index', compact('items'));
    }
}
