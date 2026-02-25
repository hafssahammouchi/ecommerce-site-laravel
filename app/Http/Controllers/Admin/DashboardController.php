<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'users' => User::count(),
            'categories' => Category::count(),
            'products' => Product::count(),
            'services' => Service::count(),
            'orders' => Order::count(),
            'revenue' => Order::whereIn('status', ['paid', 'shipped', 'delivered'])->sum('total'),
        ];

        $recentUsers = User::latest()->limit(5)->get();
        $recentProducts = Product::with('category')->latest()->limit(5)->get();
        $recentOrders = Order::with('user')->latest()->limit(10)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentProducts', 'recentOrders'));
    }
}
