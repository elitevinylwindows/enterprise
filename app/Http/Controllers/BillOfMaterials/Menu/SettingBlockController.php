<?php

namespace App\Http\Controllers\BillOfMaterials\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BillOfMaterials\Menu\SettingBlock;

class SettingBlockController extends Controller
{
    public function index()
    {
        $settingblock = SettingBlock::all();
        return view('bill_of_material.menu.SettingBlock.index', compact('settingblock'));
    }

    public function store(Request $request)
    {
        SettingBlock::create($request->only(['name']));
        return redirect()->route('settingblock.index')->with('success', 'SettingBlock added successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = SettingBlock::findOrFail($id);
        $item->update($request->only(['name']));
        return redirect()->route('settingblock.index')->with('success', 'SettingBlock updated successfully.');
    }

    public function destroy($id)
    {
        SettingBlock::destroy($id);
        return redirect()->route('settingblock.index')->with('success', 'SettingBlock deleted successfully.');
    }
}
