@extends('layouts.app')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Nouvelle campagne</h1>
                <p class="text-sm text-slate-500">Configurez une campagne marketing.</p>
            </div>
            <a href="{{ route('campaigns.index') }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200">Retour</a>
        </div>

        <form action="{{ route('campaigns.store') }}" method="POST" class="space-y-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nom</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Type</label>
                    <select name="type" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                        <option value="newsletter"{{ old('type') === 'newsletter' ? ' selected' : '' }}>Newsletter</option>
                        <option value="promotion"{{ old('type') === 'promotion' ? ' selected' : '' }}>Promotion</option>
                        <option value="relance"{{ old('type') === 'relance' ? ' selected' : '' }}>Relance</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Statut</label>
                    <select name="statut" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                        <option value="draft"{{ old('statut', 'draft') === 'draft' ? ' selected' : '' }}>Brouillon</option>
                        <option value="active"{{ old('statut') === 'active' ? ' selected' : '' }}>Active</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Template ID</label>
                <input type="number" name="template_id" value="{{ old('template_id') }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
                <p class="mt-2 text-xs text-slate-500">Identifiant du template d'email si disponible.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Destinataires</label>
                <select name="destinataires[]" multiple class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                    @foreach($contacts as $contact)
                        <option value="{{ $contact->id }}"{{ collect(old('destinataires'))->contains($contact->id) ? ' selected' : '' }}>{{ $contact->nom }} @if($contact->entreprise)({{ $contact->entreprise }})@endif</option>
                    @endforeach
                </select>
                <p class="mt-2 text-xs text-slate-500">Sélectionnez plusieurs contacts avec Ctrl / Cmd.</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Date d'envoi</label>
                    <input type="datetime-local" name="date_envoi" value="{{ old('date_envoi') }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="rounded-md bg-slate-900 px-5 py-2 text-sm font-medium text-white hover:bg-slate-700">Enregistrer</button>
            </div>
        </form>
    </div>
@endsection
