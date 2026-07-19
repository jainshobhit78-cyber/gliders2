<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductCategory;
use App\Support\UnitFormatter;

class ProductController extends Controller
{
    public function list()
    {
        $products = Product::with(['category', 'images'])
            ->orderBy('display_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();
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
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
            'wallpaper' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
            'specs_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
            'caps_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
            'filepond' => 'nullable|array',
            'filepond.*' => 'image|mimes:jpg,jpeg,png,webp,svg',
            'delivery_tag' => 'nullable|string|max:100',
            'display_order' => 'nullable|integer',
        ]);

        $profilePicName = null;
        if ($request->hasFile('profile_pic')) {
            $profilePic = $request->file('profile_pic');
            $profilePicName = $profilePic->hashName();
            $profilePic->move(public_path('uploads/products'), $profilePicName);
        }

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
                        'parameter' => UnitFormatter::normalize($spec['parameter']),
                        'value' => UnitFormatter::normalize($spec['value'] ?? ''),
                        'description' => UnitFormatter::normalize($spec['description'] ?? ''),
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
                        'heading' => UnitFormatter::normalize($cap['heading']),
                        'description' => UnitFormatter::normalize($cap['description'] ?? '')
                    ];
                }
            }
        }

        $product = Product::create([
            'title' => UnitFormatter::normalize($request->title),
            'category_id' => $request->category_id,
            'display_order' => $request->display_order ?? 999,
            'description' => UnitFormatter::normalize($request->description),
            'wallpaper' => $wallpaperName,
            'profile_pic' => $profilePicName,
            'delivery_tag' => $request->delivery_tag,
            'specs_subtext' => UnitFormatter::normalize($request->specs_subtext),
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
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
            'wallpaper' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
            'specs_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
            'caps_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
            'filepond' => 'nullable|array',
            'filepond.*' => 'image|mimes:jpg,jpeg,png,webp,svg',
            'delivery_tag' => 'nullable|string|max:100',
        ]);

        $product = Product::find($id);

        $profilePicName = $product->profile_pic;
        if ($request->hasFile('profile_pic')) {
            $profilePic = $request->file('profile_pic');
            $profilePicName = $profilePic->hashName();
            $profilePic->move(public_path('uploads/products'), $profilePicName);
        }

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
                        'parameter' => UnitFormatter::normalize($spec['parameter']),
                        'value' => UnitFormatter::normalize($spec['value'] ?? ''),
                        'description' => UnitFormatter::normalize($spec['description'] ?? ''),
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
                        'heading' => UnitFormatter::normalize($cap['heading']),
                        'description' => UnitFormatter::normalize($cap['description'] ?? '')
                    ];
                }
            }
        }

        $product->update([
            'title' => UnitFormatter::normalize($request->title),
            'category_id' => $request->category_id,
            'display_order' => $request->display_order ?? 999,
            'description' => UnitFormatter::normalize($request->description),
            'wallpaper' => $wallpaperName,
            'profile_pic' => $profilePicName,
            'delivery_tag' => $request->delivery_tag,
            'specs_subtext' => UnitFormatter::normalize($request->specs_subtext),
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
