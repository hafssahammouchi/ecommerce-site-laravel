@extends('layouts.app')

@section('title', 'Livraison & retours')
@section('meta_description', 'Modes de livraison, délais, retours et garanties Glow Beauty.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
    <div class="reveal text-center mb-14" data-delay="0">
        <h1 class="font-display text-3xl md:text-4xl font-bold text-[var(--color-noir)] mb-3">Livraison & retours</h1>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">Tout ce qu’il faut savoir sur l’expédition, les délais et les retours. Nous mettons tout en œuvre pour que votre colis arrive en parfait état.</p>
    </div>

    <div class="space-y-8">
        <section class="reveal bg-white rounded-2xl shadow-sm border border-black/5 overflow-hidden transition-shadow duration-300 hover:shadow-md" data-delay="1">
            <div class="p-6 md:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-[var(--color-rose)]/10 flex items-center justify-center text-[var(--color-rose)]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    </div>
                    <h2 class="font-display text-xl font-bold text-[var(--color-noir)]">Modes de livraison</h2>
                </div>
                <div class="grid sm:grid-cols-3 gap-6">
                    <div class="p-4 rounded-xl bg-[var(--color-creme)]/50 border border-[var(--color-rose)]/10">
                        <p class="font-semibold text-[var(--color-noir)]">Livraison standard</p>
                        <p class="text-sm text-gray-600 mt-1">5 à 7 jours ouvrés</p>
                        <p class="text-[var(--color-rose-fonce)] font-semibold mt-2">5,99 € <span class="text-emerald-600 text-sm font-normal">(offerte dès {{ number_format(config('shop.free_shipping_threshold', 50), 0) }} €)</span></p>
                    </div>
                    <div class="p-4 rounded-xl bg-[var(--color-creme)]/50 border border-[var(--color-rose)]/10">
                        <p class="font-semibold text-[var(--color-noir)]">Express</p>
                        <p class="text-sm text-gray-600 mt-1">24 à 48 h</p>
                        <p class="text-[var(--color-rose-fonce)] font-semibold mt-2">9,99 € <span class="text-emerald-600 text-sm font-normal">(offerte dès {{ number_format(config('shop.free_shipping_threshold', 50), 0) }} €)</span></p>
                    </div>
                    <div class="p-4 rounded-xl bg-[var(--color-creme)]/50 border border-[var(--color-rose)]/10">
                        <p class="font-semibold text-[var(--color-noir)]">Point relais</p>
                        <p class="text-sm text-gray-600 mt-1">4 à 6 jours</p>
                        <p class="text-[var(--color-rose-fonce)] font-semibold mt-2">4,99 € <span class="text-emerald-600 text-sm font-normal">(offerte dès {{ number_format(config('shop.free_shipping_threshold', 50), 0) }} €)</span></p>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-4">Livraison en France métropolitaine. Délais indicatifs à compter de l’expédition. Vous recevrez un email de suivi dès l’envoi de votre colis.</p>
            </div>
        </section>

        <section class="reveal bg-white rounded-2xl shadow-sm border border-black/5 overflow-hidden transition-shadow duration-300 hover:shadow-md" data-delay="2">
            <div class="p-6 md:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-[var(--color-rose)]/10 flex items-center justify-center text-[var(--color-rose)]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </div>
                    <h2 class="font-display text-xl font-bold text-[var(--color-noir)]">Retours & échanges</h2>
                </div>
                <p class="text-gray-600 mb-4">Vous disposez de <strong class="text-[var(--color-noir)]">30 jours</strong> après réception pour retourner un article non utilisé, dans son emballage d’origine et avec les accessoires éventuels.</p>
                <ol class="space-y-3 list-decimal list-inside text-gray-600">
                    <li>Contactez-nous via le <a href="{{ route('contact') }}" class="text-[var(--color-rose)] font-medium hover:underline">formulaire Contact</a> en indiquant le numéro de commande et les articles concernés.</li>
                    <li>Nous vous enverrons les instructions et l’étiquette de retour prépayée si applicable.</li>
                    <li>Expédiez le colis à nos soins. Dès réception et contrôle, le remboursement sera effectué sous <strong>14 jours</strong> par le même moyen de paiement.</li>
                </ol>
            </div>
        </section>

        <section class="bg-white rounded-2xl shadow-sm border border-black/5 overflow-hidden">
            <div class="p-6 md:p-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-[var(--color-rose)]/10 flex items-center justify-center text-[var(--color-rose)]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h2 class="font-display text-xl font-bold text-[var(--color-noir)]">Garantie & conformité</h2>
                </div>
                <p class="text-gray-600">Tous nos produits sont garantis conformes et authentiques. En cas de produit défectueux ou non conforme à votre commande, contactez-nous pour un échange ou un remboursement sans frais. Notre engagement : votre satisfaction.</p>
            </div>
        </section>
    </div>
</div>
@endsection
