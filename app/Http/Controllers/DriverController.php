<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::all();
        return view('drivers.index', compact('drivers'));
    }

    public function create()
    {
        abort_unless(\Gate::allows('create driver'), 403);
    return view('drivers.modals.create');
    }

    public function store(Request $request)
    {
        Driver::create($request->all());
        return redirect()->route('drivers.index')->with('success', 'Driver created successfully.');
    }

    public function edit($id)
{
    $driver = Driver::findOrFail($id);
    return view('drivers.modals.edit', compact('driver')); // Not drivers.edit
}



    public function update(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);
        $driver->update($request->all());
        return redirect()->route('drivers.index')->with('success', 'Driver updated successfully.');
    }

    public function destroy($id)
    {
        Driver::destroy($id);
        return redirect()->route('drivers.index')->with('success', 'Driver deleted successfully.');
    }
}
