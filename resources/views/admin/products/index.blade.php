@extends('layouts.admin')

@section('title', 'Produits')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Produits</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Nouveau</a>
</div>
<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Rechercher (nom, SKU)" value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-select">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col"><button type="submit" class="btn btn-outline-primary">Filtrer</button></div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>ID</th><th>Image</th><th>Nom</th><th>Catégorie</th><th>Prix</th><th>Stock</th><th>Actif</th><th width="140">Actions</th></tr></thead>
                <tbody>
                    @forelse($products as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>@if($p->image)<img src="{{ Storage::url($p->image) }}" alt="" style="width:40px;height:40px;object-fit:cover" class="rounded">@else<span class="text-muted">-</span>@endif</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->category->name ?? '-' }}</td>
                        <td>{{ number_format($p->final_price, 2) }} €</td>
                        <td>{{ $p->stock }}</td>
                        <td>@if($p->is_active)<span class="badge bg-success">Oui</span>@else<span class="badge bg-secondary">Non</span>@endif</td>
                        <td>
                            <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                            <form action="{{ route('admin.products.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce produit ?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Suppr.</button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-muted">Aucun produit</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
