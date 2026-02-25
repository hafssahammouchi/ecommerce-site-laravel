@extends('layouts.app')

@section('title', $product->name)
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 160))

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav class="text-sm text-gray-500 mb-6"><a href="{{ route('home') }}" class="hover:text-[var(--color-rose)]">Accueil</a> / <a href="{{ route('shop.index') }}" class="hover:text-[var(--color-rose)]">Boutique</a>@if($product->category) / <a href="{{ route('shop.category', $product->category->slug) }}" class="hover:text-[var(--color-rose)]">{{ $product->category->name }}</a>@endif / <span class="text-[var(--color-noir)]">{{ $product->name }}</span></nav>

    <div class="grid lg:grid-cols-2 gap-10 mb-14">
        <div class="rounded-2xl overflow-hidden bg-white shadow-md border border-black/5 bg-[var(--color-creme)] min-h-[280px] flex items-center justify-center">
            @if($product->image_url)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full max-h-[500px] object-cover" data-fallback="1">
            @else
            <span class="text-gray-400 text-sm p-6">{{ $product->name }}</span>
            @endif
        </div>
        <div>
            @if($product->category)<p class="text-xs uppercase tracking-wider text-gray-500 mb-1">{{ $product->category->name }}</p>@endif
            <h1 class="font-display text-2xl md:text-3xl font-bold text-[var(--color-noir)] mb-3">{{ $product->name }}</h1>
            @if($product->approved_reviews_count > 0)
            <div class="flex items-center gap-2 mb-2">
                @for($i = 1; $i <= 5; $i++)<span class="text-[var(--color-or)]">{{ ($product->approved_reviews_avg_rating ?? 0) >= $i ? '★' : '☆' }}</span>@endfor
                <span class="text-sm text-gray-500">({{ $product->approved_reviews_count }} avis)</span>
            </div>
            @endif
            <div class="flex items-center gap-3 mb-4">
                <span class="text-2xl font-bold text-[var(--color-rose-fonce)]">{{ number_format($product->final_price, 2) }} €</span>
                @if($product->sale_price)<span class="text-gray-400 line-through">{{ number_format($product->price, 2) }} €</span><span class="px-2 py-0.5 rounded text-sm font-medium bg-red-100 text-red-700">-{{ round((1 - $product->sale_price / $product->price) * 100) }}%</span>@endif
            </div>
            @if($product->description)<div class="mb-4"><h3 class="font-semibold text-[var(--color-noir)] mb-2">Description</h3><p class="text-gray-600">{{ $product->description }}</p></div>@endif
            @if($product->sku)<p class="text-sm text-gray-500 mb-2">Réf. {{ $product->sku }}</p>@endif
            <p class="text-sm mb-4">@if($product->stock > 0)<span class="text-emerald-600">En stock ({{ $product->stock }})</span>@else<span class="text-red-600">Rupture de stock</span>@endif</p>
            <form action="{{ route('cart.add', $product) }}" method="POST" class="flex flex-wrap items-center gap-3">
                @csrf
                <label class="text-sm text-gray-600">Quantité</label>
                <input type="number" name="qty" value="1" min="1" max="{{ max(1, $product->stock) }}" class="w-20 rounded-xl border border-gray-300 px-3 py-2 text-center focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20">
                <button type="submit" @if($product->stock < 1) disabled @endif class="px-6 py-3 rounded-xl font-semibold text-white bg-[var(--color-rose)] hover:bg-[var(--color-rose-fonce)] transition-all disabled:opacity-50 disabled:cursor-not-allowed">Ajouter au panier</button>
            </form>
        </div>
    </div>

    @if($reviews->isNotEmpty() || auth()->check())
    <section class="pt-10 border-t border-black/5">
        <h2 class="font-display text-xl font-bold text-[var(--color-noir)] mb-4">Avis clients</h2>
        @if($reviews->isNotEmpty())
        <div class="space-y-4 mb-6">
            @foreach($reviews as $review)
            <div class="py-4 border-b border-black/5 last:border-0">
                <div class="flex items-center gap-2 mb-1">
                    @for($i = 1; $i <= 5; $i++)<span class="text-[var(--color-or)]" style="opacity: {{ $review->rating >= $i ? 1 : 0.3 }}">★</span>@endfor
                    <span class="text-sm text-gray-500">{{ $review->user->name ?? $review->author_name ?? 'Anonyme' }} · {{ $review->created_at->format('d/m/Y') }}</span>
                </div>
                @if($review->comment)<p class="text-sm text-gray-600 mt-1">{{ $review->comment }}</p>@endif
            </div>
            @endforeach
        </div>
        @endif
        @auth
        <form action="{{ route('reviews.store', $product) }}" method="POST" class="bg-gray-50 rounded-2xl p-6">
            @csrf
            <label class="block text-sm font-medium text-gray-700 mb-2">Votre note</label>
            <select name="rating" class="rounded-xl border border-gray-300 px-3 py-2 text-sm w-40 mb-4 focus:border-[var(--color-rose)]" required>
                @for($i = 1; $i <= 5; $i++)<option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} étoile(s)</option>@endfor
            </select>
            <label class="block text-sm font-medium text-gray-700 mb-2">Commentaire (optionnel)</label>
            <textarea name="comment" rows="2" maxlength="1000" class="w-full rounded-xl border border-gray-300 px-4 py-2 mb-4 focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20" placeholder="Votre avis...">{{ old('comment') }}</textarea>
            <button type="submit" class="px-4 py-2 rounded-xl text-sm font-semibold text-white bg-[var(--color-rose)] hover:bg-[var(--color-rose-fonce)] transition-all">Publier mon avis</button>
        </form>
        @endauth
    </section>
    @endif

    @if($related->isNotEmpty())
    <section class="pt-14 mt-14 border-t border-black/5">
        <h2 class="font-display text-xl font-bold text-[var(--color-noir)] mb-6">Vous aimerez aussi</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($related as $p)
            <x-product-card :product="$p" />
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection
