<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);
        Review::updateOrCreate(
            ['product_id' => $product->id, 'user_id' => $request->user()->id],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
                'is_approved' => false,
            ]
        );
        return back()->with('success', 'Votre avis a été enregistré et sera publié après modération.');
    }
}
