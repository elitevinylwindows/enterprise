<?php

namespace App\Http\Controllers\Master\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Products\SealingAssignment;

class SealingAssignmentController extends Controller
{
    public function index()
    {
        $items = SealingAssignment::all();
        return view('master.products.sealingassignment.index', compact('items'));
    }
}
