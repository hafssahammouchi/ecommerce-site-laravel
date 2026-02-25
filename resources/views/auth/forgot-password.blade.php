@extends('layouts.app')

@section('title', 'Mot de passe oublié')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="h4 mb-4">Réinitialiser le mot de passe</h2>
                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif
                    @if($errors->has('email'))
                        <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                    @endif
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Envoyer le lien</button>
                    </form>
                    <p class="mt-3 mb-0 text-center small"><a href="{{ route('login') }}">Retour à la connexion</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
