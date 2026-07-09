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
            'wallpaper' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
            'specs_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
            'caps_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
            'filepond' => 'nullable|array',
            'filepond.*' => 'image|mimes:jpg,jpeg,png,webp,svg',
            'delivery_tag' => 'nullable|string|max:100',
        ]);

        $wallpaperName = null;
        if ($request->hasFile('wallpaper')) {
            $wallpaper = $request->file('wallpaper');
            $wallpaperName = $wallpaper->hashName();
            $wallpaper->move(public_path('uploads/products'), $wallpaperName);
        }

        $specsImageName = null;
        if ($request->hasFile('specs_image')) {
            $specsImage = $request->file('specs_image');
            $specsImageName = $specsImage->hashName();
            $specsImage->move(public_path('uploads/products'), $specsImageName);
        }

        $capsImageName = null;
        if ($request->hasFile('caps_image')) {
            $capsImage = $request->file('caps_image');
            $capsImageName = $capsImage->hashName();
            $capsImage->move(public_path('uploads/products'), $capsImageName);
        }

        $technicalSpecs = [];
        if ($request->technical_specs && is_array($request->technical_specs)) {
            foreach ($request->technical_specs as $spec) {
                if (!empty($spec['parameter'])) {
                    $technicalSpecs[] = [
                        'parameter' => $spec['parameter'],
                        'value' => $spec['value'] ?? '',
                        'description' => $spec['description'] ?? '',
                        'icon' => $spec['icon'] ?? ''
                    ];
                }
            }
        }

        $mainCapabilities = [];
        if ($request->main_capabilities && is_array($request->main_capabilities)) {
            foreach ($request->main_capabilities as $cap) {
                if (!empty($cap['heading'])) {
                    $mainCapabilities[] = [
                        'heading' => $cap['heading'],
                        'description' => $cap['description'] ?? ''
                    ];
                }
            }
        }

        $product = Product::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'wallpaper' => $wallpaperName,
            'delivery_tag' => $request->delivery_tag,
            'specs_subtext' => $request->specs_subtext,
            'specs_image' => $specsImageName,
            'technical_specs' => $technicalSpecs,
            'caps_image' => $capsImageName,
            'main_capabilities' => $mainCapabilities
        ]);

        if ($request->hasFile('filepond')) {
            foreach ($request->file('filepond') as $image) {
                $name = $image->hashName();
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
            'wallpaper' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
            'specs_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
            'caps_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
            'filepond' => 'nullable|array',
            'filepond.*' => 'image|mimes:jpg,jpeg,png,webp,svg',
            'delivery_tag' => 'nullable|string|max:100',
        ]);

        $product = Product::find($id);

        $wallpaperName = $product->wallpaper;
        if ($request->hasFile('wallpaper')) {
            $wallpaper = $request->file('wallpaper');
            $wallpaperName = $wallpaper->hashName();
            $wallpaper->move(public_path('uploads/products'), $wallpaperName);
        }

        $specsImageName = $product->specs_image;
        if ($request->hasFile('specs_image')) {
            $specsImage = $request->file('specs_image');
            $specsImageName = $specsImage->hashName();
            $specsImage->move(public_path('uploads/products'), $specsImageName);
        }

        $capsImageName = $product->caps_image;
        if ($request->hasFile('caps_image')) {
            $capsImage = $request->file('caps_image');
            $capsImageName = $capsImage->hashName();
            $capsImage->move(public_path('uploads/products'), $capsImageName);
        }

        $technicalSpecs = [];
        if ($request->technical_specs && is_array($request->technical_specs)) {
            foreach ($request->technical_specs as $spec) {
                if (!empty($spec['parameter'])) {
                    $technicalSpecs[] = [
                        'parameter' => $spec['parameter'],
                        'value' => $spec['value'] ?? '',
                        'description' => $spec['description'] ?? '',
                        'icon' => $spec['icon'] ?? ''
                    ];
                }
            }
        }

        $mainCapabilities = [];
        if ($request->main_capabilities && is_array($request->main_capabilities)) {
            foreach ($request->main_capabilities as $cap) {
                if (!empty($cap['heading'])) {
                    $mainCapabilities[] = [
                        'heading' => $cap['heading'],
                        'description' => $cap['description'] ?? ''
                    ];
                }
            }
        }

        $product->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'wallpaper' => $wallpaperName,
            'delivery_tag' => $request->delivery_tag,
            'specs_subtext' => $request->specs_subtext,
            'specs_image' => $specsImageName,
            'technical_specs' => $technicalSpecs,
            'caps_image' => $capsImageName,
            'main_capabilities' => $mainCapabilities
        ]);

        if ($request->hasFile('filepond')) {
            foreach ($request->file('filepond') as $image) {
                $name = $image->hashName();
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

