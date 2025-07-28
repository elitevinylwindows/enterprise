<?php

namespace App\Http\Controllers\Master\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Products\ProfileTypes;

class ProfileTypesController extends Controller
{
    public function index()
    {
        $items = ProfileTypes::all();
        return view('master.products.profiletypes.index', compact('items'));
    }
}
