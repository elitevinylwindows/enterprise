<?php

namespace App\Http\Controllers\Master\ProductKeys;

use App\Http\Controllers\Controller;
use App\Models\Master\ProductKeys\ProductType;
use Illuminate\Http\Request;

class ProducttypeController extends Controller
{
    public function index()
    {
        $items = ProductType::paginate(50);
        return view('master.product_keys.producttypes.index', compact('items'));
    }

    public function create()
{
    return view('master.product_keys.producttypes.create');
}


    public function store(Request $request)
{
    $request->validate([
        'product_type' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'material_type' => 'nullable|string|max:255',
        'glazing_bead_position' => 'nullable|string|max:255',
        'product_id' => 'required|string|max:255',
    ]);

    \App\Models\Master\ProductKeys\ProductType::create($request->only([
        'product_type',
        'description',
        'material_type',
        'glazing_bead_position',
        'product_id',
    ]));

    return redirect()->back()->with('success', 'Product type created successfully.');
}

public function edit($id)
{
    $productType = \App\Models\Master\ProductKeys\ProductType::findOrFail($id);
    return view('master.product_keys.producttypes.edit', compact('productType'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'product_type' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'material_type' => 'nullable|string|max:255',
        'glazing_bead_position' => 'nullable|string|max:255',
        'product_id' => 'required|string|max:255',
    ]);

    $productType = \App\Models\Master\ProductKeys\ProductType::findOrFail($id);
    $productType->update($request->only([
        'product_type',
        'description',
        'material_type',
        'glazing_bead_position',
        'product_id',
    ]));

    return redirect()->back()->with('success', 'Product type updated successfully.');
}


}
