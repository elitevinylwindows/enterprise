<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manufacturing\Machine;

class MachineController extends Controller
{
    public function index(Request $request)
    {
        $fileType = $request->get('file_type', null);
        $query = Machine::query();

        if ($fileType) {
            $query->where('file_type', $fileType);
        }

        $machines = $query->orderBy('id')->get();

        return view('manufacturing.machines.index', [
            'machines' => $machines,
            'status' => $fileType ?? 'all',
        ]);
    }

    public function create()
    {
        return view('manufacturing.machines.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'machine' => 'required|string|max:255',
            'file_type' => 'required|string|in:pdf,image,video,other',
        ]);

        Machine::create($validated);

        return redirect()->route('manufacturing.machines.index')
            ->with('success', 'Machine added successfully.');
    }

    public function show(Machine $machine)
    {
        return view('manufacturing.machines.show', compact('machine'));
    }

    public function edit(Machine $machine)
    {
        return view('manufacturing.machines.edit', compact('machine'));
    }

    public function update(Request $request, Machine $machine)
    {
        $validated = $request->validate([
            'machine' => 'required|string|max:255',
            'file_type' => 'required|string|in:pdf,image,video,other',
        ]);

        $machine->update($validated);

        return redirect()->route('manufacturing.machines.index')
            ->with('success', 'Machine updated successfully.');
    }

    public function destroy(Machine $machine)
    {
        $machine->delete();

        return redirect()->route('manufacturing.machines.index')
            ->with('success', 'Machine deleted successfully.');
    }
}
