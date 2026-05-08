@extends('layouts.app')

@section('content')
    <div class="max-w-3xl space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Activité</h1>
                <p class="text-sm text-slate-500">Détails de l'activité.</p>
            </div>
            <a href="{{ route('activities.index') }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200">Retour</a>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <dl class="grid gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-slate-500">Contact</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ $activity->contact->nom ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Type</dt>
                    <dd class="mt-1 text-base text-slate-900 capitalize">{{ $activity->type }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Date</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ optional($activity->date)->format('d/m/Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Commercial</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ $activity->commercial?->name ?? 'Non assigné' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Rappel</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ $activity->rappel ? 'Oui' : 'Non' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Résultat</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ $activity->resultat ?? '—' }}</dd>
                </div>
            </dl>

            <div class="mt-6">
                <h2 class="text-lg font-semibold text-slate-900">Description</h2>
                <p class="mt-2 text-slate-700">{{ $activity->description }}</p>
            </div>
        </div>
    </div>
@endsection
