<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM Gestion Clients</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 text-slate-900 font-sans">
    @auth
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-indigo-600 to-blue-600 text-white shadow-xl flex flex-col">
            <div class="p-6 border-b border-indigo-500">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold">ProCRM</h1>
                        <p class="text-xs text-indigo-200">Gestion clients</p>
                    </div>
                </a>
            </div>

            <nav class="p-4 space-y-2 flex-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-500 transition duration-200 font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4m0 0l4 4m-4-4v4" /></svg>
                    Tableau de bord
                </a>

                <a href="{{ route('contacts.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-500 transition duration-200 font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm0 0h6v-2a6 6 0 00-9-5.197m0 0A7.001 7.001 0 0027 13" /></svg>
                    Contacts
                </a>

                @if(auth()->user()->isAdmin() || auth()->user()->isCommercial() || auth()->user()->isDirectorCommercial())
                    <a href="{{ route('opportunities.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-500 transition duration-200 font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        Opportunités
                    </a>
                @endif

                <a href="{{ route('quotes.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-500 transition duration-200 font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Devis
                </a>

                @if(auth()->user()->isAdmin() || auth()->user()->isCommercial() || auth()->user()->isDirectorCommercial())
                    <a href="{{ route('activities.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-500 transition duration-200 font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" /></svg>
                        Activités
                    </a>
                @endif

                @if(auth()->user()->isAdmin() || auth()->user()->isMarketing())
                    <a href="{{ route('campaigns.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-500 transition duration-200 font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" /></svg>
                        Campagnes
                    </a>
                @endif

                <a href="{{ route('invoices.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-500 transition duration-200 font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Factures
                </a>

                @if(auth()->user()->isAdmin() || auth()->user()->isAdministrationRole())
                    <a href="{{ route('administration.recouvrement') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-500 transition duration-200 font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Recouvrement
                    </a>
                    <a href="{{ route('invoices.export.fec') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-500 transition duration-200 font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        Export FEC
                    </a>
                @endif

                @if(auth()->user()->isAdmin())
                    <div class="border-t border-indigo-400 my-2 pt-2">
                        <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-500 transition duration-200 font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m0 0A7.001 7.001 0 0027 13" /></svg>
                            Utilisateurs
                        </a>
                    </div>
                @endif
            </nav>

            <div class="mt-auto p-4 border-t border-indigo-500">
                <div class="bg-indigo-500 rounded-lg p-4 mb-4">
                    <p class="text-xs text-indigo-100 font-semibold">Connecté en tant que</p>
                    <p class="text-sm font-bold mt-1">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-indigo-200">{{ auth()->user()->roleLabel() }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">Déconnexion</button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <div class="bg-white border-b border-slate-200 shadow-sm">
                <div class="px-8 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">Bienvenue</h2>
                        <p class="text-sm text-slate-500">{{ now()->format('l j F Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Main Area -->
            <main class="flex-1 overflow-auto p-8">
                @if(session('success'))
                    <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 animate-pulse">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 p-4 text-rose-800">
                        <div class="flex gap-3 mb-2">
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                            <span class="font-medium">Erreurs détectées</span>
                        </div>
                        <ul class="list-disc space-y-1 pl-8 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @else
        <div class="min-h-screen flex items-center justify-center">
            @yield('content')
        </div>
    @endauth
</body>
</html>
