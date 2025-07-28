<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formula;

class FormulaController extends Controller
{
    public function index()
    {
        $formulas = Formula::pluck('percentage', 'key_name')->toArray();
        return view('executives.formulas.index', compact('formulas'));
    }

    public function update(Request $request)
    {
        foreach ($request->formulas as $key => $value) {
            Formula::updateOrCreate(
                ['key_name' => $key],
                ['percentage' => $value]
            );
        }

        return back()->with('success', 'Formulas updated.');
    }
}
