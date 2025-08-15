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
        $seriesTypes = SeriesType::with('series')->latest()->get();
        // If you need series list in the index for anything else, you can fetch it here:
        // $series = Series::orderBy('series')->get();

        return view('master.series.series_type.index', compact('seriesTypes'));
    }

    public function create()
    {
        $series = Series::orderBy('series')->get();
        // Return a PARTIAL (no @extends) so customModal can load it
        return view('master.series.series_type.create', compact('series'));
    }

    public function store(Request $request)
    {
        $seriesTable = (new Series)->getTable();

        $validated = $request->validate([
            'series_id'   => ['required', 'integer', 'exists:'.$seriesTable.',id'],
            'series_type' => ['required', 'string', 'max:255'],
        ]);

        SeriesType::create($validated);

        return redirect()
            ->route('master.series-type.index')
            ->with('success', 'Series Type created.');
    }

    public function edit($id)
    {
        $seriesType = SeriesType::findOrFail($id);
        $series     = Series::orderBy('series')->get();

        // Return a PARTIAL (no @extends)
        return view('master.series.series_type.edit', compact('seriesType', 'series'));
    }

    public function update(Request $request, $id)
    {
        $seriesTable = (new Series)->getTable();

        $validated = $request->validate([
            'series_id'   => ['required', 'integer', 'exists:'.$seriesTable.',id'],
            'series_type' => ['required', 'string', 'max:255'],
        ]);

        $st = SeriesType::findOrFail($id);
        $st->update($validated);

        return redirect()
            ->route('master.series-type.index')
            ->with('success', 'Series Type updated.');
    }

    public function destroy($id)
    {
        $st = SeriesType::findOrFail($id);
        $st->delete();

        return redirect()
            ->route('master.series-type.index')
            ->with('success', 'Series Type deleted.');
    }
}
