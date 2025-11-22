<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BProductController extends Controller
{
    protected $uploadFolder = 'admin_products';

    /**
     * Helper: delete image safely from storage.
     * Tries public disk, then tries legacy private/public location.
     */
    protected function deleteImageIfExists(string $imgPath): bool
    {
        $candidate = ltrim($imgPath, '/');

        // try delete from public disk (correct location)
        if (Storage::disk('public')->exists($candidate)) {
            Storage::disk('public')->delete($candidate);
            return true;
        }

        // fallback: maybe files were stored in storage/app/private/public/...
        if (Storage::exists('private/public/' . $candidate)) {
            Storage::delete('private/public/' . $candidate);
            return true;
        }

        return false;
    }

    public function index(Request $request): View
    {
        $q = $request->input('q');
        $query = Product::with(['user', 'category'])->orderBy('created_at', 'desc');

        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('slug', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $products = $query->paginate(20)->withQueryString();

        return view('backend.products.index', compact('products', 'q'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $sellers = User::orderBy('name')->get();
        return view('backend.products.form', [
            'mode' => 'create',
            'product' => new Product(),
            'categories' => $categories,
            'sellers' => $sellers,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'status' => 'nullable|in:draft,published',
            'images.*' => 'nullable|image|max:5120'
        ]);

        // handle image uploads
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                // stores to storage/app/public/admin_products and returns "admin_products/filename.jpg"
                $path = $file->storeAs($this->uploadFolder, $filename, 'public');
                // $path is already the relative path (e.g. "admin_products/xxx.jpg")
                $images[] = $path;

            }
        }

        $product = Product::create([
            'user_id' => $data['user_id'] ?? null,
            'category_id' => $data['category_id'] ?? null,
            'name' => $data['name'],
            'slug' => $data['slug'] ?? Str::slug($data['name']) . '-' . Str::random(4),
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'stock' => $data['stock'] ?? 0,
            'status' => $data['status'] ?? 'draft',
            'images' => $images ?: null,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function show($id): View
    {
        $product = Product::with(['user', 'category'])->findOrFail($id);
        return view('backend.products.show', compact('product'));
    }

    public function edit($id): View
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        $sellers = User::orderBy('name')->get();
        return view('backend.products.form', [
            'mode' => 'edit',
            'product' => $product,
            'categories' => $categories,
            'sellers' => $sellers,
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'status' => 'nullable|in:draft,published',
            'images.*' => 'nullable|image|max:5120',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'string'
        ]);

        // current images
        $current = $product->images ?? [];

        // remove selected images
        if (!empty($data['remove_images'])) {
            foreach ($data['remove_images'] as $rem) {
                $idx = array_search($rem, $current);
                if ($idx !== false) {
                    // use helper to delete
                    $this->deleteImageIfExists($rem);
                    array_splice($current, $idx, 1);
                }
            }
        }

        // add new uploaded images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs($this->uploadFolder, $filename, 'public');
                $current[] = str_replace('public/', '', $path);
            }
        }

        $product->update([
            'user_id' => $data['user_id'] ?? $product->user_id,
            'category_id' => $data['category_id'] ?? $product->category_id,
            'name' => $data['name'],
            'slug' => $data['slug'] ?? $product->slug,
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'stock' => $data['stock'] ?? 0,
            'status' => $data['status'] ?? $product->status,
            'images' => $current ?: null,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy($id): RedirectResponse
    {
        // find product or 404
        $product = \App\Models\Product::findOrFail($id);

        // OPTIONAL: ownership check (uncomment if you want only owner to delete)
        // if (!Auth::check() || Auth::id() !== $product->user_id) {
        //     return redirect()->back()->with('error', 'Not authorized to delete this product.');
        // }

        // delete images stored in images array
        if ($product->images && is_array($product->images)) {
            foreach ($product->images as $img) {
                $img = ltrim($img, '/');
                // primary disk
                if (Storage::disk('public')->exists($img)) {
                    Storage::disk('public')->delete($img);
                }
                // fallback if older files exist under storage/app/private/public/...
                if (Storage::exists('private/public/' . $img)) {
                    Storage::delete('private/public/' . $img);
                }
            }
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted.');
    }
}
