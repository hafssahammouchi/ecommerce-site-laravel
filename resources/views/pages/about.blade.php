@extends('layouts.app')

@section('title', 'À propos')
@section('meta_description', 'Découvrez Glow Beauty — Notre histoire, nos valeurs et notre engagement pour la beauté et le maquillage.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    {{-- Hero --}}
    <div class="py-14 md:py-20">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div class="reveal reveal-left" data-delay="0">
                <h1 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold text-[var(--color-noir)] mb-6">Notre histoire</h1>
                <p class="text-lg text-gray-600 mb-4">Glow Beauty est née de la passion pour le maquillage et le bien-être. Nous sélectionnons pour vous des produits de qualité pour sublimer votre quotidien.</p>
                <p class="text-gray-600 mb-6">Forte de plusieurs années d’expertise dans le secteur de la beauté, notre équipe travaille chaque jour avec des marques exigeantes pour vous proposer une offre maquillage, soins et accessoires à la fois tendance et fiable.</p>
                <a href="{{ route('shop.index') }}" class="btn-premium-press inline-block px-8 py-3.5 rounded-xl font-semibold text-white bg-[var(--color-rose)] hover:bg-[var(--color-rose-fonce)] transition-all duration-300 hover:scale-[1.02]">Découvrir la boutique</a>
            </div>
            <div class="reveal reveal-right relative rounded-2xl overflow-hidden shadow-xl aspect-[4/3] bg-[var(--color-creme)]" data-delay="1">
                <img src="{{ asset('images/products/soin-4.png') }}" alt="Notre univers beauté" class="w-full h-full object-cover transition-transform duration-700 hover:scale-105" loading="lazy" data-fallback="1">
            </div>
        </div>
    </div>

    {{-- Valeurs --}}
    <div class="py-14 border-t border-black/5">
        <h2 class="reveal font-display text-2xl md:text-3xl font-bold text-center text-[var(--color-noir)] mb-12" data-delay="0">Nos valeurs</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="reveal bg-white rounded-2xl p-8 shadow-sm border border-black/5 text-center card-product-hover" data-delay="1">
                <div class="w-16 h-16 rounded-2xl bg-[var(--color-rose)]/10 flex items-center justify-center mx-auto mb-4 text-[var(--color-rose)] text-2xl transition-transform duration-300 hover:scale-110">★</div>
                <h3 class="font-display text-xl font-semibold text-[var(--color-noir)] mb-2">Qualité</h3>
                <p class="text-gray-600">Produits sélectionnés et contrôlés pour vous garantir satisfaction et sécurité. Nous ne proposons que des références conformes et authentiques.</p>
            </div>
            <div class="reveal bg-white rounded-2xl p-8 shadow-sm border border-black/5 text-center card-product-hover" data-delay="2">
                <div class="w-16 h-16 rounded-2xl bg-[var(--color-rose)]/10 flex items-center justify-center mx-auto mb-4 text-[var(--color-rose)] text-2xl transition-transform duration-300 hover:scale-110">◆</div>
                <h3 class="font-display text-xl font-semibold text-[var(--color-noir)] mb-2">Expertise</h3>
                <p class="text-gray-600">Une équipe dédiée à la beauté et au conseil pour vous accompagner dans vos choix. Des réponses rapides et personnalisées.</p>
            </div>
            <div class="reveal bg-white rounded-2xl p-8 shadow-sm border border-black/5 text-center card-product-hover" data-delay="3">
                <div class="w-16 h-16 rounded-2xl bg-[var(--color-rose)]/10 flex items-center justify-center mx-auto mb-4 text-[var(--color-rose)] text-2xl transition-transform duration-300 hover:scale-110">♥</div>
                <h3 class="font-display text-xl font-semibold text-[var(--color-noir)] mb-2">Engagement</h3>
                <p class="text-gray-600">Retours faciles, livraison soignée et service client à votre écoute. Votre satisfaction est au cœur de notre démarche.</p>
            </div>
        </div>
    </div>

    @if($categories->isNotEmpty())
    <div class="py-14 border-t border-black/5">
        <h2 class="reveal font-display text-2xl md:text-3xl font-bold text-center text-[var(--color-noir)] mb-4" data-delay="0">Nos univers</h2>
        <p class="text-center text-gray-600 mb-10 max-w-2xl mx-auto">Explorez nos catégories maquillage et soins pour trouver l’essentiel de votre routine beauté.</p>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($categories as $i => $cat)
            <a href="{{ route('shop.category', $cat->slug) }}" class="reveal group block rounded-2xl overflow-hidden shadow-md border border-black/5 card-product-hover" data-delay="{{ min($i + 2, 8) }}">
                @if($cat->image_url)
                <div class="aspect-[4/3] overflow-hidden"><img src="{{ $cat->image_url }}" alt="{{ $cat->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out" data-fallback="1"></div>
                @else
                <div class="aspect-[4/3] bg-[var(--color-creme)] flex items-center justify-center text-gray-400 text-3xl">◇</div>
                @endif
                <div class="p-3 text-center"><span class="font-medium text-[var(--color-noir)] group-hover:text-[var(--color-rose-fonce)]">{{ $cat->name }}</span></div>
            </a>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('categories.index') }}" class="inline-block px-6 py-2.5 rounded-xl border-2 border-[var(--color-rose)] text-[var(--color-rose)] font-medium hover:bg-[var(--color-rose)]/5 transition-all">Voir toutes les catégories</a>
        </div>
    </div>
    @endif
</div>
@endsection
