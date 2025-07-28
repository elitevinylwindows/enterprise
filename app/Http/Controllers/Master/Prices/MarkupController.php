<?php

namespace App\Http\Controllers\Master\Prices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Prices\Markup;
use App\Models\Master\Series\Series;

class MarkupController extends Controller
{
    public function index()
    {
        $markups = Markup::with('series')->get();
        $series = Series::all();
        return view('master.prices.markup.index', compact('markups', 'series'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'series_id' => 'required|exists:elitevw_master_series,id',
            'percentage' => 'required|numeric'
        ]);

        Markup::create($data);

        return back()->with('success', 'Markup added.');
    }

    public function update(Request $request, $id)
    {
        $markup = Markup::findOrFail($id);
        if (!$markup->is_locked) {
            $markup->update($request->only('percentage'));
        }

        return back()->with('success', 'Markup updated.');
    }

    public function lock($id)
    {
        $markup = Markup::findOrFail($id);
        $markup->is_locked = true;
        $markup->save();

        return back()->with('success', 'Markup locked.');
    }
}
