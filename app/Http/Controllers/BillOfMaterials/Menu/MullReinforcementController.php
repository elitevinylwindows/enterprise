<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\MullReinforcement;

class MullReinforcementController extends Controller
{
    public function index()
    {
        $items = MullReinforcement::all();
        return view('bill_of_material.menu.MullReinforcement.index', compact('items'));
    }

    public function store(Request $request)
    {
        MullReinforcement::create($request->only(['name', 'size']));
        return back()->with('success', 'Item added.');
    }

    public function update(Request $request, $id)
    {
        $item = MullReinforcement::findOrFail($id);
        $item->update($request->only(['name', 'size']));
        return back()->with('success', 'Item updated.');
    }

    public function destroy($id)
    {
        MullReinforcement::destroy($id);
        return back()->with('success', 'Item deleted.');
    }
}
