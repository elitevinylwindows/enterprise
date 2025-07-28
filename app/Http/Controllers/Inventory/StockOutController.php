<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\StockOut;


class StockOutController extends Controller
{
public function index()
    {
        $stockOuts = StockOut::all();
        return view('inventory.stock_out.index', compact('stockOuts'));
    }   
    public function create() { return view('inventory.stock_out.create'); }
    public function store(Request $request) {}
    public function edit($id) { return view('inventory.stock_out.edit'); }
    public function update(Request $request, $id) {}
    public function destroy($id) {}
}
