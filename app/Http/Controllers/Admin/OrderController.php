<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qry) use ($q) {
                $qry->where('number', 'like', "%{$q}%")
                    ->orWhere('customer_email', 'like', "%{$q}%")
                    ->orWhere('customer_phone', 'like', "%{$q}%");
            });
        }

        $orders = $query->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['items.product', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate(['status' => 'required|in:pending,paid,shipped,delivered,cancelled']);
        $order->update(['status' => $request->status]);
        if ($request->status === 'paid' && !$order->paid_at) {
            $order->update(['paid_at' => now(), 'invoice_number' => Order::generateInvoiceNumber()]);
        }
        if ($request->status === 'shipped') {
            $order->update(['shipped_at' => now()]);
        }
        return back()->with('success', 'Statut mis à jour.');
    }
}
