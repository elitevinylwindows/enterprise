<?php

namespace App\Http\Controllers\Master\Products\ProductMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Products\ProductMaster\Profiles;

class ProfilesController extends Controller
{
    public function index()
    {
        $items = Profiles::all();
        return view('master.products.product_master.profiles.index', compact('items'));
    }
}
