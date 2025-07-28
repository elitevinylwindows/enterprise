<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormOption;
use App\Models\Series;
use App\Helper\FormOptionHelper;
use App\Models\FormOptionGroup;



class ConfiguratorController extends Controller
{

public function index(Request $request)
{
    $selectedColor = $request->get('color', 'White');
    $selectedSeries = $request->get('series', null); // Allow null

    // If no series provided, pick the first one
    if (!$selectedSeries) {
        $firstSeries = \App\Models\Series::orderBy('sort_order')->first();
        if (!$firstSeries) {
            // No series in DB, return a blank view with a warning
            return view('inventory.configurator.index', [
                'selectedColor' => $selectedColor,
                'selectedSeries' => null,
                'groups' => [],
                'groupedOptions' => [],
                'seriesList' => [],
                'noSeries' => true
            ]);
        }

        return redirect()->route('inventory.configurator.index', [
            'series' => $firstSeries->slug,
            'color' => $selectedColor
        ]);
    }

    // Otherwise fetch the selected series
    $seriesConfig = \App\Models\Series::where('slug', $selectedSeries)->firstOrFail();

    // Load groups tied to this series
    $groups = \App\Models\FormOptionGroup::where('series_id', $seriesConfig->id)
        ->with(['options' => function ($query) use ($selectedColor) {
            $query->where(function ($q) use ($selectedColor) {
                $q->whereNull('condition')
                  ->orWhere('condition', 'like', "%$selectedColor%");
            });
        }])
        ->orderBy('sort_order')
        ->get();

    // Group options
    $groupedOptions = [];
    foreach ($groups as $group) {
        $groupedOptions[$group->name] = $group->options;
    }

    $seriesList = \App\Models\Series::orderBy('name')->get();

    return view('inventory.configurator.index', compact(
        'selectedColor',
        'selectedSeries',
        'groups',
        'groupedOptions',
        'seriesList'
    ));
}


public function show($slug)
{
    // Find series by slug
    $series = \App\Models\Series::where('slug', $slug)->firstOrFail();

    // Redirect to main configurator with query
    return redirect()->route('inventory.configurator.index', [
        'series' => $series->slug
    ]);
}



}



