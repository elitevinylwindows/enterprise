<?php

namespace App\Http\Controllers\Schemas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schemas\GSCOHSUnit;

class GSCOHSUnitController extends Controller
{
    public function index()
    {
        $gscohsunits = GSCOHSUnit::all();
        return view('schemas.gscohsunit.index', compact('gscohsunits'));
    }

    public function create()
    {
        return view('schemas.gscohsunit.create');
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
            'sta_grd' => 'nullable|string',
            'tpi' => 'nullable|string',
            'tpo' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
GSCOHSUnit::create($validated);
        return redirect()->route('gscohsunit.index')->with('success', 'Created successfully.');
    }

    public function show($id)
    {
        $item = GSCOHSUnit::findOrFail($id);
        return view('schemas.gscohsunit.show', compact('item'));
    }

    public function edit($id)
    {
        $item = GSCOHSUnit::findOrFail($id);
        return view('schemas.gscohsunit.edit', compact('item'));
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
            'sta_grd' => 'nullable|string',
            'tpi' => 'nullable|string',
            'tpo' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
$item = GSCOHSUnit::findOrFail($id);
        $item->update($validated);
        return redirect()->route('gscohsunit.index')->with('success', 'Updated successfully.');
    }

    public function destroy($id)
    {
        $item = GSCOHSUnit::findOrFail($id);
        $item->delete();
        return redirect()->route('gscohsunit.index')->with('success', 'Deleted successfully.');
    }
}
