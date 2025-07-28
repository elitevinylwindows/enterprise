<?php

namespace App\Http\Controllers\Schemas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schemas\SLDUnit;

class SLDUnitController extends Controller
{
    public function index()
    {
        $sldunits = SLDUnit::all();
        return view('schemas.sldunit.index', compact('sldunits'));
    }

    public function create()
    {
        return view('schemas.sldunit.create');
    }

    public function store(Request $request)
    {
                $validated = $request->validate([
            'schema_id' => 'nullable|string',
            'lam' => 'nullable|string',
            'feat1' => 'nullable|string',
            'feat2' => 'nullable|string',
            'feat3' => 'nullable|string',
            'acid_edge' => 'nullable|string',
            'solar_cool' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
SLDUnit::create($validated);
        return redirect()->route('sldunit.index')->with('success', 'Created successfully.');
    }

    public function show($id)
    {
        $item = SLDUnit::findOrFail($id);
        return view('schemas.sldunit.show', compact('item'));
    }

    public function edit($id)
    {
        $item = SLDUnit::findOrFail($id);
        return view('schemas.sldunit.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
                $validated = $request->validate([
            'schema_id' => 'nullable|string',
            'lam' => 'nullable|string',
            'feat1' => 'nullable|string',
            'feat2' => 'nullable|string',
            'feat3' => 'nullable|string',
            'acid_edge' => 'nullable|string',
            'solar_cool' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
$item = SLDUnit::findOrFail($id);
        $item->update($validated);
        return redirect()->route('sldunit.index')->with('success', 'Updated successfully.');
    }

    public function destroy($id)
    {
        $item = SLDUnit::findOrFail($id);
        $item->delete();
        return redirect()->route('sldunit.index')->with('success', 'Deleted successfully.');
    }
}
