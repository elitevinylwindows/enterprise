<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\LockScrew;

class LockScrewController extends Controller
{
    public function index()
    {
        $lockscrew = LockScrew::all();
        return view('bill_of_material.menu.LockScrew.index', compact('lockscrew'));
    }

    public function store(Request $request)
    {
        LockScrew::create($request->only(['name']));
        return redirect()->route('lockscrew.index')->with('success', 'LockScrew added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = LockScrew::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('lockscrew.index')->with('success', 'LockScrew updated successfully.');
    }

    public function destroy($id)
    {
        LockScrew::destroy($id);
        return redirect()->route('lockscrew.index')->with('success', 'LockScrew deleted successfully.');
    }
}
