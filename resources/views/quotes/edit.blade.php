@extends('layouts.app')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Modifier le devis</h1>
                <p class="text-sm text-slate-500">Mettez à jour les informations du devis.</p>
            </div>
            <a href="{{ route('quotes.index') }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200">Retour</a>
        </div>

        <form action="{{ route('quotes.update', $quote) }}" method="POST" class="space-y-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700">Contact</label>
                <select name="contact_id" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                    <option value="">Sélectionner un contact</option>
                    @foreach($contacts as $contact)
                        <option value="{{ $contact->id }}"{{ old('contact_id', $quote->contact_id) == $contact->id ? ' selected' : '' }}>{{ $contact->nom }} @if($contact->entreprise)({{ $contact->entreprise }})@endif</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Lignes (JSON)</label>
                <textarea name="lignes" rows="5" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">{{ old('lignes', json_encode($quote->lignes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) }}</textarea>
                <p class="mt-2 text-xs text-slate-500">Entrez un tableau JSON de lignes.</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-3">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Total HT</label>
                    <input type="number" step="0.01" name="total_ht" value="{{ old('total_ht', $quote->total_ht) }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">TVA (%)</label>
                    <input type="number" step="0.01" name="tva" value="{{ old('tva', $quote->tva) }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Total TTC</label>
                    <input type="number" step="0.01" name="total_ttc" value="{{ old('total_ttc', $quote->total_ttc) }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Statut</label>
                    <select name="statut" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                        <option value="brouillon"{{ old('statut', $quote->statut) === 'brouillon' ? ' selected' : '' }}>Brouillon</option>
                        <option value="envoye"{{ old('statut', $quote->statut) === 'envoye' ? ' selected' : '' }}>Envoyé</option>
                        <option value="accepte"{{ old('statut', $quote->statut) === 'accepte' ? ' selected' : '' }}>Accepté</option>
                        <option value="refuse"{{ old('statut', $quote->statut) === 'refuse' ? ' selected' : '' }}>Refusé</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Date validité</label>
                    <input type="date" name="date_validite" value="{{ old('date_validite', optional($quote->date_validite)->format('Y-m-d')) }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="rounded-md bg-slate-900 px-5 py-2 text-sm font-medium text-white hover:bg-slate-700">Mettre à jour</button>
            </div>
        </form>
    </div>
@endsection
