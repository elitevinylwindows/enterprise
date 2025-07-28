<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\StockAdjustment;


class StockAdjustmentController extends Controller
{
    public function index()

     {
        $adjustments = StockAdjustment::all();
        return view('inventory.stock_adjustments.index', compact('adjustments'));
    }   
    
   
        public function create() 
        { 
            return view('inventory.stock_adjustments.create'); 
            
        }
    public function store(Request $request) {}
    public function edit($id) { return view('inventory.stock_adjustments.edit'); }
    public function update(Request $request, $id) {}
    public function destroy($id) {}
}
