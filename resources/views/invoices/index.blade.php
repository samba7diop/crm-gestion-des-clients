@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Factures</h1>
                <p class="text-sm text-slate-500">Suivi des factures générées à partir des devis.</p>
            </div>
            @if(auth()->user()->isAdmin() || auth()->user()->isAdministrationRole())
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('invoices.create') }}" class="inline-flex items-center justify-center rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Nouvelle facture</a>
                    <a href="{{ route('administration.recouvrement') }}" class="inline-flex items-center justify-center rounded-md bg-amber-100 px-4 py-2 text-sm font-medium text-amber-800 hover:bg-amber-200">Recouvrement</a>
                    <a href="{{ route('invoices.export.fec') }}" class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">Export FEC</a>
                </div>
            @endif
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-slate-700">Numéro</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Devis</th>
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
                            <td class="px-4 py-4 text-slate-700">#{{ $invoice->quote->id ?? '—' }}</td>
                            <td class="px-4 py-4 text-slate-700">{{ number_format($invoice->montant, 2, ',', ' ') }} €</td>
                            <td class="px-4 py-4 text-slate-700">{{ optional($invoice->date_echeance)->format('d/m/Y') }}</td>
                            <td class="px-4 py-4 text-slate-700 capitalize">{{ str_replace('_', ' ', $invoice->statut_paiement) }}</td>
                            <td class="px-4 py-4 text-slate-700">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('invoices.show', $invoice) }}" class="rounded-md bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-200">Voir</a>
                                    @if(auth()->user()->isAdmin() || auth()->user()->isAdministrationRole())
                                        <a href="{{ route('invoices.edit', $invoice) }}" class="rounded-md bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-200">Modifier</a>
                                        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-md bg-rose-100 px-3 py-1 text-xs font-medium text-rose-700 hover:bg-rose-200" onclick="return confirm('Supprimer cette facture ?')">Supprimer</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">Aucune facture trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $invoices->links() }}
        </div>
    </div>
@endsection
