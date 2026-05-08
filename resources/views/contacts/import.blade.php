@extends('layouts.app')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Importer des contacts</h1>
                <p class="text-sm text-slate-500">Importez des contacts en masse depuis un fichier CSV.</p>
            </div>
            <a href="{{ route('contacts.index') }}" class="rounded-md bg-slate-100 px-4 py-2 text-sm text-slate-700 hover:bg-slate-200">Retour</a>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <form action="{{ route('contacts.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700">Fichier CSV</label>
                    <input type="file" name="file" accept=".csv,.txt" class="mt-2 w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-900" required>
                    <p class="mt-1 text-sm text-slate-500">Colonnes attendues : nom, entreprise, email, telephone, source, secteur, taille, statut, tags</p>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="rounded-md bg-slate-900 px-5 py-2 text-sm font-medium text-white hover:bg-slate-700">Importer</button>
                </div>
            </form>
        </div>
    </div>
@endsection