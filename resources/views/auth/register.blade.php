@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<section class="auth-page min-h-[calc(100vh-8rem)] flex items-center py-12 lg:py-16">
    <div class="max-w-6xl mx-auto w-full px-4 sm:px-6 lg:px-8">
        <div class="auth-card grid lg:grid-cols-2 rounded-2xl overflow-hidden shadow-xl border border-black/5 bg-white">
            {{-- Panneau gauche : visuel / message --}}
            <div class="auth-panel hidden lg:flex flex-col justify-center px-10 xl:px-14 py-12 bg-gradient-to-br from-[var(--color-creme)] via-white to-[var(--color-creme)] order-2 lg:order-1">
                <div class="reveal reveal-right max-w-sm" data-delay="0">
                    <div class="w-14 h-14 rounded-2xl bg-[var(--color-rose)]/10 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-[var(--color-rose)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </div>
                    <h2 class="font-display text-2xl xl:text-3xl font-bold text-[var(--color-noir)]">Rejoignez {{ config('app.name') }}</h2>
                    <p class="mt-3 text-gray-600 text-base leading-relaxed">Créez votre compte pour gérer vos commandes, enregistrer vos favoris et bénéficier d’une expérience adaptée à vos envies.</p>
                </div>
            </div>

            {{-- Formulaire --}}
            <div class="px-6 sm:px-10 lg:px-12 py-10 lg:py-12 flex flex-col justify-center order-1 lg:order-2">
                <div class="reveal reveal-strong" data-delay="0">
                    <h1 class="font-display text-2xl sm:text-3xl font-bold text-[var(--color-noir)]">Créer un compte</h1>
                    <p class="mt-1 text-gray-500 text-sm">Inscription en quelques secondes</p>
                </div>

                @if($errors->any())
                    <div class="mt-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-700 text-sm animate-fade-in" role="alert">
                        <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4 reveal reveal-strong" data-delay="1">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-[var(--color-noir)] mb-1.5">Nom complet</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="auth-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20 transition-all duration-200"
                            placeholder="Jean Dupont">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-[var(--color-noir)] mb-1.5">Adresse email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="auth-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20 transition-all duration-200"
                            placeholder="vous@exemple.fr">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-[var(--color-noir)] mb-1.5">Téléphone <span class="text-gray-400 font-normal">(optionnel)</span></label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                            class="auth-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20 transition-all duration-200"
                            placeholder="06 12 34 56 78">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-[var(--color-noir)] mb-1.5">Mot de passe</label>
                        <input type="password" name="password" id="password" required
                            class="auth-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20 transition-all duration-200"
                            placeholder="••••••••">
                        <p class="mt-1 text-xs text-gray-500">Au moins 8 caractères</p>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-[var(--color-noir)] mb-1.5">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="auth-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20 transition-all duration-200"
                            placeholder="••••••••">
                    </div>
                    <button type="submit" class="auth-submit btn-premium-press w-full py-3.5 rounded-xl font-semibold text-white bg-[var(--color-rose)] hover:bg-[var(--color-rose-fonce)] transition-all duration-300 shadow-lg shadow-[var(--color-rose)]/20 hover:shadow-xl hover:shadow-[var(--color-rose)]/25 focus:outline-none focus:ring-2 focus:ring-[var(--color-rose)] focus:ring-offset-2 mt-2">
                        Créer mon compte
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-gray-500 reveal reveal-strong" data-delay="2">
                    Déjà inscrit ? <a href="{{ route('login') }}" class="text-[var(--color-rose)] font-semibold hover:text-[var(--color-rose-fonce)] transition-colors">Se connecter</a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
