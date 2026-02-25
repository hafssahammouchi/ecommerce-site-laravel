@extends('layouts.app')

@section('title', 'Contact')
@section('meta_description', 'Contactez Glow Beauty — Questions, commandes, partenariats. Réponse sous 48 h.')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
    <div class="grid lg:grid-cols-5 gap-10 lg:gap-14">
        <div class="lg:col-span-2 reveal reveal-left" data-delay="0">
            <h1 class="font-display text-3xl md:text-4xl font-bold text-[var(--color-noir)] mb-4">Contactez-nous</h1>
            <p class="text-gray-600 text-lg mb-8">Une question sur une commande, un conseil produit ou une demande de partenariat ? Envoyez-nous un message, nous vous répondrons sous <strong>48 h ouvrées</strong>.</p>
            <div class="space-y-6">
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 rounded-xl bg-[var(--color-rose)]/10 flex items-center justify-center text-[var(--color-rose)] shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-[var(--color-noir)]">Email</p>
                        <a href="mailto:contact@glowbeauty.fr" class="text-gray-600 hover:text-[var(--color-rose)] transition-colors">contact@glowbeauty.fr</a>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 rounded-xl bg-[var(--color-rose)]/10 flex items-center justify-center text-[var(--color-rose)] shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-[var(--color-noir)]">Siège</p>
                        <p class="text-gray-600">France</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:col-span-3 reveal reveal-right" data-delay="1">
            <div class="bg-white rounded-2xl shadow-sm border border-black/5 p-6 md:p-8 transition-shadow duration-300 hover:shadow-md">
                @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-700 text-sm">Veuillez corriger les champs indiqués.</div>
                @endif
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()?->name) }}" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20 @error('name') border-red-500 @enderror">
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()?->email) }}" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20 @error('email') border-red-500 @enderror">
                            @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sujet</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" placeholder="Objet de votre message" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message <span class="text-red-500">*</span></label>
                        <textarea name="message" rows="5" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20 @error('message') border-red-500 @enderror" placeholder="Décrivez votre demande...">{{ old('message') }}</textarea>
                        @error('message')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-xl font-semibold text-white bg-[var(--color-rose)] hover:bg-[var(--color-rose-fonce)] transition-all">Envoyer le message</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
