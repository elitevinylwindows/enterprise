<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\DoubleTape;

class DoubleTapeController extends Controller
{
    public function index()
    {
        $doubletape = DoubleTape::all();
        return view('bill_of_material.menu.DoubleTape.index', compact('doubletape'));
    }

    public function store(Request $request)
    {
        DoubleTape::create($request->only(['name', 'color']));
        return redirect()->route('doubletape.index')->with('success', 'DoubleTape added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = DoubleTape::findOrFail($id);
        $item->update($request->only(['name', 'color']));
        return redirect()->route('doubletape.index')->with('success', 'DoubleTape updated successfully.');
    }

    public function destroy($id)
    {
        DoubleTape::destroy($id);
        return redirect()->route('doubletape.index')->with('success', 'DoubleTape deleted successfully.');
    }
}
