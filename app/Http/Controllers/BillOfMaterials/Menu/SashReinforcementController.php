<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\SashReinforcement;

class SashReinforcementController extends Controller
{
    public function index()
    {
        $items = SashReinforcement::all();
        return view('bill_of_material.menu.SashReinforcement.index', compact('items'));
    }

    public function store(Request $request)
    {
        SashReinforcement::create($request->only(['name', 'size']));
        return back()->with('success', 'Item added.');
    }

    public function update(Request $request, $id)
    {
        $item = SashReinforcement::findOrFail($id);
        $item->update($request->only(['name', 'size']));
        return back()->with('success', 'Item updated.');
    }

    public function destroy($id)
    {
        SashReinforcement::destroy($id);
        return back()->with('success', 'Item deleted.');
    }
}
