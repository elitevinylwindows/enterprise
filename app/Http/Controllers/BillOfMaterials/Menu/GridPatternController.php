<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\GridPattern;

class GridPatternController extends Controller
{
    public function index()
    {
        $gridpattern = GridPattern::all();
        return view('bill_of_material.menu.GridPattern.index', compact('gridpattern'));
    }

    public function store(Request $request)
    {
        GridPattern::create($request->only(['name']));
        return redirect()->route('gridpattern.index')->with('success', 'GridPattern added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = GridPattern::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('gridpattern.index')->with('success', 'GridPattern updated successfully.');
    }

    public function destroy($id)
    {
        GridPattern::destroy($id);
        return redirect()->route('gridpattern.index')->with('success', 'GridPattern deleted successfully.');
    }
}
