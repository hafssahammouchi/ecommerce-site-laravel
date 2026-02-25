@extends('layouts.admin')

@section('title', 'Modifier le service')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Modifier {{ $service->name }}</h1>
    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">Retour</a>
</div>
<div class="card">
    <div class="card-body">
        @if($service->image)
        <p class="small text-muted">Image actuelle : <a href="{{ Storage::url($service->image) }}" target="_blank">Voir</a></p>
        @endif
        <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nom</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $service->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $service->slug) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Description courte</label>
                    <textarea name="description" class="form-control" rows="2">{{ old('description', $service->description) }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Contenu</label>
                    <textarea name="content" class="form-control" rows="4">{{ old('content', $service->content) }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Prix (€)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $service->price) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Icône</label>
                    <input type="text" name="icon" class="form-control" value="{{ old('icon', $service->icon) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nouvelle image (optionnel)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Ordre</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $service->sort_order) }}" min="0">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', $service->is_active) ? 'checked' : '' }}><label class="form-check-label" for="is_active">Actif</label></div>
                </div>
                <div class="col-12"><button type="submit" class="btn btn-primary">Enregistrer</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
