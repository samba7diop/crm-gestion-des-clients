@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Activités</h1>
                <p class="text-sm text-slate-500">Suivi des appels, emails, réunions et tâches.</p>
            </div>
            <a href="{{ route('activities.create') }}" class="inline-flex items-center justify-center rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Nouvelle activité</a>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-slate-700">Contact</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Type</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Date</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Commercial</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Rappel</th>
                        <th class="px-4 py-3 font-semibold text-slate-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($activities as $activity)
                        <tr>
                            <td class="px-4 py-4 text-slate-900">{{ $activity->contact->nom ?? '—' }}</td>
                            <td class="px-4 py-4 text-slate-700 capitalize">{{ $activity->type }}</td>
                            <td class="px-4 py-4 text-slate-700">{{ optional($activity->date)->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-4 text-slate-700">{{ $activity->commercial?->name ?? 'Non assigné' }}</td>
                            <td class="px-4 py-4 text-slate-700">{{ $activity->rappel ? 'Oui' : 'Non' }}</td>
                            <td class="px-4 py-4 text-slate-700">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('activities.show', $activity) }}" class="rounded-md bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-200">Voir</a>
                                    <a href="{{ route('activities.edit', $activity) }}" class="rounded-md bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-200">Modifier</a>
                                    <form action="{{ route('activities.destroy', $activity) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-md bg-rose-100 px-3 py-1 text-xs font-medium text-rose-700 hover:bg-rose-200" onclick="return confirm('Supprimer cette activité ?')">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">Aucune activité.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $activities->links() }}
        </div>
    </div>
@endsection
