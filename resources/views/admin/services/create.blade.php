@extends('layouts.admin')

@section('title', 'Nouveau service')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Nouveau service</h1>
    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">Retour</a>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nom</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Slug (optionnel)</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Description courte</label>
                    <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Contenu</label>
                    <textarea name="content" class="form-control" rows="4">{{ old('content') }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Prix (€)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Icône (Bootstrap Icons, ex: bi-star)</label>
                    <input type="text" name="icon" class="form-control" value="{{ old('icon', 'bi-star') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Ordre</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" checked><label class="form-check-label" for="is_active">Actif</label></div>
                </div>
                <div class="col-12"><button type="submit" class="btn btn-primary">Créer</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
