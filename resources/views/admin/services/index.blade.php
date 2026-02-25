@extends('layouts.admin')

@section('title', 'Services')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Services</h1>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Nouveau</a>
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
                <thead><tr><th>ID</th><th>Nom</th><th>Slug</th><th>Prix</th><th>Ordre</th><th>Actif</th><th width="140">Actions</th></tr></thead>
                <tbody>
                    @forelse($services as $s)
                    <tr>
                        <td>{{ $s->id }}</td>
                        <td>{{ $s->name }}</td>
                        <td><code>{{ $s->slug }}</code></td>
                        <td>{{ $s->price ? number_format($s->price, 2) . ' €' : '-' }}</td>
                        <td>{{ $s->sort_order }}</td>
                        <td>@if($s->is_active)<span class="badge bg-success">Oui</span>@else<span class="badge bg-secondary">Non</span>@endif</td>
                        <td>
                            <a href="{{ route('admin.services.edit', $s) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                            <form action="{{ route('admin.services.destroy', $s) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce service ?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Suppr.</button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-muted">Aucun service</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
