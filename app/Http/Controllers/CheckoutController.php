<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $ids = array_map('intval', array_keys($cart));
        $products = Product::whereIn('id', $ids)->get()->keyBy('id');
        $items = [];
        $subtotal = 0;
        $stockWarnings = [];
        foreach ($cart as $id => $qty) {
            $id = (int) $id;
            $qty = (int) $qty;
            $product = $products->get($id);
            if (!$product) {
                continue;
            }
            $available = max(0, $product->stock);
            $qtyToUse = min($qty, $available);
            if ($qtyToUse <= 0) {
                $stockWarnings[] = $product->name . ' : plus en stock.';
                continue;
            }
            if ($qtyToUse < $qty) {
                $stockWarnings[] = $product->name . ' : stock limité à ' . $available . '. Réduisez la quantité au panier si besoin.';
            }
            $items[] = (object) [
                'product' => $product,
                'qty' => $qtyToUse,
                'subtotal' => $product->final_price * $qtyToUse,
            ];
            $subtotal += $product->final_price * $qtyToUse;
        }
        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'Panier invalide ou stock insuffisant. Vérifiez les quantités disponibles.');
        }

        /* Mettre à jour le panier en session avec les quantités plafonnées au stock, pour que la commande utilise les bonnes valeurs */
        $newCart = [];
        foreach ($items as $item) {
            $newCart[$item->product->id] = $item->qty;
        }
        $request->session()->put('cart', $newCart);

        $deliveryOptions = config('shop.shipping', []);
        $freeThreshold = config('shop.free_shipping_threshold', 50);

        return view('checkout.show', [
            'items' => $items,
            'subtotal' => $subtotal,
            'deliveryOptions' => $deliveryOptions,
            'freeThreshold' => $freeThreshold,
            'stockWarnings' => $stockWarnings,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $validated = $request->validate([
            'customer_email' => ['required', 'email'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'shipping_name' => ['required', 'string', 'max:255'],
            'shipping_address' => ['required', 'string'],
            'shipping_city' => ['required', 'string', 'max:100'],
            'shipping_postal_code' => ['required', 'string', 'max:20'],
            'shipping_country' => ['nullable', 'string', 'max:100'],
            'delivery_option' => ['required', 'string', 'in:standard,express,relay'],
            'payment_method' => ['required', 'string', 'in:card,on_delivery'],
            'notes' => ['nullable', 'string', 'max:500'],
            'coupon_code' => ['nullable', 'string', 'max:50'],
            'shipping_lat' => ['nullable', 'numeric'],
            'shipping_lng' => ['nullable', 'numeric'],
        ]);

        $ids = array_map('intval', array_keys($cart));
        $products = Product::whereIn('id', $ids)->get()->keyBy('id');
        $subtotal = 0;
        $orderItems = [];
        foreach ($cart as $id => $qty) {
            $id = (int) $id;
            $qty = (int) $qty;
            $product = $products->get($id);
            if (!$product) {
                return redirect()->route('cart.index')->with('error', 'Un produit de votre panier n\'est plus disponible. Veuillez mettre à jour votre panier.');
            }
            $available = (int) $product->stock;
            if ($available < $qty) {
                return redirect()->route('checkout.show')->with('error', 'Stock insuffisant pour « ' . e($product->name) . ' » (disponible : ' . $available . '). Réduisez la quantité au panier puis réessayez.');
            }
            $price = $product->final_price;
            $total = $price * $qty;
            $subtotal += $total;
            $orderItems[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'qty' => $qty,
                'price' => $price,
                'total' => $total,
            ];
        }

        $freeThreshold = config('shop.free_shipping_threshold', 50);
        $deliveryOptions = config('shop.shipping', []);
        $deliveryPrice = $subtotal >= $freeThreshold
            ? 0
            : (float) ($deliveryOptions[$validated['delivery_option']]['price'] ?? 0);

        $discountAmount = 0;
        $couponCode = null;
        if (!empty($validated['coupon_code'])) {
            $coupon = Coupon::where('code', strtoupper(trim($validated['coupon_code'])))->first();
            if ($coupon && $coupon->isValid($subtotal)) {
                $discountAmount = $coupon->discountAmount($subtotal);
                $couponCode = $coupon->code;
                $coupon->increment('used_count');
            }
        }

        $total = max(0, $subtotal - $discountAmount + $deliveryPrice);

        $order = Order::create([
            'number' => Order::generateNumber(),
            'invoice_number' => null,
            'user_id' => auth()->id(),
            'status' => Order::STATUS_PENDING,
            'subtotal' => $subtotal,
            'delivery_price' => $deliveryPrice,
            'total' => $total,
            'coupon_code' => $couponCode,
            'discount_amount' => $discountAmount,
            'delivery_option' => $validated['delivery_option'],
            'payment_method' => $validated['payment_method'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'shipping_name' => $validated['shipping_name'],
            'shipping_address' => $validated['shipping_address'],
            'shipping_city' => $validated['shipping_city'],
            'shipping_postal_code' => $validated['shipping_postal_code'],
            'shipping_country' => $validated['shipping_country'] ?? 'France',
            'shipping_lat' => $validated['shipping_lat'] ?? null,
            'shipping_lng' => $validated['shipping_lng'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($orderItems as $item) {
            $order->items()->create($item);
            Product::where('id', $item['product_id'])->decrement('stock', $item['qty']);
            Product::where('id', $item['product_id'])->increment('sales_count', $item['qty']);
        }

        $request->session()->forget('cart');

        if (($validated['payment_method'] ?? 'card') === Order::PAYMENT_ON_DELIVERY) {
            return redirect()->route('checkout.confirmation', $order)->with('success', 'Commande enregistrée. Vous paierez à la livraison.');
        }

        return redirect()->route('checkout.payment', $order)->with('success', 'Commande enregistrée. Passez au paiement.');
    }

    public function payment(Order $order): View|RedirectResponse
    {
        if ($order->status !== Order::STATUS_PENDING) {
            return redirect()->route('checkout.confirmation', $order);
        }
        if (($order->payment_method ?? 'card') === Order::PAYMENT_ON_DELIVERY) {
            return redirect()->route('checkout.confirmation', $order);
        }
        $order->load('items.product');
        return view('checkout.payment', compact('order'));
    }

    public function pay(Request $request, Order $order): RedirectResponse
    {
        if ($order->status !== Order::STATUS_PENDING) {
            return redirect()->route('checkout.confirmation', $order);
        }
        $order->update([
            'status' => Order::STATUS_PAID,
            'paid_at' => now(),
            'invoice_number' => Order::generateInvoiceNumber(),
        ]);
        return redirect()->route('checkout.confirmation', $order)->with('success', 'Paiement effectué. Merci pour votre commande !');
    }

    public function confirmation(Order $order): View
    {
        $order->load('items');
        return view('checkout.confirmation', compact('order'));
    }
}
