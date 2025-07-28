<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\Corners;

class CornersController extends Controller
{
    public function index()
    {
        $corners = Corners::all();
        return view('bill_of_material.menu.Corners.index', compact('corners'));
    }

    public function store(Request $request)
    {
        Corners::create($request->only(['name']));
        return redirect()->route('corners.index')->with('success', 'Corners added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = Corners::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('corners.index')->with('success', 'Corners updated successfully.');
    }

    public function destroy($id)
    {
        Corners::destroy($id);
        return redirect()->route('corners.index')->with('success', 'Corners deleted successfully.');
    }
}
