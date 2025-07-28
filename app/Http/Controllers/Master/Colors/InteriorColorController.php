<?php

namespace App\Http\Controllers\Master\Colors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Colors\InteriorColor;

class InteriorColorController extends Controller
{
    public function index()
{
    $interiorColors = InteriorColor::all();

    return view('master.colors.interior_colors.index', compact('interiorColors'));
}


    public function create()
    {
        return view('master.colors.interior_colors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
              'name' => 'required|unique:elitevw_master_colors_interior_colors,name',
        'code' => 'required'
        ]);

        InteriorColor::create($request->only(['name', 'code']));

        return redirect()->route('master.colors.interior-colors.index')->with('success', 'Interior color added.');
    }

    public function edit(InteriorColor $interiorColor)
    {
        return view('master.colors.interior_colors.edit', compact('interiorColor'));
    }

    public function update(Request $request, InteriorColor $interiorColor)
    {
        $request->validate([
            'name' => 'required|string|unique:interior_colors,name,' . $interiorColor->id,
            'code' => 'required|string|unique:interior_colors,code,' . $interiorColor->id,
        ]);

        $interiorColor->update($request->only(['name', 'code']));

        return redirect()->route('color-options.interior-colors.index')->with('success', 'Interior color updated.');
    }

    public function destroy(InteriorColor $interiorColor)
    {
        $interiorColor->delete();
        return redirect()->route('color-options.interior-colors.index')->with('success', 'Interior color deleted.');
    }
}
