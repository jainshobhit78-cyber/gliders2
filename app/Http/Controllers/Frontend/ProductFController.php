<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\GeneralSetting;

class ProductFController extends Controller
{
    private const OFFERINGS = [
        'parachutes' => [
            'title' => 'Parachutes',
            'description' => 'Explore our personnel, cargo, brake, recovery and aerial-delivery parachute systems.',
            'keywords' => ['parachute', 'aerial delivery'],
        ],
        'rubber-inflatables' => [
            'title' => 'Rubber Inflatables',
            'description' => 'Explore KM floats, inflatable boats and our growing range of rubber-based systems.',
            'keywords' => ['rubber', 'inflatable', 'float', 'boat', 'km bridge'],
        ],
        'technical-clothing' => [
            'title' => 'Technical Clothing',
            'description' => 'Mission-ready technical clothing and protective apparel engineered for demanding environments.',
            'keywords' => ['technical clothing', 'clothing', 'garment', 'apparel', 'protective wear', 'uniform'],
        ],
    ];

    // CATEGORY LIST PAGE
    public function index()
    {
        $categories = ProductCategory::where('status', 'active')
            ->orderBy('display_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $setting = GeneralSetting::first();

        return view('frontend.products.index', compact('categories', 'setting'));
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

    public function offering(string $offering)
    {
        abort_unless(array_key_exists($offering, self::OFFERINGS), 404);

        $definition = self::OFFERINGS[$offering];
        $products = Product::with(['images', 'category'])
            ->whereHas('category', function ($query) {
                $query->whereRaw('LOWER(status) = ?', ['active']);
            })
            ->where(function ($query) use ($definition) {
                foreach ($definition['keywords'] as $keyword) {
                    $like = '%'.strtolower($keyword).'%';

                    $query->orWhereRaw('LOWER(title) LIKE ?', [$like])
                        ->orWhereRaw("LOWER(COALESCE(description, '')) LIKE ?", [$like])
                        ->orWhereHas('category', function ($categoryQuery) use ($like) {
                            $categoryQuery->whereRaw('LOWER(name) LIKE ?', [$like])
                                ->orWhereRaw("LOWER(COALESCE(category_title, '')) LIKE ?", [$like])
                                ->orWhereRaw("LOWER(COALESCE(category_subtitle, '')) LIKE ?", [$like]);
                        });
                }
            })
            ->latest()
            ->get();

        $categories = $products->pluck('category')->filter()->unique('id')->values();

        return view('frontend.products.offering-products', compact(
            'offering',
            'definition',
            'products',
            'categories'
        ));
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
