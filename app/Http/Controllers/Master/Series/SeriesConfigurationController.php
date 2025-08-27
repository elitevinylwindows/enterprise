<?php

namespace App\Http\Controllers\Master\Series;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Series\SeriesConfiguration;
use App\Models\Master\ProductKeys\ProductType;
use App\Imports\SeriesConfigurationImport;
use Maatwebsite\Excel\Facades\Excel;

class SeriesConfigurationController extends Controller
{
    public function index()
    {
        $seriesTypes  = SeriesConfiguration::with('productTypes')->latest()->get();
        $productTypes = ProductType::orderBy('product_type')->get();

        return view('master.series.series_configuration.index', compact('seriesTypes', 'productTypes'));
    }

    public function create()
    {
        $productTypes = ProductType::orderBy('product_type')->get();

        // Return a PARTIAL (no @extends) because customModal will inject it
        return view('master.series.series_configuration.create', compact('productTypes'));
    }


    public function importForm()
    {
        // modal partial (no @extends)
        return view('master.series.series_configuration.import');
    }

    public function importUpload(Request $request)
    {
        $request->validate([
            'file' => ['required','file','mimes:xlsx,xls,csv'],
        ]);

        $summary = Excel::toCollection(new SeriesConfigurationImport, $request->file('file'));
     

        $import = new SeriesConfigurationImport;
        Excel::import($import, $request->file('file'));

        return redirect()
            ->route('master.series-configuration.index')
            ->with('success', __('Import completed.'))
            ->with('import_report', $import->report());
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'series_type'         => ['required','string','max:255'],
            'product_type_ids'    => ['required','array','min:1'],
            // remove stray space after ":" and point to your actual table:
            'product_type_ids.*'  => ['integer','exists:elitevw_master_productkeys_producttypes,id'],
        ]);

        $sc = SeriesConfiguration::create([
            'series_type' => $validated['series_type'],
        ]);

        $sc->productTypes()->sync($validated['product_type_ids']);

        return redirect()->route('master.series-configuration.index')
            ->with('success', 'Series Type created.');
    }

    public function edit($id)
    {
        $seriesType   = SeriesConfiguration::with('productTypes')->findOrFail($id);
        $productTypes = ProductType::orderBy('product_type')->get();

        // Partial too
        return view('master.series.series_configuration.edit', compact('seriesType', 'productTypes'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'series_type'         => ['required','string','max:255'],
            'product_type_ids'    => ['required','array','min:1'],
            'product_type_ids.*'  => ['integer','exists:elitevw_master_productkeys_producttypes,id'],
        ]);

        $sc = SeriesConfiguration::findOrFail($id);
        $sc->update([
            'series_type' => $validated['series_type'],
        ]);

        $sc->productTypes()->sync($validated['product_type_ids']);

        return redirect()->route('master.series-configuration.index')
            ->with('success', 'Series Type updated.');
    }

    public function destroy($id)
    {
        $sc = SeriesConfiguration::findOrFail($id);
        $sc->delete();

        return redirect()->route('master.series-configuration.index')
            ->with('success', 'Series Type deleted.');
    }
    public function show($id)
{
    $sc = SeriesConfiguration::with('productTypes')->findOrFail($id);
    return view('master.series.series_configuration.show', compact('sc')); // partial
}

}
