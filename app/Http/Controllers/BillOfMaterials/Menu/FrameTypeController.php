<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\FrameType;

class FrameTypeController extends Controller
{
    public function index()
    {
        $frametype = FrameType::all();
        return view('bill_of_material.menu.FrameType.index', compact('frametype'));
    }

    public function store(Request $request)
    {
        FrameType::create($request->only(['name', 'color']));
        return redirect()->route('frametype.index')->with('success', 'FrameType added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = FrameType::findOrFail($id);
        $item->update($request->only(['name', 'color']));
        return redirect()->route('frametype.index')->with('success', 'FrameType updated successfully.');
    }

    public function destroy($id)
    {
        FrameType::destroy($id);
        return redirect()->route('frametype.index')->with('success', 'FrameType deleted successfully.');
    }
}
