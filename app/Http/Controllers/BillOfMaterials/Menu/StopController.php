<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\Stop;

class StopController extends Controller
{
    public function index()
    {
        $stop = Stop::all();
        return view('bill_of_material.menu.Stop.index', compact('stop'));
    }

    public function store(Request $request)
    {
        Stop::create($request->only(['name', 'color']));
        return redirect()->route('stop.index')->with('success', 'Stop added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = Stop::findOrFail($id);
        $item->update($request->only(['name', 'color']));
        return redirect()->route('stop.index')->with('success', 'Stop updated successfully.');
    }

    public function destroy($id)
    {
        Stop::destroy($id);
        return redirect()->route('stop.index')->with('success', 'Stop deleted successfully.');
    }
}
