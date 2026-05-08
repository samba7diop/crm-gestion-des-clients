@extends('layouts.app')

@section('content')
    <div class="max-w-4xl">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Facture #{{ $invoice->numero }}</h1>
                <p class="text-sm text-slate-500">Détails de la facture et statut de paiement.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('invoices.edit', $invoice) }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200">Modifier</a>
                <a href="{{ route('invoices.index') }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200">Retour</a>
            </div>
        </div>

        <div class="space-y-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <h2 class="text-sm font-semibold text-slate-500">Client</h2>
                    <p class="mt-2 text-base font-medium text-slate-900">{{ $invoice->quote->contact->nom ?? 'Client' }}</p>
                    <p class="text-sm text-slate-600">{{ $invoice->quote->contact->email ?? 'Pas d\'email' }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-slate-500">Devis lié</h2>
                    <p class="mt-2 text-base font-medium text-slate-900">#{{ $invoice->quote->id }}</p>
                    <p class="text-sm text-slate-600">Montant devis : {{ number_format($invoice->quote->montant, 2, ',', ' ') }} €</p>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-3">
                <div>
                    <h2 class="text-sm font-semibold text-slate-500">Numéro</h2>
                    <p class="mt-2 text-base font-medium text-slate-900">{{ $invoice->numero }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-slate-500">Montant</h2>
                    <p class="mt-2 text-base font-medium text-slate-900">{{ number_format($invoice->montant, 2, ',', ' ') }} €</p>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-slate-500">Échéance</h2>
                    <p class="mt-2 text-base font-medium text-slate-900">{{ optional($invoice->date_echeance)->format('d/m/Y') }}</p>
                </div>
            </div>

            <div>
                <h2 class="text-sm font-semibold text-slate-500">Statut de paiement</h2>
                <p class="mt-2 text-base font-medium text-slate-900">{{ ucfirst(str_replace('_', ' ', $invoice->statut_paiement)) }}</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <h2 class="text-sm font-semibold text-slate-500">Total TTC devis</h2>
                    <p class="mt-2 text-base font-medium text-slate-900">{{ number_format($invoice->quote->total_ttc, 2, ',', ' ') }} €</p>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-slate-500">Validité du devis</h2>
                    <p class="mt-2 text-base font-medium text-slate-900">{{ optional($invoice->quote->date_validite)->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
