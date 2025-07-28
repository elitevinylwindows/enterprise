<?php

namespace App\Http\Controllers\Master\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Products\ReinforcementAssignments;

class ReinforcementAssignmentsController extends Controller
{
    public function index()
    {
        $items = ReinforcementAssignments::all();
        return view('master.products.reinforcementassignments.index', compact('items'));
    }
}
