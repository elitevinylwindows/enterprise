<?php

namespace App\Http\Controllers;

use App\Models\FormOption;
use App\Models\FormOptionGroup;
use Illuminate\Http\Request;
use App\Models\GlassType;
use App\Models\Series;
use App\Models\ReinforcementOption;
use App\Models\OptionGroup; // This should be FormOptionGroup unless you renamed it


class FormOptionController extends Controller
{
  public function index()
{
    $groups = FormOptionGroup::with(['options'])->get();

    foreach ($groups as $group) {
        $groupName = strtolower($group->name);

        if (str_contains($groupName, 'reinforcement')) {
            $group->options = \App\Models\ReinforcementOption::where('option_group_id', $group->id)->get();
        }

        if (str_contains($groupName, 'glass type')) {
            $group->options = \App\Models\GlassType::where('option_group_id', $group->id)->get();
        }
    }

    // Load all series for dropdowns
    $seriesList = Series::orderBy('name')->get();

    return view('inventory.form_options.index', compact('groups', 'seriesList'));
}

public function create()
{

    $groups = \App\Models\FormOptionGroup::all();
    return view('inventory.form_options.create', compact('groups'));
}
public function edit(FormOption $option)
{
    $groups = FormOptionGroup::all();

    // If you use related sizes as a JSON field or separate table, load them accordingly:
    $option->sizes = json_decode($option->sizes ?? '[]'); // Adjust as needed

    return view('inventory.form_options.edit', compact('option', 'groups'));
}
public function destroy($id)
{
    $option = FormOption::findOrFail($id);
    $option->delete();

    return back()->with('success', 'Option deleted.');
}


public function store(Request $request)
{
    // Pre-check for malformed glass_sets or reinforce_option
    if ($request->has('glass_sets') && !is_array($request->glass_sets)) {
        return back()->with('error', 'Invalid glass set data.');
    }

    if ($request->has('reinforce_option') && !is_array($request->reinforce_option)) {
        return back()->with('error', 'Invalid reinforcement data.');
    }

    // Now validate the rest
    $validated = $request->validate([
        'group_id' => 'required|exists:elitevw_sr_form_option_groups,id',
        'option_name' => 'required|string|max:255',
        'sub_option' => 'nullable|string',
        'is_default' => 'nullable|boolean',
        'has_thickness' => 'nullable|boolean',
        'thickness' => 'nullable|string',
        'size' => 'nullable|array',
        'size.*.size' => 'nullable|string',
        'size.*.name' => 'nullable|string',
    ]);

    // Main option (non-size)
    $option = FormOption::create([
        'group_id'      => $validated['group_id'],
        'option_name'   => $validated['option_name'],
        'sub_option'    => $validated['sub_option'] ?? null,
        'is_default'    => $request->has('is_default'),
        'has_thickness' => $request->has('has_thickness'),
        'thickness'     => $request->input('thickness'),
        'is_size'       => 0,
        'is_thickness'  => $request->has('has_thickness') ? 1 : 0,
    ]);

    \Log::info('Main option created:', $option->toArray());

    // Create additional size options if present
    if ($request->has('size')) {
        foreach ($request->size as $sz) {
            if (!empty($sz['name']) && !empty($sz['size'])) {
                $sizeOption = FormOption::create([
                    'group_id'     => $validated['group_id'],
                    'option_name'  => $sz['name'],
                    'size_label'   => $sz['name'],
                    'size_value'   => $sz['size'],
                    'is_size'      => 1,
                    'is_thickness' => 0,
                    'is_default'   => $request->has('is_default') ? 1 : 0,
                ]);
                \Log::info('Size option created:', $sizeOption->toArray());
            }
        }
    }
$group = FormOptionGroup::find($request->group_id);
$groupName = strtolower($group->name);

if (str_contains($groupName, 'glass type') && $request->has('glass_sets')) {
    foreach ($request->glass_sets as $glassSet) {
        $glass = new GlassType(); // your model
        $glass->option_group_id = $group->id;
        $glass->name = $glassSet['name'];
        $glass->prices = json_encode(array_map(function($thickness, $fraction, $index) use ($glassSet) {
            return [
                'thickness' => $thickness,
                'fraction' => $fraction,
                'price' => $glassSet['prices'][$index] ?? null
            ];
        }, ['3.1 MM','3.9 MM','4.7 MM','5.7 MM'], ['1/8','5/32','3/16','1/4'], array_keys($glassSet['prices'])));
        $glass->save();
    }
}

if ((str_contains($groupName, 'sash reinforcement') || str_contains($groupName, 'mull reinforcement')) && $request->has('reinforce_option')) {
    foreach ($request->reinforce_option['sizes'] as $row) {
        $reinforce = new ReinforcementOption(); // your model
        $reinforce->option_group_id = $group->id;
        $reinforce->name = $row['name'];
        $reinforce->size = $row['size'];
        $reinforce->save();
    }
}

    return redirect()->back()->with('success', 'Option added successfully.');
}



public function updateOption(Request $request, $id)
{
    $option = FormOption::findOrFail($id);

    // Always update common fields
    $option->option_name = $request->option_name;
    $option->sub_option = $request->sub_option;
    $option->is_default = $request->has('is_default');

    // Handle Reinforcement (size_json)
    if (Str::contains(strtolower($option->group->name), 'reinforcement')) {
        $option->size_json = $request->input('sizes', []);
    }

    // Handle Glass Type (thickness_json)
    elseif (Str::contains(strtolower($option->group->name), 'glass')) {
        $input = $request->input('thickness_json', []);
        $existing = $option->thickness_json ?? [];

        $updated = [];
        foreach ($existing as $index => $row) {
            $updated[] = [
                'thickness' => $row['thickness'] ?? '',
                'fraction' => $row['fraction'] ?? '',
                'price' => $input[$index]['price'] ?? '',
            ];
        }

        $option->thickness_json = $updated;
    }

    $option->save();

    return back()->with('success', 'Option updated successfully.');
}


    public function storeGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'condition' => 'nullable|string',
        ]);

        FormOptionGroup::create($request->only('name', 'condition'));

        return back()->with('success', 'Group added.');
    }

public function storeOption(Request $request)
{
    $groupId = $request->group_id;
    $group = FormOptionGroup::findOrFail($groupId);

    $groupName = strtolower($group->name);

    if (str_contains($groupName, 'glass type')) {
        // Save each glass set
        foreach ($request->glass_sets ?? [] as $set) {
            GlassType::create([
                'option_group_id' => $groupId,
                'name' => $set['name'],
                'prices' => collect($set['prices'] ?? [])->map(function ($price, $index) {
                    $thicknessMap = [
                        0 => ['thickness' => '3.1 MM', 'fraction' => '1/8'],
                        1 => ['thickness' => '3.9 MM', 'fraction' => '5/32'],
                        2 => ['thickness' => '4.7 MM', 'fraction' => '3/16'],
                        3 => ['thickness' => '5.7 MM', 'fraction' => '1/4'],
                    ];
                    return array_merge($thicknessMap[$index] ?? [], ['price' => $price]);
                }),
            ]);
        }

    } elseif (str_contains($groupName, 'reinforcement')) {
        // Save reinforcement sizes
        foreach ($request->reinforce_option['sizes'] ?? [] as $row) {
            \App\Models\ReinforcementOption::create([
                'option_group_id' => $groupId,
                'name' => $row['name'],
                'size' => $row['size'],
            ]);
        }

    } else {
        // Regular options
        foreach ($request->options ?? [] as $row) {
            FormOption::create([
                'option_group_id' => $groupId,
                'option_name' => $row['name'],
                'sub_option' => isset($row['sub_option']) ? 'yes' : null,
                'is_default' => $request->has('is_default'),
            ]);
        }
    }

    return redirect()->back()->with('success', 'Options saved.');
}


}
