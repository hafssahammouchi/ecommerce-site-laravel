@extends('layouts.app')

@section('title', 'Panier')
@section('meta_description', 'Votre panier Glow Beauty.')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="font-display text-2xl md:text-3xl font-bold text-[var(--color-noir)] mb-8">Votre panier</h1>

    @if(empty($items))
    <div class="text-center py-16">
        <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4 text-gray-400 text-4xl">🛒</div>
        <p class="text-gray-500 mb-6">Votre panier est vide.</p>
        <a href="{{ route('shop.index') }}" class="inline-block px-8 py-3.5 rounded-xl font-semibold text-white bg-[var(--color-rose)] hover:bg-[var(--color-rose-fonce)] transition-all">Découvrir la boutique</a>
    </div>
    @else
    <div class="flex flex-col lg:flex-row gap-8">
        <div class="flex-1 bg-white rounded-2xl shadow-sm border border-black/5 overflow-hidden">
            @foreach($items as $item)
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-6 border-b border-black/5 last:border-0">
                <a href="{{ route('shop.product', $item->product->slug) }}" class="shrink-0 w-20 h-20 rounded-xl overflow-hidden bg-[var(--color-creme)] flex items-center justify-center">
                    @if($item->product->image_url)<img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover" data-fallback="1">@else<span class="text-gray-400 text-xs">—</span>@endif
                </a>
                <div class="flex-1 min-w-0">
                    <a href="{{ route('shop.product', $item->product->slug) }}" class="font-medium text-[var(--color-noir)] hover:text-[var(--color-rose-fonce)]">{{ $item->product->name }}</a>
                    <p class="text-sm text-gray-500">{{ number_format($item->product->final_price, 2) }} € / unité</p>
                </div>
                <div class="flex items-center gap-4 w-full sm:w-auto">
                    <form action="{{ route('cart.update') }}" method="POST" class="flex items-center gap-2">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="product_id" value="{{ $item->product->id }}">
                        <input type="number" name="qty" value="{{ $item->qty }}" min="1" max="{{ $item->product->stock }}" class="w-16 rounded-lg border border-gray-300 px-2 py-1.5 text-center text-sm" onchange="this.form.submit()">
                    </form>
                    <span class="font-semibold w-20 text-right">{{ number_format($item->subtotal, 2) }} €</span>
                    <form action="{{ route('cart.remove', $item->product) }}" method="POST" class="inline"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button type="submit" class="p-2 rounded-lg text-red-500 hover:bg-red-50 transition-colors" title="Retirer">🗑</button></form>
                </div>
            </div>
            @endforeach
        </div>
        <div class="lg:w-80 shrink-0">
            <div class="bg-white rounded-2xl shadow-sm border border-black/5 p-6 sticky top-24">
                <h3 class="font-semibold text-[var(--color-noir)] mb-4">Récapitulatif</h3>
                <div class="flex justify-between text-gray-600 mb-2"><span>Sous-total</span><span class="font-semibold text-[var(--color-noir)]">{{ number_format($total, 2) }} €</span></div>
                <p class="text-sm text-emerald-600 mb-4">Livraison offerte dès {{ number_format(config('shop.free_shipping_threshold', 50), 0) }} €</p>
                <hr class="border-black/5 my-4">
                <div class="flex justify-between text-lg font-bold mb-6"><span>Total</span><span>{{ number_format($total, 2) }} €</span></div>
                <a href="{{ route('checkout.show') }}" class="block w-full text-center py-3.5 rounded-xl font-semibold text-white bg-[var(--color-rose)] hover:bg-[var(--color-rose-fonce)] transition-all">Passer la commande</a>
                <a href="{{ route('shop.index') }}" class="block text-center mt-3 text-sm text-gray-500 hover:text-[var(--color-rose)] transition-colors">Continuer mes achats</a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
