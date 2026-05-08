@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">Tableau de bord Marketing</h1>
                <p class="text-slate-600 mt-2">Bienvenue {{ $user->name }}, pilotez votre stratégie marketing</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('campaigns.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transition duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    Nouvelle campagne
                </a>
            </div>
        </div>

        <!-- KPIs Principaux -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-slate-200">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-blue-100">Leads Totaux</p>
                            <h3 class="text-3xl font-bold mt-1">{{ $stats['lead_contacts'] }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 12a6 6 0 11-12 0 6 6 0 0112 0z" /></svg>
                        </div>
                    </div>
                    <p class="text-xs text-blue-100 mt-3">+{{ $stats['new_leads'] }} ce mois</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-slate-200">
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-emerald-100">Campagnes Actives</p>
                            <h3 class="text-3xl font-bold mt-1">{{ $stats['active_campaigns'] }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.343a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM15.657 14.657a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM11 17a1 1 0 102 0v-1a1 1 0 10-2 0v1zM5.343 15.657a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414l-.707.707zM4 11a1 1 0 01-1-1V9a1 1 0 112 0v1a1 1 0 01-1 1zM5.343 5.343a1 1 0 01-1.414 1.414L3.222 6.05a1 1 0 011.414-1.414l.707.707zM10 6a4 4 0 100 8 4 4 0 000-8zm0 2a2 2 0 110 4 2 2 0 010-4z" /></svg>
                        </div>
                    </div>
                    <p class="text-xs text-emerald-100 mt-3">sur {{ $stats['campaigns'] }} total</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-slate-200">
                <div class="bg-gradient-to-br from-amber-500 to-orange-600 p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-amber-100">Leads Qualifiés</p>
                            <h3 class="text-3xl font-bold mt-1">{{ $stats['high_score_leads'] }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        </div>
                    </div>
                    <p class="text-xs text-amber-100 mt-3">Score ≥ 80</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-slate-200">
                <div class="bg-gradient-to-br from-purple-500 to-pink-600 p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-purple-100">Conversion</p>
                            <h3 class="text-3xl font-bold mt-1">
                                {{ $stats['lead_contacts'] > 0 ? round(($stats['quotes'] / $stats['lead_contacts']) * 100, 1) : 0 }}%
                            </h3>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M13 7H7v6h6V7z" /></svg>
                        </div>
                    </div>
                    <p class="text-xs text-purple-100 mt-3">{{ $stats['quotes'] }} devis générés</p>
                </div>
            </div>
        </div>

        <!-- Section principale -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Segmentation & Análises -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Segmentation des leads -->
                <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M7 2a1 1 0 100 2h6a1 1 0 100-2H7zM7 8a1 1 0 100 2h6a1 1 0 100-2H7zM7 14a1 1 0 100 2h6a1 1 0 100-2H7z" /></svg>
                        Segmentation des Leads
                    </h2>
                    <div class="grid grid-cols-3 gap-3">
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                            <p class="text-sm text-green-700 font-semibold">Haut Score</p>
                            <p class="text-3xl font-bold text-green-900 mt-2">{{ $stats['high_score_leads'] }}</p>
                            <p class="text-xs text-green-600 mt-2">≥80</p>
                        </div>
                        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-4 border border-yellow-200">
                            <p class="text-sm text-yellow-700 font-semibold">Score Moyen</p>
                            <p class="text-3xl font-bold text-yellow-900 mt-2">{{ $stats['medium_score_leads'] }}</p>
                            <p class="text-xs text-yellow-600 mt-2">50-79</p>
                        </div>
                        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-4 border border-red-200">
                            <p class="text-sm text-red-700 font-semibold">Bas Score</p>
                            <p class="text-3xl font-bold text-red-900 mt-2">{{ $stats['low_score_leads'] }}</p>
                            <p class="text-xs text-red-600 mt-2">&lt;50</p>
                        </div>
                    </div>
                </div>

                <!-- Répartition par secteur et taille -->
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                        <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 5a1 1 0 011-1h1a1 1 0 011 1v1a1 1 0 01-1 1H3a1 1 0 01-1-1V5zM6 5a1 1 0 011-1h1a1 1 0 011 1v1a1 1 0 01-1 1H7a1 1 0 01-1-1V5zM10 5a1 1 0 011-1h1a1 1 0 011 1v1a1 1 0 01-1 1h-1a1 1 0 01-1-1V5zM2 9a1 1 0 011-1h1a1 1 0 011 1v1a1 1 0 01-1 1H3a1 1 0 01-1-1V9zM6 9a1 1 0 011-1h1a1 1 0 011 1v1a1 1 0 01-1 1H7a1 1 0 01-1-1V9zM10 9a1 1 0 011-1h1a1 1 0 011 1v1a1 1 0 01-1 1h-1a1 1 0 01-1-1V9z" /></svg>
                            Répartition par Secteur
                        </h2>
                        <div class="space-y-2 max-h-64 overflow-y-auto">
                            @forelse($extra['leadsBySector'] as $sector)
                                <div class="flex justify-between items-center p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition">
                                    <span class="font-medium text-sm text-slate-900">{{ $sector->secteur ?: 'Non spécifié' }}</span>
                                    <span class="bg-blue-100 text-blue-700 font-bold text-xs px-3 py-1 rounded-full">{{ $sector->count }}</span>
                                </div>
                            @empty
                                <p class="text-slate-500 text-sm text-center py-4">Aucun secteur défini</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                        <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2zm0 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z" /></svg>
                            Répartition par Taille
                        </h2>
                        <div class="space-y-2 max-h-64 overflow-y-auto">
                            @forelse($extra['leadsBySize'] as $size)
                                <div class="flex justify-between items-center p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition">
                                    <span class="font-medium text-sm text-slate-900">{{ $size->taille ?: 'Non spécifiée' }}</span>
                                    <span class="bg-blue-100 text-blue-700 font-bold text-xs px-3 py-1 rounded-full">{{ $size->count }}</span>
                                </div>
                            @empty
                                <p class="text-slate-500 text-sm text-center py-4">Aucune taille définie</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Sources de leads -->
                <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M4.3 12.98a8 8 0 1115.4 0M9 20h2v-2H9v2zm4-3h2v-2h-2v2zm4-3h2v-2h-2v2z" /></svg>
                        Sources de Leads
                    </h2>
                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        @forelse($extra['leadsBySource'] as $source)
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition">
                                <span class="font-medium text-sm text-slate-900">{{ $source->source ?: 'Non renseigné' }}</span>
                                <span class="bg-blue-100 text-blue-700 font-bold text-xs px-3 py-1 rounded-full">{{ $source->count }}</span>
                            </div>
                        @empty
                            <p class="text-slate-500 text-sm text-center py-4">Aucune source disponible</p>
                        @endforelse
                    </div>
                </div>

                <!-- Campagnes récentes -->
                <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4z" /></svg>
                        Campagnes Récentes
                    </h2>
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @forelse($extra['recentCampaigns'] as $campaign)
                            <div class="bg-gradient-to-r from-slate-50 to-slate-100 rounded-lg p-4 border border-slate-200 hover:shadow-md transition">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $campaign->nom }}</p>
                                        <p class="text-xs text-slate-600 mt-1">{{ $campaign->type }}</p>
                                    </div>
                                    @if($campaign->statut === 'active')
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">Actif</span>
                                    @elseif($campaign->statut === 'draft')
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-semibold">Brouillon</span>
                                    @else
                                        <span class="bg-slate-100 text-slate-800 px-2 py-1 rounded text-xs font-semibold">Terminé</span>
                                    @endif
                                </div>
                                <p class="text-xs text-slate-500 mt-2">{{ optional($campaign->date_envoi)->format('d/m/Y') }}</p>
                            </div>
                        @empty
                            <p class="text-slate-500 text-sm text-center py-4">Aucune campagne récente</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" /></svg>
                    Évolution des Leads
                </h2>
                <canvas id="leadsChart" height="80"></canvas>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 9.5A1.5 1.5 0 013.5 8H5v4H3.5A1.5 1.5 0 012 9.5zM6 8a1 1 0 100 2h8a1 1 0 100-2H6zM6 12a1 1 0 100 2h8a1 1 0 100-2H6z" /></svg>
                    Qualité des Leads
                </h2>
                <canvas id="qualityChart" height="80"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Graphique des leads
        const leadsCtx = document.getElementById('leadsChart').getContext('2d');
        new Chart(leadsCtx, {
            type: 'line',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Nombre de leads',
                    data: @json($chartData['values']),
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Graphique de qualité
        const qualityCtx = document.getElementById('qualityChart').getContext('2d');
        new Chart(qualityCtx, {
            type: 'doughnut',
            data: {
                labels: ['Haut Score', 'Score Moyen', 'Bas Score'],
                datasets: [{
                    data: [{{ $stats['high_score_leads'] }}, {{ $stats['medium_score_leads'] }}, {{ $stats['low_score_leads'] }}],
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(251, 191, 36, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderColor: ['rgb(34, 197, 94)', 'rgb(251, 191, 36)', 'rgb(239, 68, 68)'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'bottom', labels: { font: { size: 12 } } }
                }
            }
        });
    </script>
@endsection