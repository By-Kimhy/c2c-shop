<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class SellerProductController extends Controller
{
    /**
     * Only products owned by the authenticated seller.
     */
    protected function ownerQuery()
    {
        return Product::query()->where('user_id', auth()->id());
    }

    /**
     * Store uploaded image, create resized main image and thumbnail.
     * Returns array with 'path' and 'thumb' (public disk paths).
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @return array
     */
    protected function storeUploadedImage($file, $folder = 'seller_products')
    {
        // Ensure directory exists
        $dir = storage_path("app/public/{$folder}");
        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        // safe filename
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $ext = $file->getClientOriginalExtension();
        $safe = Str::slug(substr($originalName, 0, 40));
        $name = time() . '-' . $safe . '.' . $ext;

        $mainPath = "{$folder}/{$name}";
        $mainFull = storage_path("app/public/{$mainPath}");

        // Resize main image to max width 1200 while preserving aspect ratio
        $img = Image::make($file)->orientate();
        $img->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($mainFull, 85); // 85% quality

        // Create square thumbnail 300x300 (fit + crop)
        $thumbName = 'thumb-' . $name;
        $thumbPath = "{$folder}/{$thumbName}";
        $thumbFull = storage_path("app/public/{$thumbPath}");

        Image::make($file)->orientate()
            ->fit(300, 300, function ($constraint) {
                $constraint->upsize();
            })->save($thumbFull, 80);

        return ['path' => $mainPath, 'thumb' => $thumbPath];
    }

    /**
     * GET /seller/products
     */
    public function index(Request $request)
    {
        $q = $request->input('q');
        $query = $this->ownerQuery()->orderBy('created_at', 'desc');

        if ($q) {
            $query->where('name', 'like', "%{$q}%");
        }

        $products = $query->paginate(15)->withQueryString();

        return view('frontend.seller.products.index', compact('products', 'q'));
    }

    /**
     * GET /seller/products/create
     */
    public function create()
    {
        return view('frontend.seller.products.form', [
            'product' => new Product,
            'mode' => 'create'
        ]);
    }

    /**
     * POST /seller/products
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'status' => 'nullable|in:draft,published',
            'images.*' => 'nullable|image|max:4096',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imgFile) {
                $saved = $this->storeUploadedImage($imgFile, 'seller_products');
                $images[] = $saved['path'];
            }
        }

        $product = Product::create([
            'user_id' => auth()->id(),
            'category_id' => $data['category_id'] ?? 1,
            'name' => $data['name'],
            'slug' => $data['slug'] ?? Str::slug($data['name']) . '-' . Str::random(4),
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'stock' => $data['stock'] ?? 0,
            'status' => $data['status'] ?? 'draft',
            'images' => $images ?: null,
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Product created.');
    }

    /**
     * GET /seller/products/{id}
     */
    public function show($id)
    {
        $product = $this->ownerQuery()->findOrFail($id);
        return view('frontend.seller.products.show', compact('product'));
    }

    /**
     * GET /seller/products/{id}/edit
     */
    public function edit($id)
    {
        $product = $this->ownerQuery()->findOrFail($id);
        return view('frontend.seller.products.form', [
            'product' => $product,
            'mode' => 'edit'
        ]);
    }

    /**
     * PUT /seller/products/{id}
     */
    public function update(Request $request, $id)
    {
        $product = $this->ownerQuery()->findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => "nullable|string|max:255|unique:products,slug,{$product->id}",
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'status' => 'nullable|in:draft,published',
            'images.*' => 'nullable|image|max:4096',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'string',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $currentImages = $product->images ?? [];

        // Remove selected images (delete both main and thumb)
        if (!empty($data['remove_images'])) {
            foreach ($data['remove_images'] as $rem) {
                $k = array_search($rem, $currentImages);
                if ($k !== false) {
                    // delete main
                    if (Storage::disk('public')->exists($currentImages[$k])) {
                        Storage::disk('public')->delete($currentImages[$k]);
                    }
                    // delete thumb
                    $thumbCandidate = dirname($currentImages[$k]) . '/thumb-' . basename($currentImages[$k]);
                    if (Storage::disk('public')->exists($thumbCandidate)) {
                        Storage::disk('public')->delete($thumbCandidate);
                    }
                    array_splice($currentImages, $k, 1);
                }
            }
        }

        // Add new uploaded images (resized + thumb)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imgFile) {
                $saved = $this->storeUploadedImage($imgFile, 'seller_products');
                $currentImages[] = $saved['path'];
            }
        }

        $product->update([
            'name' => $data['name'],
            'slug' => $data['slug'] ?? $product->slug,
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'stock' => $data['stock'] ?? 0,
            'status' => $data['status'] ?? $product->status,
            'images' => $currentImages ?: null,
            'category_id' => $data['category_id'] ?? $product->category_id
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Product updated.');
    }

    /**
     * DELETE /seller/products/{id}
     */
    public function destroy($id)
    {
        $product = $this->ownerQuery()->findOrFail($id);

        // delete images and thumbnails
        if ($product->images && is_array($product->images)) {
            foreach ($product->images as $img) {
                if (Storage::disk('public')->exists($img)) {
                    Storage::disk('public')->delete($img);
                }
                $thumbCandidate = dirname($img) . '/thumb-' . basename($img);
                if (Storage::disk('public')->exists($thumbCandidate)) {
                    Storage::disk('public')->delete($thumbCandidate);
                }
            }
        }

        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Product deleted.');
    }
}
