<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\GlassType;

class GlassTypeController extends Controller
{
   public function index()
{
    $glasstype = GlassType::all();
    return view('bill_of_material.menu.GlassType.index', compact('glasstype'));
}


    public function store(Request $request)
    {
        GlassType::create($request->only([
            'name',
            'thickness_3_1_mm',
            'thickness_3_9_mm',
            'thickness_4_7_mm',
            'thickness_5_7_mm'
        ]));

        return redirect()->route('glasstype.index')->with('success', 'Glass Type added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = GlassType::findOrFail($id);
        $item->update($request->only([
            'name',
            'thickness_3_1_mm',
            'thickness_3_9_mm',
            'thickness_4_7_mm',
            'thickness_5_7_mm'
        ]));

        return redirect()->route('glasstype.index')->with('success', 'Glass Type updated successfully.');
    }

    public function destroy($id)
    {
        GlassType::destroy($id);
        return redirect()->route('glasstype.index')->with('success', 'Glass Type deleted successfully.');
    }
}
