@extends('layouts.app')

@section('content')
    <div class="max-w-3xl space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Campagne : {{ $campaign->nom }}</h1>
                <p class="text-sm text-slate-500">Détails de la campagne.</p>
            </div>
            <a href="{{ route('campaigns.index') }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200">Retour</a>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <dl class="grid gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-slate-500">Type</dt>
                    <dd class="mt-1 text-base text-slate-900 capitalize">{{ $campaign->type }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Statut</dt>
                    <dd class="mt-1 text-base text-slate-900">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $campaign->statut === 'active' ? 'bg-green-100 text-green-800' :
                               ($campaign->statut === 'draft' ? 'bg-yellow-100 text-yellow-800' :
                               ($campaign->statut === 'envoyee' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')) }}">
                            {{ ucfirst($campaign->statut) }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Template ID</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ $campaign->template_id ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Date d'envoi</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ optional($campaign->date_envoi)->format('d/m/Y H:i') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Destinataires</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ count($recipients) }}</dd>
                </div>
            </dl>

            <div class="mt-6">
                <h2 class="text-lg font-semibold text-slate-900">Destinataires</h2>
                <ul class="mt-4 space-y-2 text-sm text-slate-700">
                    @forelse($recipients as $recipient)
                        <li>{{ $recipient->nom }} @if($recipient->entreprise)({{ $recipient->entreprise }})@endif</li>
                    @empty
                        <li>Aucun destinataire associé.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
