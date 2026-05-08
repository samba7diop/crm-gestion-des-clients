@extends('layouts.app')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Modifier la facture</h1>
                <p class="text-sm text-slate-500">Actualisez les détails de la facture.</p>
            </div>
            <a href="{{ route('invoices.index') }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200">Retour</a>
        </div>

        <form action="{{ route('invoices.update', $invoice) }}" method="POST" class="space-y-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700">Devis</label>
                <select name="quote_id" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                    <option value="">Sélectionner un devis</option>
                    @foreach($quotes as $quote)
                        <option value="{{ $quote->id }}"{{ old('quote_id', $invoice->quote_id) == $quote->id ? ' selected' : '' }}>#{{ $quote->id }} - {{ $quote->contact->nom ?? 'Client' }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Numéro</label>
                    <input type="text" name="numero" value="{{ old('numero', $invoice->numero) }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Montant</label>
                    <input type="number" step="0.01" name="montant" value="{{ old('montant', $invoice->montant) }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Date d'échéance</label>
                    <input type="date" name="date_echeance" value="{{ old('date_echeance', optional($invoice->date_echeance)->format('Y-m-d')) }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Statut de paiement</label>
                    <select name="statut_paiement" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                        <option value="en_attente"{{ old('statut_paiement', $invoice->statut_paiement) === 'en_attente' ? ' selected' : '' }}>En attente</option>
                        <option value="paye"{{ old('statut_paiement', $invoice->statut_paiement) === 'paye' ? ' selected' : '' }}>Payé</option>
                        <option value="en_retard"{{ old('statut_paiement', $invoice->statut_paiement) === 'en_retard' ? ' selected' : '' }}>En retard</option>
                        <option value="annule"{{ old('statut_paiement', $invoice->statut_paiement) === 'annule' ? ' selected' : '' }}>Annulé</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="rounded-md bg-slate-900 px-5 py-2 text-sm font-medium text-white hover:bg-slate-700">Mettre à jour</button>
            </div>
        </form>
    </div>
@endsection
