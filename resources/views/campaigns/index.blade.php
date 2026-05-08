@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Campagnes</h1>
                <p class="text-sm text-slate-500">Gestion des campagnes marketing.</p>
            </div>
            <a href="{{ route('campaigns.create') }}" class="inline-flex items-center justify-center rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Nouvelle campagne</a>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-slate-700">Nom</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Type</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Statut</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Destinataires</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Date envoi</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($campaigns as $campaign)
                        <tr>
                            <td class="px-4 py-4 text-slate-900">{{ $campaign->nom }}</td>
                            <td class="px-4 py-4 text-slate-700 capitalize">{{ $campaign->type }}</td>
                            <td class="px-4 py-4 text-slate-700">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $campaign->statut === 'active' ? 'bg-green-100 text-green-800' :
                                       ($campaign->statut === 'draft' ? 'bg-yellow-100 text-yellow-800' :
                                       ($campaign->statut === 'envoyee' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ ucfirst($campaign->statut) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-slate-700">{{ count($campaign->destinataires ?? []) }}</td>
                            <td class="px-4 py-4 text-slate-700">{{ optional($campaign->date_envoi)->format('d/m/Y H:i') ?? '—' }}</td>
                            <td class="px-4 py-4 text-slate-700">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('campaigns.show', $campaign) }}" class="rounded-md bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-200">Voir</a>
                                    <a href="{{ route('campaigns.edit', $campaign) }}" class="rounded-md bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-200">Modifier</a>
                                    <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-md bg-rose-100 px-3 py-1 text-xs font-medium text-rose-700 hover:bg-rose-200" onclick="return confirm('Supprimer cette campagne ?')">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">Aucune campagne trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $campaigns->links() }}
        </div>
    </div>
@endsection
