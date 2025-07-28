<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\Rollers;

class RollersController extends Controller
{
    public function index()
    {
        $rollers = Rollers::all();
        return view('bill_of_material.menu.Rollers.index', compact('rollers'));
    }

    public function store(Request $request)
    {
        Rollers::create($request->only(['name']));
        return redirect()->route('rollers.index')->with('success', 'Rollers added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = Rollers::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('rollers.index')->with('success', 'Rollers updated successfully.');
    }

    public function destroy($id)
    {
        Rollers::destroy($id);
        return redirect()->route('rollers.index')->with('success', 'Rollers deleted successfully.');
    }
}
