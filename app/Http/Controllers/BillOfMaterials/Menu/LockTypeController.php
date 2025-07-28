<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\LockType;

class LockTypeController extends Controller
{
    public function index()
    {
        $locktype = LockType::all();
        return view('bill_of_material.menu.LockType.index', compact('locktype'));
    }

    public function store(Request $request)
    {
        LockType::create($request->only(['name']));
        return redirect()->route('locktype.index')->with('success', 'LockType added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = LockType::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('locktype.index')->with('success', 'LockType updated successfully.');
    }

    public function destroy($id)
    {
        LockType::destroy($id);
        return redirect()->route('locktype.index')->with('success', 'LockType deleted successfully.');
    }
}
