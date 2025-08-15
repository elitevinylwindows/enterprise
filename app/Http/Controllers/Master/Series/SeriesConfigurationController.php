<?php

namespace App\Http\Controllers\Master\Series;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Series\SeriesType;
use App\Models\Master\ProductKeys\ProductType;

class SeriesConfigurationController extends Controller
{
    public function index()
    {
        $seriesTypes  = SeriesType::with(['productTypes'])->latest()->get();
        $productTypes = ProductType::orderBy('product_type')->get();

        return view('master.series.series_configuration.index', compact('seriesTypes', 'productTypes'));
    }

    public function create()
    {
        $series       = Series::orderBy('series')->get();
        $productTypes = ProductType::orderBy('product_type')->get();

        return view('master.series.series-configuration.create', compact('series', 'productTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'series_type'         => ['required','string','max:255'],
            'product_type_ids'    => ['required','array','min:1'],
            'product_type_ids.*'  => ['integer','exists: elitevw_master_productkeys_producttypes,id'],
        ]);

        $st = SeriesType::create([
            'series_type' => $validated['series_type'],
        ]);

        $st->productTypes()->sync($validated['product_type_ids']);

        return redirect()->route('master.series-configuration.index')->with('success', 'Series Type created.');
    }

    public function edit($id)
    {
        $seriesType   = SeriesType::with('productTypes')->findOrFail($id);
        $productTypes = ProductType::orderBy('product_type')->get();

        return view('master.series.series_configuration.edit', compact('seriesType', 'productTypes'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'series_type'         => ['required','string','max:255'],
            'product_type_ids'    => ['required','array','min:1'],
            'product_type_ids.*'  => ['integer','exists: elitevw_master_productkeys_producttypes,id'],
        ]);

        $st = SeriesType::findOrFail($id);
        $st->update([
            'series_id'   => $validated['series_id'],
            'series_type' => $validated['series_type'],
        ]);

        $st->productTypes()->sync($validated['product_type_ids']);

        return redirect()->route('master.series-configuration.index')->with('success', 'Series Type updated.');
    }

    public function destroy($id)
    {
        $seriesType = SeriesType::findOrFail($id);
        $seriesType->delete();

        return redirect()->route('master.series-configuration.index')->with('success', 'Series Type deleted.');
    }
}
