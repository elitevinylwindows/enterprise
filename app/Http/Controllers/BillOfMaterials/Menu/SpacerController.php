<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\Spacer;

class SpacerController extends Controller
{
    public function index()
    {
        $spacer = Spacer::all();
        return view('bill_of_material.menu.Spacer.index', compact('spacer'));
    }

    public function store(Request $request)
    {
        Spacer::create($request->only(['name']));
        return redirect()->route('spacer.index')->with('success', 'Spacer added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = Spacer::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('spacer.index')->with('success', 'Spacer updated successfully.');
    }

    public function destroy($id)
    {
        Spacer::destroy($id);
        return redirect()->route('spacer.index')->with('success', 'Spacer deleted successfully.');
    }
}
