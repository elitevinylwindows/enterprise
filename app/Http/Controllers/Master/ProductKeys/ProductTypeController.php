<?php

namespace App\Http\Controllers\Master\ProductKeys;

use App\Http\Controllers\Controller;
use App\Models\Master\ProductKeys\ProductType;
use App\Models\Master\Series\Series; // <-- add this
use Illuminate\Http\Request;

class ProducttypeController extends Controller
{
    public function index()
{
    $items  = \App\Models\Master\ProductKeys\ProductType::orderBy('product_type')->get();
    $series = Series::orderBy('series')->get(); // <-- pass series to view
    return view('master.product_keys.producttypes.index', compact('items','series'));
}

    public function create()
{
    $series = Series::orderBy('series')->get();
    return view('master.product_keys.producttypes.create', compact('series'));
}

    public function store(Request $request)
    {
        $request->validate([
            'product_type' => 'required|string|max:255',
            'series'       => 'required|string|max:255', // storing the series *name* string
            'description'  => 'required|string|max:255',
            'material_type' => 'nullable|string|max:255',
            'glazing_bead_position' => 'nullable|string|max:255',
            'product_id'   => 'required|string|max:255',
        ]);

        ProductType::create($request->only([
            'product_type',
            'series',                 // we store the selected series name
            'description',
            'material_type',
            'glazing_bead_position',
            'product_id',
        ]));

        return redirect()->back()->with('success', 'Product Type created successfully.');
    }

    public function edit($id)
    {
        $productType = ProductType::findOrFail($id);
        $series = Series::orderBy('series')->get(); // <-- pass series list
        return view('master.product_keys.producttypes.edit', compact('productType', 'series'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_type' => 'required|string|max:255',
            'series'       => 'required|string|max:255',
            'description'  => 'required|string|max:255',
            'material_type' => 'nullable|string|max:255',
            'glazing_bead_position' => 'nullable|string|max:255',
            'product_id'   => 'required|string|max:255',
        ]);

        $productType = ProductType::findOrFail($id);
        $productType->update($request->only([
            'product_type',
            'series',                 // store selected series name
            'description',
            'material_type',
            'glazing_bead_position',
            'product_id',
        ]));

        return redirect()->back()->with('success', 'Product type updated successfully.');
    }
}
