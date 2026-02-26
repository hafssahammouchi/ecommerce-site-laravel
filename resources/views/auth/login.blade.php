@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<section class="auth-page min-h-[calc(100vh-8rem)] flex items-center py-12 lg:py-16">
    <div class="max-w-6xl mx-auto w-full px-4 sm:px-6 lg:px-8">
        <div class="auth-card grid lg:grid-cols-2 rounded-2xl overflow-hidden shadow-xl border border-black/5 bg-white">
            {{-- Panneau gauche : visuel / message --}}
            <div class="auth-panel hidden lg:flex flex-col justify-center px-10 xl:px-14 py-12 bg-gradient-to-br from-[var(--color-creme)] via-white to-[var(--color-creme)]">
                <div class="reveal reveal-left max-w-sm" data-delay="0">
                    <div class="w-14 h-14 rounded-2xl bg-[var(--color-rose)]/10 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-[var(--color-rose)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h2 class="font-display text-2xl xl:text-3xl font-bold text-[var(--color-noir)]">Bienvenue sur {{ config('app.name') }}</h2>
                    <p class="mt-3 text-gray-600 text-base leading-relaxed">Connectez-vous pour gérer vos commandes, vos favoris et profiter d’une expérience personnalisée.</p>
                </div>
            </div>

            {{-- Formulaire --}}
            <div class="px-6 sm:px-10 lg:px-12 py-10 lg:py-12 flex flex-col justify-center">
                <div class="reveal reveal-strong" data-delay="0">
                    <h1 class="font-display text-2xl sm:text-3xl font-bold text-[var(--color-noir)]">Connexion</h1>
                    <p class="mt-1 text-gray-500 text-sm">Accédez à votre espace client</p>
                </div>

                @if($errors->any())
                    <div class="mt-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-700 text-sm animate-fade-in" role="alert">
                        @if($errors->has('email') || $errors->has('password'))
                            Identifiants incorrects ou champs invalides.
                        @else
                            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                        @endif
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5 reveal reveal-strong" data-delay="1">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-[var(--color-noir)] mb-1.5">Adresse email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            class="auth-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20 transition-all duration-200 @error('email') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                            placeholder="vous@exemple.fr">
                        @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-[var(--color-noir)] mb-1.5">Mot de passe</label>
                        <input type="password" name="password" id="password" required
                            class="auth-input w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-[var(--color-rose)] focus:ring-2 focus:ring-[var(--color-rose)]/20 transition-all duration-200 @error('password') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                            placeholder="••••••••">
                        @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember"
                            class="h-4 w-4 rounded border-gray-300 text-[var(--color-rose)] focus:ring-[var(--color-rose)]/30">
                        <label for="remember" class="ml-2 text-sm text-gray-600">Se souvenir de moi</label>
                    </div>
                    <button type="submit" class="auth-submit btn-premium-press w-full py-3.5 rounded-xl font-semibold text-white bg-[var(--color-rose)] hover:bg-[var(--color-rose-fonce)] transition-all duration-300 shadow-lg shadow-[var(--color-rose)]/20 hover:shadow-xl hover:shadow-[var(--color-rose)]/25 focus:outline-none focus:ring-2 focus:ring-[var(--color-rose)] focus:ring-offset-2">
                        Se connecter
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-gray-500 reveal reveal-strong" data-delay="2">
                    <a href="{{ route('password.request') }}" class="text-[var(--color-rose)] font-medium hover:text-[var(--color-rose-fonce)] transition-colors">Mot de passe oublié ?</a>
                </p>
                <p class="mt-2 text-center text-sm text-gray-500">
                    Pas encore de compte ? <a href="{{ route('register') }}" class="text-[var(--color-rose)] font-semibold hover:text-[var(--color-rose-fonce)] transition-colors">Créer un compte</a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
