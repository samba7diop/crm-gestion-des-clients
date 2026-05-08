@extends('layouts.app')

@section('content')
    <div class="max-w-3xl space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Opportunité : {{ $opportunity->titre }}</h1>
                <p class="text-sm text-slate-500">Détails de l'opportunité.</p>
            </div>
            <a href="{{ route('opportunities.index') }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200">Retour</a>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <dl class="grid gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-slate-500">Contact</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ $opportunity->contact->nom ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Entreprise</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ $opportunity->contact->entreprise ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Valeur</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ number_format($opportunity->valeur, 2, ',', ' ') }} €</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Probabilité</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ $opportunity->probabilite }} %</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Étape</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ ucfirst($opportunity->etape) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Commercial</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ $opportunity->commercial?->name ?? 'Non assigné' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Date de clôture</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ optional($opportunity->date_cloture)->format('d/m/Y') ?? '—' }}</dd>
                </div>
            </dl>
        </div>
    </div>
@endsection
