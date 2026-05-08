@extends('layouts.app')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Nouvel utilisateur</h1>
                <p class="text-sm text-slate-500">Créez un compte pour un acteur du CRM.</p>
            </div>
            <a href="{{ route('users.index') }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200">Retour</a>
        </div>

        <form action="{{ route('users.store') }}" method="POST" class="space-y-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700">Nom</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Rôle</label>
                <select name="role" required class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
                    <option value="admin"{{ old('role') === 'admin' ? ' selected' : '' }}>Admin</option>
                    <option value="marketing"{{ old('role') === 'marketing' ? ' selected' : '' }}>Marketing</option>
                    <option value="commercial"{{ old('role') === 'commercial' ? ' selected' : '' }}>Commercial</option>
                    <option value="directeur_commercial"{{ old('role') === 'directeur_commercial' ? ' selected' : '' }}>Directeur Commercial</option>
                    <option value="administration"{{ old('role') === 'administration' ? ' selected' : '' }}>Administration</option>
                </select>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Mot de passe</label>
                    <input type="password" name="password" required class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Confirmation du mot de passe</label>
                    <input type="password" name="password_confirmation" required class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="rounded-md bg-slate-900 px-5 py-2 text-sm font-medium text-white hover:bg-slate-700">Créer</button>
            </div>
        </form>
    </div>
@endsection
