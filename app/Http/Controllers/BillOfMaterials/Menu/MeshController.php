<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\Mesh;

class MeshController extends Controller
{
    public function index()
    {
        $mesh = Mesh::all();
        return view('bill_of_material.menu.Mesh.index', compact('mesh'));
    }

    public function store(Request $request)
    {
        Mesh::create($request->only(['name']));
        return redirect()->route('mesh.index')->with('success', 'Mesh added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = Mesh::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('mesh.index')->with('success', 'Mesh updated successfully.');
    }

    public function destroy($id)
    {
        Mesh::destroy($id);
        return redirect()->route('mesh.index')->with('success', 'Mesh deleted successfully.');
    }
}
