@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent">Tableau de Bord Directeur Commercial</h1>
                <p class="text-slate-600 mt-2">Bienvenue {{ $user->name }}, pilotage de l'équipe et vue stratégique</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('opportunities.index') }}" class="flex items-center gap-2 bg-gradient-to-r from-red-600 to-pink-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transition duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    Pipeline
                </a>
            </div>
        </div>

        <!-- KPIs principaux -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-slate-200">
                <div class="bg-gradient-to-br from-red-500 to-red-600 p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-red-100">Pipeline Estimé</p>
                            <h3 class="text-3xl font-bold mt-1">{{ number_format($stats['forecast'] ?? 0, 0, ',', ' ') }} €</h3>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" /></svg>
                        </div>
                    </div>
                    <p class="text-xs text-red-100 mt-3">Chiffre d'affaires probable</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-slate-200">
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-green-100">Taux de Réussite</p>
                            <h3 class="text-3xl font-bold mt-1">{{ $stats['win_rate'] }}%</h3>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        </div>
                    </div>
                    <p class="text-xs text-green-100 mt-3">Opportunités gagnées</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-slate-200">
                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-blue-100">Devis Générés</p>
                            <h3 class="text-3xl font-bold mt-1">{{ $stats['quotes'] }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" /><path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm11-4a1 1 0 10-2 0 1 1 0 002 0z" clip-rule="evenodd" /></svg>
                        </div>
                    </div>
                    <p class="text-xs text-blue-100 mt-3">Tous les commerciaux</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-slate-200">
                <div class="bg-gradient-to-br from-purple-500 to-indigo-600 p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-purple-100">Factures</p>
                            <h3 class="text-3xl font-bold mt-1">{{ $stats['invoices'] }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M4.555 5.659c0-.476.484-.959.927-.959h6.036c.443 0 .927.483.927.959v9.282c0 .476-.484.959-.927.959H5.482c-.443 0-.927-.483-.927-.959V5.659z" /><path d="M7.752 2c-.51 0-1 .49-1 1.002v1.498H6.25a1.5 1.5 0 00-1.5 1.5v10.5a1.5 1.5 0 001.5 1.5h7.5a1.5 1.5 0 001.5-1.5V6c0-.828.672-1.5-1.5-1.5h-.502V3c0-.512-.49-1-1-1h-3.498z" /></svg>
                        </div>
                    </div>
                    <p class="text-xs text-purple-100 mt-3">En cours de traitement</p>
                </div>
            </div>
        </div>

        <!-- Objectifs de l'équipe -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" /></svg>
                    Performance de l'équipe
                </h2>
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                        <p class="text-sm text-blue-700 font-semibold">Opportunités</p>
                        <p class="text-3xl font-bold text-blue-900 mt-2">{{ $stats['team_opportunities'] }}</p>
                        <p class="text-xs text-blue-600 mt-2">Pipeline actif</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                        <p class="text-sm text-green-700 font-semibold">Devis</p>
                        <p class="text-3xl font-bold text-green-900 mt-2">{{ $stats['team_quotes'] }}</p>
                        <p class="text-xs text-green-600 mt-2">En circulation</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                        <p class="text-sm text-purple-700 font-semibold">Factures</p>
                        <p class="text-3xl font-bold text-purple-900 mt-2">{{ $stats['team_invoices'] }}</p>
                        <p class="text-xs text-purple-600 mt-2">À traiter</p>
                    </div>
                </div>
            </div>

            <!-- Top performers -->
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                    Top Performers
                </h2>
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @forelse($extra['topPerformers'] as $performer)
                        <div class="bg-gradient-to-r from-slate-50 to-slate-100 rounded-lg p-4 border border-slate-200 hover:shadow-md transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-slate-900">{{ $performer->commercial->name ?? 'Non assigné' }}</p>
                                    <p class="text-sm text-slate-600 mt-1">{{ $performer->total_contacts }} contacts récents</p>
                                </div>
                                <div class="bg-red-100 rounded-full px-3 py-1">
                                    <span class="text-xs font-bold text-red-700">{{ $performer->total_contacts }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500 text-sm text-center py-4">Aucune donnée disponible</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Statistiques détaillées -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Pipeline par étape -->
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path d="M13 7H7v6h6V7z" /></svg>
                    Pipeline par Étape
                </h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gradient-to-r from-slate-50 to-slate-100">
                            <tr class="border-b-2 border-slate-200">
                                <th class="px-4 py-3 text-left text-sm font-bold text-slate-900">Étape</th>
                                <th class="px-4 py-3 text-right text-sm font-bold text-slate-900">Nombre</th>
                                <th class="px-4 py-3 text-right text-sm font-bold text-slate-900">Progression</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($extra['pipelineByStage'] as $stage)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-4 py-3 text-sm font-semibold text-slate-900">{{ ucfirst($stage->etape) }}</td>
                                    <td class="px-4 py-3 text-right text-sm font-bold text-slate-700">{{ $stage->total }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="w-24 bg-slate-200 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-red-500 to-pink-600 h-2 rounded-full" style="width: {{ ($stage->total / ($extra['pipelineByStage']->sum('total') ?? 1)) * 100 }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Devis récents -->
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" /><path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm11-4a1 1 0 10-2 0 1 1 0 002 0z" clip-rule="evenodd" /></svg>
                    Devis Récents
                </h2>
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @forelse($extra['recentQuotes'] as $quote)
                        <div class="bg-gradient-to-r from-slate-50 to-slate-100 rounded-lg p-4 border border-slate-200 hover:shadow-md transition">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-bold text-slate-900">{{ $quote->reference ?? 'Devis #' . $quote->id }}</p>
                                    <p class="text-xs text-slate-600 mt-1">
                                        @if($quote->statut === 'accepted')
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">Accepté</span>
                                        @elseif($quote->statut === 'refused')
                                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-semibold">Refusé</span>
                                        @else
                                            <span class="bg-amber-100 text-amber-800 px-2 py-1 rounded text-xs font-semibold">En attente</span>
                                        @endif
                                    </p>
                                </div>
                                <span class="text-xs text-slate-500">{{ $quote->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500 text-sm text-center py-4">Aucun devis récent</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Graphique de synthèse -->
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
            <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" /></svg>
                Vue Globale & Tendances
            </h2>
            <canvas id="directorChart" height="100"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const directorCtx = document.getElementById('directorChart').getContext('2d');
        new Chart(directorCtx, {
            type: 'bar',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Opportunités',
                    data: @json($chartData['values']),
                    backgroundColor: [
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(249, 115, 22, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(34, 197, 94, 0.8)'
                    ],
                    borderRadius: 8,
                    borderSkipped: false,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: true, position: 'top' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        ticks: { font: { size: 12 } }
                    },
                    x: { grid: { display: false }, ticks: { font: { size: 12 } } }
                }
            }
        });
    </script>
@endsection
