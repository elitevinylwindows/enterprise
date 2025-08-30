<?php

namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller; // ✅
use Illuminate\Http\Request;
use App\Models\Rating\NfrcProductLine;
use App\Models\Rating\NfrcWindowType;

class NfrcProductLineController extends Controller
{
    public function index(Request $request)
{
    $typeId = $request->query('type_id');              // ✅ capture
    $s      = trim((string)$request->query('s', ''));  // ✅ capture

    $q = \App\Models\Rating\NfrcProductLine::with('type');
    if ($typeId) {
        $q->where('window_type_id', $typeId);
    }
    if ($s !== '') {
        $q->where(function ($w) use ($s) {
            $w->where('manufacturer','like',"%$s%")
              ->orWhere('series_model','like',"%$s%")
              ->orWhere('product_line','like',"%$s%");
        });
    }

    $lines = $q->orderBy('series_model')->orderBy('product_line')
               ->paginate(20)->withQueryString();
    $types = \App\Models\Rating\NfrcWindowType::orderBy('name')->get(['id','name']);

    return view('rating.product_line.index', compact('lines','types','typeId','s')); // ✅ pass them
}


    public function create()
    {
        $types = NfrcWindowType::orderBy('name')->get(['id','name']);
        return view('rating.product_line.create', compact('types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'window_type_id'   => 'required|exists:elitevw_rating_window_types,id',
            'manufacturer'     => 'required|string|max:160',
            'series_model'     => 'required|string|max:160',
            'product_line'     => 'required|string|max:160',
            'product_line_url' => 'nullable|url|max:512',
            'is_energy_star'   => 'nullable|boolean',
        ]);
        $data['is_energy_star'] = (bool)($data['is_energy_star'] ?? false);

        NfrcProductLine::create($data);
        return redirect()->route('rating.product-line.index')->with('success','Product line created.');
    }

    public function edit(NfrcProductLine $line)
    {
        $types = NfrcWindowType::orderBy('name')->get(['id','name']);
        return view('rating.product_line.edit', compact('line','types'));
    }

    public function update(Request $request, NfrcProductLine $line)
    {
        $data = $request->validate([
            'window_type_id'   => 'required|exists:elitevw_rating_window_types,id',
            'manufacturer'     => 'required|string|max:160',
            'series_model'     => 'required|string|max:160',
            'product_line'     => 'required|string|max:160',
            'product_line_url' => 'nullable|url|max:512',
            'is_energy_star'   => 'nullable|boolean',
        ]);
        $data['is_energy_star'] = (bool)($data['is_energy_star'] ?? false);

        $line->update($data);
        return redirect()->route('rating.product-line.index')->with('success','Product line updated.');
    }

    public function destroy(NfrcProductLine $line)
    {
        $line->delete();
        return redirect()->route('rating.product-line.index')->with('success','Product line deleted.');
    }
}
