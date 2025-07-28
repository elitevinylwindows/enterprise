<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\Category;


class CategoryController extends Controller
{
     public function index()
    {
        $categories = Category::all();
        return view('inventory.categories.index', compact('categories'));
    }
    public function create() { return view('inventory.categories.create'); }
    
   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'status' => 'required|in:Active,Inactive',
    ]);

    \App\Models\Inventory\Category::create([
        'name' => $request->name,
        'description' => $request->description,
        'status' => $request->status,
    ]);

     return redirect()->route('inventory.categories.index')
                 ->with('success', 'Category created successfully.');

}


   
    
    
    public function edit($id)
{
    $category = \App\Models\Inventory\Category::findOrFail($id);
    return view('inventory.categories.edit', compact('category'));
}

   public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'status' => 'required|in:Active,Inactive',
    ]);

    $category = \App\Models\Inventory\Category::findOrFail($id);
    $category->update([
        'name' => $request->name,
        'description' => $request->description,
        'status' => $request->status,
    ]);

   return redirect()->route('inventory.categories.index')
                 ->with('success', 'Category created successfully.');
}

    public function destroy($id) {}
}