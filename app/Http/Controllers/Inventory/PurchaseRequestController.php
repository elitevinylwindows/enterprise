<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseRequestController extends Controller
{
    public function index()
    {
        $requests = []; 
        return view('inventory.purchase_requests.index', compact('requests'));
    }

    public function create()
    {
        return view('inventory.purchase_requests.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function edit($id)
    {
        return view('inventory.purchase_requests.edit', compact('id'));
    }
}
