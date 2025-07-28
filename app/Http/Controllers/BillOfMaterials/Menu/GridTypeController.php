<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\GridType;

class GridTypeController extends Controller
{
    public function index()
    {
        $gridtype = GridType::all();
        return view('bill_of_material.menu.GridType.index', compact('gridtype'));
    }

    public function store(Request $request)
    {
        GridType::create($request->only(['name', 'color']));
        return redirect()->route('gridtype.index')->with('success', 'GridType added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = GridType::findOrFail($id);
        $item->update($request->only(['name', 'color']));
        return redirect()->route('gridtype.index')->with('success', 'GridType updated successfully.');
    }

    public function destroy($id)
    {
        GridType::destroy($id);
        return redirect()->route('gridtype.index')->with('success', 'GridType deleted successfully.');
    }
}
