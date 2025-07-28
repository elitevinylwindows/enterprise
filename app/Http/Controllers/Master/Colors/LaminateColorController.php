<?php

namespace App\Http\Controllers\Master\Colors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Colors\LaminateColor;

class LaminateColorController extends Controller
{
    public function index()
{
    $laminateColors = LaminateColor::all();

    return view('master.colors.laminate_colors.index', compact('laminateColors'));
}


    public function create()
    {
        return view('master.colors.laminate_colors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
              'name' => 'required|unique:elitevw_master_colors_laminate_colors,name',
        'code' => 'required'
        ]);

LaminateColor::create($request->only(['name', 'code']));

        return redirect()->route('laminate-colors.index')->with('success', 'Laminate color added.');
    }

    public function edit(LaminateColor $laminateColor)
    {
        return view('master.colors.laminate_colors.edit', compact('laminateColor'));
    }

    public function update(Request $request, LaminateColor $laminateColor)
    {
        $request->validate([
            'name' => 'required|string|unique:laminate_colors,name,' . $laminateColor->id,
            'code' => 'required|string|unique:laminate_colors,code,' . $laminateColor->id,
        ]);

        $laminateColor->update($request->only(['name', 'code']));

        return redirect()->route('color-options.laminate-colors.index')->with('success', 'Laminate color updated.');
    }

    public function destroy(LaminateColor $laminateColor)
    {
        $laminateColor->delete();
        return redirect()->route('color-options.laminate-colors.index')->with('success', 'Laminate color deleted.');
    }
}
