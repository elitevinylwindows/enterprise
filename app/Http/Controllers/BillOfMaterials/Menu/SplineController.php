<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\Spline;

class SplineController extends Controller
{
    public function index()
    {
        $spline = Spline::all();
        return view('bill_of_material.menu.Spline.index', compact('spline'));
    }

    public function store(Request $request)
    {
        Spline::create($request->only(['name']));
        return redirect()->route('spline.index')->with('success', 'Spline added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = Spline::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('spline.index')->with('success', 'Spline updated successfully.');
    }

    public function destroy($id)
    {
        Spline::destroy($id);
        return redirect()->route('spline.index')->with('success', 'Spline deleted successfully.');
    }
}
