<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductFController extends Controller
{
    // CATEGORY LIST PAGE
    public function index()
    {
        $categories = ProductCategory::where('status', 'active')
            ->orderBy('display_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return view('frontend.products.index', compact('categories'));
    }

    // CATEGORY PRODUCTS PAGE
    public function category($id)
    {
        $category = ProductCategory::findOrFail($id);

        $products = Product::with('images')
            ->where('category_id', $id)
            ->latest()
            ->get();

        return view('frontend.products.category-products', compact('category', 'products'));
    }

    public function productDetail($categoryId, $productId)
    {
        $category = ProductCategory::findOrFail($categoryId);

        $product = Product::with('images')
            ->where('category_id', $categoryId)
            ->findOrFail($productId);

        $categories = ProductCategory::where('status', 'active')
            ->orderBy('display_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return view(
            'frontend.products.product-detail',
            compact('category', 'product', 'categories')
        );
    }
}
