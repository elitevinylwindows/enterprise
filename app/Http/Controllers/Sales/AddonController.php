<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales\Addon;

class AddonController extends Controller
{
    public function index()
    {
        $addons = Addon::all();
        return view('sales.addons.index', compact('addons'));
    }

    public function store(Request $request)
    {
        Addon::create($request->only('group_name', 'option_label', 'fee'));
        return redirect()->route('sales.addons.index')->with('success', 'Addon created.');
    }

    public function destroy($id)
    {
        Addon::destroy($id);
        return back()->with('success', 'Addon deleted.');
    }
}
