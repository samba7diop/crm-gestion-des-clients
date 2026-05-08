@extends('layouts.app')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Nouvelle opportunité</h1>
                <p class="text-sm text-slate-500">Ajoutez une nouvelle opportunité dans le pipeline.</p>
            </div>
            <a href="{{ route('opportunities.index') }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200">Retour</a>
        </div>

        <form action="{{ route('opportunities.store') }}" method="POST" class="space-y-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Titre</label>
                    <input type="text" name="titre" value="{{ old('titre') }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Contact</label>
                    <select name="contact_id" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                        <option value="">Sélectionner un contact</option>
                        @foreach($contacts as $contact)
                            <option value="{{ $contact->id }}"{{ old('contact_id') == $contact->id ? ' selected' : '' }}>{{ $contact->nom }} @if($contact->entreprise)({{ $contact->entreprise }})@endif</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Valeur (€)</label>
                    <input type="number" step="0.01" name="valeur" value="{{ old('valeur', 0) }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Probabilité (%)</label>
                    <input type="number" min="0" max="100" name="probabilite" value="{{ old('probabilite', 0) }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Étape</label>
                    <input type="text" name="etape" value="{{ old('etape') }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Date de clôture</label>
                    <input type="date" name="date_cloture" value="{{ old('date_cloture') }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Commercial</label>
                    <select name="commercial_id" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
                        <option value="">Non assigné</option>
                        @foreach($commercials as $commercial)
                            <option value="{{ $commercial->id }}"{{ old('commercial_id') == $commercial->id ? ' selected' : '' }}>{{ $commercial->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="rounded-md bg-slate-900 px-5 py-2 text-sm font-medium text-white hover:bg-slate-700">Enregistrer</button>
            </div>
        </form>
    </div>
@endsection
