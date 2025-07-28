<?php

namespace App\Http\Controllers\Master\Series;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Series\SeriesName;
use App\Models\Master\Series\Series;


class SeriesNameController extends Controller
{
  public function index()
{
    $seriesNames = SeriesName::with('series')->get();
    $series = Series::all(); // <-- Add this
    return view('master.series.series_name.index', compact('seriesNames', 'series')); // <-- Add it here too
}



   public function store(Request $request)
{
    $request->validate([
        'series_id' => 'required|exists:elitevw_master_series,id',
        'series_name' => 'required|string|max:255',
    ]);

    \App\Models\Master\Series\SeriesName::create([
        'series_id'    => $request->series_id,
        'series_name'  => $request->series_name,
    ]);

    return redirect()->route('master.series-name.index')->with('success', 'Series Name created successfully.');
}


  public function create()
{
    $series = Series::all();
    return view('master.series.series_name.create', compact('series'));
}

public function edit($id)
{
    $seriesName = SeriesName::findOrFail($id);
    $series = Series::all(); // For displaying the related series if needed

    return view('master.series.series_name.edit', compact('seriesName', 'series'));
}



    public function update(Request $request, $id)
    {
        $seriesName = SeriesName::findOrFail($id);

        $request->validate([
            'series_name' => 'required|string|max:255',
        ]);

        $seriesName->update($request->all());

        return redirect()->route('master.series-name.index')->with('success', 'Series Name updated successfully.');
    }

    public function destroy($id)
    {
        $seriesName = SeriesName::findOrFail($id);
        $seriesName->delete();

        return redirect()->route('master.series-name.index')->with('success', 'Series Name deleted successfully.');
    }
}
