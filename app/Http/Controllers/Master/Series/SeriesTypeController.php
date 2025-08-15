<?php

namespace App\Http\Controllers\Master\Series;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Series\Series;
use App\Models\Master\Series\SeriesType;
use App\Models\Master\Series\SeriesConfiguration;
use App\Models\Master\ProductKeys\ProductType;

class SeriesTypeController extends Controller
{
    public function index()
{
    $seriesTypes = \App\Models\Master\Series\SeriesType::with('series')
        ->orderByDesc('id')
        ->get();

    // If you show filters on the left:
    $series = \App\Models\Master\Series\Series::orderBy('series')->get();

    return view('master.series.series_type.index', compact('seriesTypes','series'));
}


    public function create()
    {
        $series = Series::orderBy('series')->get();
        // return PARTIAL (no @extends) for customModal
        return view('master.series.series_type.create', compact('series'));
    }

    // App\Http\Controllers\Master\Series\SeriesTypeController.php

public function store(Request $request)
{
    $seriesTable = (new \App\Models\Master\Series\Series)->getTable();
    $cfgTable    = (new \App\Models\Master\Series\SeriesConfiguration)->getTable();

    $validated = $request->validate([
        'series_id'           => ['required','integer',"exists:{$seriesTable},id"],
        'config_ids'          => ['nullable','array'],
        'config_ids.*'        => ['integer',"exists:{$cfgTable},id"],
        'series_type_custom'  => ['nullable','string','max:255'],
    ]);

    $labels = collect();

    // From selected configs
    if (!empty($validated['config_ids'])) {
        $cfgs = \App\Models\Master\Series\SeriesConfiguration::whereIn('id', $validated['config_ids'])->pluck('series_type');
        $labels = $labels->merge($cfgs);
    }

    // Optional custom
    if (!empty($validated['series_type_custom'])) {
        $labels->push(trim($validated['series_type_custom']));
    }

    $labels = $labels
        ->filter(fn($v) => $v !== null && $v !== '')
        ->map(fn($v) => trim($v))
        ->unique();

    $created = 0;
    foreach ($labels as $label) {
        $row = \App\Models\Master\Series\SeriesType::firstOrCreate(
            ['series_id' => $validated['series_id'], 'series_type' => $label]
        );
        if ($row->wasRecentlyCreated) $created++;
    }

    return redirect()
        ->route('master.series-type.index')
        ->with('success', $created ? __(':n series type(s) created.', ['n' => $created]) : __('Nothing to create.'));
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

 


public function configsBySeries(Series $series)
{
    // product type IDs for this series (name string)
    $ptIds = \App\Models\Master\ProductKeys\ProductType::where('series', $series->series)->pluck('id');

    // configurations linked via the direct foreign key
    $configs = \App\Models\Master\Series\SeriesConfiguration::whereIn('product_type_id', $ptIds)
        ->orderBy('series_type')
        ->get(['id','series_type']);

    return response()->json([
        'success' => true,
        'data'    => $configs->map(fn ($c) => ['id' => $c->id, 'label' => $c->series_type]),
    ]);
}



}
