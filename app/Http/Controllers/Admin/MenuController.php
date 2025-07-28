<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Menu;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    public function index()
{
$menus = Menu::with('parent')->orderBy('order')->get();
    return view('admin.menu.index', compact('menus'));
}


    public function create()
    {
        $roles = User::all();
        $parents = Menu::where('type', '!=', 'sub-submenu')->get();
        $menus = Menu::orderBy('order')->get();
        return view('admin.menu.create', compact('roles', 'parents', 'menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'route' => 'nullable|string',
            'type' => 'required|string',
            'icon' => 'nullable|string',
            'parent_id' => 'nullable|integer',
            'roles' => 'nullable|array',
        ]);

        $menu = Menu::create([
            'name' => $request->name,
            'route' => $request->route,
            'type' => $request->type,
            'icon' => $request->icon,
            'parent_id' => $request->parent_id,
            'order' => Menu::max('order') + 1,
            'roles' => json_encode($request->roles ?? []),
        ]);

        Cache::forget('menu_cache');

        return redirect()->route('menu.index')->with('success', 'Menu created successfully.');
    }

   public function edit($id)
{
    $menu = Menu::findOrFail($id);
    $roles = \App\Models\User::all(); // or use Role::all() if you have a Role model
    $parents = Menu::where('type', '!=', 'sub-submenu')
                   ->where('id', '!=', $id) // to avoid selecting itself as parent
                   ->get();
    return view('admin.menu.edit', compact('menu', 'roles', 'parents'));
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'route' => 'nullable|string',
            'type' => 'required|string',
            'icon' => 'nullable|string',
            'parent_id' => 'nullable|integer',
            'roles' => 'nullable|array',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->update([
            'name' => $request->name,
            'route' => $request->route,
            'type' => $request->type,
            'icon' => $request->icon,
            'parent_id' => $request->parent_id,
            'roles' => json_encode($request->roles ?? []),
        ]);

        Cache::forget('menu_cache');

        return redirect()->route('menu.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy($id)
    {
        Menu::destroy($id);
        Cache::forget('menu_cache');
        return redirect()->back()->with('success', 'Menu deleted.');
    }



private function generateNestableHtml($menus, $parentId = null)
{
    if (!isset($menus[$parentId])) return '';

    $html = '<ol class="dd-list">';
    foreach ($menus[$parentId] as $menu) {
        $html .= '<li class="dd-item" data-id="' . $menu->id . '">';
        $html .= '<div class="dd-handle"><i class="' . $menu->icon . '"></i>' . $menu->name . '</div>';
        $html .= $this->generateNestableHtml($menus, $menu->id); // Recursive
        $html .= '</li>';
    }
    $html .= '</ol>';

    return $html;
}



public function reorder()
{
    $allMenus = Menu::orderBy('order')->get();

    // Menus that are not yet ordered (i.e., available items)
    $orderedIds = Menu::whereNotNull('order')->pluck('id')->toArray();
    $availableMenus = $allMenus->filter(fn($menu) => !in_array($menu->id, $orderedIds));

    // Menus already ordered
    $orderedMenus = Menu::whereNotNull('order')->orderBy('order')->get();

    return view('admin.menu.reorder', compact('availableMenus', 'orderedMenus'));
}

public function saveReorder(Request $request)
{
    $menuStructure = json_decode($request->menu_structure, true);

    foreach ($menuStructure as $index => $item) {
        Menu::where('id', $item['id'])->update([
            'order' => $index + 1
        ]);
    }

    return redirect()->route('menu.index')->with('success', 'Menu order updated successfully.');
}

    public function exportJson()
    {
        $menus = Menu::orderBy('order')->get();
        return response()->json($menus);
    }
}
