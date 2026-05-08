@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-blue-600 bg-clip-text text-transparent">Tableau de bord Commercial</h1>
                <p class="text-slate-600 mt-2">Bienvenue {{ $user->name }}, voici votre espace de travail personnel</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('contacts.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transition duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    Nouveau contact
                </a>
                <a href="{{ route('opportunities.create') }}" class="flex items-center gap-2 bg-white border-2 border-indigo-600 text-indigo-600 font-semibold py-3 px-6 rounded-lg hover:bg-indigo-50 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    Nouvelle opportunité
                </a>
            </div>
        </div>

        <!-- Alerte si inactivité -->
        @if($stats['inactive_opportunities'] > 0)
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 border-l-4 border-amber-500 rounded-lg p-5 flex items-start gap-4">
                <div class="bg-amber-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                </div>
                <div>
                    <h3 class="font-bold text-amber-900">Attention : {{ $stats['inactive_opportunities'] }} opportunités inactives</h3>
                    <p class="text-amber-800 text-sm mt-1">Celles-ci n'ont pas été mises à jour depuis plus de 14 jours. Pensez à les relancer !</p>
                </div>
            </div>
        @endif

        <!-- KPIs principaux -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Contacts -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-slate-200">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-blue-100">Mes Contacts</p>
                            <h3 class="text-3xl font-bold mt-1">{{ $stats['contacts'] }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" /></svg>
                        </div>
                    </div>
                    <p class="text-xs text-blue-100 mt-3">
                        <span class="font-semibold">{{ $stats['client_contacts'] }}</span> clients · 
                        <span class="font-semibold">{{ $stats['lead_contacts'] }}</span> leads
                    </p>
                </div>
                <div class="p-4">
                    <a href="{{ route('contacts.index') }}" class="text-blue-600 font-semibold text-sm hover:text-blue-700">Voir tous →</a>
                </div>
            </div>

            <!-- Opportunités -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-slate-200">
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-green-100">Opportunités</p>
                            <h3 class="text-3xl font-bold mt-1">{{ $stats['opportunities'] }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a4 4 0 00-8 0v1h8z" /></svg>
                        </div>
                    </div>
                    <p class="text-xs text-green-100 mt-3">
                        Taux de réussite: <span class="font-semibold">{{ $extra['myWinRate'] }}%</span>
                    </p>
                </div>
                <div class="p-4">
                    <a href="{{ route('opportunities.index') }}" class="text-green-600 font-semibold text-sm hover:text-green-700">Voir pipeline →</a>
                </div>
            </div>

            <!-- Devis -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-slate-200">
                <div class="bg-gradient-to-br from-purple-500 to-indigo-600 p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-purple-100">Devis</p>
                            <h3 class="text-3xl font-bold mt-1">{{ $stats['quotes'] }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" /><path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm11-4a1 1 0 10-2 0 1 1 0 002 0z" clip-rule="evenodd" /></svg>
                        </div>
                    </div>
                    <p class="text-xs text-purple-100 mt-3">
                        <span class="font-semibold">{{ $stats['quotes_accepted'] }}</span> acceptés · 
                        <span class="font-semibold">{{ $stats['quotes'] > 0 ? round(($stats['quotes_accepted'] / $stats['quotes']) * 100) : 0 }}%</span>
                    </p>
                </div>
                <div class="p-4">
                    <a href="{{ route('quotes.index') }}" class="text-purple-600 font-semibold text-sm hover:text-purple-700">Voir devis →</a>
                </div>
            </div>

            <!-- Prévision CA -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-slate-200">
                <div class="bg-gradient-to-br from-orange-500 to-red-600 p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-orange-100">Prévision CA</p>
                            <h3 class="text-3xl font-bold mt-1">{{ number_format($stats['forecast'], 0, ',', ' ') }} €</h3>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M8.16 2.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM7 14a.75.75 0 00-1.5 0v.008a.75.75 0 001.5 0V14zM14.75 7a.75.75 0 100-1.5.75.75 0 000 1.5zM15.75 14.008a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" /></svg>
                        </div>
                    </div>
                    <p class="text-xs text-orange-100 mt-3">Basé sur probabilités</p>
                </div>
                <div class="p-4">
                    <p class="text-orange-600 font-semibold text-sm">Mise à jour automatique</p>
                </div>
            </div>
        </div>

        <!-- Section principale -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Pipeline & Statistiques -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Performance -->
                <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" /></svg>
                        Ma Performance
                    </h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                            <span class="font-semibold text-slate-900">Taux de conversion</span>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-blue-600">{{ $extra['myWinRate'] }}%</p>
                                <p class="text-xs text-slate-500">Opportunités gagnées</p>
                            </div>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                            <span class="font-semibold text-slate-900">Factures payées</span>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-green-600">{{ $stats['invoices_paid'] }}</p>
                                <p class="text-xs text-slate-500">sur {{ $stats['invoices'] }} total</p>
                            </div>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-purple-50 rounded-lg border-l-4 border-purple-500">
                            <span class="font-semibold text-slate-900">Factures en attente</span>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-purple-600">{{ $stats['invoices_pending'] }}</p>
                                <p class="text-xs text-slate-500">À suivre</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Graphique -->
                <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                    <h2 class="text-xl font-bold text-slate-900 mb-4">Aperçu des KPIs</h2>
                    <canvas id="metricsChart" height="300"></canvas>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Activités récentes -->
                <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5H5.75A2.75 2.75 0 003 4.25v11.5A2.75 2.75 0 005.75 18.5h8.5a2.75 2.75 0 002.75-2.75V6.5" /></svg>
                        Activités récentes
                    </h2>
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @forelse($extra['recentActivities'] as $activity)
                            <div class="pb-3 border-b border-slate-100 last:border-0 last:pb-0">
                                <p class="font-semibold text-sm text-slate-900">{{ $activity->type }}</p>
                                <p class="text-xs text-slate-600 mt-1">{{ Str::limit($activity->description, 60) }}</p>
                                <p class="text-xs text-slate-400 mt-1">{{ optional($activity->date)->format('d/m/Y H:i') }}</p>
                            </div>
                        @empty
                            <p class="text-slate-500 text-sm text-center py-4">Aucune activité récente</p>
                        @endforelse
                    </div>
                </div>

                <!-- Sources de contacts -->
                <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.applied9l1.821 10.26a2 2 0 002.112 1.738h6.08a2 2 0 002.04-1.659l1.83-10.363c.156-.892-.646-1.68-1.56-1.68H5.009a1 1 0 00-.986.836l-.564-3.192A2 2 0 001.25 2H1a1 1 0 000 2h.5z" /><path d="M5 16a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM14 16a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" /></svg>
                        Sources de contacts
                    </h2>
                    <div class="space-y-2">
                        @forelse($extra['contactsBySource'] as $source)
                            <div class="flex justify-between items-center p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition">
                                <span class="font-medium text-sm text-slate-900">{{ $source->source ?: 'Non renseigné' }}</span>
                                <span class="bg-indigo-100 text-indigo-700 font-bold text-xs px-3 py-1 rounded-full">{{ $source->count }}</span>
                            </div>
                        @empty
                            <p class="text-slate-500 text-sm text-center py-4">Aucune source</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const metricsCtx = document.getElementById('metricsChart').getContext('2d');
        new Chart(metricsCtx, {
            type: 'line',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Nombre',
                    data: @json($chartData['values']),
                    borderColor: 'rgb(99, 102, 241)',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointBackgroundColor: 'rgb(99, 102, 241)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
@endsection