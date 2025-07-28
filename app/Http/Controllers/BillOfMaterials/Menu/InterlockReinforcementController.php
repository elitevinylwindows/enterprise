<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\InterlockReinforcement;

class InterlockReinforcementController extends Controller
{
    public function index()
    {
        $interlockreinforcement = InterlockReinforcement::all();
        return view('bill_of_material.menu.InterlockReinforcement.index', compact('interlockreinforcement'));
    }

    public function store(Request $request)
    {
        InterlockReinforcement::create($request->only(['name']));
        return redirect()->route('interlockreinforcement.index')->with('success', 'InterlockReinforcement added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = InterlockReinforcement::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('interlockreinforcement.index')->with('success', 'InterlockReinforcement updated successfully.');
    }

    public function destroy($id)
    {
        InterlockReinforcement::destroy($id);
        return redirect()->route('interlockreinforcement.index')->with('success', 'InterlockReinforcement deleted successfully.');
    }
}
