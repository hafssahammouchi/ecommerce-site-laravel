<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        $categories = Category::active()->orderBy('sort_order')->get();
        return view('pages.about', compact('categories'));
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function contactStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'] ?? 'Sans objet',
            'message' => $validated['message'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('contact')->with('success', 'Votre message a bien été envoyé. Nous vous répondrons sous 48 h.');
    }

    public function faq(): View
    {
        return view('pages.faq');
    }

    public function shipping(): View
    {
        return view('pages.shipping');
    }

    public function legal(): View
    {
        return view('pages.legal');
    }

    /** Page liste des catégories (entreprise) */
    public function categories(): View
    {
        $categories = Category::active()->withCount('products')->orderBy('sort_order')->get();
        return view('pages.categories', compact('categories'));
    }
}
