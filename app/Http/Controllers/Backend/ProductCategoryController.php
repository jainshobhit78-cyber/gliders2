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
            'display_order' => 'nullable|integer|min:1'
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/category'), $imageName);
        }

        ProductCategory::create([
            'name' => $request->name,
            'image' => $imageName,
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
            'display_order' => 'nullable|integer|min:1'
        ]);

        $category = ProductCategory::find($id);

        $imageName = $category->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/category'), $imageName);
        }

        $category->update([
            'name' => $request->name,
            'image' => $imageName,
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
