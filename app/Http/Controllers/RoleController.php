<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roleData = Role::where('parent_id', parentId())->get();
        return view('role.index', compact('roleData'));
    }

    public function create()
    {
        $permissionList = new Collection();
        foreach (\Auth::user()->roles as $role) {
            $permissionList = $permissionList->merge($role->permissions);
        }

        return view('role.create', compact('permissionList'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'title' => 'required|unique:roles,name,null,id,parent_id,' . parentId(),
                'user_permission' => 'required',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->route('role.index')->with('error', $messages->first());
        }

        $userRole = new Role();
        $userRole->name = $request->title;
        $userRole->parent_id = parentId();
        $userRole->save();

        foreach ($request->user_permission as $permission) {
            $result = Permission::find($permission);
            $userRole->givePermissionTo($result);
        }

        return redirect()->route('role.index')->with('success', __('Role successfully created.'));
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissionList = Permission::all(); // get all permissions
        $assignPermission = $role->permissions->pluck('id')->toArray();

        return view('role.edit', compact('role', 'permissionList', 'assignPermission'));
    }

    public function update(Request $request, $id)
    {
        $userRole = Role::find($id);

        $validator = \Validator::make(
            $request->all(),
            [
                'title' => 'required|unique:roles,name,' . $userRole->id . ',id,parent_id,' . parentId(),
                'user_permission' => 'required',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->route('role.index')->with('error', $messages->first());
        }

        $permissionData = $request->except(['permissions']);
        $assignPermissions = $request->user_permission;

        $userRole->fill($permissionData)->save();

        // revoke all and reassign
        $userRole->syncPermissions($assignPermissions);

        return redirect()->route('role.index')->with('success', __('Role successfully updated.'));
    }

    public function destroy($id)
    {
        $userRole = Role::find($id);
        $userRole->delete();

        return redirect()->route('role.index')->with('success', __('Role successfully deleted.'));
    }
}
