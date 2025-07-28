<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\Location;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        return view('inventory.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('inventory.locations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        Location::create($request->all());

        return redirect()->route('inventory.locations.index')->with('success', 'Location created successfully.');
    }

    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return view('inventory.locations.edit', compact('location'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        $location = Location::findOrFail($id);
        $location->update($request->all());

        return redirect()->route('inventory.locations.index')->with('success', 'Location updated successfully.');
    }

    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return redirect()->route('inventory.locations.index')->with('success', 'Location deleted successfully.');
    }
}
