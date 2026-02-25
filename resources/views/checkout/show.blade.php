@extends('layouts.app')

@section('title', 'Finaliser la commande')
@section('meta_description', 'Finalisez votre commande — Adresse de livraison et paiement sécurisé.')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="font-display text-2xl md:text-3xl font-bold text-[var(--color-noir)] mb-2 animate-fade-in-up">Finaliser la commande</h1>
    <p class="text-gray-600 mb-8 animate-fade-in-up">Renseignez votre adresse de livraison et localisez-vous pour le suivi.</p>

    @if(session('error'))
    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 animate-fade-in-up">{{ session('error') }}</div>
    @endif

    @if(!empty($stockWarnings))
    <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 animate-fade-in-up">
        <p class="font-medium mb-1">Attention — stock :</p>
        <ul class="list-disc list-inside text-sm space-y-0.5">
            @foreach($stockWarnings as $w)
            <li>{{ $w }}</li>
            @endforeach
        </ul>
        <p class="text-sm mt-2">Les quantités ont été ajustées au stock disponible. Vous pouvez modifier le panier si besoin.</p>
    </div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
        @csrf
        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-black/5 overflow-hidden animate-fade-in-up">
                    <div class="px-6 py-4 border-b border-black/5 font-semibold text-[var(--color-noir)] flex items-center gap-2">
                        <svg class="w-5 h-5 text-[var(--color-rose)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Adresse de livraison
                    </div>
                    <div class="p-6 space-y-4">
                        {{-- Bloc GPS --}}
                        <div class="bg-[var(--color-creme)] border border-[var(--color-rose)]/20 rounded-xl p-4">
                            <div class="flex items-center gap-2 font-semibold text-[var(--color-noir)] mb-2">
                                <svg class="w-5 h-5 text-[var(--color-rose)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Localisation pour la livraison
                            </div>
                            <p class="text-sm text-gray-600 mb-3">Enregistrez votre position GPS pour faciliter le suivi de votre colis et permettre au livreur de vous localiser.</p>
                            <div class="flex flex-wrap items-center gap-3">
                                <button type="button" id="btn-gps" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border-2 border-[var(--color-rose)] text-[var(--color-rose)] font-medium hover:bg-[var(--color-rose)] hover:text-white transition-all duration-300">
                                    <span id="gps-icon" class="w-4 h-4"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg></span>
                                    <span id="gps-text">Utiliser ma position GPS</span>
                                </button>
                                <span id="gps-status" class="text-sm"></span>
                            </div>
                            <input type="hidden" name="shipping_lat" id="shipping_lat" value="{{ old('shipping_lat') }}">
                            <input type="hidden" name="shipping_lng" id="shipping_lng" value="{{ old('shipping_lng') }}">
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="customer_email" value="{{ old('customer_email', auth()->user()?->email) }}" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20 transition-all @error('customer_email') border-red-500 @enderror">
                                @error('customer_email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone <span class="text-red-500">*</span></label>
                                <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required placeholder="06 12 34 56 78" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20 @error('customer_phone') border-red-500 @enderror">
                                @error('customer_phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet <span class="text-red-500">*</span></label>
                                <input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->user()?->name) }}" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20 @error('shipping_name') border-red-500 @enderror">
                                @error('shipping_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Adresse <span class="text-red-500">*</span></label>
                                <input type="text" name="shipping_address" value="{{ old('shipping_address') }}" required placeholder="Numéro et nom de rue" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20 @error('shipping_address') border-red-500 @enderror">
                                @error('shipping_address')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Code postal <span class="text-red-500">*</span></label>
                                <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code') }}" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20 @error('shipping_postal_code') border-red-500 @enderror">
                                @error('shipping_postal_code')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ville <span class="text-red-500">*</span></label>
                                <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20 @error('shipping_city') border-red-500 @enderror">
                                @error('shipping_city')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pays</label>
                                <input type="text" name="shipping_country" value="{{ old('shipping_country', 'France') }}" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Instructions livraison (optionnel)</label>
                                <textarea name="notes" rows="2" placeholder="Code bâtiment, étage..." class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-black/5 overflow-hidden animate-fade-in-up">
                    <div class="px-6 py-4 border-b border-black/5 font-semibold text-[var(--color-noir)] flex items-center gap-2">
                        <svg class="w-5 h-5 text-[var(--color-rose)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Mode de livraison
                    </div>
                    <div class="p-6 space-y-3">
                        @foreach($deliveryOptions as $key => $option)
                        <label class="flex items-center justify-between p-4 rounded-xl border-2 cursor-pointer transition-all duration-300 has-[:checked]:border-[var(--color-rose)] has-[:checked]:bg-[var(--color-rose)]/5">
                            <span class="flex items-center gap-3">
                                <input type="radio" name="delivery_option" value="{{ $key }}" data-price="{{ $option['price'] }}" {{ old('delivery_option', 'standard') === $key ? 'checked' : '' }} class="w-4 h-4 text-[var(--color-rose)]">
                                {{ $option['label'] }}
                            </span>
                            @if($subtotal >= $freeThreshold)<span class="text-emerald-600 font-semibold">Offert</span>@else<span>{{ number_format($option['price'], 2) }} €</span>@endif
                        </label>
                        @endforeach
                        @if($subtotal < $freeThreshold)<p class="text-sm text-gray-500 mt-2">Livraison offerte dès {{ number_format($freeThreshold, 0) }} € d'achat.</p>@endif
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-black/5 overflow-hidden animate-fade-in-up">
                    <div class="px-6 py-4 border-b border-black/5 font-semibold text-[var(--color-noir)] flex items-center gap-2">
                        <svg class="w-5 h-5 text-[var(--color-rose)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2h-2m-4-1V7a2 2 0 012-2h2a2 2 0 012 2v1"/></svg>
                        Mode de paiement
                    </div>
                    <div class="p-6 space-y-3">
                        <label class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all duration-300 has-[:checked]:border-[var(--color-rose)] has-[:checked]:bg-[var(--color-rose)]/5">
                            <input type="radio" name="payment_method" value="on_delivery" {{ old('payment_method', 'on_delivery') === 'on_delivery' ? 'checked' : '' }} class="w-4 h-4 text-[var(--color-rose)]">
                            <span class="flex-1">
                                <span class="font-medium text-[var(--color-noir)]">Paiement à la livraison</span>
                                <span class="block text-sm text-gray-500">Espèces ou carte chez le livreur</span>
                            </span>
                        </label>
                        <label class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all duration-300 has-[:checked]:border-[var(--color-rose)] has-[:checked]:bg-[var(--color-rose)]/5">
                            <input type="radio" name="payment_method" value="card" {{ old('payment_method') === 'card' ? 'checked' : '' }} class="w-4 h-4 text-[var(--color-rose)]">
                            <span class="flex-1">
                                <span class="font-medium text-[var(--color-noir)]">Payer par carte maintenant</span>
                                <span class="block text-sm text-gray-500">Paiement sécurisé en ligne (page suivante)</span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-black/5 overflow-hidden sticky top-24 animate-fade-in-up">
                    <div class="px-6 py-4 border-b border-black/5 font-semibold flex items-center gap-2">Récapitulatif</div>
                    <div class="p-6 space-y-3">
                        @foreach($items as $item)
                        <div class="flex justify-between text-sm">
                            <span>{{ $item->product->name }} × {{ $item->qty }}</span>
                            <span class="font-medium">{{ number_format($item->subtotal, 2) }} €</span>
                        </div>
                        @endforeach
                        <div class="pt-3">
                            <input type="text" name="coupon_code" value="{{ old('coupon_code') }}" placeholder="Code promo" class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm mb-3">
                        </div>
                        <div class="flex justify-between text-gray-600 text-sm"><span>Sous-total</span><span id="recap-subtotal">{{ number_format($subtotal, 2) }} €</span></div>
                        <div class="flex justify-between text-gray-600 text-sm"><span>Livraison</span><span id="recap-delivery">@if($subtotal >= $freeThreshold)0,00 €@else{{ number_format($deliveryOptions['standard']['price'] ?? 0, 2) }} €@endif</span></div>
                        <hr class="border-black/5">
                        <div class="flex justify-between text-lg font-bold"><span>Total</span><span id="recap-total">@if($subtotal >= $freeThreshold){{ number_format($subtotal, 2) }} €@else{{ number_format($subtotal + ($deliveryOptions['standard']['price'] ?? 0), 2) }} €@endif</span></div>
                        <button type="submit" class="w-full mt-4 py-3.5 rounded-xl font-semibold text-white bg-[var(--color-rose)] hover:bg-[var(--color-rose-fonce)] transition-all duration-300">Continuer vers le paiement</button>
                        <a href="{{ route('cart.index') }}" class="block text-center mt-2 text-sm text-gray-600 hover:text-[var(--color-rose)] transition-colors">Retour au panier</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
(function() {
    const freeThreshold = {{ $freeThreshold }};
    const subtotal = {{ $subtotal }};
    document.querySelectorAll('input[name="delivery_option"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            const price = subtotal >= freeThreshold ? 0 : parseFloat(this.dataset.price);
            document.getElementById('recap-delivery').textContent = price.toFixed(2) + ' €';
            document.getElementById('recap-total').textContent = (subtotal + price).toFixed(2) + ' €';
        });
    });

    var btnGps = document.getElementById('btn-gps');
    var statusEl = document.getElementById('gps-status');
    var latInput = document.getElementById('shipping_lat');
    var lngInput = document.getElementById('shipping_lng');
    var gpsText = document.getElementById('gps-text');
    var gpsIcon = document.getElementById('gps-icon');

    function setStatus(html, type) {
        statusEl.innerHTML = html;
        statusEl.className = 'text-sm ' + (type === 'success' ? 'text-emerald-600 font-medium' : type === 'error' ? 'text-red-600' : 'text-gray-500');
    }

    if (btnGps && navigator.geolocation) {
        btnGps.addEventListener('click', function() {
            btnGps.disabled = true;
            gpsText.textContent = 'Localisation...';
            gpsIcon.innerHTML = '<svg class="gps-spinner w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            setStatus('En cours...', 'idle');
            navigator.geolocation.getCurrentPosition(
                function(pos) {
                    latInput.value = pos.coords.latitude;
                    lngInput.value = pos.coords.longitude;
                    setStatus('✓ Position enregistrée', 'success');
                    gpsText.textContent = 'Position enregistrée';
                    gpsIcon.innerHTML = '<svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>';
                    btnGps.disabled = false;
                },
                function(err) {
                    var msg = 'Impossible d\'obtenir la position.';
                    if (err.code === 1) msg = 'Autorisation refusée.';
                    else if (err.code === 2) msg = 'Position indisponible.';
                    setStatus('✗ ' + msg, 'error');
                    gpsText.textContent = 'Utiliser ma position GPS';
                    gpsIcon.innerHTML = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>';
                    btnGps.disabled = false;
                }
            );
        });
    } else if (btnGps) {
        btnGps.style.display = 'none';
    }
})();
</script>
@endpush
@endsection
