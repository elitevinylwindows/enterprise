<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\SteelReinforcement;

class SteelReinforcementController extends Controller
{
    public function index()
    {
        $steelreinforcement = SteelReinforcement::all();
        return view('bill_of_material.menu.SteelReinforcement.index', compact('steelreinforcement'));
    }

    public function store(Request $request)
    {
        SteelReinforcement::create($request->only(['name']));
        return redirect()->route('steelreinforcement.index')->with('success', 'SteelReinforcement added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = SteelReinforcement::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('steelreinforcement.index')->with('success', 'SteelReinforcement updated successfully.');
    }

    public function destroy($id)
    {
        SteelReinforcement::destroy($id);
        return redirect()->route('steelreinforcement.index')->with('success', 'SteelReinforcement deleted successfully.');
    }
}
