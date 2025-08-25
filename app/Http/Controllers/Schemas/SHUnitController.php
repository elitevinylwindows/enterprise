<?php

namespace App\Http\Controllers\Schemas;

use App\Http\Controllers\Controller;
use App\Imports\SHUnitImport;
use Illuminate\Http\Request;
use App\Models\Schemas\SHUnit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class SHUnitController extends Controller
{
    public function index()
    {
        $shunits = SHUnit::all();
        return view('schemas.shunit.index', compact('shunits'));
    }

    public function create()
    {
        return view('schemas.shunit.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'schema_id' => 'nullable|string',
            'product_id' => 'nullable|string',
            'product_code' => 'nullable|string',
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
        SHUnit::create($validated);
        return redirect()->route('sh-unit.index')->with('success', 'Created successfully.');
    }

    public function show($id)
    {
        $item = SHUnit::findOrFail($id);
        return view('schemas.shunit.show', compact('item'));
    }

    public function edit($id)
    {
        $item = SHUnit::findOrFail($id);
        return view('schemas.shunit.edit', compact('item'));
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
            'le3_combo' => 'nullable|string',
            'sta_grid' => 'nullable|string',
            'tpi' => 'nullable|string',
            'tpo' => 'nullable|string',
            'acid_edge' => 'nullable|string',
            'solar_cool' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
        $item = SHUnit::findOrFail($id);
        $item->update($validated);
        return redirect()->route('shunit.index')->with('success', 'Updated successfully.');
    }

    public function destroy($id)
    {
        $item = SHUnit::findOrFail($id);
        $item->delete();
        return redirect()->route('shunit.index')->with('success', 'Deleted successfully.');
    }

    public function importModal()
    {
        return view('schemas.shunit.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        try{
            DB::beginTransaction();
            $file = $request->file('file');
            Excel::import(new SHUnitImport, $file);

            DB::commit();
            return redirect()->route('sh-unit.index')->with('success', 'Data imported successfully.');
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->with('error', 'Error importing data: ' . $e->getMessage());
        }
    }
}
