<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\TensionSpring;

class TensionSpringController extends Controller
{
    public function index()
    {
        $tensionspring = TensionSpring::all();
        return view('bill_of_material.menu.TensionSpring.index', compact('tensionspring'));
    }

    public function store(Request $request)
    {
        TensionSpring::create($request->only(['name']));
        return redirect()->route('tensionspring.index')->with('success', 'TensionSpring added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = TensionSpring::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('tensionspring.index')->with('success', 'TensionSpring updated successfully.');
    }

    public function destroy($id)
    {
        TensionSpring::destroy($id);
        return redirect()->route('tensionspring.index')->with('success', 'TensionSpring deleted successfully.');
    }
}
