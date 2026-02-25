@extends('layouts.app')

@section('title', isset($currentCategory) ? $currentCategory->name : 'Boutique')

@section('content')
@if(isset($currentCategory))
<div class="bg-gradient-to-br from-white to-[var(--color-creme)] border-b border-black/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="reveal flex flex-col md:flex-row md:items-center gap-6" data-delay="0">
            @if($currentCategory->image_url)
            <div class="md:w-1/3 shrink-0 reveal reveal-left" data-delay="1">
                <img src="{{ $currentCategory->image_url }}" alt="{{ $currentCategory->name }}" class="rounded-2xl shadow-md w-full max-h-56 object-cover transition-transform duration-500 hover:scale-[1.02]" data-fallback="1">
            </div>
            @endif
            <div class="md:flex-1">
                <nav class="text-sm text-gray-500 mb-2"><a href="{{ route('home') }}" class="hover:text-[var(--color-rose)] transition-colors">Accueil</a> / <a href="{{ route('shop.index') }}" class="hover:text-[var(--color-rose)] transition-colors">Boutique</a> / <span class="text-[var(--color-noir)]">{{ $currentCategory->name }}</span></nav>
                <h1 class="font-display text-2xl md:text-3xl font-bold text-[var(--color-noir)]">{{ $currentCategory->name }}</h1>
                @if($currentCategory->description)<p class="text-gray-600 mt-2">{{ $currentCategory->description }}</p>@endif
            </div>
        </div>
    </div>
</div>
@endif

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <aside class="lg:w-72 shrink-0">
            <div class="sticky top-24 space-y-6">
                <h3 class="font-display text-lg font-bold text-[var(--color-noir)]">Catégories</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('shop.index') }}" class="block py-1.5 {{ !isset($currentCategory) ? 'font-semibold text-[var(--color-noir)]' : 'text-gray-600 hover:text-[var(--color-rose)]' }}">Tous les produits</a></li>
                    @foreach($categories as $cat)
                    <li><a href="{{ route('shop.category', $cat->slug) }}" class="block py-1.5 {{ (isset($currentCategory) && $currentCategory->id === $cat->id) ? 'font-semibold text-[var(--color-noir)]' : 'text-gray-600 hover:text-[var(--color-rose)]' }}">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
                <a href="{{ route('categories.index') }}" class="inline-block w-full text-center py-2.5 rounded-xl border-2 border-[var(--color-rose)] text-[var(--color-rose)] font-medium hover:bg-[var(--color-rose)]/5 transition-all text-sm">Voir toutes les catégories</a>
                <form method="GET" action="{{ isset($currentCategory) ? route('shop.category', $currentCategory->slug) : route('shop.index') }}">
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @if(request('on_sale'))<input type="hidden" name="on_sale" value="1">@endif
                    <label class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
                    <div class="flex gap-2">
                        <input type="text" name="q" placeholder="Nom du produit..." value="{{ request('q') }}" class="flex-1 rounded-xl border border-gray-300 px-3 py-2 text-sm focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20">
                        <button type="submit" class="rounded-xl px-4 py-2 bg-[var(--color-rose)] text-white hover:bg-[var(--color-rose-fonce)] transition-all">⌕</button>
                    </div>
                </form>
                @php $baseRoute = isset($currentCategory) ? route('shop.category', $currentCategory->slug) : route('shop.index'); $queryNoSale = array_filter(request()->only(['q', 'sort'])); $queryWithSale = array_filter(array_merge($queryNoSale, ['on_sale' => 1])); @endphp
                <div><span class="text-sm font-medium text-gray-700">Filtres</span> @if(request('on_sale'))<a href="{{ $baseRoute . ($queryNoSale ? '?' . http_build_query($queryNoSale) : '') }}" class="block text-sm text-emerald-600 mt-1">✓ En promotion — tout afficher</a>@else<a href="{{ $baseRoute . '?' . http_build_query($queryWithSale) }}" class="block text-sm text-[var(--color-rose)] mt-1 hover:underline">Voir les promos</a>@endif</div>
            </div>
        </aside>
        <div class="flex-1 min-w-0">
            @if(!isset($currentCategory))<h1 class="font-display text-2xl font-bold text-[var(--color-noir)] mb-2">Tous nos produits</h1><p class="text-gray-500 mb-6">Découvrez notre sélection maquillage et soins.</p>@endif
            <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
                <span class="text-sm text-gray-500">{{ $products->count() }} produit(s)</span>
                <form method="GET" action="{{ isset($currentCategory) ? route('shop.category', $currentCategory->slug) : route('shop.index') }}" class="flex items-center gap-2">
                    <input type="hidden" name="q" value="{{ request('q') }}">@if(request('on_sale'))<input type="hidden" name="on_sale" value="1">@endif
                    <label class="text-sm text-gray-600">Trier</label>
                    <select name="sort" onchange="this.form.submit()" class="rounded-xl border border-gray-300 px-3 py-2 text-sm focus:border-[var(--color-rose)]">
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Nouveautés</option>
                        <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Popularité</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                    </select>
                </form>
            </div>
            @if($products->isEmpty())
            <p class="text-gray-500 mt-8">Aucun produit ne correspond à votre recherche.</p>
            @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $i => $product)<div class="reveal" data-delay="{{ min($i % 8, 8) }}"><x-product-card :product="$product" /></div>@endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
