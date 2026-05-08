@extends('layouts.app')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Nouveau contact</h1>
                <p class="text-sm text-slate-500">Ajoutez un prospect ou client dans le CRM.</p>
            </div>
            <a href="{{ route('contacts.index') }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200">Retour</a>
        </div>

        <form action="{{ route('contacts.store') }}" method="POST" class="space-y-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nom</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Entreprise</label>
                    <input type="text" name="entreprise" value="{{ old('entreprise') }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Téléphone</label>
                    <input type="text" name="telephone" value="{{ old('telephone') }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Source</label>
                    <select name="source" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
                        <option value="">Sélectionner</option>
                        <option value="website"{{ old('source') === 'website' ? ' selected' : '' }}>Site web</option>
                        <option value="referral"{{ old('source') === 'referral' ? ' selected' : '' }}>Recommandation</option>
                        <option value="email"{{ old('source') === 'email' ? ' selected' : '' }}>Email</option>
                        <option value="campagne"{{ old('source') === 'campagne' ? ' selected' : '' }}>Campagne</option>
                        <option value="salon"{{ old('source') === 'salon' ? ' selected' : '' }}>Salon</option>
                        <option value="autre"{{ old('source') === 'autre' ? ' selected' : '' }}>Autre</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Secteur</label>
                    <select name="secteur" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
                        <option value="">Sélectionner</option>
                        <option value="industrie"{{ old('secteur') === 'industrie' ? ' selected' : '' }}>Industrie</option>
                        <option value="services"{{ old('secteur') === 'services' ? ' selected' : '' }}>Services</option>
                        <option value="retail"{{ old('secteur') === 'retail' ? ' selected' : '' }}>Retail</option>
                        <option value="sante"{{ old('secteur') === 'sante' ? ' selected' : '' }}>Santé</option>
                        <option value="tech"{{ old('secteur') === 'tech' ? ' selected' : '' }}>Technologie</option>
                        <option value="autre"{{ old('secteur') === 'autre' ? ' selected' : '' }}>Autre</option>
                    </select>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Taille entreprise</label>
                    <select name="taille" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
                        <option value="">Sélectionner</option>
                        <option value="petite"{{ old('taille') === 'petite' ? ' selected' : '' }}>Petite (1-10 employés)</option>
                        <option value="moyenne"{{ old('taille') === 'moyenne' ? ' selected' : '' }}>Moyenne (11-50 employés)</option>
                        <option value="grande"{{ old('taille') === 'grande' ? ' selected' : '' }}>Grande (50+ employés)</option>
                        <option value="autre"{{ old('taille') === 'autre' ? ' selected' : '' }}>Autre</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Statut</label>
                    <select name="statut" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                        <option value="prospect"{{ old('statut', 'prospect') === 'prospect' ? ' selected' : '' }}>Prospect</option>
                        <option value="client"{{ old('statut') === 'client' ? ' selected' : '' }}>Client</option>
                        <option value="ancien_client"{{ old('statut') === 'ancien_client' ? ' selected' : '' }}>Ancien client</option>
                    </select>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Commercial</label>
                    <select name="commercial_id" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
                        <option value="">Non assigné</option>
                        @foreach($commercials as $commercial)
                            <option value="{{ $commercial->id }}"{{ old('commercial_id') == $commercial->id ? ' selected' : '' }}>{{ $commercial->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Tags (séparés par des virgules)</label>
                <input type="text" name="tags" value="{{ old('tags') }}" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="rounded-md bg-slate-900 px-5 py-2 text-sm font-medium text-white hover:bg-slate-700">Enregistrer</button>
            </div>
        </form>
    </div>
@endsection
