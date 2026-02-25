@extends('layouts.admin')

@section('title', 'Catégories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Catégories</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Nouvelle</a>
</div>
<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Rechercher" value="{{ request('search') }}">
            </div>
            <div class="col"><button type="submit" class="btn btn-outline-primary">Filtrer</button></div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>ID</th><th>Nom</th><th>Slug</th><th>Produits</th><th>Actif</th><th>Ordre</th><th width="140">Actions</th></tr></thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr>
                        <td>{{ $cat->id }}</td>
                        <td>{{ $cat->name }}</td>
                        <td><code>{{ $cat->slug }}</code></td>
                        <td>{{ $cat->products_count }}</td>
                        <td>@if($cat->is_active)<span class="badge bg-success">Oui</span>@else<span class="badge bg-secondary">Non</span>@endif</td>
                        <td>{{ $cat->sort_order }}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                            <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette catégorie ?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Suppr.</button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-muted">Aucune catégorie</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
