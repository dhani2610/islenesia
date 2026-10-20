<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display product catalog with filter and search.
     */
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        if ($request->filled('q')) {
            $searchTerm = '%' . trim($request->query('q')) . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('short_description', 'like', $searchTerm);
            });
        }

        $categories = \App\Models\Category::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->pluck('name');

        if ($categories->isEmpty()) {
            $categories = Product::where('is_active', true)
                ->distinct()
                ->pluck('category');
        }

        $products = $query->orderBy('sort_order')->paginate(12)->withQueryString();

        if ($request->ajax() || $request->wantsJson()) {
            $formatted = $products->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'slug' => $p->slug,
                    'category' => $p->category,
                    'short_description' => $p->short_description,
                    'specifications' => $p->specifications,
                    'image_url' => $p->image_url,
                    'show_url' => route('catalog.show', $p->slug),
                ];
            });

            return response()->json([
                'success' => true,
                'products' => $formatted,
                'total' => $products->total(),
            ]);
        }

        return view('pages.catalog.index', compact('products', 'categories'));
    }

    /**
     * Display detailed product specifications and inquiry CTA.
     * Note: Supplier/farmer identity is strictly kept confidential as requested.
     */
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->take(3)
            ->get();

        return view('pages.catalog.show', compact('product', 'relatedProducts'));
    }

    /**
     * Dynamic lightweight JSON endpoint for product gallery images.
     * Prevents heavy initial page payload and loads smoothly via client-side fetch.
     */
    public function gallery(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'count' => count($product->gallery_items),
            'items' => $product->gallery_items,
        ]);
    }
}
