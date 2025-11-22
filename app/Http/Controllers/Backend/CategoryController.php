<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $q = $request->input('q');
        $query = Category::orderBy('name');

        if ($q) {
            $query->where('name', 'like', "%{$q}%")
                  ->orWhere('slug', 'like', "%{$q}%");
        }

        $categories = $query->paginate(20)->withQueryString();

        return view('backend.categories.index', compact('categories', 'q'));
    }

    public function create(): View
    {
        return view('backend.categories.form', [
            'mode' => 'create',
            'category' => new Category(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:191|unique:categories,name',
            'slug' => 'nullable|string|max:191|unique:categories,slug',
        ]);

        $category = Category::create([
            'name' => $data['name'],
            'slug' => $data['slug'] ?? null,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit($id): View
    {
        $category = Category::findOrFail($id);

        return view('backend.categories.form', [
            'mode' => 'edit',
            'category' => $category,
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        $data = $request->validate([
            'name' => ['required','string','max:191', Rule::unique('categories','name')->ignore($category->id)],
            'slug' => ['nullable','string','max:191', Rule::unique('categories','slug')->ignore($category->id)],
        ]);

        $category->update([
            'name' => $data['name'],
            'slug' => $data['slug'] ?? $category->slug,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy($id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        // Optional: prevent deleting categories with products. Remove if you prefer.
        if ($category->products()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete category with products. Move or delete products first.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }
}
