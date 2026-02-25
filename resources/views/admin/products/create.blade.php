@extends('layouts.admin')

@section('title', 'Nouveau produit')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Nouveau produit</h1>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Retour</a>
</div>
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Catégorie</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $c)<option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nom</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Prix (€)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Prix promo (€)</label>
                    <input type="number" step="0.01" name="sale_price" class="form-control" value="{{ old('sale_price') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">SKU</label>
                    <input type="text" name="sku" class="form-control" value="{{ old('sku') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" min="0" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" checked><label class="form-check-label" for="is_active">Actif</label></div>
                    <div class="form-check"><input type="checkbox" name="is_featured" value="1" class="form-check-input" id="is_featured"><label class="form-check-label" for="is_featured">À la une</label></div>
                </div>
                <div class="col-12"><button type="submit" class="btn btn-primary">Créer</button></div>
            </div>
        </form>
    </div>
</div>
@endsection
