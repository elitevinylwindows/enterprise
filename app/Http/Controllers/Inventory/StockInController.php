<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\StockIn;


class StockInController extends Controller
{
 public function index()
    {
        $stockIns = StockIn::all();
        return view('inventory.stock_in.index', compact('stockIns'));
    }
    public function create() { return view('inventory.stock_in.create'); }
    public function store(Request $request) {}
    public function edit($id) { return view('inventory.stock_in.edit'); }
    public function update(Request $request, $id) {}
    public function destroy($id) {}
}
