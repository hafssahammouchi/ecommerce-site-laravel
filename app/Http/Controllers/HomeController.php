<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $slider = config('shop.slider', []);
        $heroBackground = config('shop.hero_background', 'images/products/soin-4.png');
        $categories = Category::active()->orderBy('sort_order')->limit(6)->get();
        $newArrivals = Product::active()->latest()->limit(8)->get();
        $bestSellers = Product::active()->bestSellers()->limit(8)->get();
        $onSale = Product::active()->onSale()->limit(8)->get();
        $services = Service::active()->limit(6)->get();

        return view('home', compact('slider', 'heroBackground', 'categories', 'newArrivals', 'bestSellers', 'onSale', 'services'));
    }
}
