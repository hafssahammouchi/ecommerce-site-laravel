@extends('layouts.app')

@section('title', 'Mentions légales')
@section('meta_description', 'Mentions légales, éditeur, hébergement, propriété intellectuelle et données personnelles Glow Beauty.')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
    <h1 class="font-display text-3xl md:text-4xl font-bold text-center text-[var(--color-noir)] mb-12">Mentions légales</h1>

    <div class="prose prose-gray max-w-none space-y-10">
        <section class="bg-white rounded-2xl shadow-sm border border-black/5 p-6 md:p-8">
            <h2 class="font-display text-xl font-bold text-[var(--color-noir)] mb-3">Éditeur du site</h2>
            <p class="text-gray-600">Le site est édité par <strong>{{ config('app.name') }}</strong>, dont le siège social est situé en France. Pour toute question relative à l’éditeur, vous pouvez nous contacter via le <a href="{{ route('contact') }}" class="text-[var(--color-rose)] font-medium hover:underline">formulaire de contact</a> ou à l’adresse contact@glowbeauty.fr.</p>
        </section>

        <section class="bg-white rounded-2xl shadow-sm border border-black/5 p-6 md:p-8">
            <h2 class="font-display text-xl font-bold text-[var(--color-noir)] mb-3">Hébergement</h2>
            <p class="text-gray-600">Le site est hébergé par un prestataire d’hébergement web. Pour toute question relative à l’hébergement ou à la disponibilité du site, contactez-nous à contact@glowbeauty.fr.</p>
        </section>

        <section class="bg-white rounded-2xl shadow-sm border border-black/5 p-6 md:p-8">
            <h2 class="font-display text-xl font-bold text-[var(--color-noir)] mb-3">Propriété intellectuelle</h2>
            <p class="text-gray-600">L’ensemble du contenu du site (textes, images, logos, structure, charte graphique) est protégé par le droit d’auteur et les marques déposées. Toute reproduction, représentation ou utilisation non autorisée des éléments du site est interdite et peut constituer une contrefaçon.</p>
        </section>

        <section class="bg-white rounded-2xl shadow-sm border border-black/5 p-6 md:p-8">
            <h2 class="font-display text-xl font-bold text-[var(--color-noir)] mb-3">Données personnelles</h2>
            <p class="text-gray-600 mb-4">Les données collectées (identité, adresse, email, commandes, messages) sont utilisées pour la gestion des commandes, la relation client et, avec votre accord, l’envoi de communications commerciales (newsletter). Vous disposez d’un droit d’accès, de rectification, d’effacement et d’opposition au traitement de vos données.</p>
            <p class="text-gray-600">Pour exercer ces droits ou pour toute question : <a href="mailto:contact@glowbeauty.fr" class="text-[var(--color-rose)] font-medium hover:underline">contact@glowbeauty.fr</a>.</p>
        </section>

        <section class="bg-white rounded-2xl shadow-sm border border-black/5 p-6 md:p-8">
            <h2 class="font-display text-xl font-bold text-[var(--color-noir)] mb-3">Cookies</h2>
            <p class="text-gray-600">Le site utilise des cookies nécessaires au fonctionnement (session, panier, préférences, sécurité). En poursuivant votre navigation, vous acceptez l’utilisation de ces cookies. Vous pouvez configurer votre navigateur pour refuser les cookies non essentiels.</p>
        </section>

        <section class="bg-white rounded-2xl shadow-sm border border-black/5 p-6 md:p-8">
            <h2 class="font-display text-xl font-bold text-[var(--color-noir)] mb-3">Contact</h2>
            <p class="text-gray-600 mb-0">Pour toute question relative aux mentions légales : <a href="{{ route('contact') }}" class="text-[var(--color-rose)] font-medium hover:underline">Formulaire de contact</a> ou <a href="mailto:contact@glowbeauty.fr" class="text-[var(--color-rose)] font-medium hover:underline">contact@glowbeauty.fr</a>.</p>
        </section>
    </div>
</div>
@endsection
