<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use App\Models\Manufacturing\Line;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LineController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = Line::query();

        if ($status === 'deleted') {
            $query = Line::onlyTrashed();
        } elseif ($status === 'active') {
            $query->where('status', 'active');
        } elseif ($status === 'inactive') {
            $query->where('status', 'inactive');
        }

        $lines = $query->orderBy('id', 'desc')->get();

        return view('manufacturing.lines.index', compact('lines', 'status'));
    }

    public function create()
    {
        // modal partial
        return view('manufacturing.lines.create');
    }

    public function store(Request $request)
    {
        $table = (new Line)->getTable();

        $data = $request->validate([
            'line'        => ['required', 'string', 'max:255', Rule::unique($table, 'line')],
            'description' => ['nullable', 'string'],
            'status'      => ['required', Rule::in(['active','inactive'])],
        ]);

        Line::create($data);

        return redirect()->route('manufacturing.lines.index')
            ->with('success', 'Line created.');
    }

    public function edit(Line $line)
    {
        // modal partial
        return view('manufacturing.lines.edit', compact('line'));
    }

    public function update(Request $request, Line $line)
    {
        $table = $line->getTable();

        $data = $request->validate([
            'line'        => ['required', 'string', 'max:255', Rule::unique($table, 'line')->ignore($line->id)],
            'description' => ['nullable', 'string'],
            'status'      => ['required', Rule::in(['active','inactive'])],
        ]);

        $line->update($data);

        return redirect()->route('manufacturing.lines.index')
            ->with('success', 'Line updated.');
    }

    public function destroy(Line $line)
    {
        $line->delete();

        return redirect()->route('manufacturing.lines.index', ['status' => 'deleted'])
            ->with('success', 'Line deleted.');
    }
}
