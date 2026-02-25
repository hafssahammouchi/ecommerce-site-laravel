<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', config('app.name') . ' — Maquillage et cosmétiques premium.')">
    <title>@yield('title', 'Boutique') — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    @if(file_exists(public_path('build/manifest.json')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: { extend: { fontFamily: { sans: ['DM Sans', 'sans-serif'], display: ['Playfair Display', 'serif'] } } }
      }
    </script>
    <link href="{{ asset('css/fallback.css') }}" rel="stylesheet">
    @endif
    @stack('styles')
</head>
<body class="bg-[var(--color-creme)] text-[var(--color-noir)] font-sans antialiased min-h-screen flex flex-col">
    {{-- Nav sticky avec transition --}}
    <header id="main-nav" class="nav-sticky fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm border-b border-black/5">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-18">
                <a href="{{ route('home') }}" class="font-display text-xl font-semibold text-[var(--color-noir)] tracking-tight">{{ config('app.name') }}</a>

                <div class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="nav-link-underline px-4 py-2 rounded-lg text-sm font-medium text-[var(--color-noir)] hover:text-[var(--color-rose-fonce)] transition-colors duration-300">Accueil</a>
                    <a href="{{ route('shop.index') }}" class="nav-link-underline px-4 py-2 rounded-lg text-sm font-medium text-[var(--color-noir)] hover:text-[var(--color-rose-fonce)] transition-colors duration-300">Boutique</a>
                    <a href="{{ route('about') }}" class="nav-link-underline px-4 py-2 rounded-lg text-sm font-medium text-[var(--color-noir)] hover:text-[var(--color-rose-fonce)] transition-colors duration-300">À propos</a>
                    <a href="{{ route('contact') }}" class="nav-link-underline px-4 py-2 rounded-lg text-sm font-medium text-[var(--color-noir)] hover:text-[var(--color-rose-fonce)] transition-colors duration-300">Contact</a>
                    <a href="{{ route('faq') }}" class="nav-link-underline px-4 py-2 rounded-lg text-sm font-medium text-[var(--color-noir)] hover:text-[var(--color-rose-fonce)] transition-colors duration-300">FAQ</a>
                    <a href="{{ route('shipping') }}" class="nav-link-underline px-4 py-2 rounded-lg text-sm font-medium text-[var(--color-noir)] hover:text-[var(--color-rose-fonce)] transition-colors duration-300">Livraison</a>
                    <div class="relative group">
                        <button type="button" class="px-4 py-2 rounded-lg text-sm font-medium text-[var(--color-noir)] hover:bg-black/5 hover:text-[var(--color-rose-fonce)] transition-all duration-300 flex items-center gap-1">
                            Entreprise <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div class="absolute left-0 mt-1 w-48 py-2 bg-white rounded-xl shadow-lg border border-black/5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <a href="{{ route('categories.index') }}" class="block px-4 py-2 text-sm text-[var(--color-noir)] hover:bg-[var(--color-creme)]">Nos catégories</a>
                            <a href="{{ route('legal') }}" class="block px-4 py-2 text-sm text-[var(--color-noir)] hover:bg-[var(--color-creme)]">Mentions légales</a>
                        </div>
                    </div>
                    @php $cartCount = array_sum(session('cart', [])); @endphp
                    <a href="{{ route('cart.index') }}" class="relative p-2 rounded-lg text-[var(--color-noir)] hover:bg-black/5 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        @if($cartCount > 0)<span class="absolute -top-0.5 -right-0.5 min-w-[1.25rem] h-5 px-1 flex items-center justify-center text-xs font-semibold text-white bg-[var(--color-rose)] rounded-full">{{ $cartCount }}</span>@endif
                    </a>
                </div>

                <div class="hidden lg:flex items-center gap-2">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-sm font-medium text-[var(--color-noir)] hover:text-[var(--color-rose-fonce)] transition-colors">Admin</a>
                        @endif
                        <div class="relative group">
                            <button type="button" class="px-4 py-2 rounded-lg text-sm font-medium text-[var(--color-noir)] hover:bg-black/5 transition-all flex items-center gap-1">
                                {{ auth()->user()->name }} <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="absolute right-0 mt-1 w-48 py-2 bg-white rounded-xl shadow-lg border border-black/5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <a href="{{ route('account.orders') }}" class="block px-4 py-2 text-sm hover:bg-[var(--color-creme)]">Mes commandes</a>
                                <a href="{{ route('wishlist.index') }}" class="block px-4 py-2 text-sm hover:bg-[var(--color-creme)]">Favoris</a>
                                <form action="{{ route('logout') }}" method="POST" class="block"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-[var(--color-creme)] text-red-600">Déconnexion</button></form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-[var(--color-noir)] hover:text-[var(--color-rose-fonce)] transition-colors">Connexion</a>
                        <a href="{{ route('register') }}" class="px-4 py-2.5 rounded-lg text-sm font-medium text-white bg-[var(--color-rose)] hover:bg-[var(--color-rose-fonce)] transition-all duration-300">Inscription</a>
                    @endauth
                </div>

                {{-- Mobile menu button --}}
                <button type="button" id="mobile-menu-btn" class="lg:hidden p-2 rounded-lg text-[var(--color-noir)]" aria-label="Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
            <div id="mobile-menu" class="hidden lg:hidden py-4 border-t border-black/5">
                <div class="flex flex-col gap-1">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg hover:bg-black/5">Accueil</a>
                    <a href="{{ route('shop.index') }}" class="px-4 py-2 rounded-lg hover:bg-black/5">Boutique</a>
                    <a href="{{ route('about') }}" class="px-4 py-2 rounded-lg hover:bg-black/5">À propos</a>
                    <a href="{{ route('contact') }}" class="px-4 py-2 rounded-lg hover:bg-black/5">Contact</a>
                    <a href="{{ route('faq') }}" class="px-4 py-2 rounded-lg hover:bg-black/5">FAQ</a>
                    <a href="{{ route('shipping') }}" class="px-4 py-2 rounded-lg hover:bg-black/5">Livraison</a>
                    <a href="{{ route('categories.index') }}" class="px-4 py-2 rounded-lg hover:bg-black/5">Nos catégories</a>
                    <a href="{{ route('legal') }}" class="px-4 py-2 rounded-lg hover:bg-black/5">Mentions légales</a>
                    <a href="{{ route('cart.index') }}" class="px-4 py-2 rounded-lg hover:bg-black/5 flex items-center gap-2">Panier @if($cartCount > 0)<span class="bg-[var(--color-rose)] text-white text-xs px-2 py-0.5 rounded-full">{{ $cartCount }}</span>@endif</a>
                    @auth
                        <a href="{{ route('account.orders') }}" class="px-4 py-2 rounded-lg hover:bg-black/5">Mes commandes</a>
                        <a href="{{ route('wishlist.index') }}" class="px-4 py-2 rounded-lg hover:bg-black/5">Favoris</a>
                        <form action="{{ route('logout') }}" method="POST"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button type="submit" class="w-full text-left px-4 py-2 rounded-lg hover:bg-black/5 text-red-600">Déconnexion</button></form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg hover:bg-black/5">Connexion</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg bg-[var(--color-rose)] text-white font-medium">Inscription</a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <div class="h-16 lg:h-18 flex-shrink-0"></div>

    @if(session('success'))
        <div class="bg-emerald-50 border-b border-emerald-200 text-emerald-800 px-4 py-3 flex items-center justify-between animate-fade-in" role="alert">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800">×</button>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border-b border-red-200 text-red-800 px-4 py-3 flex items-center justify-between animate-fade-in" role="alert">
            <span>{{ session('error') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">×</button>
        </div>
    @endif
    @if(session('status'))
        <div class="bg-sky-50 border-b border-sky-200 text-sky-800 px-4 py-3 flex items-center justify-between animate-fade-in" role="alert">
            <span>{{ session('status') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-sky-600 hover:text-sky-800">×</button>
        </div>
    @endif

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-[var(--color-noir)] text-gray-400 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8">
                <div class="col-span-2 lg:col-span-1">
                    <div class="font-display text-lg font-semibold text-white mb-3">{{ config('app.name') }}</div>
                    <p class="text-sm">Maquillage et cosmétiques premium. Produits soigneusement sélectionnés.</p>
                </div>
                <div>
                    <div class="font-semibold text-white mb-2">Boutique</div>
                    <ul class="space-y-1 text-sm">
                        <li><a href="{{ route('shop.index') }}" class="hover:text-[var(--color-rose)] transition-colors">Tous les produits</a></li>
                        <li><a href="{{ route('categories.index') }}" class="hover:text-[var(--color-rose)] transition-colors">Catégories</a></li>
                        <li><a href="{{ route('home') }}" class="hover:text-[var(--color-rose)] transition-colors">Accueil</a></li>
                    </ul>
                </div>
                <div>
                    <div class="font-semibold text-white mb-2">Informations</div>
                    <ul class="space-y-1 text-sm">
                        <li><a href="{{ route('about') }}" class="hover:text-[var(--color-rose)] transition-colors">À propos</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-[var(--color-rose)] transition-colors">Contact</a></li>
                        <li><a href="{{ route('faq') }}" class="hover:text-[var(--color-rose)] transition-colors">FAQ</a></li>
                        <li><a href="{{ route('shipping') }}" class="hover:text-[var(--color-rose)] transition-colors">Livraison</a></li>
                    </ul>
                </div>
                <div>
                    <div class="font-semibold text-white mb-2">Légal</div>
                    <ul class="space-y-1 text-sm">
                        <li><a href="{{ route('legal') }}" class="hover:text-[var(--color-rose)] transition-colors">Mentions légales</a></li>
                        <li><a href="{{ route('sitemap') }}" class="hover:text-[var(--color-rose)] transition-colors">Plan du site</a></li>
                    </ul>
                </div>
            </div>
            <hr class="border-gray-700 my-8">
            <div class="flex flex-wrap justify-between items-center text-sm gap-4">
                <span>&copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</span>
                <span>contact@glowbeauty.fr</span>
            </div>
        </div>
    </footer>

    <script>
    document.querySelectorAll('img[data-fallback]').forEach(function(img) {
        img.addEventListener('error', function() { this.style.display = 'none'; });
    });
    document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
    window.addEventListener('scroll', function() {
        var nav = document.getElementById('main-nav');
        if (window.scrollY > 20) nav.classList.add('shadow-md'); else nav.classList.remove('shadow-md');
    });
    (function() {
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, { rootMargin: '0px 0px -60px 0px', threshold: 0.08 });
        document.querySelectorAll('.reveal, .reveal-strong').forEach(function(el) { observer.observe(el); });
    })();
    </script>
    @stack('scripts')
</body>
</html>
