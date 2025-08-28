<?php

namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating\NfrcWindowType;  // ✅ correct namespace

class NfrcWindowTypeController extends Controller
{
    public function index()
    {
        $types = NfrcWindowType::orderBy('name')->paginate(20);
        return view('rating.window_type.index', compact('types'));
    }

    public function create()
    {
        return view('rating.window_type.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'slug' => 'required|string|max:80|unique:elitevw_rating_window_types,slug',
        ]);

        NfrcWindowType::create($data);

        return redirect()->route('rating.window-type.index')
                         ->with('success','Window type created successfully.');
    }

    public function edit(NfrcWindowType $type)
    {
        return view('rating.window_type.edit', compact('type'));
    }

    public function update(Request $request, NfrcWindowType $type)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'slug' => 'required|string|max:80|unique:elitevw_rating_window_types,slug,'.$type->id,
        ]);

        $type->update($data);

        return redirect()->route('rating.window-type.index')
                         ->with('success','Window type updated successfully.');
    }

    public function destroy(NfrcWindowType $type)
    {
        $type->delete();
        return redirect()->route('rating.window-type.index')
                         ->with('success','Window type deleted successfully.');
    }
}
