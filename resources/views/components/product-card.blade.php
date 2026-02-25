@props(['product', 'showActions' => true])
<div class="bg-white rounded-2xl overflow-hidden shadow-md border border-black/5 h-full flex flex-col card-product-hover">
    <div class="relative aspect-[3/4] overflow-hidden bg-[var(--color-creme)] group">
        <a href="{{ route('shop.product', $product->slug) }}" class="block w-full h-full flex items-center justify-center p-4">
            @if($product->image_url)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out" loading="lazy" data-fallback="1">
            @else
            <span class="text-gray-400 text-sm text-center">{{ $product->name }}</span>
            @endif
        </a>
        @if($product->sale_price)
        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg text-xs font-semibold text-white bg-[var(--color-rose)] shadow-lg transition-transform duration-300 group-hover:scale-105">Promo</span>
        @endif
        @if($showActions)
        <div class="absolute bottom-3 left-3 right-3 flex gap-2 opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-400 ease-out">
            @auth
            <form action="{{ route('wishlist.store', $product) }}" method="POST" class="flex-1"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button type="submit" class="btn-premium-press w-full py-2 rounded-xl bg-white/95 text-gray-700 text-sm font-medium hover:bg-white transition-all duration-200 hover:scale-[1.02]" title="Favoris">♡</button></form>
            @endauth
            <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1"><input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="qty" value="1"><button type="submit" class="btn-premium-press w-full py-2 rounded-xl bg-[var(--color-rose)] text-white text-sm font-semibold hover:bg-[var(--color-rose-fonce)] transition-all duration-200 hover:scale-[1.02]">Ajouter</button></form>
        </div>
        @endif
    </div>
    <div class="p-4 flex-1 flex flex-col">
        <a href="{{ route('shop.product', $product->slug) }}" class="font-medium text-[var(--color-noir)] hover:text-[var(--color-rose-fonce)] transition-colors line-clamp-2">{{ $product->name }}</a>
        <div class="mt-2 flex items-center gap-2">
            <span class="font-bold text-[var(--color-rose-fonce)]">{{ number_format($product->final_price, 2) }} €</span>
            @if($product->sale_price)<span class="text-sm text-gray-400 line-through">{{ number_format($product->price, 2) }} €</span>@endif
        </div>
    </div>
</div>
