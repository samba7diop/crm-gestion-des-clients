@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Tableau de bord CRM</h1>
            <p class="text-sm text-slate-500">Bonjour {{ $user->name }}, voici votre espace de travail.</p>
            <p class="text-sm text-slate-500">Rôle : {{ ucfirst($user->role) }}.</p>
        </div>

        @if(!empty($stats['inactive_opportunities']) && $stats['inactive_opportunities'] > 0)
            <div class="rounded-lg border border-amber-200 bg-amber-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-amber-800">Opportunités inactives</h3>
                        <div class="mt-2 text-sm text-amber-700">
                            <p>{{ $stats['inactive_opportunities'] }} opportunités n'ont pas été mises à jour depuis plus de 14 jours.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Contacts</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $stats['contacts'] ?? 0 }}</p>
                <div class="mt-4">
                    <a href="{{ route('contacts.index') }}" class="text-sm text-blue-600 hover:text-blue-500">Voir tous →</a>
                </div>
            </div>

            @if($user->isAdmin())
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Utilisateurs</p>
                    <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $stats['users'] ?? 0 }}</p>
                    <div class="mt-4">
                        <a href="{{ route('users.index') }}" class="text-sm text-slate-600 hover:text-slate-500">Voir tous →</a>
                    </div>
                </div>
            @endif

            @if($user->isAdmin() || $user->isCommercial())
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Opportunités</p>
                    <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $stats['opportunities'] ?? 0 }}</p>
                    <div class="mt-4">
                        <a href="{{ route('opportunities.index') }}" class="text-sm text-green-600 hover:text-green-500">Voir tous →</a>
                    </div>
                </div>
            @endif

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Devis</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $stats['quotes'] ?? 0 }}</p>
                <div class="mt-4">
                    <a href="{{ route('quotes.index') }}" class="text-sm text-yellow-600 hover:text-yellow-500">Voir tous →</a>
                </div>
            </div>

            @if($user->isAdmin() || $user->isCommercial())
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Activités</p>
                    <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $stats['activities'] ?? 0 }}</p>
                    <div class="mt-4">
                        <a href="{{ route('activities.index') }}" class="text-sm text-purple-600 hover:text-purple-500">Voir tous →</a>
                    </div>
                </div>
            @endif

            @if($user->isAdmin() || $user->isMarketing())
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Campagnes</p>
                    <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $stats['campaigns'] ?? 0 }}</p>
                    <div class="mt-4">
                        <a href="{{ route('campaigns.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500">Voir tous →</a>
                    </div>
                </div>
            @endif

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Factures</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $stats['invoices'] ?? 0 }}</p>
                <div class="mt-4">
                    <a href="{{ route('invoices.index') }}" class="text-sm text-red-600 hover:text-red-500">Voir tous →</a>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Prévision CA</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ number_format($stats['forecast'] ?? 0, 0, ',', ' ') }} €</p>
                <div class="mt-4">
                    <span class="text-sm text-slate-500">Basé sur probabilités</span>
                </div>
            </div>
        </div>

        @if($user->isCommercial())
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-900">Mon pipeline</h3>
                    <div class="mt-4 space-y-3 text-sm text-slate-600">
                        <div class="flex justify-between"><span>Prospects</span><span>{{ $stats['lead_contacts'] ?? 0 }}</span></div>
                        <div class="flex justify-between"><span>Clients</span><span>{{ $stats['client_contacts'] ?? 0 }}</span></div>
                        <div class="flex justify-between"><span>Taux de victoire</span><span>{{ $extra['myWinRate'] ?? 0 }}%</span></div>
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-900">Sources de prospects</h3>
                    <div class="mt-4 space-y-2 text-sm text-slate-600">
                        @forelse($extra['contactsBySource'] ?? [] as $source)
                            <div class="flex justify-between border-b border-slate-100 py-2">
                                <span>{{ $source->source ?: 'Non renseigné' }}</span>
                                <span>{{ $source->count }}</span>
                            </div>
                        @empty
                            <p>Aucune source disponible.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-900">Activités récentes</h3>
                    <div class="mt-4 space-y-3 text-sm text-slate-600">
                        @forelse($extra['recentActivities'] ?? [] as $activity)
                            <div class="rounded-lg border border-slate-100 p-3">
                                <p class="font-medium text-slate-900">{{ $activity->type }}</p>
                                <p>{{ Illuminate\Support\Str::limit($activity->description, 80) }}</p>
                                <p class="text-xs text-slate-500">{{ optional($activity->date)->format('d/m/Y H:i') }}</p>
                            </div>
                        @empty
                            <p>Aucune activité récente.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif

        @if($user->isMarketing())
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-900">Prospects & campagnes</h3>
                    <div class="mt-4 space-y-3 text-sm text-slate-600">
                        <div class="flex justify-between"><span>Total prospects</span><span>{{ $stats['lead_contacts'] ?? 0 }}</span></div>
                        <div class="flex justify-between"><span>Nouveaux ce mois</span><span>{{ $stats['new_leads'] ?? 0 }}</span></div>
                        <div class="flex justify-between"><span>Campagnes actives</span><span>{{ $stats['active_campaigns'] ?? 0 }}</span></div>
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-900">Segmentation prospects</h3>
                    <div class="mt-4 space-y-3 text-sm text-slate-600">
                        <div class="flex justify-between"><span>Haut score</span><span>{{ $stats['high_score_leads'] ?? 0 }}</span></div>
                        <div class="flex justify-between"><span>Score moyen</span><span>{{ $stats['medium_score_leads'] ?? 0 }}</span></div>
                        <div class="flex justify-between"><span>Bas score</span><span>{{ $stats['low_score_leads'] ?? 0 }}</span></div>
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-900">Campagnes récentes</h3>
                    <div class="mt-4 space-y-3 text-sm text-slate-600">
                        @forelse($extra['recentCampaigns'] ?? [] as $campaign)
                            <div class="rounded-lg border border-slate-100 p-3">
                                <p class="font-medium text-slate-900">{{ $campaign->nom }}</p>
                                <p>{{ $campaign->type }}</p>
                                <p class="text-xs text-slate-500">{{ optional($campaign->date_envoi)->format('d/m/Y') }}</p>
                            </div>
                        @empty
                            <p>Aucune campagne récente.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif

        @if($user->isAdmin())
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Performance commerciale</h3>
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700">
                        <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-4 py-3">Commercial</th>
                                <th class="px-4 py-3">Contacts</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @foreach($extra['topCommercials'] ?? [] as $commercial)
                                <tr>
                                    <td class="px-4 py-3">{{ $commercial->commercial->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $commercial->total_contacts }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div class="grid gap-6 sm:grid-cols-2">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Statut des factures</h3>
                <div class="mt-4 space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-slate-600">Payées</span>
                        <span class="text-sm font-medium text-slate-900">{{ $stats['invoices_paid'] ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-slate-600">En attente</span>
                        <span class="text-sm font-medium text-slate-900">{{ $stats['invoices_pending'] ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Statut des devis</h3>
                <div class="mt-4 space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-slate-600">Acceptés</span>
                        <span class="text-sm font-medium text-slate-900">{{ $stats['quotes_accepted'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-slate-900">Graphique des métriques</h3>
            <div class="mt-4">
                <canvas id="metricsChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('metricsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Nombre',
                    data: @json($chartData['values']),
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
