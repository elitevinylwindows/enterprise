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

    /**
     * JSON for the modal “Available Configurations for this Series”.
     * Assumes SeriesConfiguration has a `series_id` and `series_type` column.
     */
    // app/Http/Controllers/Master/Series/SeriesTypeController.php




public function configsBySeries(\App\Models\Master\Series\Series $series)
{
    $ptTable = (new \App\Models\Master\ProductKeys\ProductType)->getTable(); // elitevw_master_productkeys_producttypes
    $ptIds   = \App\Models\Master\ProductKeys\ProductType::where('series', $series->series)->pluck('id');

    $configs = \App\Models\Master\Series\SeriesConfiguration::query()
        ->whereIn('product_type_id', $ptIds) // direct FK on configurations table (if you use it)
        ->orWhereHas('productTypes', function ($q) use ($ptIds, $ptTable) {
            $q->whereIn("$ptTable.id", $ptIds);
        })
        ->orderBy('series_type')
        ->get(['id','series_type']);

    return response()->json([
        'success' => true,
        'data' => $configs->map(fn ($c) => ['id' => $c->id, 'label' => $c->series_type]),
    ]);
}



}
