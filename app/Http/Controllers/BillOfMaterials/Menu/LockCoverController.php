<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\LockCover;

class LockCoverController extends Controller
{
    public function index()
    {
        $lockcover = LockCover::all();
        return view('bill_of_material.menu.LockCover.index', compact('lockcover'));
    }

    public function store(Request $request)
    {
        LockCover::create($request->only(['name', 'color']));
        return redirect()->route('lockcover.index')->with('success', 'LockCover added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = LockCover::findOrFail($id);
        $item->update($request->only(['name', 'color']));
        return redirect()->route('lockcover.index')->with('success', 'LockCover updated successfully.');
    }

    public function destroy($id)
    {
        LockCover::destroy($id);
        return redirect()->route('lockcover.index')->with('success', 'LockCover deleted successfully.');
    }
}
