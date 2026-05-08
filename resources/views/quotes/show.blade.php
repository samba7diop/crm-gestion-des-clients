@extends('layouts.app')

@section('content')
    <div class="max-w-3xl space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Devis #{{ $quote->id }}</h1>
                <p class="text-sm text-slate-500">Détails du devis.</p>
            </div>
            <a href="{{ route('quotes.index') }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200">Retour</a>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-slate-500">Contact</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ $quote->contact->nom ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Entreprise</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ $quote->contact->entreprise ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Statut</dt>
                    <dd class="mt-1 text-base text-slate-900 capitalize">{{ $quote->statut }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Validité</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ optional($quote->date_validite)->format('d/m/Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Total HT</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ number_format($quote->total_ht, 2, ',', ' ') }} €</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Total TTC</dt>
                    <dd class="mt-1 text-base text-slate-900">{{ number_format($quote->total_ttc, 2, ',', ' ') }} €</dd>
                </div>
            </div>

            <div class="mt-6">
                <h2 class="text-lg font-semibold text-slate-900">Lignes</h2>
                <div class="mt-4 space-y-3">
                    @foreach($quote->lignes as $line)
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-sm text-slate-700"><strong>Description :</strong> {{ $line['description'] ?? '—' }}</p>
                            <p class="text-sm text-slate-700"><strong>Quantité :</strong> {{ $line['quantite'] ?? '—' }}</p>
                            <p class="text-sm text-slate-700"><strong>Prix :</strong> {{ isset($line['prix']) ? number_format($line['prix'], 2, ',', ' ') . ' €' : '—' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
