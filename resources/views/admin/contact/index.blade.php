@extends('layouts.admin')

@section('title', 'Messages contact')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Messages contact</h1>
</div>
<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Rechercher (nom, email, message)" value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Tous les statuts</option>
                    <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>Nouveau</option>
                    <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Lu</option>
                    <option value="replied" {{ request('status') === 'replied' ? 'selected' : '' }}>Répondu</option>
                </select>
            </div>
            <div class="col"><button type="submit" class="btn btn-outline-primary">Filtrer</button></div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>Date</th><th>Nom</th><th>Email</th><th>Sujet</th><th>Statut</th><th></th></tr></thead>
                <tbody>
                    @forelse($messages as $msg)
                    <tr class="{{ $msg->status === 'new' ? 'table-light' : '' }}">
                        <td>{{ $msg->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $msg->name }}</td>
                        <td>{{ $msg->email }}</td>
                        <td>{{ Str::limit($msg->subject, 30) }}</td>
                        <td><span class="badge bg-{{ $msg->status === 'new' ? 'warning' : ($msg->status === 'replied' ? 'success' : 'secondary') }}">{{ $msg->status }}</span></td>
                        <td><a href="{{ route('admin.contact.show', $msg) }}" class="btn btn-sm btn-outline-primary">Voir</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-muted">Aucun message.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
