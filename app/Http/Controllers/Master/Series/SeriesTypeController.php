<?php

namespace App\Http\Controllers\Master\Series;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Series\Series;
use App\Models\Master\Series\SeriesType;
use App\Models\Master\Series\SeriesConfiguration;

class SeriesTypeController extends Controller
{
    public function index(Request $request)
    {
        $q = SeriesType::with('series')->latest();

        if ($request->filled('series_id')) {
            $q->where('series_id', $request->integer('series_id'));
        }

        $seriesTypes = $q->get();
        $series      = Series::orderBy('series')->get();   // <- needed for the left filter list

        return view('master.series.series_type.index', compact('seriesTypes', 'series'));
    }

    public function create()
    {
        $series = Series::orderBy('series')->get();
        // return PARTIAL (no @extends) for customModal
        return view('master.series.series_type.create', compact('series'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'series_id'   => ['required','integer','exists:'.(new Series)->getTable().',id'],
            'series_type' => ['required','string','max:255'],
        ]);

        SeriesType::create($validated);

        return redirect()->route('master.series-type.index')
            ->with('success', 'Series Type created.');
    }

    public function edit($id)
    {
        $seriesType = SeriesType::findOrFail($id);
        $series     = Series::orderBy('series')->get();
        // return PARTIAL (no @extends) for customModal
        return view('master.series.series_type.edit', compact('seriesType','series'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'series_id'   => ['required','integer','exists:'.(new Series)->getTable().',id'],
            'series_type' => ['required','string','max:255'],
        ]);

        $st = SeriesType::findOrFail($id);
        $st->update($validated);

        return redirect()->route('master.series-type.index')
            ->with('success', 'Series Type updated.');
    }

    public function destroy($id)
    {
        SeriesType::findOrFail($id)->delete();

        return redirect()->route('master.series-type.index')
            ->with('success', 'Series Type deleted.');
    }

    /**
     * JSON for the modal “Available Configurations for this Series”.
     * Assumes SeriesConfiguration has a `series_id` and `series_type` column.
     */
    public function configsBySeries(Series $series)
    {
        $configs = SeriesConfiguration::where('series_id', $series->id)
            ->orderBy('series_type')
            ->get(['id','series_type']);

        return response()->json([
            'success' => true,
            'data' => $configs->map(fn($c) => [
                'id'    => $c->id,
                'label' => $c->series_type,
            ]),
        ]);
    }
}
