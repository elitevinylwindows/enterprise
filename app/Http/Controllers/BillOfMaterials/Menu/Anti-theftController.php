<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\Anti-theft;

class Anti-theftController extends Controller
{
    public function index()
    {
        $spacer = Anti-theft::all();
        return view('bill_of_material.menu.Anti-theft.index', compact('spacer'));
    }

    public function store(Request $request)
    {
        Anti-theft::create($request->only(['name']));
        return redirect()->route('spacer.index')->with('success', 'Anti-theft added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = Anti-theft::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('spacer.index')->with('success', 'Anti-theft updated successfully.');
    }

    public function destroy($id)
    {
        Anti-theft::destroy($id);
        return redirect()->route('spacer.index')->with('success', 'Anti-theft deleted successfully.');
    }
}
