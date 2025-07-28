<?php

namespace App\Http\Controllers\Schemas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schemas\CMPromo;

class CMPromoController extends Controller
{
    public function index()
    {
        $cmpromos = CMPromo::all();
        return view('schemas.cmpromo.index', compact('cmpromos'));
    }

    public function create()
    {
        return view('schemas.cmpromo.create');
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
            'sta_grid' => 'nullable|string',
            'tpi' => 'nullable|string',
            'tpo' => 'nullable|string',
            'acid_edge' => 'nullable|string',
            'solar_cool' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
CMPromo::create($validated);
        return redirect()->route('cmpromo.index')->with('success', 'Created successfully.');
    }

    public function show($id)
    {
        $item = CMPromo::findOrFail($id);
        return view('schemas.cmpromo.show', compact('item'));
    }

    public function edit($id)
    {
        $item = CMPromo::findOrFail($id);
        return view('schemas.cmpromo.edit', compact('item'));
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
            'sta_grid' => 'nullable|string',
            'tpi' => 'nullable|string',
            'tpo' => 'nullable|string',
            'acid_edge' => 'nullable|string',
            'solar_cool' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
$item = CMPromo::findOrFail($id);
        $item->update($validated);
        return redirect()->route('cmpromo.index')->with('success', 'Updated successfully.');
    }

    public function destroy($id)
    {
        $item = CMPromo::findOrFail($id);
        $item->delete();
        return redirect()->route('cmpromo.index')->with('success', 'Deleted successfully.');
    }
}
