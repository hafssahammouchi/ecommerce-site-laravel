@extends('layouts.admin')

@section('title', 'Modifier la catégorie')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Modifier {{ $category->name }}</h1>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Retour</a>
</div>
<div class="card">
    <div class="card-body">
        @if($category->image)
        <p class="small text-muted">Image actuelle : <a href="{{ Storage::url($category->image) }}" target="_blank">Voir</a></p>
        @endif
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nom</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="2">{{ old('description', $category->description) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nouvelle image (optionnel)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Ordre</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $category->sort_order) }}" min="0">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', $category->is_active) ? 'checked' : '' }}><label class="form-check-label" for="is_active">Active</label></div>
                </div>
                <div class="col-12"><button type="submit" class="btn btn-primary">Enregistrer</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
