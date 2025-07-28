<?php

namespace App\Http\Controllers\Schemas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schemas\SWDUnit;

class SWDUnitController extends Controller
{
    public function index()
    {
        $swdunits = SWDUnit::all();
        return view('schemas.swdunit.index', compact('swdunits'));
    }

    public function create()
    {
        return view('schemas.swdunit.create');
    }

    public function store(Request $request)
    {
                $validated = $request->validate([
            'schema_id' => 'nullable|string',
            'lam' => 'nullable|string',
            'feat1' => 'nullable|string',
            'feat2' => 'nullable|string',
            'feat3' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
SWDUnit::create($validated);
        return redirect()->route('swdunit.index')->with('success', 'Created successfully.');
    }

    public function show($id)
    {
        $item = SWDUnit::findOrFail($id);
        return view('schemas.swdunit.show', compact('item'));
    }

    public function edit($id)
    {
        $item = SWDUnit::findOrFail($id);
        return view('schemas.swdunit.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
                $validated = $request->validate([
            'schema_id' => 'nullable|string',
            'lam' => 'nullable|string',
            'feat1' => 'nullable|string',
            'feat2' => 'nullable|string',
            'feat3' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
$item = SWDUnit::findOrFail($id);
        $item->update($validated);
        return redirect()->route('swdunit.index')->with('success', 'Updated successfully.');
    }

    public function destroy($id)
    {
        $item = SWDUnit::findOrFail($id);
        $item->delete();
        return redirect()->route('swdunit.index')->with('success', 'Deleted successfully.');
    }
}
