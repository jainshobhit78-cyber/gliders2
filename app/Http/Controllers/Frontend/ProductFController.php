<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

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
    public function index(Request $request)
    {
        $offering = $request->query('offering');
        $definition = $offering ? (self::OFFERINGS[$offering] ?? null) : null;

        abort_if($offering && ! $definition, 404);

        $categoriesQuery = ProductCategory::whereRaw('LOWER(status) = ?', ['active']);

        if ($definition) {
            $categoriesQuery->where(function ($query) use ($definition) {
                foreach ($definition['keywords'] as $keyword) {
                    $like = '%'.strtolower($keyword).'%';

                    $query->orWhereRaw('LOWER(name) LIKE ?', [$like])
                        ->orWhereRaw("LOWER(COALESCE(category_title, '')) LIKE ?", [$like])
                        ->orWhereRaw("LOWER(COALESCE(category_subtitle, '')) LIKE ?", [$like])
                        ->orWhereHas('products', function ($productQuery) use ($like) {
                            $productQuery->where(function ($matchQuery) use ($like) {
                                $matchQuery->whereRaw('LOWER(title) LIKE ?', [$like])
                                    ->orWhereRaw("LOWER(COALESCE(description, '')) LIKE ?", [$like]);
                            });
                        });
                }
            });
        }

        $categories = $categoriesQuery
            ->orderBy('display_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $setting = GeneralSetting::first();

        return view('frontend.products.index', compact('categories', 'setting', 'offering', 'definition'));
    }

    // CATEGORY PRODUCTS PAGE
    public function category($id)
    {
        $category = ProductCategory::findOrFail($id);

        $products = Product::with('images')
            ->where('category_id', $id)
            ->orderBy('display_order', 'asc')
            ->orderBy('id', 'asc')
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
