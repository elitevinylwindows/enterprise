<?php

namespace App\Http\Controllers\Master\Series;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Series\Series;

class SeriesController extends Controller
{
    public function index()
    {
        $series = Series::all();
        return view('master.series.index', compact('series'));
    }
    public function store(Request $request)
{
    $request->validate([
        'series' => 'required|string|max:255',
    ]);

    \App\Models\Master\Series\Series::create([
        'series' => $request->series
    ]);

    return redirect()->route('master.series.index')->with('success', 'Series created successfully.');
}

public function edit($id)
{
    $series = \App\Models\Master\Series\Series::findOrFail($id);
    return view('master.series.edit', compact('series'));
}


}
