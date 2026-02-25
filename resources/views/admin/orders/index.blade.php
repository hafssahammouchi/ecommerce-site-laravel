@extends('layouts.admin')

@section('title', 'Commandes')

@section('content')
<h1 class="h3 mb-4">Commandes</h1>

<form method="GET" class="row g-2 mb-4">
    <div class="col-auto">
        <input type="text" name="q" class="form-control form-control-sm" placeholder="N° ou email..." value="{{ request('q') }}">
    </div>
    <div class="col-auto">
        <select name="status" class="form-select form-select-sm">
            <option value="">Tous les statuts</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Payé</option>
            <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Expédié</option>
            <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Livré</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Annulé</option>
        </select>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary btn-sm">Filtrer</button>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Client</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><a href="{{ route('admin.orders.show', $order) }}">{{ $order->number }}</a></td>
                    <td>{{ $order->customer_email }}</td>
                    <td>{{ number_format($order->total, 2) }} €</td>
                    <td><span class="badge bg-{{ $order->status === 'paid' ? 'success' : ($order->status === 'pending' ? 'warning' : 'secondary') }}">{{ $order->status }}</span></td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Voir</a></td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-muted">Aucune commande</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
