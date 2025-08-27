<?php

namespace App\Http\Controllers\Schemas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schemas\GSCOSHUnit;

class GSCOSHUnitController extends Controller
{
    public function index()
    {
        $gscoshunits = GSCOSHUnit::all();
        return view('schemas.gscoshunit.index', compact('gscoshunits'));
    }

    public function create()
    {
        return view('schemas.gscoshunit.create');
    }

    public function store(Request $request)
    {
                $validated = $request->validate([
            'schema_id' => 'nullable|string',
            'retrofit' => 'nullable|string',
            'nailon' => 'nullable|string',
            'block' => 'nullable|string',
            'le3_clr' => 'nullable|string',
            'le3_lam' => 'nullable|string',
            'clr_temp' => 'nullable|string',
            'onele3_oneclr_temp' => 'nullable|string',
            'lam_temp' => 'nullable|string',
            'feat1' => 'nullable|string',
            'feat2' => 'nullable|string',
            'feat3' => 'nullable|string',
            'clr_clr' => 'nullable|string',
            'le3_clr_le3' => 'nullable|string',
            'twole3_oneclr_temp' => 'nullable|string',
            'sta_grid' => 'nullable|string',
            'tpi' => 'nullable|string',
            'tpo' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
GSCOSHUnit::create($validated);
        return redirect()->route('gscoshunit.index')->with('success', 'Created successfully.');
    }

    public function show($id)
    {
        $item = GSCOSHUnit::findOrFail($id);
        return view('schemas.gscoshunit.show', compact('item'));
    }

    public function edit($id)
    {
        $item = GSCOSHUnit::findOrFail($id);
        return view('schemas.gscoshunit.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
                $validated = $request->validate([
            'schema_id' => 'nullable|string',
            'retrofit' => 'nullable|string',
            'nailon' => 'nullable|string',
            'block' => 'nullable|string',
            'le3_clr' => 'nullable|string',
            'le3_lam' => 'nullable|string',
            'clr_temp' => 'nullable|string',
            'onele3_oneclr_temp' => 'nullable|string',
            'lam_temp' => 'nullable|string',
            'feat1' => 'nullable|string',
            'feat2' => 'nullable|string',
            'feat3' => 'nullable|string',
            'clr_clr' => 'nullable|string',
            'le3_clr_le3' => 'nullable|string',
            'twole3_oneclr_temp' => 'nullable|string',
            'sta_grid' => 'nullable|string',
            'tpi' => 'nullable|string',
            'tpo' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
$item = GSCOSHUnit::findOrFail($id);
        $item->update($validated);
        return redirect()->route('gscoshunit.index')->with('success', 'Updated successfully.');
    }

    public function destroy($id)
    {
        $item = GSCOSHUnit::findOrFail($id);
        $item->delete();
        return redirect()->route('gscoshunit.index')->with('success', 'Deleted successfully.');
    }
}
