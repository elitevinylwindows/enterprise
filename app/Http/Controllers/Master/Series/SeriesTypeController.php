<?php

namespace App\Http\Controllers\Master\Series;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Series\Series;
use App\Models\Master\Series\SeriesType;

class SeriesTypeController extends Controller
{
    public function index()
    {
        $seriesTypes = SeriesType::with('series')->get();
        $series = Series::all();

        return view('master.series.series_type.index', compact('seriesTypes', 'series'));
    }

    public function create()
    {
        $series = Series::all();
        return view('master.series.series_type.create', compact('series'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'series_id' => 'required|exists:elitevw_master_series,id',
            'series_type' => 'required|string',
        ]);

        $seriesTypes = array_filter(array_map('trim', explode(',', $request->series_type)));

        SeriesType::create([
            'series_id' => $request->series_id,
            'series_type' => json_encode($seriesTypes),
        ]);

        return redirect()->back()->with('success', 'Series Type saved.');
    }

    public function edit($id)
    {
        $seriesType = SeriesType::findOrFail($id);
        $series = Series::all();

        return view('master.series.series_type.edit', compact('seriesType', 'series'));
    }

    public function update(Request $request, $id)
    {
        $seriesType = SeriesType::findOrFail($id);

        $request->validate([
            'series_id' => 'required|exists:elitevw_master_series,id',
            'series_type' => 'required|string',
        ]);

        $seriesTypes = array_filter(array_map('trim', explode(',', $request->series_type)));

        $seriesType->update([
            'series_id' => $request->series_id,
            'series_type' => json_encode($seriesTypes),
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
