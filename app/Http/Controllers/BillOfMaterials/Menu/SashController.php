<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\Sash;

class SashController extends Controller
{
    public function index()
    {
        $sash = Sash::all();
        return view('bill_of_material.menu.Sash.index', compact('sash'));
    }

    public function store(Request $request)
    {
        Sash::create($request->only(['name']));
        return redirect()->route('sash.index')->with('success', 'Sash added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = Sash::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('sash.index')->with('success', 'Sash updated successfully.');
    }

    public function destroy($id)
    {
        Sash::destroy($id);
        return redirect()->route('sash.index')->with('success', 'Sash deleted successfully.');
    }
}
