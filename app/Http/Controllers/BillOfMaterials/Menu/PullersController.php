<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\Pullers;

class PullersController extends Controller
{
    public function index()
    {
        $pullers = Pullers::all();
        return view('bill_of_material.menu.Pullers.index', compact('pullers'));
    }

    public function store(Request $request)
    {
        Pullers::create($request->only(['name']));
        return redirect()->route('pullers.index')->with('success', 'Pullers added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = Pullers::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('pullers.index')->with('success', 'Pullers updated successfully.');
    }

    public function destroy($id)
    {
        Pullers::destroy($id);
        return redirect()->route('pullers.index')->with('success', 'Pullers deleted successfully.');
    }
}
