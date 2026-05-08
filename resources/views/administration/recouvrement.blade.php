@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Recouvrement</h1>
                <p class="text-sm text-slate-500">Factures échues à suivre (en attente / en retard).</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('invoices.index') }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200">Voir toutes les factures</a>
                <a href="{{ route('invoices.export.fec') }}" class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">Export FEC</a>
            </div>
        </div>
           
        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">En attente</p>
                <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $stats['pending'] }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">En retard</p>
                <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $stats['overdue'] }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Total à encaisser</p>
                <p class="mt-2 text-2xl font-semibold text-slate-900">{{ number_format($stats['total_due'] ?? 0, 2, ',', ' ') }} €</p>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-slate-200 p-4 sm:flex-row sm:items-center sm:justify-between">
                <form method="GET" class="flex flex-wrap items-center gap-2">
                    <select name="statut_paiement" class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900">
                        <option value="">En attente + En retard</option>
                        <option value="en_attente"{{ request('statut_paiement') === 'en_attente' ? ' selected' : '' }}>En attente</option>
                        <option value="en_retard"{{ request('statut_paiement') === 'en_retard' ? ' selected' : '' }}>En retard</option>
                    </select>
                    <button class="rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Filtrer</button>
                    <a href="{{ route('administration.recouvrement') }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200">Réinitialiser</a>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-slate-700">Numéro</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Client</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Montant</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Échéance</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Statut</th>
                            <th class="px-4 py-3 font-semibold text-slate-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse($invoices as $invoice)
                            <tr>
                                <td class="px-4 py-4 text-slate-900">{{ $invoice->numero }}</td>
                                <td class="px-4 py-4 text-slate-700">
                                    <div class="font-medium">{{ $invoice->quote?->contact?->nom ?? '—' }}</div>
                                    <div class="text-xs text-slate-500">{{ $invoice->quote?->contact?->email ?? '' }}</div>
                                </td>
                                <td class="px-4 py-4 text-slate-700">{{ number_format($invoice->montant, 2, ',', ' ') }} €</td>
                                <td class="px-4 py-4 text-slate-700">{{ optional($invoice->date_echeance)->format('d/m/Y') }}</td>
                                <td class="px-4 py-4 text-slate-700 capitalize">{{ str_replace('_', ' ', $invoice->statut_paiement) }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('invoices.show', $invoice) }}" class="rounded-md bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-200">Voir</a>

                                        <form action="{{ route('invoices.reminder', $invoice) }}" method="POST" class="inline">
                                            @csrf
                                            <button class="rounded-md bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700 hover:bg-amber-200" onclick="return confirm('Envoyer une relance ?')">Relancer</button>
                                        </form>

                                        <form action="{{ route('invoices.payment-status', $invoice) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="statut_paiement" value="paye">
                                            <button class="rounded-md bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700 hover:bg-emerald-200">Marquer payée</button>
                                        </form>

                                        <form action="{{ route('invoices.payment-status', $invoice) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="statut_paiement" value="annule">
                                            <button class="rounded-md bg-rose-100 px-3 py-1 text-xs font-medium text-rose-700 hover:bg-rose-200" onclick="return confirm('Annuler cette facture ?')">Annuler</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-slate-500">Aucune facture échue.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            {{ $invoices->links() }}
        </div>
    </div>
@endsection

