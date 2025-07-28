<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\WarningLabel;

class WarningLabelController extends Controller
{
    public function index()
    {
        $warninglabel = WarningLabel::all();
        return view('bill_of_material.menu.WarningLabel.index', compact('warninglabel'));
    }

    public function store(Request $request)
    {
        WarningLabel::create($request->only(['name']));
        return redirect()->route('warninglabel.index')->with('success', 'WarningLabel added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = WarningLabel::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('warninglabel.index')->with('success', 'WarningLabel updated successfully.');
    }

    public function destroy($id)
    {
        WarningLabel::destroy($id);
        return redirect()->route('warninglabel.index')->with('success', 'WarningLabel deleted successfully.');
    }
}
