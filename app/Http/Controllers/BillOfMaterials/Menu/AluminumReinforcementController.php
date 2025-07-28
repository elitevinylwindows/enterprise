<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\AluminumReinforcement;

class AluminumReinforcementController extends Controller
{
    public function index()
    {
        $aluminumreinforcement = AluminumReinforcement::all();
        return view('bill_of_material.menu.AluminumReinforcement.index', compact('aluminumreinforcement'));
    }

    public function store(Request $request)
    {
        AluminumReinforcement::create($request->only(['name']));
        return redirect()->route('aluminumreinforcement.index')->with('success', 'AluminumReinforcement added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = AluminumReinforcement::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('aluminumreinforcement.index')->with('success', 'AluminumReinforcement updated successfully.');
    }

    public function destroy($id)
    {
        AluminumReinforcement::destroy($id);
        return redirect()->route('aluminumreinforcement.index')->with('success', 'AluminumReinforcement deleted successfully.');
    }
}
