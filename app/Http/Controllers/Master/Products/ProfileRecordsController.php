<?php

namespace App\Http\Controllers\Master\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Products\ProfileRecords;

class ProfileRecordsController extends Controller
{
    public function index()
    {
        $items = ProfileRecords::all();
        return view('master.products.profilerecords.index', compact('items'));
    }
}
