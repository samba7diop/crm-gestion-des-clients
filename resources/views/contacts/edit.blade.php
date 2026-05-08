@extends('layouts.app')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Modifier le contact</h1>
                <p class="text-sm text-slate-500">Mettez à jour les informations client.</p>
            </div>
            <a href="{{ route('contacts.index') }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200">Retour</a>
        </div>

        <form action="{{ route('contacts.update', $contact) }}" method="POST" class="space-y-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf
            @method('PUT')

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nom</label>
                    <input type="text" name="nom" value="{{ old('nom', $contact->nom) }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $contact->email) }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Entreprise</label>
                    <input type="text" name="entreprise" value="{{ old('entreprise', $contact->entreprise) }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Téléphone</label>
                    <input type="text" name="telephone" value="{{ old('telephone', $contact->telephone) }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Source</label>
                    <input type="text" name="source" value="{{ old('source', $contact->source) }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Statut</label>
                    <select name="statut" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                        <option value="prospect"{{ old('statut', $contact->statut) === 'prospect' ? ' selected' : '' }}>Prospect</option>
                        <option value="client"{{ old('statut', $contact->statut) === 'client' ? ' selected' : '' }}>Client</option>
                        <option value="ancien_client"{{ old('statut', $contact->statut) === 'ancien_client' ? ' selected' : '' }}>Ancien client</option>
                    </select>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Score</label>
                    <input type="number" name="score" min="0" max="100" value="{{ old('score', $contact->score) }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Commercial</label>
                    <select name="commercial_id" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
                        <option value="">Non assigné</option>
                        @foreach($commercials as $commercial)
                            <option value="{{ $commercial->id }}"{{ old('commercial_id', $contact->commercial_id) == $commercial->id ? ' selected' : '' }}>{{ $commercial->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Tags (séparés par des virgules)</label>
                <input type="text" name="tags" value="{{ old('tags', is_array($contact->tags) ? implode(', ', $contact->tags) : '') }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('contacts.index') }}" class="rounded-md border border-slate-200 px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">Annuler</a>
                <button type="submit" class="rounded-md bg-slate-900 px-5 py-2 text-sm font-medium text-white hover:bg-slate-700">Mettre à jour</button>
            </div>
        </form>
    </div>
@endsection
