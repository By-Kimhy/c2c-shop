<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'seller')->paginate(20);
        return view('backend.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('backend.products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        Product::create($data);

        return redirect()
            ->route('backend.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $this->authorize('manage', $product);

        $categories = Category::all();
        return view('backend.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize('manage', $product);

        $product->update($request->validated());

        return redirect()
            ->route('backend.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $this->authorize('manage', $product);

        $product->delete();

        return redirect()
            ->route('backend.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}