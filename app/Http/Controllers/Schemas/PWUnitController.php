<?php

namespace App\Http\Controllers\Schemas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schemas\PWUnit;

class PWUnitController extends Controller
{
    public function index()
    {
        $pwunits = PWUnit::all();
        return view('schemas.pwunit.index', compact('pwunits'));
    }

    public function create()
    {
        return view('schemas.pwunit.create');
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
            'le3_temp' => 'nullable|string',
            'lam_temp' => 'nullable|string',
            'feat1' => 'nullable|string',
            'feat2' => 'nullable|string',
            'feat3' => 'nullable|string',
            'clr_clr' => 'nullable|string',
            'le3_clr_le3' => 'nullable|string',
            'twole3_oneclr_temp' => 'nullable|string',
            'sta_grd' => 'nullable|string',
            'tpi' => 'nullable|string',
            'tpo' => 'nullable|string',
            'acid_edge' => 'nullable|string',
            'solar_cool' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
PWUnit::create($validated);
        return redirect()->route('pwunit.index')->with('success', 'Created successfully.');
    }

    public function show($id)
    {
        $item = PWUnit::findOrFail($id);
        return view('schemas.pwunit.show', compact('item'));
    }

    public function edit($id)
    {
        $item = PWUnit::findOrFail($id);
        return view('schemas.pwunit.edit', compact('item'));
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
            'le3_temp' => 'nullable|string',
            'lam_temp' => 'nullable|string',
            'feat1' => 'nullable|string',
            'feat2' => 'nullable|string',
            'feat3' => 'nullable|string',
            'clr_clr' => 'nullable|string',
            'le3_clr_le3' => 'nullable|string',
            'twole3_oneclr_temp' => 'nullable|string',
            'sta_grd' => 'nullable|string',
            'tpi' => 'nullable|string',
            'tpo' => 'nullable|string',
            'acid_edge' => 'nullable|string',
            'solar_cool' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
$item = PWUnit::findOrFail($id);
        $item->update($validated);
        return redirect()->route('pwunit.index')->with('success', 'Updated successfully.');
    }

    public function destroy($id)
    {
        $item = PWUnit::findOrFail($id);
        $item->delete();
        return redirect()->route('pwunit.index')->with('success', 'Deleted successfully.');
    }
}
