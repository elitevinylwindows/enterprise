<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\ReinforcementMaterial;

class ReinforcementMaterialController extends Controller
{
    public function index()
    {
        $reinforcementmaterial = ReinforcementMaterial::all();
        return view('bill_of_material.menu.ReinforcementMaterial.index', compact('reinforcementmaterial'));
    }

    public function store(Request $request)
    {
        ReinforcementMaterial::create($request->only(['name']));
        return redirect()->route('reinforcementmaterial.index')->with('success', 'ReinforcementMaterial added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = ReinforcementMaterial::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('reinforcementmaterial.index')->with('success', 'ReinforcementMaterial updated successfully.');
    }

    public function destroy($id)
    {
        ReinforcementMaterial::destroy($id);
        return redirect()->route('reinforcementmaterial.index')->with('success', 'ReinforcementMaterial deleted successfully.');
    }
}
