<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\AmmaLabel;

class AmmaLabelController extends Controller
{
    public function index()
    {
        $ammalabel = AmmaLabel::all();
        return view('bill_of_material.menu.AmmaLabel.index', compact('ammalabel'));
    }

    public function store(Request $request)
    {
        AmmaLabel::create($request->only(['name']));
        return redirect()->route('ammalabel.index')->with('success', 'AmmaLabel added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = AmmaLabel::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('ammalabel.index')->with('success', 'AmmaLabel updated successfully.');
    }

    public function destroy($id)
    {
        AmmaLabel::destroy($id);
        return redirect()->route('ammalabel.index')->with('success', 'AmmaLabel deleted successfully.');
    }
}
