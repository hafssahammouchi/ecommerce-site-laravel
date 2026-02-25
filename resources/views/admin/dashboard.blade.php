@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<h1 class="h3 mb-4">Tableau de bord</h1>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 bg-primary bg-opacity-10 p-3 me-3"><i class="bi bi-people text-primary fs-4"></i></div>
                    <div>
                        <h6 class="text-muted mb-0">Utilisateurs</h6>
                        <h3 class="mb-0">{{ $stats['users'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 bg-success bg-opacity-10 p-3 me-3"><i class="bi bi-folder text-success fs-4"></i></div>
                    <div>
                        <h6 class="text-muted mb-0">Catégories</h6>
                        <h3 class="mb-0">{{ $stats['categories'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 bg-info bg-opacity-10 p-3 me-3"><i class="bi bi-box-seam text-info fs-4"></i></div>
                    <div>
                        <h6 class="text-muted mb-0">Produits</h6>
                        <h3 class="mb-0">{{ $stats['products'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 bg-warning bg-opacity-10 p-3 me-3"><i class="bi bi-briefcase text-warning fs-4"></i></div>
                    <div>
                        <h6 class="text-muted mb-0">Services</h6>
                        <h3 class="mb-0">{{ $stats['services'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 bg-secondary bg-opacity-10 p-3 me-3"><i class="bi bi-cart-check text-secondary fs-4"></i></div>
                    <div>
                        <h6 class="text-muted mb-0">Commandes</h6>
                        <h3 class="mb-0">{{ $stats['orders'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 bg-success bg-opacity-10 p-3 me-3"><i class="bi bi-currency-euro text-success fs-4"></i></div>
                    <div>
                        <h6 class="text-muted mb-0">Chiffre d'affaires</h6>
                        <h3 class="mb-0">{{ number_format($stats['revenue'] ?? 0, 0) }} €</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Dernières commandes</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>N°</th><th>Client</th><th>Total</th><th>Statut</th><th>Date</th></tr></thead>
                    <tbody>
                        @forelse($recentOrders ?? [] as $o)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $o) }}">{{ $o->number }}</a></td>
                            <td>{{ $o->customer_email }}</td>
                            <td>{{ number_format($o->total, 2) }} €</td>
                            <td><span class="badge bg-{{ $o->status === 'paid' ? 'success' : ($o->status === 'pending' ? 'warning' : 'secondary') }}">{{ $o->status }}</span></td>
                            <td>{{ $o->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-muted">Aucune commande</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-white"><h5 class="mb-0">Derniers utilisateurs</h5></div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Nom</th><th>Email</th><th>Rôle</th></tr></thead>
                    <tbody>
                        @forelse($recentUsers as $u)
                        <tr><td>{{ $u->name }}</td><td>{{ $u->email }}</td><td><span class="badge bg-{{ $u->role === 'admin' ? 'danger' : 'secondary' }}">{{ $u->role }}</span></td></tr>
                        @empty
                        <tr><td colspan="3" class="text-muted">Aucun utilisateur</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-white"><h5 class="mb-0">Derniers produits</h5></div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Produit</th><th>Catégorie</th><th>Prix</th></tr></thead>
                    <tbody>
                        @forelse($recentProducts as $p)
                        <tr><td>{{ $p->name }}</td><td>{{ $p->category->name ?? '-' }}</td><td>{{ number_format($p->final_price, 2) }} €</td></tr>
                        @empty
                        <tr><td colspan="3" class="text-muted">Aucun produit</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
