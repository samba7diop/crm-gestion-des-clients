@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Devis</h1>
                <p class="text-sm text-slate-500">Liste des devis CRM.</p>
            </div>
            <a href="{{ route('quotes.create') }}" class="inline-flex items-center justify-center rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Nouveau devis</a>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-slate-700">ID</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Contact</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Total TTC</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Statut</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Validité</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($quotes as $quote)
                        <tr>
                            <td class="px-4 py-4 text-slate-900">#{{ $quote->id }}</td>
                            <td class="px-4 py-4 text-slate-700">{{ $quote->contact->nom ?? '—' }}</td>
                            <td class="px-4 py-4 text-slate-700">{{ number_format($quote->total_ttc, 2, ',', ' ') }} €</td>
                            <td class="px-4 py-4 text-slate-700 capitalize">{{ $quote->statut }}</td>
                            <td class="px-4 py-4 text-slate-700">{{ optional($quote->date_validite)->format('d/m/Y') }}</td>
                            <td class="px-4 py-4 text-slate-700">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('quotes.show', $quote) }}" class="rounded-md bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-200">Voir</a>
                                    <a href="{{ route('quotes.edit', $quote) }}" class="rounded-md bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-200">Modifier</a>
                                    <form action="{{ route('quotes.destroy', $quote) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-md bg-rose-100 px-3 py-1 text-xs font-medium text-rose-700 hover:bg-rose-200" onclick="return confirm('Supprimer ce devis ?')">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">Aucun devis pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $quotes->links() }}
        </div>
    </div>
@endsection
