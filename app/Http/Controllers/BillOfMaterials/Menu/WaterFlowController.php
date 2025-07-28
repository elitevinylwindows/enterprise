<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\WaterFlow;

class WaterFlowController extends Controller
{
    public function index()
    {
        $waterflow = WaterFlow::all();
        return view('bill_of_material.menu.WaterFlow.index', compact('waterflow'));
    }

    public function store(Request $request)
    {
        WaterFlow::create($request->only(['name', 'color']));
        return redirect()->route('waterflow.index')->with('success', 'WaterFlow added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = WaterFlow::findOrFail($id);
        $item->update($request->only(['name', 'color']));
        return redirect()->route('waterflow.index')->with('success', 'WaterFlow updated successfully.');
    }

    public function destroy($id)
    {
        WaterFlow::destroy($id);
        return redirect()->route('waterflow.index')->with('success', 'WaterFlow deleted successfully.');
    }
}
