<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\StockTransfer;


class StockTransferController extends Controller
{
 public function index()
    {
        $transfers = StockTransfer::all();
        return view('inventory.stock_transfer.index', compact('transfers'));
    }
    public function create() { return view('inventory.stock_transfer.create'); }
    public function store(Request $request) {}
    public function edit($id) { return view('inventory.stock_transfer.edit'); }
    public function update(Request $request, $id) {}
    public function destroy($id) {}
}
