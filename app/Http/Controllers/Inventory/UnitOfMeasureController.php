<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\Uom;


class UnitOfMeasureController extends Controller
{

  public function index()
    {
        $uoms = Uom::all();
        return view('inventory.uoms.index', compact('uoms'));
    }    public function create() { return view('inventory.uoms.create'); }
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'short_code' => 'required|string|max:10',
        'status' => 'required|in:Active,Inactive',

    ]);

    $uom = Uom::create([
        'name' => $request->name,
        'short_code' => $request->short_code,
        'status' => $request->status,
    ]);

    return redirect()->route('inventory.uoms.index')
                 ->with('success', 'UOM created successfully.');

}

    public function edit($id)
{
    $uom = \App\Models\Inventory\Uom::findOrFail($id);
    return view('inventory.uoms.edit', compact('uom'));
}

   public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'short_code' => 'required|string|max:10',
        'status' => 'required|in:Active,Inactive',
    ]);

    $uom = \App\Models\Inventory\Uom::findOrFail($id);
    $uom->update([
        'name' => $request->name,
        'short_code' => $request->short_code,
        'status' => $request->status,
    ]);

    return redirect()->route('inventory.uoms.index')
                 ->with('success', 'Unit created successfully.');
}

    public function destroy($id) {}
}