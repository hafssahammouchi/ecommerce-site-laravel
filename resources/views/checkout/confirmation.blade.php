@extends('layouts.app')

@section('title', 'Commande confirmée')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="text-center mb-8 animate-fade-in-up">
        <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        </div>
        @php $payOnDelivery = ($order->payment_method ?? 'card') === \App\Models\Order::PAYMENT_ON_DELIVERY; @endphp
        <h1 class="font-display text-2xl md:text-3xl font-bold text-[var(--color-noir)]">
            @if($order->status === 'paid') Commande confirmée
            @elseif($payOnDelivery) Commande enregistrée
            @elseif($order->status === 'pending') Paiement en attente
            @else Commande
            @endif
        </h1>
        <p class="text-gray-600 mt-2">Numéro de commande : <strong>{{ $order->number }}</strong></p>
        @if($payOnDelivery)<p class="text-[var(--color-rose)] font-medium mt-1">Vous paierez à la livraison (espèces ou carte chez le livreur).</p>@endif
        @if($order->invoice_number)<p class="text-sm text-gray-500">Facture n° <strong>{{ $order->invoice_number }}</strong></p>@endif
    </div>

    <div class="space-y-6 animate-fade-in-up">
        <div class="bg-white rounded-2xl shadow-sm border border-black/5 overflow-hidden">
            <div class="px-6 py-4 border-b border-black/5 font-semibold">Détails de la commande</div>
            <div class="p-6">
                <table class="w-full text-sm">
                    @foreach($order->items as $item)
                    <tr class="border-b border-black/5"><td class="py-2">{{ $item->product_name }} × {{ $item->qty }}</td><td class="text-right font-medium">{{ number_format($item->total, 2) }} €</td></tr>
                    @endforeach
                    <tr><td class="py-2 pt-4">Sous-total</td><td class="text-right py-2 pt-4">{{ number_format($order->subtotal, 2) }} €</td></tr>
                    <tr><td class="py-1">Livraison ({{ \Illuminate\Support\Arr::get(config('shop.shipping', []), $order->delivery_option . '.label', $order->delivery_option) }})</td><td class="text-right">{{ number_format($order->delivery_price, 2) }} €</td></tr>
                    @if($order->discount_amount > 0)<tr><td class="py-1">Réduction ({{ $order->coupon_code }})</td><td class="text-right text-emerald-600">-{{ number_format($order->discount_amount, 2) }} €</td></tr>@endif
                    <tr class="font-bold text-base"><td class="py-3">Total</td><td class="text-right py-3">{{ number_format($order->total, 2) }} €</td></tr>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-black/5 overflow-hidden">
            <div class="px-6 py-4 border-b border-black/5 font-semibold">Adresse de livraison</div>
            <div class="p-6 text-gray-700">
                {{ $order->shipping_name }}<br>{{ $order->shipping_address }}<br>{{ $order->shipping_postal_code }} {{ $order->shipping_city }}<br>{{ $order->shipping_country }}<br>Tél. {{ $order->customer_phone }}
            </div>
            @if($order->shipping_lat && $order->shipping_lng)
            <div class="px-6 pb-6">
                <p class="text-sm font-medium text-gray-600 mb-2">Position enregistrée pour le suivi livraison</p>
                <div id="map" class="w-full h-64 rounded-xl overflow-hidden bg-gray-100"></div>
            </div>
            @endif
        </div>

        <p><span class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $order->status === 'paid' ? 'bg-emerald-100 text-emerald-800' : ($order->status === 'shipped' ? 'bg-sky-100 text-sky-800' : 'bg-gray-100 text-gray-800') }}">{{ ucfirst($order->status) }}</span></p>
        @if($order->status === 'pending' && !$payOnDelivery)
        <p class="text-amber-600 text-sm">Paiement en attente.</p>
        <a href="{{ route('checkout.payment', $order) }}" class="inline-block px-6 py-3 rounded-xl font-semibold text-white bg-[var(--color-rose)] hover:bg-[var(--color-rose-fonce)] transition-all">Payer maintenant</a>
        @endif
        <div class="flex flex-wrap gap-3 pt-4">
            <a href="{{ route('shop.index') }}" class="px-6 py-3 rounded-xl font-semibold text-white bg-[var(--color-rose)] hover:bg-[var(--color-rose-fonce)] transition-all">Continuer mes achats</a>
            @auth<a href="{{ route('account.orders') }}" class="px-6 py-3 rounded-xl font-semibold border-2 border-[var(--color-rose)] text-[var(--color-rose)] hover:bg-[var(--color-rose)]/5 transition-all">Mes commandes</a>@endauth
        </div>
    </div>
</div>

@if($order->shipping_lat && $order->shipping_lng)
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var map = L.map('map').setView([{{ $order->shipping_lat }}, {{ $order->shipping_lng }}], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);
    L.marker([{{ $order->shipping_lat }}, {{ $order->shipping_lng }}]).addTo(map).bindPopup('Adresse de livraison');
});
</script>
@endpush
@endif
@endsection
