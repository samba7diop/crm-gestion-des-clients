<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\HistoryLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::with('commercial')->latest();

        if (Auth::user()->isCommercial()) {
            $query->where('commercial_id', Auth::id());
        }

        if ($request->filled('search')) {
            $query->where(function ($sub) use ($request) {
                $sub->where('nom', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('entreprise', 'like', '%' . $request->search . '%');
            });
        }

        foreach (['statut', 'secteur', 'taille'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->input($field));
            }
        }

        if ($request->filled('tag')) {
            $query->whereJsonContains('tags', $request->input('tag'));
        }

        $contacts = $query->paginate(15)->withQueryString();

        return view('contacts.index', compact('contacts'));
    }

    public function create()
    {
        $commercials = User::orderBy('name')->get();

        return view('contacts.create', compact('commercials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'entreprise' => 'nullable|string|max:255',
            'email' => 'required|email|unique:contacts,email',
            'telephone' => 'nullable|string|max:50',
            'source' => 'nullable|string|max:100',
            'secteur' => 'nullable|string|max:100',
            'taille' => 'nullable|string|max:100',
            'score' => 'nullable|integer|min:0|max:100',
            'tags' => 'nullable|string',
            'statut' => 'required|in:prospect,client,ancien_client',
            'commercial_id' => 'nullable|exists:users,id',
        ]);

        $validated['tags'] = $this->parseTags($validated['tags'] ?? '');
        $validated['score'] = $this->buildScore($validated);
        $validated['commercial_id'] = $validated['commercial_id'] ?? (Auth::user()->isCommercial() ? Auth::id() : null);

        $contact = Contact::create($validated);

        HistoryLog::create([
            'model_type' => Contact::class,
            'model_id' => $contact->id,
            'action' => 'create',
            'changes' => $validated,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('contacts.index')->with('success', 'Contact créé avec succès.');
    }

    public function show(Contact $contact)
    {
        $contact->load(['activities', 'historyLogs', 'opportunities', 'quotes']);

        return view('contacts.show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        $commercials = User::orderBy('name')->get();

        return view('contacts.edit', compact('contact', 'commercials'));
    }

    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'entreprise' => 'nullable|string|max:255',
            'email' => 'required|email|unique:contacts,email,' . $contact->id,
            'telephone' => 'nullable|string|max:50',
            'source' => 'nullable|string|max:100',
            'secteur' => 'nullable|string|max:100',
            'taille' => 'nullable|string|max:100',
            'score' => 'nullable|integer|min:0|max:100',
            'tags' => 'nullable|string',
            'statut' => 'required|in:prospect,client,ancien_client',
            'commercial_id' => 'nullable|exists:users,id',
        ]);

        $validated['tags'] = $this->parseTags($validated['tags'] ?? '');
        $validated['score'] = $validated['score'] ?? $this->buildScore($validated);

        $changes = $contact->getChanges();
        $contact->update($validated);

        HistoryLog::create([
            'model_type' => Contact::class,
            'model_id' => $contact->id,
            'action' => 'update',
            'changes' => array_merge($changes, $validated),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('contacts.index')->with('success', 'Contact mis à jour avec succès.');
    }

    public function destroy(Contact $contact)
    {
        HistoryLog::create([
            'model_type' => Contact::class,
            'model_id' => $contact->id,
            'action' => 'delete',
            'changes' => $contact->toArray(),
            'user_id' => Auth::id(),
        ]);

        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contact supprimé.');
    }

    public function importForm()
    {
        return view('contacts.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $path = $request->file('file')->getRealPath();
        $rows = array_map('str_getcsv', file($path));
        $header = array_map('strtolower', array_shift($rows));

        $imported = 0;
        $merged = 0;

        foreach ($rows as $row) {
            $row = array_combine($header, $row);
            if (! $row || empty($row['email'])) {
                continue;
            }

            $data = [
                'nom' => $row['nom'] ?? 'Contact',
                'entreprise' => $row['entreprise'] ?? null,
                'email' => $row['email'],
                'telephone' => $row['telephone'] ?? null,
                'source' => $row['source'] ?? null,
                'secteur' => $row['secteur'] ?? null,
                'taille' => $row['taille'] ?? null,
                'statut' => $row['statut'] ?? 'prospect',
                'tags' => $this->parseTags($row['tags'] ?? ''),
                'score' => $this->buildScore($row),
            ];

            $existing = Contact::where('email', $data['email'])
                ->orWhere('telephone', $data['telephone'])->first();

            if ($existing) {
                $existing->update(array_filter($data));
                $merged++;
                HistoryLog::create([
                    'model_type' => Contact::class,
                    'model_id' => $existing->id,
                    'action' => 'merge_import',
                    'changes' => $existing->getChanges(),
                    'user_id' => Auth::id(),
                ]);
            } else {
                Contact::create($data);
                $imported++;
            }
        }

        return redirect()->route('contacts.index')->with('success', "Import terminé : $imported contacts ajoutés, $merged doublons fusionnés.");
    }

    public function export(Request $request)
    {
        $format = $request->query('format', 'csv');
        $contacts = Contact::with('commercial')->orderBy('nom')->get();

        if ($format === 'json') {
            return response()->json($contacts);
        }

        $csv = 'Nom,Entreprise,Email,Telephone,Source,Secteur,Taille,Statut,Commercial,Score,Tags\n';
        foreach ($contacts as $contact) {
            $csv .= sprintf(
                '"%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s"\n',
                $contact->nom,
                $contact->entreprise,
                $contact->email,
                $contact->telephone,
                $contact->source,
                $contact->secteur,
                $contact->taille,
                $contact->statut,
                $contact->commercial?->name,
                $contact->score,
                implode(',', $contact->tags ?? []),
            );
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="contacts-export.csv"',
        ]);
    }

    protected function parseTags(string $tags): array
    {
        return array_filter(array_map('trim', explode(',', $tags)));
    }

    protected function buildScore(array $data): int
    {
        $score = $data['score'] ?? 0;
        $score += config('crm.lead_scoring.source.' . strtolower($data['source'] ?? 'autre'), 0);
        $score += config('crm.lead_scoring.secteur.' . strtolower($data['secteur'] ?? 'autre'), 0);
        $size = strtolower($data['taille'] ?? 'autre');
        $score += config('crm.lead_scoring.entreprise_size.' . $size, 0);

        return min(max($score, 0), 100);
    }
}
