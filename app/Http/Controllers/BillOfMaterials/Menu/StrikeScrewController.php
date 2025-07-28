<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\StrikeScrew;

class StrikeScrewController extends Controller
{
    public function index()
    {
        $strikescrew = StrikeScrew::all();
        return view('bill_of_material.menu.StrikeScrew.index', compact('strikescrew'));
    }

    public function store(Request $request)
    {
        StrikeScrew::create($request->only(['name']));
        return redirect()->route('strikescrew.index')->with('success', 'StrikeScrew added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = StrikeScrew::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('strikescrew.index')->with('success', 'StrikeScrew updated successfully.');
    }

    public function destroy($id)
    {
        StrikeScrew::destroy($id);
        return redirect()->route('strikescrew.index')->with('success', 'StrikeScrew deleted successfully.');
    }
}
