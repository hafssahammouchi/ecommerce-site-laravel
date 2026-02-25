@extends('layouts.app')

@section('title', 'Accueil')
@section('meta_description', config('app.name') . ' — Maquillage et cosmétiques premium. Découvrez nos nouveautés, best-sellers et offres.')

@section('content')
@if(!empty($slider))
{{-- Hero Slider --}}
<div class="relative h-[75vh] min-h-[400px] overflow-hidden">
    @foreach($slider as $i => $slide)
    <div class="hero-slide absolute inset-0 bg-cover bg-center transition-opacity duration-700 {{ $i === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}" data-slide="{{ $i }}" style="background-image: url('{{ $slide['image'] ?? '' }}');">
        <div class="hero-overlay absolute inset-0"></div>
        <div class="relative z-10 h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="max-w-xl">
                    <h2 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold text-white drop-shadow-lg animate-fade-in-up">{{ $slide['title'] ?? '' }}</h2>
                    <p class="text-white/95 text-lg mt-3 drop-shadow animate-fade-in-up" style="animation-delay: 0.1s">{{ $slide['subtitle'] ?? '' }}</p>
                    <a href="{{ $slide['url'] ?? route('shop.index') }}" class="btn-premium-press inline-block mt-6 px-8 py-3.5 rounded-xl font-semibold text-white bg-[var(--color-rose)] hover:bg-[var(--color-rose-fonce)] transition-all duration-300 animate-fade-in-up hover:scale-[1.02] active:scale-[0.98]" style="animation-delay: 0.2s">{{ $slide['cta'] ?? 'Découvrir' }}</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex gap-2">
        @foreach($slider as $i => $s)
        <button type="button" class="hero-dot w-2.5 h-2.5 rounded-full transition-all duration-300 {{ $i === 0 ? 'bg-white scale-125' : 'bg-white/50 hover:bg-white/80' }}" data-slide="{{ $i }}" aria-label="Slide {{ $i + 1 }}"></button>
        @endforeach
    </div>
    <button type="button" class="hero-prev absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/90 text-[var(--color-noir)] flex items-center justify-center hover:bg-white transition-all shadow-lg" aria-label="Précédent">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button type="button" class="hero-next absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/90 text-[var(--color-noir)] flex items-center justify-center hover:bg-white transition-all shadow-lg" aria-label="Suivant">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </button>
</div>
@else
{{-- Hero premium : arrière-plan configurable + zoom Ken Burns + animations renforcées --}}
<section class="hero-home relative min-h-[85vh] flex items-center justify-center overflow-hidden text-center">
    <div class="hero-zoom-bg absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset($heroBackground ?? 'images/products/soin-4.png') }}');"></div>
    <div class="hero-premium-bg absolute inset-0" aria-hidden="true"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-black/55 via-black/45 to-black/65"></div>
    <div class="relative z-10 px-4 py-24 max-w-4xl mx-auto">
        <h1 class="hero-title-in font-display text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold text-white drop-shadow-2xl tracking-tight">Sublimez votre beauté</h1>
        <p class="hero-subtitle-in text-white/95 text-lg md:text-xl mt-5 mb-10 drop-shadow-md" style="animation-delay: 0.15s">Maquillage et soins soigneusement sélectionnés.</p>
        <a href="{{ route('shop.index') }}" class="hero-cta-in btn-premium-press inline-block px-10 py-4 rounded-2xl font-semibold text-white bg-[var(--color-rose)] hover:bg-[var(--color-rose-fonce)] transition-all duration-300 hover:scale-[1.04] shadow-2xl border border-white/10" style="animation-delay: 0.35s">Découvrir la boutique</a>
    </div>
</section>
@endif

@if($categories->isNotEmpty())
<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12 reveal reveal-strong" data-delay="0">
        <h2 class="font-display text-3xl md:text-4xl font-bold text-[var(--color-noir)]">Explorer par catégorie</h2>
        <p class="text-gray-500 mt-2 text-lg">Parcourez nos univers maquillage et soins</p>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-5">
        @foreach($categories as $i => $category)
        <a href="{{ route('shop.category', $category->slug) }}" class="reveal reveal-strong reveal-strong-scale group block rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 card-product-hover" data-delay="{{ min($i, 8) }}">
            <div class="relative aspect-[4/3] overflow-hidden bg-[var(--color-creme)]">
                @if($category->image_url)
                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out" loading="lazy" data-fallback="1">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                <span class="absolute bottom-3 left-3 right-3 font-semibold text-white text-sm drop-shadow">{{ $category->name }}</span>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif

@if($newArrivals->isNotEmpty())
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-between items-end gap-4 mb-10 reveal reveal-strong" data-delay="0">
            <div><h2 class="font-display text-2xl md:text-3xl font-bold text-[var(--color-noir)]">Nouveautés</h2><p class="text-gray-500 text-sm mt-0.5">Les dernières arrivées</p></div>
            <a href="{{ route('shop.index') }}?sort=newest" class="text-[var(--color-rose)] font-medium hover:underline transition-colors duration-300">Voir tout</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($newArrivals as $i => $product)<div class="reveal reveal-strong reveal-strong-scale" data-delay="{{ min($i, 8) }}"><x-product-card :product="$product" /></div>@endforeach
        </div>
    </div>
</section>
@endif

@if($bestSellers->isNotEmpty())
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-between items-end gap-4 mb-10 reveal reveal-strong reveal-left" data-delay="0">
            <div><h2 class="font-display text-2xl md:text-3xl font-bold text-[var(--color-noir)]">Meilleures ventes</h2><p class="text-gray-500 text-sm mt-0.5">Les incontournables</p></div>
            <a href="{{ route('shop.index') }}?sort=popular" class="text-[var(--color-rose)] font-medium hover:underline transition-colors duration-300">Voir tout</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($bestSellers as $i => $product)<div class="reveal reveal-strong reveal-right" data-delay="{{ min($i, 8) }}"><x-product-card :product="$product" /></div>@endforeach
        </div>
    </div>
</section>
@endif

@if($onSale->isNotEmpty())
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-between items-end gap-4 mb-10 reveal reveal-strong reveal-scale" data-delay="0">
            <div><h2 class="font-display text-2xl md:text-3xl font-bold text-[var(--color-noir)]">En promotion</h2><p class="text-gray-500 text-sm mt-0.5">Offres limitées</p></div>
            <a href="{{ route('shop.index') }}?on_sale=1" class="text-[var(--color-rose)] font-medium hover:underline transition-colors duration-300">Voir tout</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($onSale as $i => $product)<div class="reveal reveal-strong reveal-strong-scale" data-delay="{{ min($i, 8) }}"><x-product-card :product="$product" /></div>@endforeach
        </div>
    </div>
</section>
@endif

@if($services->isNotEmpty())
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="reveal reveal-strong" data-delay="0"><h2 class="font-display text-2xl md:text-3xl font-bold text-[var(--color-noir)] mb-2">Nos engagements</h2><p class="text-gray-500 mb-12 text-lg">Votre satisfaction au cœur de notre démarche</p></div>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($services as $i => $service)
            <div class="reveal reveal-strong reveal-strong-scale p-6 rounded-2xl transition-all duration-500 hover:bg-white/70 hover:shadow-xl hover:-translate-y-1" data-delay="{{ min($i + 1, 8) }}"><div class="w-14 h-14 rounded-2xl bg-[var(--color-rose)]/10 flex items-center justify-center mx-auto mb-3 text-[var(--color-rose)] text-2xl transition-transform duration-300 hover:scale-110">★</div><h3 class="font-semibold text-[var(--color-noir)]">{{ $service->name }}</h3><p class="text-sm text-gray-500 mt-1">{{ $service->description }}</p></div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="py-16 bg-[var(--color-noir)] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="reveal reveal-strong flex flex-col lg:flex-row items-center justify-between gap-6" data-delay="0">
            <div class="text-center lg:text-left">
                <h2 class="font-display text-2xl font-bold">Livraison offerte dès {{ number_format(config('shop.free_shipping_threshold', 50), 0) }}€ d'achat</h2>
                <p class="text-gray-400 mt-1">Commandez en toute sérénité. Retours sous 30 jours.</p>
            </div>
            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-wrap gap-2 justify-center lg:justify-end">
                @csrf
                <input type="email" name="email" class="rounded-xl border-0 px-4 py-2.5 w-64 text-[var(--color-noir)] focus:ring-2 focus:ring-[var(--color-rose)] transition-all" placeholder="Votre email" required>
                <button type="submit" class="btn-premium-press px-6 py-2.5 rounded-xl font-semibold bg-[var(--color-rose)] hover:bg-[var(--color-rose-fonce)] transition-all duration-300 hover:scale-[1.02]">S'inscrire à la newsletter</button>
            </form>
        </div>
        @if($errors->has('email'))<p class="text-amber-400 text-sm mt-2 text-center lg:text-right">{{ $errors->first('email') }}</p>@endif
    </div>
</section>

@if(!empty($slider))
@push('scripts')
<script>
(function() {
    var slides = document.querySelectorAll('.hero-slide');
    var dots = document.querySelectorAll('.hero-dot');
    var current = 0;
    function go(n) { current = (n + slides.length) % slides.length; slides.forEach(function(s, i) { s.classList.toggle('opacity-100', i === current); s.classList.toggle('z-10', i === current); s.classList.toggle('opacity-0', i !== current); s.classList.toggle('z-0', i !== current); }); dots.forEach(function(d, i) { d.classList.toggle('bg-white', i === current); d.classList.toggle('scale-125', i === current); d.classList.toggle('bg-white/50', i !== current); }); }
    dots.forEach(function(d, i) { d.addEventListener('click', function() { go(i); }); });
    document.querySelector('.hero-prev')?.addEventListener('click', function() { go(current - 1); });
    document.querySelector('.hero-next')?.addEventListener('click', function() { go(current + 1); });
    setInterval(function() { go(current + 1); }, 5000);
})();
</script>
@endpush
@endif
@endsection
