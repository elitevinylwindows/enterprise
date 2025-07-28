<?php

namespace App\Http\Controllers\Schemas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schemas\GSCOSWDUnit;

class GSCOSWDUnitController extends Controller
{
    public function index()
    {
        $gscoswdunits = GSCOSWDUnit::all();
        return view('schemas.gscoswdunit.index', compact('gscoswdunits'));
    }

    public function create()
    {
        return view('schemas.gscoswdunit.create');
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
            'coror_mulit' => 'nullable|string',
            'base_mulit' => 'nullable|string',
            'feat1' => 'nullable|string',
            'feat2' => 'nullable|string',
            'feat3' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
GSCOSWDUnit::create($validated);
        return redirect()->route('gscoswdunit.index')->with('success', 'Created successfully.');
    }

    public function show($id)
    {
        $item = GSCOSWDUnit::findOrFail($id);
        return view('schemas.gscoswdunit.show', compact('item'));
    }

    public function edit($id)
    {
        $item = GSCOSWDUnit::findOrFail($id);
        return view('schemas.gscoswdunit.edit', compact('item'));
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
            'coror_mulit' => 'nullable|string',
            'base_mulit' => 'nullable|string',
            'feat1' => 'nullable|string',
            'feat2' => 'nullable|string',
            'feat3' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
$item = GSCOSWDUnit::findOrFail($id);
        $item->update($validated);
        return redirect()->route('gscoswdunit.index')->with('success', 'Updated successfully.');
    }

    public function destroy($id)
    {
        $item = GSCOSWDUnit::findOrFail($id);
        $item->delete();
        return redirect()->route('gscoswdunit.index')->with('success', 'Deleted successfully.');
    }
}
