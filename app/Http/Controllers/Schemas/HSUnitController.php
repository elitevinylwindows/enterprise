<?php

namespace App\Http\Controllers\Schemas;

use App\Http\Controllers\Controller;
use App\Imports\HSUnitImport;
use Illuminate\Http\Request;
use App\Models\Schemas\HSUnit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class HSUnitController extends Controller
{
    public function index()
    {
        $hsunits = HSUnit::all();
        return view('schemas.hsunit.index', compact('hsunits'));
    }

    public function create()
    {
        return view('schemas.hsunit.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'schema_id' => 'nullable|string',
            'retrofit' => 'nullable|string',
            'nailon' => 'nullable|string',
            'block' => 'nullable|string',
            'le3_clr' => 'nullable|string',
            'clr_clr' => 'nullable|string',
            'le3_lam' => 'nullable|string',
            'le3_clr_le3' => 'nullable|string',
            'clr_temp' => 'nullable|string',
            '1le3_1clrtemp' => 'nullable|string',
            '2le3_1clrtemp' => 'nullable|string',
            'lam_temp' => 'nullable|string',
            'obs' => 'nullable|string',
            'feat2' => 'nullable|string',
            'feat3' => 'nullable|string',
            'sta_grd' => 'nullable|string',
            'tpi' => 'nullable|string',
            'tpo' => 'nullable|string',
            'acid_etch' => 'nullable|string',
            'solar_cool' => 'nullable|string',
            'solar_cool_g' => 'nullable|string',
        ]);

        HSUnit::create($validated);
        
        return redirect()->route('hs-unit.index')->with('success', 'Created successfully.');
    }

    public function show($id)
    {
        $item = HSUnit::findOrFail($id);
        return view('schemas.hsunit.show', compact('item'));
    }

    public function edit($id)
    {
        $item = HSUnit::findOrFail($id);
        return view('schemas.hsunit.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'schema_id' => 'nullable|string',
            'retrofit' => 'nullable|string',
            'nailon' => 'nullable|string',
            'block' => 'nullable|string',
            'le3_clr' => 'nullable|string',
            'clr_clr' => 'nullable|string',
            'le3_lam' => 'nullable|string',
            'le3_clr_le3' => 'nullable|string',
            'clr_temp' => 'nullable|string',
            '1le3_1clrtemp' => 'nullable|string',
            '2le3_1clrtemp' => 'nullable|string',
            'lam_temp' => 'nullable|string',
            'obs' => 'nullable|string',
            'feat2' => 'nullable|string',
            'feat3' => 'nullable|string',
            'sta_grd' => 'nullable|string',
            'tpi' => 'nullable|string',
            'tpo' => 'nullable|string',
            'acid_etch' => 'nullable|string',
            'solar_cool' => 'nullable|string',
            'solar_cool_g' => 'nullable|string',
        ]);
        $item = HSUnit::findOrFail($id);
        $item->update($validated);
        return redirect()->route('hs-unit.index')->with('success', 'Updated successfully.');
    }

    public function destroy($id)
    {
        $item = HSUnit::findOrFail($id);
        $item->delete();
        return redirect()->route('hs-unit.index')->with('success', 'Deleted successfully.');
    }

    public function importModal()
    {
        return view('schemas.hsunit.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        try{
            DB::beginTransaction();
            $file = $request->file('file');
            Excel::import(new HSUnitImport, $file);

            DB::commit();
            return redirect()->route('hs-unit.index')->with('success', 'Data imported successfully.');
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->with('error', 'Error importing data: ' . $e->getMessage());
        }
    }
}
