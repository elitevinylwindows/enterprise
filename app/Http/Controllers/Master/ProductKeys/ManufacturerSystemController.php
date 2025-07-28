<?php

namespace App\Http\Controllers\Master\ProductKeys;

use App\Http\Controllers\Controller;
use App\Models\Master\ProductKeys\ManufacturerSystem;
use Illuminate\Http\Request;

class ManufacturersystemController extends Controller
{
    public function index()
    {
        $items = ManufacturerSystem::paginate(50);
        return view('master.product_keys.manufacturersystems.index', compact('items'));
    }
}
