@extends('layouts.app')

@section('title', 'Mes favoris')
@section('meta_description', 'Votre liste de favoris.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="font-display text-2xl font-bold text-[var(--color-noir)] mb-8">Mes favoris</h1>

    @if($products->isEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-black/5 p-12 text-center">
        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4 text-gray-400 text-3xl">♥</div>
        <p class="text-gray-500 mb-6">Votre liste de favoris est vide.</p>
        <a href="{{ route('shop.index') }}" class="inline-block px-6 py-3 rounded-xl font-semibold text-white bg-[var(--color-rose)] hover:bg-[var(--color-rose-fonce)] transition-all">Découvrir la boutique</a>
    </div>
    @else
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="relative bg-white rounded-2xl overflow-hidden shadow-md border border-black/5 card-product-hover">
            <form action="{{ route('wishlist.destroy', $product) }}" method="POST" class="absolute top-2 right-2 z-10"><input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="w-10 h-10 rounded-full bg-white/90 flex items-center justify-center text-red-500 hover:bg-white shadow" title="Retirer">♥</button></form>
            <a href="{{ route('shop.product', $product->slug) }}" class="block aspect-[3/4] overflow-hidden bg-[var(--color-creme)] flex items-center justify-center p-4">@if($product->image_url)<img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" data-fallback="1">@else<span class="text-gray-400 text-sm text-center">{{ $product->name }}</span>@endif</a>
            <div class="p-4">
                <a href="{{ route('shop.product', $product->slug) }}" class="font-medium text-[var(--color-noir)] hover:text-[var(--color-rose-fonce)] line-clamp-2">{{ $product->name }}</a>
                <div class="mt-2 flex items-center gap-2"><span class="font-bold text-[var(--color-rose-fonce)]">{{ number_format($product->final_price, 2) }} €</span>@if($product->sale_price)<span class="text-sm text-gray-400 line-through">{{ number_format($product->price, 2) }} €</span>@endif</div>
                <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-3"><input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="qty" value="1"><button type="submit" class="w-full py-2 rounded-xl text-sm font-semibold text-white bg-[var(--color-rose)] hover:bg-[var(--color-rose-fonce)] transition-all">Ajouter au panier</button></form>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
