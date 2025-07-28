<?php

namespace App\Http\Controllers;

use App\Models\ProductionStatus;
use Illuminate\Http\Request;

class ProductionStatusController extends Controller
{
    public function index()
    {
        $statuses = ProductionStatus::all();
        return view('production_status.index', compact('statuses'));
    }

    public function create()
    {
        return view('production_status.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'seq_no' => 'required|integer',
            'prod_status_code' => 'required|string',
            'description' => 'required|string',
            'station' => 'nullable|string',
            'print_flag' => 'boolean',
            'next_status_code' => 'nullable|string',
            'color' => 'required|string',
        ]);

        ProductionStatus::create($request->all());
        return redirect()->route('production-status.index')->with('success', 'Status created.');
    }

    public function edit(ProductionStatus $production_status)
    {
        return view('production_status.edit', compact('production_status'));
    }

    public function update(Request $request, ProductionStatus $production_status)
    {
        $request->validate([
            'seq_no' => 'required|integer',
            'prod_status_code' => 'required|string',
            'description' => 'required|string',
            'station' => 'nullable|string',
            'print_flag' => 'boolean',
            'next_status_code' => 'nullable|string',
            'color' => 'required|string',
        ]);

        $production_status->update($request->all());
        return redirect()->route('production-status.index')->with('success', 'Status updated.');
    }

    public function destroy(ProductionStatus $production_status)
    {
        $production_status->delete();
        return redirect()->route('production-status.index')->with('success', 'Status deleted.');
    }
}
