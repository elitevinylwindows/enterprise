<?php

namespace App\Http\Controllers\Master\Series;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Series\SeriesConfiguration;
use App\Models\Master\ProductKeys\ProductType;

class SeriesConfigurationController extends Controller
{
    public function index()
    {
        $seriesTypes  = SeriesConfiguration::with('productTypes')->latest()->get();
        $productTypes = ProductType::orderBy('product_type')->get();

        return view('master.series.series_configuration.index', compact('seriesTypes', 'productTypes'));
        // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ underscore folder
    }

    public function create()
    {
        $productTypes = ProductType::orderBy('product_type')->get();

        // Return a PARTIAL (no @extends) because customModal will inject it
        return view('master.series.series_configuration.create', compact('productTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'series_type'         => ['required','string','max:255'],
            'product_type_ids'    => ['required','array','min:1'],
            // remove stray space after ":" and point to your actual table:
            'product_type_ids.*'  => ['integer','exists:elitevw_master_product_types,id'],
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
            'product_type_ids.*'  => ['integer','exists:elitevw_master_product_types,id'],
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
}
