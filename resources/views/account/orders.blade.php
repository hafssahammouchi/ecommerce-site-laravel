@extends('layouts.app')

@section('title', 'Mes commandes')
@section('meta_description', 'Historique de vos commandes.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="font-display text-2xl font-bold text-[var(--color-noir)] mb-8">Mes commandes</h1>

    @if($orders->isEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-black/5 p-12 text-center">
        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4 text-gray-400 text-3xl">📦</div>
        <p class="text-gray-500 mb-6">Vous n'avez pas encore passé de commande.</p>
        <a href="{{ route('shop.index') }}" class="inline-block px-6 py-3 rounded-xl font-semibold text-white bg-[var(--color-rose)] hover:bg-[var(--color-rose-fonce)] transition-all">Découvrir la boutique</a>
    </div>
    @else
    <div class="bg-white rounded-2xl shadow-sm border border-black/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-black/5"><tr><th class="text-left px-6 py-4 font-semibold text-[var(--color-noir)]">N° commande</th><th class="text-left px-6 py-4 font-semibold">Date</th><th class="text-left px-6 py-4 font-semibold">Total</th><th class="text-left px-6 py-4 font-semibold">Statut</th><th class="px-6 py-4"></th></tr></thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr class="border-b border-black/5 hover:bg-gray-50/50">
                        <td class="px-6 py-4"><a href="{{ route('checkout.confirmation', $order) }}" class="font-medium text-[var(--color-rose)] hover:underline">{{ $order->number }}</a></td>
                        <td class="px-6 py-4 text-gray-600">{{ $order->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 font-medium">{{ number_format($order->total, 2) }} €</td>
                        <td class="px-6 py-4"><span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium {{ $order->status === 'paid' ? 'bg-emerald-100 text-emerald-800' : ($order->status === 'shipped' ? 'bg-sky-100 text-sky-800' : 'bg-gray-100 text-gray-800') }}">{{ ucfirst($order->status) }}</span></td>
                        <td class="px-6 py-4"><a href="{{ route('checkout.confirmation', $order) }}" class="text-sm font-medium text-[var(--color-rose)] hover:underline">Détails</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
