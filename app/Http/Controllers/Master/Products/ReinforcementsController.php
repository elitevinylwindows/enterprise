<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Reinforcements;

class ReinforcementsController extends Controller
{
    public function index()
    {
        $items = Reinforcements::all();
        return view('master.reinforcements.index', compact('items'));
    }
}
