<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\Strike;

class StrikeController extends Controller
{
    public function index()
    {
        $strike = Strike::all();
        return view('bill_of_material.menu.Strike.index', compact('strike'));
    }

    public function store(Request $request)
    {
        Strike::create($request->only(['name']));
        return redirect()->route('strike.index')->with('success', 'Strike added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = Strike::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('strike.index')->with('success', 'Strike updated successfully.');
    }

    public function destroy($id)
    {
        Strike::destroy($id);
        return redirect()->route('strike.index')->with('success', 'Strike deleted successfully.');
    }
}
