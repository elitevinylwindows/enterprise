<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\Screen;

class ScreenController extends Controller
{
    public function index()
    {
        $screen = Screen::all();
        return view('bill_of_material.menu.Screen.index', compact('screen'));
    }

    public function store(Request $request)
    {
        Screen::create($request->only(['name']));
        return redirect()->route('screen.index')->with('success', 'Screen added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = Screen::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('screen.index')->with('success', 'Screen updated successfully.');
    }

    public function destroy($id)
    {
        Screen::destroy($id);
        return redirect()->route('screen.index')->with('success', 'Screen deleted successfully.');
    }
}
