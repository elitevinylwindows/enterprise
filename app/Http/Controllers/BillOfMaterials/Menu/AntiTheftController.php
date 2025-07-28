<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\AntiTheft;

class AntiTheftController extends Controller
{
    public function index()
    {
        $antitheft = AntiTheft::all();
        return view('bill_of_material.menu.AntiTheft.index', compact('antitheft'));
    }

    public function store(Request $request)
    {
        AntiTheft::create($request->only(['name']));
        return redirect()->route('antitheft.index')->with('success', 'AntiTheft added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = AntiTheft::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('antitheft.index')->with('success', 'AntiTheft updated successfully.');
    }

    public function destroy($id)
    {
        AntiTheft::destroy($id);
        return redirect()->route('antitheft.index')->with('success', 'AntiTheft deleted successfully.');
    }
}
