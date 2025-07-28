<?php

namespace App\Http\Controllers\Schemas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schemas\GSCOSLDUnit;

class GSCOSLDUnitController extends Controller
{
    public function index()
    {
        $gscosldunits = GSCOSLDUnit::all();
        return view('schemas.gscosldunit.index', compact('gscosldunits'));
    }

    public function create()
    {
        return view('schemas.gscosldunit.create');
    }

    public function store(Request $request)
    {
                $validated = $request->validate([
            'schema_id' => 'nullable|string',
            'clr_clr' => 'nullable|string',
            'le3_clr' => 'nullable|string',
            'le3_clr_le3' => 'nullable|string',
            'le3_lam' => 'nullable|string',
            'clr_lam' => 'nullable|string',
            'color_multi' => 'nullable|string',
            'base_multi' => 'nullable|string',
            'feat1' => 'nullable|string',
            'feat2' => 'nullable|string',
            'feat3' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
GSCOSLDUnit::create($validated);
        return redirect()->route('gscosldunit.index')->with('success', 'Created successfully.');
    }

    public function show($id)
    {
        $item = GSCOSLDUnit::findOrFail($id);
        return view('schemas.gscosldunit.show', compact('item'));
    }

    public function edit($id)
    {
        $item = GSCOSLDUnit::findOrFail($id);
        return view('schemas.gscosldunit.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
                $validated = $request->validate([
            'schema_id' => 'nullable|string',
            'clr_clr' => 'nullable|string',
            'le3_clr' => 'nullable|string',
            'le3_clr_le3' => 'nullable|string',
            'le3_lam' => 'nullable|string',
            'clr_lam' => 'nullable|string',
            'color_multi' => 'nullable|string',
            'base_multi' => 'nullable|string',
            'feat1' => 'nullable|string',
            'feat2' => 'nullable|string',
            'feat3' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
$item = GSCOSLDUnit::findOrFail($id);
        $item->update($validated);
        return redirect()->route('gscosldunit.index')->with('success', 'Updated successfully.');
    }

    public function destroy($id)
    {
        $item = GSCOSLDUnit::findOrFail($id);
        $item->delete();
        return redirect()->route('gscosldunit.index')->with('success', 'Deleted successfully.');
    }
}
