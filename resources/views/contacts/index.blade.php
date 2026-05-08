@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Contacts</h1>
                <p class="text-sm text-slate-500">Liste des clients et prospects</p>
            </div>
            <a href="{{ route('contacts.create') }}" class="inline-flex items-center justify-center rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Nouveau contact</a>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-slate-700">Nom</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Entreprise</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Email</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Secteur</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Statut</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Score</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Commercial</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($contacts as $contact)
                        <tr>
                            <td class="px-4 py-4 text-slate-900">{{ $contact->nom }}</td>
                            <td class="px-4 py-4 text-slate-700">{{ $contact->entreprise ?? '—' }}</td>
                            <td class="px-4 py-4 text-slate-700">{{ $contact->email }}</td>
                            <td class="px-4 py-4 text-slate-700 capitalize">{{ $contact->statut }}</td>
                            <td class="px-4 py-4 text-slate-700">{{ $contact->commercial?->name ?? 'Non assigné' }}</td>
                            <td class="px-4 py-4 text-slate-700">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('contacts.show', $contact) }}" class="rounded-md bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-200">Voir</a>
                                    <a href="{{ route('contacts.edit', $contact) }}" class="rounded-md bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-200">Modifier</a>
                                    <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-md bg-rose-100 px-3 py-1 text-xs font-medium text-rose-700 hover:bg-rose-200" onclick="return confirm('Supprimer ce contact ?')">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">Aucun contact trouvé. Créez-en un pour démarrer.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $contacts->links() }}
        </div>
    </div>
@endsection
