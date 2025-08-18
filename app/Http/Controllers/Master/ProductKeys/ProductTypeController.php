<?php

namespace App\Http\Controllers\Master\ProductKeys;

use App\Http\Controllers\Controller;
use App\Models\Master\ProductKeys\ProductType;
use App\Models\Master\Series\Series; 
use Illuminate\Http\Request;
use App\Models\Manufacturing\Line;

class ProducttypeController extends Controller
{
    public function index()
{
    $items  = ProductType::orderBy('product_type')->get();
    $series = Series::orderBy('series')->get();
    $lines  = Line::orderBy('line')->get(['id', 'line']);  
    return view('master.product_keys.producttypes.index', compact('items','series','lines'));
}

public function create()
{
    $series = Series::orderBy('series')->get();
    $lines  = Line::orderBy('line')->get(['id', 'line']);
    return view('master.product_keys.producttypes.create', compact('series','lines'));
}

public function edit($id)
{
    $productType = ProductType::findOrFail($id);
    $series      = Series::orderBy('series')->get();
    $lines       = Line::orderBy('line')->get(['id', 'line']);
    return view('master.product_keys.producttypes.edit', compact('productType','series','lines'));
}

    public function store(Request $request)
{
    $data = $request->validate([
        'product_type' => 'required|string|max:255',
        'series'       => 'required|string|max:255',
        'description'  => 'required|string|max:255',
        'type'         => 'nullable|string|max:255', // or Rule::in(['Door','Window'])
        'line_id'      => ['required', Rule::exists((new Line)->getTable(), 'id')], // <-- here
        'material_type'         => 'nullable|string|max:255',
        'glazing_bead_position' => 'nullable|string|max:255',
        'product_id'   => 'required|string|max:255',
    ]);

    ProductType::create($data); // includes line_id now
    return redirect()->back()->with('success', 'Product Type created successfully.');
}

   

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_type' => 'required|string|max:255',
            'series'       => 'required|string|max:255',
            'description'  => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'line_id' => 'nullable|string|max:255',
            'material_type' => 'nullable|string|max:255',
            'glazing_bead_position' => 'nullable|string|max:255',
            'product_id'   => 'required|string|max:255',
        ]);

        $productType = ProductType::findOrFail($id);
        $productType->update($request->only([
            'product_type',
            'series',                 // store selected series name
            'description',
            'type',
            'line_id',
            'material_type',
            'glazing_bead_position',
            'product_id',
        ]));

        return redirect()->back()->with('success', 'Product type updated successfully.');
    }
}
