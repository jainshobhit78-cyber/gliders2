<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    public function list()
    {
        $products = Product::with(['category', 'images'])->latest()->get();
        $categories = ProductCategory::where('status', 'active')->get();

        return view('backend.products.product.list', compact('products', 'categories'));
    }

    public function add()
    {
        $categories = ProductCategory::where('status', 'active')->get();
        return view('backend.products.product.add', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'wallpaper' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'filepond' => 'nullable|array',
            'filepond.*' => 'image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'delivery_tag' => 'nullable|string|max:100',
        ]);

        $wallpaperName = null;

        if ($request->hasFile('wallpaper')) {
            $wallpaper = $request->file('wallpaper');
            $wallpaperName = time() . '_wallpaper_' . $wallpaper->getClientOriginalName();
            $wallpaper->move(public_path('uploads/products'), $wallpaperName);
        }

        $product = Product::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'wallpaper' => $wallpaperName,
            'delivery_tag' => $request->delivery_tag
        ]);

        if ($request->hasFile('filepond')) {
            foreach ($request->file('filepond') as $image) {
                $name = time() . '_' . $image->getClientOriginalName();

                $image->move(public_path('uploads/products'), $name);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $name
                ]);
            }
        }

        return redirect('admin/product/list')->with('success', 'Product Added');
    }

    public function edit($id)
    {
        $product = Product::with('images')->find($id);
        $categories = ProductCategory::where('status', 'active')->get();

        return view('backend.products.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'wallpaper' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'filepond' => 'nullable|array',
            'filepond.*' => 'image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'delivery_tag' => 'nullable|string|max:100',
        ]);

        $product = Product::find($id);

        $wallpaperName = $product->wallpaper;

        if ($request->hasFile('wallpaper')) {
            $wallpaper = $request->file('wallpaper');
            $wallpaperName = time() . '_wallpaper_' . $wallpaper->getClientOriginalName();
            $wallpaper->move(public_path('uploads/products'), $wallpaperName);
        }

        $product->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'wallpaper' => $wallpaperName,
            'delivery_tag' => $request->delivery_tag
        ]);

        if ($request->hasFile('filepond')) {
            foreach ($request->file('filepond') as $image) {
                $name = time() . '_' . $image->getClientOriginalName();

                $image->move(public_path('uploads/products'), $name);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $name
                ]);
            }
        }

        if ($request->removed_images) {
            $ids = explode(',', $request->removed_images);

            foreach ($ids as $imgId) {
                ProductImage::find($imgId)?->delete();
            }
        }

        return redirect('admin/product/list')->with('success', 'Product Updated');
    }

    public function delete($id)
    {
        Product::find($id)->delete();

        return back()->with('success', 'Product Deleted');
    }
}
