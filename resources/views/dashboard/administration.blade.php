@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">Tableau de bord Administration</h1>
                <p class="text-slate-600 mt-2">Bienvenue {{ $user->name }}, gestion financière et recouvrement</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('invoices.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transition duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    Nouvelle facture
                </a>
            </div>
        </div>

        <!-- Alert si factures en retard -->
        @if($stats['invoices_overdue'] > 0)
            <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 rounded-lg p-5 flex items-start gap-4">
                <div class="bg-red-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                </div>
                <div>
                    <h3 class="font-bold text-red-900">Alerte de recouvrement</h3>
                    <p class="text-red-800 text-sm mt-1">{{ $stats['invoices_overdue'] }} factures en retard nécessitent une action immédiate</p>
                </div>
            </div>
        @endif

        <!-- KPIs Principaux -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Payées -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-slate-200">
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-green-100">Factures Payées</p>
                            <h3 class="text-3xl font-bold mt-1">{{ $stats['invoices_paid'] }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        </div>
                    </div>
                    <p class="text-xs text-green-100 mt-3">Documents réglés</p>
                </div>
            </div>

            <!-- En attente -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-slate-200">
                <div class="bg-gradient-to-br from-yellow-500 to-amber-600 p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-yellow-100">En Attente</p>
                            <h3 class="text-3xl font-bold mt-1">{{ $stats['invoices_pending'] }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 102 0V6z" /></svg>
                        </div>
                    </div>
                    <p class="text-xs text-yellow-100 mt-3">Montants à encaisser</p>
                </div>
            </div>

            <!-- En retard -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-slate-200">
                <div class="bg-gradient-to-br from-red-500 to-red-600 p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-red-100">En Retard</p>
                            <h3 class="text-3xl font-bold mt-1">{{ $stats['invoices_overdue'] }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 7.923A6 6 0 0113.477 14.89zm1.414-1.414A8 8 0 103.06 3.06a8 8 0 0111.831 11.831zM9.172 5.172a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L10 7.414l-2.172 2.172a1 1 0 01-1.414-1.414l3-3z" clip-rule="evenodd" /></svg>
                        </div>
                    </div>
                    <p class="text-xs text-red-100 mt-3">Actions requises</p>
                </div>
            </div>

            <!-- Total à encaisser -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 border border-slate-200">
                <div class="bg-gradient-to-br from-purple-500 to-indigo-600 p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-purple-100">À Encaisser</p>
                            <h3 class="text-2xl font-bold mt-1">{{ number_format($stats['total_due'] ?? 0, 0, ',', ' ') }} €</h3>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M8.16 2.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM7 14a.75.75 0 00-1.5 0v.008a.75.75 0 001.5 0V14zM14.75 7a.75.75 0 100-1.5.75.75 0 000 1.5zM15.75 14.008a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" /></svg>
                        </div>
                    </div>
                    <p class="text-xs text-purple-100 mt-3">Sommes en attente</p>
                </div>
            </div>
        </div>

        <!-- Section principale -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <!-- État des encaissements -->
                <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" /></svg>
                        État des Encaissements
                    </h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                            <span class="font-semibold text-slate-900">Factures Payées</span>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-green-600">{{ $stats['invoices_paid'] }}</p>
                                <p class="text-xs text-slate-500">{{ number_format($stats['processed_amount'] ?? 0, 0, ',', ' ') }} €</p>
                            </div>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
                            <span class="font-semibold text-slate-900">Factures en Attente</span>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-yellow-600">{{ $stats['invoices_pending'] }}</p>
                                <p class="text-xs text-slate-500">À suivre</p>
                            </div>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-red-50 rounded-lg border-l-4 border-red-500">
                            <span class="font-semibold text-slate-900">Factures en Retard</span>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-red-600">{{ $stats['invoices_overdue'] }}</p>
                                <p class="text-xs text-slate-500">Recouvrement urgent</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Flux de trésorerie -->
                <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5z" /></svg>
                        Flux de Trésorerie
                    </h2>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg">
                            <span class="font-semibold text-slate-900">Montant Encaissé</span>
                            <span class="text-2xl font-bold text-green-600">{{ number_format($stats['processed_amount'] ?? 0, 0, ',', ' ') }} €</span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg">
                            <span class="font-semibold text-slate-900">Montant en Attente</span>
                            <span class="text-2xl font-bold text-yellow-600">{{ number_format($stats['total_due'] ?? 0, 0, ',', ' ') }} €</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Factures récentes -->
                <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" /></svg>
                        Factures Récentes
                    </h2>
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @foreach($extra['recentInvoices'] as $invoice)
                            <div class="bg-gradient-to-r from-slate-50 to-slate-100 rounded-lg p-4 border border-slate-200 hover:shadow-md transition">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $invoice->reference ?? 'Facture #' . $invoice->id }}</p>
                                        <p class="text-xs text-slate-600 mt-1">
                                            @if($invoice->statut_paiement === 'paye')
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">Payée</span>
                                            @elseif($invoice->statut_paiement === 'en_attente')
                                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-semibold">En attente</span>
                                            @else
                                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-semibold">En retard</span>
                                            @endif
                                        </p>
                                    </div>
                                    <span class="text-xs text-slate-500">{{ $invoice->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Prospects en attente -->
                <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 12a6 6 0 11-12 0 6 6 0 0112 0z" /></svg>
                        Prospects
                    </h2>
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-lg p-4 border border-emerald-200">
                        <div class="text-center">
                            <p class="text-3xl font-bold text-emerald-600">{{ $extra['pendingContacts'] }}</p>
                            <p class="text-sm text-slate-600 mt-2">prospects en statut prospect</p>
                            <p class="text-xs text-slate-500 mt-2">À préparer pour relances</p>
                        </div>
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Actions Prioritaires</h2>
                    <div class="grid gap-2">
                        <a href="{{ route('invoices.index') }}" class="flex items-center gap-2 bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 font-semibold py-3 px-4 rounded-lg hover:shadow-md transition text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" /></svg>
                            Suivi factures
                        </a>
                        <a href="{{ route('contacts.index') }}" class="flex items-center gap-2 bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 font-semibold py-3 px-4 rounded-lg hover:shadow-md transition text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 12a6 6 0 11-12 0 6 6 0 0112 0z" /></svg>
                            Voir contacts
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphique de recouvrement -->
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
            <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 9.5A1.5 1.5 0 013.5 8H5v4H3.5A1.5 1.5 0 012 9.5zM6 8a1 1 0 100 2h8a1 1 0 100-2H6zM6 12a1 1 0 100 2h8a1 1 0 100-2H6z" /></svg>
                Aperçu de Recouvrement
            </h2>
            <canvas id="adminFinanceChart" height="100"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const adminFinanceCtx = document.getElementById('adminFinanceChart').getContext('2d');
        new Chart(adminFinanceCtx, {
            type: 'doughnut',
            data: {
                labels: ['Payées', 'En attente', 'En retard'],
                datasets: [{
                    data: @json($chartData['values']),
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
