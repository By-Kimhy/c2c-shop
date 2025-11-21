<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BCategoryController extends Controller
{
    // list categories
    public function index()
    {
        $categories = Category::latest()->paginate(12);
        return view('backend.categories.index', compact('categories'));
    }

    // show create form
    public function create()
    {
        return view('backend.categories.create');
    }

    // store new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . substr(uniqid(), -6),
        ]);

        return redirect()->route('backend.categories.index')->with('flash_message', 'Category created successfully');
    }

    // show edit form
    public function edit(Category $category)
    {
        return view('backend.categories.edit', compact('category'));
    }

    // update category
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
            // keep slug or update if needed:
            'slug' => Str::slug($request->name) . '-' . substr(uniqid(), -6),
        ]);

        return redirect()->route('backend.categories.index')->with('flash_message', 'Category updated successfully');
    }

    // delete category
    public function destroy(Category $category)
    {
        // optionally check for related products before delete
        if ($category->products()->count()) {
            return redirect()->route('backend.categories.index')->with('flash_message', 'Cannot delete: category has products');
        }

        $category->delete();
        return redirect()->route('backend.categories.index')->with('flash_message', 'Category deleted');
    }
}
