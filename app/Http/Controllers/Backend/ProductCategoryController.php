<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{

    public function list()
    {
        $categories = ProductCategory::orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();
        return view('backend.products.categories.list', compact('categories'));
    }

    public function add()
    {
        return view('backend.products.categories.add');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'category_title' => 'nullable|string',
            'category_subtitle' => 'nullable|string',
            'display_order' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
            'wallpaper_image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/category'), $imageName);
        }

        $wallpaperName = null;
        if ($request->hasFile('wallpaper_image')) {
            $wallpaper = $request->file('wallpaper_image');
            $wallpaperName = 'bg_' . time() . '.' . $wallpaper->getClientOriginalExtension();
            $wallpaper->move(public_path('uploads/category'), $wallpaperName);
        }

        ProductCategory::create([
            'name' => $request->name,
            'category_title' => $request->category_title,
            'category_subtitle' => $request->category_subtitle,
            'image' => $imageName,
            'wallpaper_image' => $wallpaperName,
            'status' => $request->status,
            'display_order' => $request->display_order ?? 999
        ]);

        return redirect('admin/category/list')->with('success', 'Category Added');
    }

    public function edit($id)
    {
        $category = ProductCategory::find($id);
        return view('backend.products.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'category_title' => 'nullable|string',
            'category_subtitle' => 'nullable|string',
            'display_order' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
            'wallpaper_image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $category = ProductCategory::find($id);

        $imageName = $category->image;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/category'), $imageName);
        }

        $wallpaperName = $category->wallpaper_image;
        if ($request->hasFile('wallpaper_image')) {
            $wallpaper = $request->file('wallpaper_image');
            $wallpaperName = 'bg_' . time() . '.' . $wallpaper->getClientOriginalExtension();
            $wallpaper->move(public_path('uploads/category'), $wallpaperName);
        }

        $category->update([
            'name' => $request->name,
            'category_title' => $request->category_title,
            'category_subtitle' => $request->category_subtitle,
            'image' => $imageName,
            'wallpaper_image' => $wallpaperName,
            'status' => $request->status,
            'display_order' => $request->display_order ?? $category->display_order
        ]);

        return redirect('admin/category/list')->with('success', 'Category Updated');

    }

    public function delete($id)
    {
        ProductCategory::find($id)->delete();

        return back()->with('success', 'Category Deleted');
    }

}
