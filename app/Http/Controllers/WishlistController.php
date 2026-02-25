<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): View
    {
        $products = $request->user()->wishlist()->with('category')->get();
        return view('wishlist.index', compact('products'));
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        $request->user()->wishlist()->syncWithoutDetaching([$product->id]);
        return back()->with('success', 'Produit ajouté à vos favoris.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $request->user()->wishlist()->detach($product->id);
        return back()->with('success', 'Produit retiré des favoris.');
    }
}
