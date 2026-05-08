@extends('layouts.app')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Nouvelle activité</h1>
                <p class="text-sm text-slate-500">Enregistrez un appel, un email, une réunion ou une tâche.</p>
            </div>
            <a href="{{ route('activities.index') }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200">Retour</a>
        </div>

        <form action="{{ route('activities.store') }}" method="POST" class="space-y-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700">Contact</label>
                <select name="contact_id" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                    <option value="">Sélectionner un contact</option>
                    @foreach($contacts as $contact)
                        <option value="{{ $contact->id }}"{{ old('contact_id') == $contact->id ? ' selected' : '' }}>{{ $contact->nom }} @if($contact->entreprise)({{ $contact->entreprise }})@endif</option>
                    @endforeach
                </select>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Type</label>
                    <select name="type" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                        <option value="appel"{{ old('type') === 'appel' ? ' selected' : '' }}>Appel</option>
                        <option value="email"{{ old('type') === 'email' ? ' selected' : '' }}>Email</option>
                        <option value="reunion"{{ old('type') === 'reunion' ? ' selected' : '' }}>Réunion</option>
                        <option value="tache"{{ old('type') === 'tache' ? ' selected' : '' }}>Tâche</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Date</label>
                    <input type="datetime-local" name="date" value="{{ old('date') }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Description</label>
                <textarea name="description" rows="4" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>{{ old('description') }}</textarea>
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
                <div class="flex items-end">
                    <label class="inline-flex items-center gap-2 text-sm font-medium text-slate-700">
                        <input type="checkbox" name="rappel" class="h-4 w-4 rounded border-slate-300 text-slate-900" {{ old('rappel') ? 'checked' : '' }}>
                        Rappel
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Résultat</label>
                <textarea name="resultat" rows="3" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">{{ old('resultat') }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="rounded-md bg-slate-900 px-5 py-2 text-sm font-medium text-white hover:bg-slate-700">Enregistrer</button>
            </div>
        </form>
    </div>
@endsection
