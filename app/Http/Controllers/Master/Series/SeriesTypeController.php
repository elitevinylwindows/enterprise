<?php

namespace App\Http\Controllers\Master\Series;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Series\Series;
use App\Models\Master\Series\SeriesType;
use App\Models\Master\Series\SeriesConfiguration;
use App\Models\Master\ProductKeys\ProductType;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;


class SeriesTypeController extends Controller
{
    // app/Http/Controllers/Master/Series/SeriesTypeController.php

public function index(\Illuminate\Http\Request $request)
{
    $activeSeriesId = $request->integer('series_id');

    $seriesQuery = \App\Models\Master\Series\Series::with([
        'seriesTypes' => fn ($q) => $q->orderBy('series_type'),
    ])->orderBy('series');

    if ($activeSeriesId) {
        $seriesQuery->where('id', $activeSeriesId);
    }

    // for left filter menu
    $seriesList = \App\Models\Master\Series\Series::orderBy('series')->get();

    $series = $seriesQuery->get();

    return view('master.series.series_type.index', [
        'series'         => $series,       // rows for the table
        'seriesList'     => $seriesList,   // for the sidebar
        'activeSeriesId' => $activeSeriesId,
    ]);
}



public function manage(Series $series)
{
    // ProductTypes tied to this Series (by name on product types table)
    $ptIds = ProductType::where('series', $series->series)->pluck('id');

    // All configurations connected to these PTs (either direct FK or via pivot if you’re using it)
    $configs = SeriesConfiguration::query()
        ->whereIn('product_type_id', $ptIds) // direct FK path
        ->orWhereHas('productTypes', function ($q) use ($ptIds) {
            $q->whereIn((new ProductType)->getTable().'.id', $ptIds);
        })
        ->orderBy('series_type')
        ->get(['id','series_type']);

    // Already chosen types for this series (strings)
    $chosenLabels = SeriesType::where('series_id', $series->id)
        ->pluck('series_type')
        ->map('trim')
        ->all();

    // return a PARTIAL (no @extends) for your customModal loader
    return view('master.series.series_type.manage', [
        'series'        => $series,
        'configs'       => $configs,
        'chosenLabels'  => $chosenLabels,
    ]);
}

public function manageUpdate(Request $request, Series $series)
{
    $cfgTable = (new SeriesConfiguration)->getTable();

    $validated = $request->validate([
        'config_ids'   => ['nullable','array'],
        'config_ids.*' => ['integer', 'exists:'.$cfgTable.',id'],
    ]);

    // Selected labels from checkboxes
    $selectedLabels = SeriesConfiguration::whereIn('id', Arr::wrap($validated['config_ids'] ?? []))
        ->pluck('series_type')
        ->map(fn($s) => trim((string)$s))
        ->filter()
        ->unique()
        ->values();

    // Current labels in DB for this series
    $currentLabels = SeriesType::where('series_id', $series->id)
        ->pluck('series_type')
        ->map(fn($s) => trim((string)$s))
        ->values();

    // Universe of config labels for this Series (used to avoid deleting custom free-typed ones)
    $universe = SeriesConfiguration::query()
        ->orderBy('series_type')
        ->pluck('series_type')
        ->map(fn($s) => trim((string)$s))
        ->unique();

    // What to add (in selected but not in current)
    $toAdd = $selectedLabels->diff($currentLabels);

    // What to remove (in current AND in universe of known configs, but NOT selected)
    // -> avoids deleting any custom labels you might have added previously by typing
    $toRemove = $currentLabels->intersect($universe)->diff($selectedLabels);

    DB::transaction(function () use ($series, $toAdd, $toRemove) {
        foreach ($toAdd as $label) {
            SeriesType::firstOrCreate([
                'series_id'   => $series->id,
                'series_type' => $label,
            ]);
        }

        if ($toRemove->isNotEmpty()) {
            SeriesType::where('series_id', $series->id)
                ->whereIn('series_type', $toRemove->all())
                ->delete();
        }
    });

    return redirect()
        ->route('master.series-type.index', ['series_id' => $series->id])
        ->with('success', __('Series Types updated.'));
}

public function destroyBySeries(Series $series)
{
    SeriesType::where('series_id', $series->id)->delete();

    return redirect()
        ->route('master.series-type.index', ['series_id' => $series->id])
        ->with('success', __('All Series Types removed for this series.'));
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




public function configsBySeries(Series $series)
{
    // Get ProductType IDs for this series (matches column "series" in producttypes table)
    $ptIds = ProductType::where('series', $series->series)->pluck('id');

    // Return configs that are linked to any of those PTs either:
    //  a) directly via configs.product_type_id, or
    //  b) via the pivot table.
    $configs = SeriesConfiguration::query()
        ->whereIn('product_type_id', $ptIds) // direct FK
        ->orWhereHas('productTypes', function ($q) use ($ptIds) {
            $q->whereIn('elitevw_master_productkeys_producttypes.id', $ptIds);
        })
        ->orderBy('series_type')
        ->get(['id','series_type']);

    return response()->json([
        'success' => true,
        'data' => $configs->map(fn ($c) => ['id' => $c->id, 'label' => $c->series_type]),
    ]);
}


}
