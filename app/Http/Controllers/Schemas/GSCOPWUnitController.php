<?php

namespace App\Http\Controllers\Schemas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schemas\GSCOPWUnit;

class GSCOPWUnitController extends Controller
{
    public function index()
    {
        $gscopwunits = GSCOPWUnit::all();
        return view('schemas.gscopwunit.index', compact('gscopwunits'));
    }

    public function create()
    {
        return view('schemas.gscopwunit.create');
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
GSCOPWUnit::create($validated);
        return redirect()->route('gscopwunit.index')->with('success', 'Created successfully.');
    }

    public function show($id)
    {
        $item = GSCOPWUnit::findOrFail($id);
        return view('schemas.gscopwunit.show', compact('item'));
    }

    public function edit($id)
    {
        $item = GSCOPWUnit::findOrFail($id);
        return view('schemas.gscopwunit.edit', compact('item'));
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
$item = GSCOPWUnit::findOrFail($id);
        $item->update($validated);
        return redirect()->route('gscopwunit.index')->with('success', 'Updated successfully.');
    }

    public function destroy($id)
    {
        $item = GSCOPWUnit::findOrFail($id);
        $item->delete();
        return redirect()->route('gscopwunit.index')->with('success', 'Deleted successfully.');
    }
}
