<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\MullScrew;

class MullScrewController extends Controller
{
    public function index()
    {
        $mullscrew = MullScrew::all();
        return view('bill_of_material.menu.MullScrew.index', compact('mullscrew'));
    }

    public function store(Request $request)
    {
        MullScrew::create($request->only(['name']));
        return redirect()->route('mullscrew.index')->with('success', 'MullScrew added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = MullScrew::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('mullscrew.index')->with('success', 'MullScrew updated successfully.');
    }

    public function destroy($id)
    {
        MullScrew::destroy($id);
        return redirect()->route('mullscrew.index')->with('success', 'MullScrew deleted successfully.');
    }
}
