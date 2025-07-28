<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\Snapping;

class SnappingController extends Controller
{
    public function index()
    {
        $snapping = Snapping::all();
        return view('bill_of_material.menu.Snapping.index', compact('snapping'));
    }

    public function store(Request $request)
    {
        Snapping::create($request->only(['name', 'color']));
        return redirect()->route('snapping.index')->with('success', 'Snapping added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = Snapping::findOrFail($id);
        $item->update($request->only(['name', 'color']));
        return redirect()->route('snapping.index')->with('success', 'Snapping updated successfully.');
    }

    public function destroy($id)
    {
        Snapping::destroy($id);
        return redirect()->route('snapping.index')->with('success', 'Snapping deleted successfully.');
    }
}
