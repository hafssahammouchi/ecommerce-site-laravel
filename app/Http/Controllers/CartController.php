<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Afficher le panier.
     */
    public function index(Request $request): View
    {
        $cart = $request->session()->get('cart', []);
        $ids = array_map('intval', array_filter(array_keys($cart), 'is_numeric'));
        $products = Product::whereIn('id', $ids)->get()->keyBy('id');
        $total = 0;
        $items = [];
        foreach ($cart as $id => $qty) {
            $id = (int) $id;
            $product = $products->get($id);
            if ($product) {
                $items[] = (object) [
                    'product' => $product,
                    'qty' => $qty,
                    'subtotal' => $product->final_price * $qty,
                ];
                $total += $product->final_price * $qty;
            }
        }

        return view('cart.index', compact('items', 'total'));
    }

    /**
     * Ajouter au panier.
     */
    public function add(Request $request, Product $product): RedirectResponse
    {
        $qty = max(1, (int) $request->get('qty', 1));
        $cart = $request->session()->get('cart', []);
        $id = (int) $product->id;
        $cart[$id] = (int) ($cart[$id] ?? 0) + $qty;
        if ($product->stock > 0 && $cart[$id] > $product->stock) {
            $cart[$id] = $product->stock;
        }
        $request->session()->put('cart', $cart);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'count' => array_sum($cart)]);
        }

        return back()->with('success', 'Produit ajouté au panier.');
    }

    /**
     * Mettre à jour la quantité.
     */
    public function update(Request $request): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        $id = (int) $request->product_id;
        $qty = max(0, (int) $request->qty);
        if ($qty === 0) {
            unset($cart[$id]);
        } else {
            $product = Product::find($id);
            if ($product && $product->stock > 0) {
                $cart[$id] = min($qty, $product->stock);
            }
        }
        $request->session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Panier mis à jour.');
    }

    /**
     * Retirer du panier.
     */
    public function remove(Request $request, Product $product): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$product->id]);
        $request->session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produit retiré du panier.');
    }
}
