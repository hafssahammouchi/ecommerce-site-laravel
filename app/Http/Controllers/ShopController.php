<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    /**
     * Catalogue : tous les produits avec recherche et pagination.
     */
    public function index(Request $request): View
    {
        $query = Product::active()->with('category');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qry) use ($q) {
                $qry->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->boolean('on_sale')) {
            $query->onSale();
        }

        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'popular' => $query->bestSellers(),
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            default => $query->latest(),
        };

        $products = $query->get();
        $categories = Category::active()->orderBy('sort_order')->get();

        return view('shop.index', compact('products', 'categories'));
    }

    /**
     * Produits d'une catégorie.
     */
    public function category(Request $request, string $slug): View
    {
        $category = Category::where('slug', $slug)->active()->firstOrFail();
        $query = $category->products()->active();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qry) use ($q) {
                $qry->where('name', 'like', "%{$q}%")->orWhere('description', 'like', "%{$q}%");
            });
        }
        if ($request->boolean('on_sale')) {
            $query->onSale();
        }
        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'popular' => $query->bestSellers(),
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            default => $query->latest(),
        };

        $products = $query->get();
        $categories = Category::active()->orderBy('sort_order')->get();

        return view('shop.index', [
            'products' => $products,
            'categories' => $categories,
            'currentCategory' => $category,
        ]);
    }

    /**
     * Fiche produit.
     */
    public function product(string $slug): View
    {
        $product = Product::where('slug', $slug)->active()->with('category')->withCount('approvedReviews')->withAvg('approvedReviews', 'rating')->firstOrFail();
        $related = Product::active()->where('category_id', $product->category_id)->where('id', '!=', $product->id)->limit(4)->get();
        $reviews = $product->approvedReviews()->with('user')->latest()->limit(10)->get();

        return view('shop.product', compact('product', 'related', 'reviews'));
    }
}
