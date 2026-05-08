@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Opportunités</h1>
                <p class="text-sm text-slate-500">Vue du pipeline commercial.</p>
            </div>
            <a href="{{ route('opportunities.create') }}" class="inline-flex items-center justify-center rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Nouvelle opportunité</a>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-slate-700">Titre</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Contact</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Valeur</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Probabilité</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Étape</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Commercial</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($opportunities as $opportunity)
                        <tr>
                            <td class="px-4 py-4 text-slate-900">{{ $opportunity->titre }}</td>
                            <td class="px-4 py-4 text-slate-700">{{ $opportunity->contact->nom ?? '—' }}</td>
                            <td class="px-4 py-4 text-slate-700">{{ number_format($opportunity->valeur, 2, ',', ' ') }} €</td>
                            <td class="px-4 py-4 text-slate-700">{{ $opportunity->probabilite }} %</td>
                            <td class="px-4 py-4 text-slate-700">{{ ucfirst($opportunity->etape) }}</td>
                            <td class="px-4 py-4 text-slate-700">{{ $opportunity->commercial?->name ?? 'Non assigné' }}</td>
                            <td class="px-4 py-4 text-slate-700">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('opportunities.show', $opportunity) }}" class="rounded-md bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-200">Voir</a>
                                    <a href="{{ route('opportunities.edit', $opportunity) }}" class="rounded-md bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-200">Modifier</a>
                                    <form action="{{ route('opportunities.destroy', $opportunity) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-md bg-rose-100 px-3 py-1 text-xs font-medium text-rose-700 hover:bg-rose-200" onclick="return confirm('Supprimer cette opportunité ?')">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-sm text-slate-500">Aucune opportunité trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $opportunities->links() }}
        </div>
    </div>
@endsection
