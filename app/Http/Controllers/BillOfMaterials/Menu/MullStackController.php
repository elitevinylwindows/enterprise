<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\MullStack;

class MullStackController extends Controller
{
    public function index()
    {
        $mullstack = MullStack::all();
        return view('bill_of_material.menu.MullStack.index', compact('mullstack'));
    }

    public function store(Request $request)
    {
        MullStack::create($request->only(['name', 'color']));
        return redirect()->route('mullstack.index')->with('success', 'MullStack added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = MullStack::findOrFail($id);
        $item->update($request->only(['name', 'color']));
        return redirect()->route('mullstack.index')->with('success', 'MullStack updated successfully.');
    }

    public function destroy($id)
    {
        MullStack::destroy($id);
        return redirect()->route('mullstack.index')->with('success', 'MullStack deleted successfully.');
    }
}
