@extends('layouts.app')

@section('title', 'Paiement')
@section('meta_description', 'Finalisez le paiement de votre commande.')

@section('content')
<div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-white rounded-2xl shadow-sm border border-black/5 p-8">
        <h1 class="font-display text-xl font-bold text-[var(--color-noir)] mb-2">Paiement sécurisé</h1>
        <p class="text-gray-500 text-sm mb-6">Commande <strong>{{ $order->number }}</strong> — Total : <strong>{{ number_format($order->total, 2) }} €</strong></p>
        <div class="bg-gray-50 rounded-xl p-4 mb-6 text-sm text-gray-600">
            <span class="text-emerald-600">✓</span> Paiement simulé pour la démonstration. En production, une intégration Stripe serait utilisée.
        </div>
        <form action="{{ route('checkout.pay', $order) }}" method="POST">
            @csrf
            <button type="submit" class="w-full py-3.5 rounded-xl font-semibold text-white bg-[var(--color-rose)] hover:bg-[var(--color-rose-fonce)] transition-all flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Payer par carte (simulation)
            </button>
        </form>
        <a href="{{ route('checkout.confirmation', $order) }}" class="block text-center mt-4 text-sm text-gray-500 hover:text-[var(--color-rose)]">Retour à la commande</a>
    </div>
</div>
@endsection
