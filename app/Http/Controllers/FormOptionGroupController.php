<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormOptionGroup;

class FormOptionGroupController extends Controller
{
    // Show the form to edit a group
    public function edit($id)
    {
        $group = FormOptionGroup::findOrFail($id);
        return view('inventory.form_options.groups.edit', compact('group'));
    }

    // Handle update request
    public function update(Request $request, $id)
    {
        $group = FormOptionGroup::findOrFail($id);
        $group->update($request->validate([
            'group_name' => 'required|string|max:255',
            'has_thickness' => 'nullable|boolean',
            'has_size' => 'nullable|boolean',
            'has_submenu' => 'nullable|boolean',
            'condition' => 'nullable|string|max:255',
        ]));

        return redirect()->route('form-options.index')->with('success', 'Group updated successfully.');
    }

    // Optional: show all groups (e.g. index page)
    public function index()
    {
        
        $seriesList = \App\Models\Series::orderBy('name')->get();
        $groups = FormOptionGroup::all();
return view('inventory.form_options.index', compact('groups', 'seriesList'));
    }
}
