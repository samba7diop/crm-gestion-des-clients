@extends('layouts.app')

@section('content')
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-200">
            <!-- Header avec gradient -->
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 p-8 text-white">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-center">ProCRM</h1>
                <p class="text-center text-indigo-100 text-sm mt-1">Plateforme de gestion clients</p>
            </div>

            <!-- Form -->
            <div class="p-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-2">Se connecter</h2>
                <p class="text-slate-600 text-sm mb-6">Accédez à votre espace de travail professionnel</p>

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                Adresse e-mail
                            </span>
                        </label>
                        <input 
                            type="email" 
                            id="email"
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            class="w-full px-4 py-3 rounded-lg border border-slate-300 bg-slate-50 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
                            placeholder="vous@exemple.com"
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-rose-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18.101 12.93a1 1 0 00-1.414-1.414L10 15.586 7.707 13.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l6-6z" clip-rule="evenodd" /></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                Mot de passe
                            </span>
                        </label>
                        <input 
                            type="password" 
                            id="password"
                            name="password" 
                            required 
                            class="w-full px-4 py-3 rounded-lg border border-slate-300 bg-slate-50 text-slate-900 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
                            placeholder="••••••••"
                        >
                    </div>

                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="remember"
                            name="remember" 
                            class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500"
                        >
                        <label for="remember" class="ml-2 text-sm text-slate-600">Se souvenir de moi</label>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:from-indigo-700 hover:to-blue-700 transition duration-200 shadow-lg hover:shadow-xl transform hover:scale-105"
                    >
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                            Se connecter
                        </span>
                    </button>
                </form>

                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-xs text-blue-800 font-medium mb-2">Comptes de test disponibles :</p>
                    <div class="text-xs text-blue-700 space-y-1">
                        <p><span class="font-semibold">Admin :</span> ngaidoaissata19@gmail.com / password</p>
                        <p><span class="font-semibold">Commercial :</span> commercial@gmail.com / password</p>
                       
                        <p><span class="font-semibold">Marketing :</span> senecodou@gmail.com / password</p>
                        <p><span class="font-semibold">Directeur commercial :</span> directeurcommercial@gmail.com / Password</p>
                        <p><span class="font-semibold">Administration :</span> konteaicha@gmail.com/ Password</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-sm text-slate-600">
            <p>ProCRM © 2026 · Tous droits réservés</p>
        </div>
    </div>
@endsection

