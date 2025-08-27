<?php

namespace App\Http\Controllers\Schemas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schemas\WindowDoorField;

class WindowDoorFieldController extends Controller
{
    public function index()
    {
        $windowdoorfields = WindowDoorField::all();
        return view('schemas.windowdoorfield.index', compact('windowdoorfields'));
    }

    public function create()
    {
        return view('schemas.windowdoorfield.create');
    }

    public function store(Request $request)
    {
                $validated = $request->validate([
            'schema_id' => 'nullable|string',
            'clr_temp' => 'nullable|string',
            'le3_temp' => 'nullable|string',
            'lam_temp' => 'nullable|string',
            'feat1' => 'nullable|string',
            'feat2' => 'nullable|string',
            'feat3' => 'nullable|string',
            'sta_grid' => 'nullable|string',
            'le3_clr_temp_combo' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
WindowDoorField::create($validated);
        return redirect()->route('windowdoorfield.index')->with('success', 'Created successfully.');
    }

    public function show($id)
    {
        $item = WindowDoorField::findOrFail($id);
        return view('schemas.windowdoorfield.show', compact('item'));
    }

    public function edit($id)
    {
        $item = WindowDoorField::findOrFail($id);
        return view('schemas.windowdoorfield.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
                $validated = $request->validate([
            'schema_id' => 'nullable|string',
            'clr_temp' => 'nullable|string',
            'le3_temp' => 'nullable|string',
            'lam_temp' => 'nullable|string',
            'feat1' => 'nullable|string',
            'feat2' => 'nullable|string',
            'feat3' => 'nullable|string',
            'sta_grid' => 'nullable|string',
            'le3_clr_temp_combo' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
$item = WindowDoorField::findOrFail($id);
        $item->update($validated);
        return redirect()->route('windowdoorfield.index')->with('success', 'Updated successfully.');
    }

    public function destroy($id)
    {
        $item = WindowDoorField::findOrFail($id);
        $item->delete();
        return redirect()->route('windowdoorfield.index')->with('success', 'Deleted successfully.');
    }
}
