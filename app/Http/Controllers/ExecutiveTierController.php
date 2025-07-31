<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Tier;


class ExecutiveTierController extends Controller
{
   public function index()
{
    $tiers = Tier::orderBy('sort_order')->get(); // or just ::all() for now
    return view('executives.tiers.index', compact('tiers'));
}


public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:100',
        'benefits' => 'required|string',
        'percentage' => 'required|numeric|min:0|max:100',
    ]);

    Tier::create([
        'name' => $request->name,
        'benefits' => $request->benefits,
        'percentage' => $request->percentage,
        'sort_order' => Tier::max('sort_order') + 1, // optional for order
    ]);

    return redirect()->route('executives.tiers.index')->with('success', 'Tier created successfully.');
}
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'benefits' => 'required|string',
        'percentage' => 'required|numeric|min:0|max:100',
    ]);

    $tier = Tier::findOrFail($id);
    $tier->update([
        'name' => $request->name,
        'benefits' => $request->benefits,
        'percentage' => $request->percentage,
    ]);

    return redirect()->route('executives.tiers.index')->with('success', 'Tier updated successfully.');
}


}
