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
        $q = Line::query();
        if ($status === 'deleted') $q = Line::onlyTrashed();
        elseif ($status === 'active') $q->where('status','active');
        elseif ($status === 'inactive') $q->where('status','inactive');

        $lines = $q->latest('id')->get();
        return view('manufacturing.lines.index', compact('lines','status'));
    }

    public function create() { return view('manufacturing.lines.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'line'        => ['required','string','max:255', Rule::unique((new Line)->getTable(),'line')],
            'description' => ['nullable','string'],
            'status'      => ['required', Rule::in(['active','inactive'])],
        ]);
        Line::create($data);
        return redirect()->route('manufacturing.lines.index')->with('success','Line created.');
    }

    public function edit(Line $line) { return view('manufacturing.lines.edit', compact('line')); }

    public function update(Request $request, Line $line)
    {
        $data = $request->validate([
            'line'        => ['required','string','max:255', Rule::unique($line->getTable(),'line')->ignore($line->id)],
            'description' => ['nullable','string'],
            'status'      => ['required', Rule::in(['active','inactive'])],
        ]);
        $line->update($data);
        return redirect()->route('manufacturing.lines.index')->with('success','Line updated.');
    }

    public function destroy(Line $line)
    {
        $line->delete();
        return redirect()->route('manufacturing.lines.index', ['status'=>'deleted'])->with('success','Line deleted.');
    }
}
