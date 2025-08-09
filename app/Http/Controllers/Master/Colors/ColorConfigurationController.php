<?php

namespace App\Http\Controllers\Master\Colors;

use App\Http\Controllers\Controller;
use App\Models\Master\Colors\ColorConfiguration;
use Illuminate\Http\Request;

class ColorConfigurationController extends Controller
{
public function index()
{
    $colorConfigurations = \App\Models\Master\Colors\ColorConfiguration::all();
    $exteriorColors = \App\Models\Master\Colors\ExteriorColor::all();
    $interiorColors = \App\Models\Master\Colors\InteriorColor::all();
    $laminateColors = \App\Models\Master\Colors\LaminateColor::all();

    return view('master.colors.color_configurations.index', compact(
        'colorConfigurations',
        'exteriorColors',
        'interiorColors',
        'laminateColors'
    ));
}



public function create()
{
    $colorConfigurations = \App\Models\Master\Colors\ColorConfiguration::all();
    $exteriorColors = \App\Models\Master\Colors\ExteriorColor::all();
    $interiorColors = \App\Models\Master\Colors\InteriorColor::all();
    $laminateColors = \App\Models\Master\Colors\LaminateColor::all();

    return view('master.colors.color_configurations.create', compact(
        'colorConfigurations',
        'exteriorColors',
        'interiorColors',
        'laminateColors'
    ));
}


    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:elitevw_master_colors_color_configurations,name',
        'code' => 'required'
    ]);

    ColorConfiguration::create($request->only(['name', 'code']));

    return redirect()->route('color-options.color-configurations.index')->with('success', 'Color Configuration created.');
}


    public function edit($id)
    {
        $config = ColorConfiguration::findOrFail($id);
        return view('master.colors.color_configurations.edit', compact('config'));
    }

    public function update(Request $request, $id)
    {
        $config = ColorConfiguration::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|unique:elitevw_master_colors_color_configurations,name,' . $id,
            'code' => 'required'
        ]);

        $config->update($request->only(['name', 'code']));

        return redirect()->route('color-options.color-configurations.index')->with('success', 'Updated successfully.');
    }

    public function destroy($id)
    {
        $config = ColorConfiguration::findOrFail($id);
        $config->delete();

        return redirect()->back()->with('success', 'Deleted successfully.');
    }
}
