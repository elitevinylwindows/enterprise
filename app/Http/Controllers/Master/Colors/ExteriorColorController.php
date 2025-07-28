<?php

namespace App\Http\Controllers\Master\Colors;

use App\Http\Controllers\Controller;
use App\Models\Master\Colors\ExteriorColor;
use Illuminate\Http\Request;

class ExteriorColorController extends Controller
{

public function index()
{
    $exteriorColors = ExteriorColor::all();
    return view('master.colors.exterior_colors.index', compact('exteriorColors'));
}



    public function create()
    {
        return view('master.colors.exterior_colors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            
             'name' => 'required|unique:elitevw_master_colors_exterior_colors,name',
        'code' => 'required'
        ]);

ExteriorColor::create($request->only(['name', 'code']));

        return redirect()->route('color-options.exterior-colors.index')->with('success', 'Exterior Color created.');
    }

    public function edit($id)
    {
        $color = ExteriorColor::findOrFail($id);
        return view('master.colors.exterior_colors.edit', compact('color'));
    }

    public function update(Request $request, $id)
    {
        $color = ExteriorColor::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:exterior_colors,name,' . $id
        ]);

        $color->update($request->all());

        return redirect()->route('color-options.exterior-colors.index')->with('success', 'Updated successfully.');
    }

    public function destroy($id)
    {
        $color = ExteriorColor::findOrFail($id);
        $color->delete();

        return redirect()->back()->with('success', 'Deleted successfully.');
    }
}
