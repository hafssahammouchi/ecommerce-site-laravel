<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .admin-sidebar { min-height: calc(100vh - 56px); background: #1a1d29; width: 220px; }
        .admin-sidebar .nav-link { color: #adb5bd; padding: 0.75rem 1rem; }
        .admin-sidebar .nav-link:hover, .admin-sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,0.1); }
        .admin-content { flex: 1; background: #f8f9fa; }
        .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); }
        .table th { font-weight: 600; }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}"><i class="bi bi-gear"></i> Administration</a>
            <div class="d-flex align-items-center text-light">
                <span class="me-3">{{ auth()->user()->name }}</span>
                <a class="btn btn-outline-light btn-sm" href="{{ route('home') }}">Voir le site</a>
                <form action="{{ route('logout') }}" method="POST" class="ms-2 d-inline">@csrf<button type="submit" class="btn btn-outline-danger btn-sm">Déconnexion</button></form>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <aside class="admin-sidebar">
            <nav class="nav flex-column pt-2">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Tableau de bord</a>
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="bi bi-people me-2"></i> Utilisateurs</a>
                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}"><i class="bi bi-folder me-2"></i> Catégories</a>
                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}"><i class="bi bi-box-seam me-2"></i> Produits</a>
                <a class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}" href="{{ route('admin.services.index') }}"><i class="bi bi-briefcase me-2"></i> Services</a>
                <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}"><i class="bi bi-cart-check me-2"></i> Commandes</a>
                <a class="nav-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}" href="{{ route('admin.contact.index') }}"><i class="bi bi-envelope me-2"></i> Messages contact</a>
            </nav>
        </aside>
        <main class="admin-content p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
