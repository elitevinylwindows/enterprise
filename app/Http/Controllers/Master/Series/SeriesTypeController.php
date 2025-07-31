<?php

namespace App\Http\Controllers\Master\Series;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Series\Series;
use App\Models\Master\Series\SeriesType;
use App\Models\Master\ProductKeys\ProductType;

class SeriesTypeController extends Controller
{
    public function index()
    {
        $seriesTypes = SeriesType::with(['series', 'productType'])->get();
        $series = Series::all();
        $productTypes = ProductType::all();

        return view('master.series.series_type.index', compact('seriesTypes', 'series', 'productTypes'));
    }

    public function create()
    {
        $series = Series::all();
        $productTypes = ProductType::all();
        return view('master.series.series_type.create', compact('series', 'productTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'series_id' => 'required|exists:elitevw_master_series,id',
            'product_type_id' => 'required|exists:elitevw_master_product_types,id',
            'series_type' => 'required|string|max:255',
        ]);

        SeriesType::create([
            'series_id' => $request->series_id,
            'product_type_id' => $request->product_type_id,
            'series_type' => $request->series_type,
        ]);

        return redirect()->back()->with('success', 'Series Type saved.');
    }

    public function edit($id)
    {
        $seriesType = SeriesType::findOrFail($id);
        $series = Series::all();
        $productTypes = ProductType::all();

        return view('master.series.series_type.edit', compact('seriesType', 'series', 'productTypes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'series_id' => 'required|exists:elitevw_master_series,id',
            'product_type_id' => 'required|exists:elitevw_master_product_types,id',
            'series_type' => 'required|string|max:255',
        ]);

        $seriesType = SeriesType::findOrFail($id);
        $seriesType->update([
            'series_id' => $request->series_id,
            'product_type_id' => $request->product_type_id,
            'series_type' => $request->series_type,
        ]);

        return redirect()->route('master.series-type.index')->with('success', 'Series Type updated successfully.');
    }

    public function destroy($id)
    {
        $seriesType = SeriesType::findOrFail($id);
        $seriesType->delete();

        return redirect()->route('master.series-type.index')->with('success', 'Series Type deleted successfully.');
    }
}
