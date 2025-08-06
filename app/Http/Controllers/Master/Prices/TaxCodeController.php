<?php

namespace App\Http\Controllers\Master\Prices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Prices\TaxCode;

class TaxCodeController extends Controller
{
    public function index()
    {
        $taxCodes = TaxCode::all();
        return view('master.prices.tax_codes.index', compact('taxCodes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rate' => 'required|numeric',
        ]);

        TaxCode::create($request->only('code', 'city', 'description', 'rate'));

        return redirect()->route('master.prices.tax-codes.index')->with('success', 'Tax code added successfully.');
    }

    public function edit($id)
{
    $taxCode = TaxCode::findOrFail($id);
    return view('master.prices.tax_codes.edit', compact('taxCode'));
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rate' => 'required|numeric',
        ]);

        $taxCode = TaxCode::findOrFail($id);
        $taxCode->update($request->only('code', 'city', 'description', 'rate'));

        return redirect()->route('master.prices.tax-codes.index')->with('success', 'Tax code updated successfully.');
    }

    public function destroy($id)
    {
        $taxCode = TaxCode::findOrFail($id);
        $taxCode->delete();

        return redirect()->route('master.prices.tax-codes.index')->with('success', 'Tax code deleted successfully.');
    }
}
