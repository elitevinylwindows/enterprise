<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\NightLock;

class NightLockController extends Controller
{
    public function index()
    {
        $nightlock = NightLock::all();
        return view('bill_of_material.menu.NightLock.index', compact('nightlock'));
    }

    public function store(Request $request)
    {
        NightLock::create($request->only(['name']));
        return redirect()->route('nightlock.index')->with('success', 'NightLock added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = NightLock::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('nightlock.index')->with('success', 'NightLock updated successfully.');
    }

    public function destroy($id)
    {
        NightLock::destroy($id);
        return redirect()->route('nightlock.index')->with('success', 'NightLock deleted successfully.');
    }
}
