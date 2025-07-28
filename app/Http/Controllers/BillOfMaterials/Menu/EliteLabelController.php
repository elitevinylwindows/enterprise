<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\EliteLabel;

class EliteLabelController extends Controller
{
    public function index()
    {
        $elitelabel = EliteLabel::all();
        return view('bill_of_material.menu.EliteLabel.index', compact('elitelabel'));
    }

    public function store(Request $request)
    {
        EliteLabel::create($request->only(['name']));
        return redirect()->route('elitelabel.index')->with('success', 'EliteLabel added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = EliteLabel::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('elitelabel.index')->with('success', 'EliteLabel updated successfully.');
    }

    public function destroy($id)
    {
        EliteLabel::destroy($id);
        return redirect()->route('elitelabel.index')->with('success', 'EliteLabel deleted successfully.');
    }
}
