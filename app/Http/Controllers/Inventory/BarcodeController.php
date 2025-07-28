<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\Barcode;


class BarcodeController extends Controller
{
 public function index()
    {
        $barcodes = Barcode::all();
        return view('inventory.barcodes.index', compact('barcodes'));
    }    
    
    public function create()
{
    return view('inventory.barcodes.create');
}
    
    public function store(Request $request) {}
}