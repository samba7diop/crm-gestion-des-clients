@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Tableau de bord Administrateur</h1>
            <p class="text-sm text-slate-500">Bonjour {{ $user->name }}, gérez la plateforme et surveillez les indicateurs clés.</p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Utilisateurs</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $stats['users'] }}</p>
                <div class="mt-4 text-sm text-slate-500">Comptes actifs sur la plateforme</div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Contacts</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $stats['contacts'] }}</p>
                <div class="mt-4 text-sm text-slate-500">Base clients et prospects</div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Opportunités</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $stats['opportunities'] }}</p>
                <div class="mt-4 text-sm text-slate-500">Pipeline commercial total</div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Factures</p>
                <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $stats['invoices'] }}</p>
                <div class="mt-4 text-sm text-slate-500">Documents de facturation créés</div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Activité récente</h3>
                <div class="mt-4 text-sm text-slate-600 space-y-3">
                    <div class="flex justify-between">
                        <span>Campagnes actives</span>
                        <span class="font-medium">{{ $stats['active_campaigns'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Factures payées</span>
                        <span class="font-medium text-green-600">{{ $stats['invoices_paid'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Factures en attente</span>
                        <span class="font-medium text-yellow-600">{{ $stats['invoices_pending'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Factures en retard</span>
                        <span class="font-medium text-red-600">{{ $stats['overdue_invoices'] }}</span>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Performance financière</h3>
                <div class="mt-4 text-sm text-slate-600 space-y-3">
                    <div class="flex justify-between">
                        <span>Revenu encaissé</span>
                        <span class="font-medium text-green-600">{{ number_format($extra['totalRevenue'] ?? 0, 0, ',', ' ') }} €</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Contacts récents</span>
                        <span class="font-medium">{{ $stats['contacts'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Opportunités totales</span>
                        <span class="font-medium">{{ $stats['opportunities'] }}</span>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Gestion rapide</h3>
                <div class="mt-4 grid gap-3">
                    <a href="{{ route('users.index') }}" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100">Utilisateurs</a>
                    <a href="{{ route('invoices.index') }}" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100">Factures</a>
                    <a href="{{ route('contacts.index') }}" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100">Contacts</a>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Derniers utilisateurs</h3>
                <div class="mt-4 space-y-3 text-sm text-slate-700">
                    @foreach($extra['latestUsers'] as $userRow)
                        <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                            <div class="font-medium">{{ $userRow->name }}</div>
                            <div class="text-slate-500">{{ $userRow->email }} · {{ $userRow->roleLabel() }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Analyse rapide</h3>
                <div class="mt-4 text-sm text-slate-600 space-y-3">
                    <div class="flex justify-between">
                        <span>Clients</span>
                        <span class="font-medium">{{ $stats['contacts'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Factures</span>
                        <span class="font-medium">{{ $stats['invoices'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Opportunités</span>
                        <span class="font-medium">{{ $stats['opportunities'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-slate-900">Vue générale</h3>
            <div class="mt-4">
                <canvas id="adminChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const adminCtx = document.getElementById('adminChart').getContext('2d');
        new Chart(adminCtx, {
            type: 'bar',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Nombre',
                    data: @json($chartData['values']),
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(251, 191, 36, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
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
