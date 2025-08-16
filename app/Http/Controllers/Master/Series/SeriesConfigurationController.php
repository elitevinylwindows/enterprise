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
        // name kept as $seriesTypes to avoid changing your blade
        $seriesTypes  = SeriesConfiguration::with('productType')->latest()->get();
        $productTypes = ProductType::orderBy('product_type')->get();

        return view('master.series.series_configuration.index', compact('seriesTypes', 'productTypes'));
    }

    public function create()
    {
        $productTypes = ProductType::orderBy('product_type')->get();
        return view('master.series.series_configuration.create', compact('productTypes'));
    }

    public function store(Request $request)
    {
        $ptTable = (new ProductType)->getTable();

        $validated = $request->validate([
            'series_type'     => ['required', 'string', 'max:255'],
            'product_type_id' => ['required', 'integer', 'exists:'.$ptTable.',id'], // SINGLE
        ]);

        SeriesConfiguration::create($validated);

        return redirect()
            ->route('master.series-configuration.index')
            ->with('success', 'Series configuration created.');
    }

    public function edit($id)
    {
        $seriesType   = SeriesConfiguration::findOrFail($id);
        $productTypes = ProductType::orderBy('product_type')->get();

        return view('master.series.series_configuration.edit', compact('seriesType', 'productTypes'));
    }

    public function update(Request $request, $id)
    {
        $ptTable = (new ProductType)->getTable();

        $validated = $request->validate([
            'series_type'     => ['required', 'string', 'max:255'],
            'product_type_id' => ['required', 'integer', 'exists:'.$ptTable.',id'], // SINGLE
        ]);

        $sc = SeriesConfiguration::findOrFail($id);
        $sc->update($validated);

        return redirect()
            ->route('master.series-configuration.index')
            ->with('success', 'Series configuration updated.');
    }

    public function destroy($id)
    {
        SeriesConfiguration::findOrFail($id)->delete();

        return redirect()
            ->route('master.series-configuration.index')
            ->with('success', 'Series configuration deleted.');
    }
}
