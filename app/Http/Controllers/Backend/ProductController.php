<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $products = $user->hasRole('admin') ? Product::latest()->paginate(10) 
                                            : Product::where('user_id', $user->id)->latest()->paginate(10);
        return view('backend.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('backend.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'category_id'=>'required|exists:categories,id',
            'price'=>'required|numeric|min:0',
            'stock'=>'required|integer|min:0',
            'status'=>'required|in:draft,published',
        ]);

        $product = new Product($request->only('name','category_id','description','price','stock','status'));
        $product->user_id = auth()->id();
        $product->save();

        return redirect()->route('backend.products.index')->with('success','Product created');
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        $categories = Category::all();
        return view('backend.products.edit', compact('product','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $request->validate([
            'name'=>'required',
            'category_id'=>'required|exists:categories,id',
            'price'=>'required|numeric|min:0',
            'stock'=>'required|integer|min:0',
            'status'=>'required|in:draft,published',
        ]);

        $product->update($request->only('name','category_id','description','price','stock','status'));

        return redirect()->route('backend.products.index')->with('success','Product updated');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();
        return redirect()->route('backend.products.index')->with('success','Product deleted');
    }
}
