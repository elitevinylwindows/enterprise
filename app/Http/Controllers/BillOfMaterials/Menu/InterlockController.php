<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\Interlock;

class InterlockController extends Controller
{
    public function index()
    {
        $interlock = Interlock::all();
        return view('bill_of_material.menu.Interlock.index', compact('interlock'));
    }

    public function store(Request $request)
    {
        Interlock::create($request->only(['name']));
        return redirect()->route('interlock.index')->with('success', 'Interlock added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = Interlock::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('interlock.index')->with('success', 'Interlock updated successfully.');
    }

    public function destroy($id)
    {
        Interlock::destroy($id);
        return redirect()->route('interlock.index')->with('success', 'Interlock deleted successfully.');
    }
}
