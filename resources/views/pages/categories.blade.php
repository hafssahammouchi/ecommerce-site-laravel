@extends('layouts.app')

@section('title', 'Nos catégories')
@section('meta_description', 'Explorez les univers maquillage et beauté Glow Beauty : lèvres, teint, yeux, ongles, soins, accessoires.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
    <div class="text-center mb-14">
        <h1 class="font-display text-3xl md:text-4xl font-bold text-[var(--color-noir)] mb-3">Nos catégories</h1>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">Explorez nos univers maquillage et beauté. Chaque catégorie regroupe des produits soigneusement sélectionnés pour votre routine.</p>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($categories as $category)
        <a href="{{ route('shop.category', $category->slug) }}" class="group block bg-white rounded-2xl overflow-hidden shadow-md border border-black/5 card-product-hover">
            <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                @if($category->image_url)
                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" data-fallback="1">
                @else
                <div class="w-full h-full flex items-center justify-center text-gray-300 text-5xl">◇</div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="absolute bottom-0 left-0 right-0 p-5 text-white">
                    <span class="font-display text-xl font-semibold block">{{ $category->name }}</span>
                    @if($category->products_count > 0)<span class="text-sm text-white/90">{{ $category->products_count }} produit(s)</span>@endif
                </div>
            </div>
            @if($category->description)
            <div class="p-5 border-t border-black/5">
                <p class="text-sm text-gray-600 line-clamp-2">{{ $category->description }}</p>
            </div>
            @endif
        </a>
        @endforeach
    </div>
</div>
@endsection
