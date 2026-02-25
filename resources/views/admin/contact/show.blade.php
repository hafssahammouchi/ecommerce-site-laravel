@extends('layouts.admin')

@section('title', 'Message de ' . $contact->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Message reçu</h1>
    <a href="{{ route('admin.contact.index') }}" class="btn btn-outline-secondary">Retour</a>
</div>
<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6"><strong>De</strong> {{ $contact->name }}</div>
            <div class="col-md-6"><strong>Email</strong> <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></div>
        </div>
        <div class="mb-3"><strong>Sujet</strong> {{ $contact->subject }}</div>
        <div class="mb-2"><strong>Reçu le</strong> {{ $contact->created_at->format('d/m/Y à H:i') }}</div>
        <hr>
        <div class="mb-0"><strong>Message</strong></div>
        <div class="p-3 bg-light rounded mt-2">{{ nl2br(e($contact->message)) }}</div>
    </div>
</div>
@endsection
