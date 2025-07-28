<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\RollerTrack;

class RollerTrackController extends Controller
{
    public function index()
    {
        $rollertrack = RollerTrack::all();
        return view('bill_of_material.menu.RollerTrack.index', compact('rollertrack'));
    }

    public function store(Request $request)
    {
        RollerTrack::create($request->only(['name', 'color']));
        return redirect()->route('rollertrack.index')->with('success', 'RollerTrack added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = RollerTrack::findOrFail($id);
        $item->update($request->only(['name', 'color']));
        return redirect()->route('rollertrack.index')->with('success', 'RollerTrack updated successfully.');
    }

    public function destroy($id)
    {
        RollerTrack::destroy($id);
        return redirect()->route('rollertrack.index')->with('success', 'RollerTrack deleted successfully.');
    }
}
