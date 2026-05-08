@extends('layouts.app')

@section('content')
    <div class="max-w-3xl space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Détails du contact</h1>
                <p class="text-sm text-slate-500">Toutes les informations liées au contact.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('contacts.edit', $contact) }}" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Modifier</a>
                <a href="{{ route('contacts.index') }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200">Retour</a>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <dl class="grid gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-slate-500">Nom</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ $contact->nom }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Entreprise</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ $contact->entreprise ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Email</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ $contact->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Téléphone</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ $contact->telephone ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Statut</dt>
                    <dd class="mt-1 text-base text-slate-900 capitalize">{{ $contact->statut }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Commercial</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ $contact->commercial?->name ?? 'Non assigné' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Secteur</dt>
                    <dd class="mt-1 text-base text-slate-900 capitalize">{{ $contact->secteur ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Taille entreprise</dt>
                    <dd class="mt-1 text-base text-slate-900 capitalize">{{ $contact->taille ?? '—' }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-slate-500">Tags</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ is_array($contact->tags) ? implode(', ', $contact->tags) : '—' }}</dd>
                </div>
            </dl>
        </div>
    </div>
@endsection
