<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\MullCap;

class MullCapController extends Controller
{
    public function index()
    {
        $mullcap = MullCap::all();
        return view('bill_of_material.menu.MullCap.index', compact('mullcap'));
    }

    public function store(Request $request)
    {
        MullCap::create($request->only(['name', 'color']));
        return redirect()->route('mullcap.index')->with('success', 'MullCap added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = MullCap::findOrFail($id);
        $item->update($request->only(['name', 'color']));
        return redirect()->route('mullcap.index')->with('success', 'MullCap updated successfully.');
    }

    public function destroy($id)
    {
        MullCap::destroy($id);
        return redirect()->route('mullcap.index')->with('success', 'MullCap deleted successfully.');
    }
}
