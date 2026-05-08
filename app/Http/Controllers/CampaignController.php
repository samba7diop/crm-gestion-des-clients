<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CampaignController extends Controller
{
    private function authorizeMarketing(): void
    {
        if (!Auth::check() || !Auth::user()->isMarketing()) {
            abort(403);
        }
    }

    public function index()
    {
        $this->authorizeMarketing();

        $campaigns = Campaign::latest()->paginate(15);

        return view('campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        $this->authorizeMarketing();

        $contacts = Contact::orderBy('nom')->get();

        return view('campaigns.create', compact('contacts'));
    }

    public function store(Request $request)
    {
        $this->authorizeMarketing();

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|in:newsletter,promotion,relance',
            'template_id' => 'nullable|integer',
            'destinataires' => 'required|array|min:1',
            'destinataires.*' => 'exists:contacts,id',
            'date_envoi' => 'nullable|date',
            'stats' => 'nullable|array',
        ]);

        $validated['stats'] = $validated['stats'] ?? [];

        Campaign::create($validated);

        return redirect()->route('campaigns.index')->with('success', 'Campagne créée.');
    }

    public function show(Campaign $campaign)
    {
        $this->authorizeMarketing();

        $recipients = Contact::whereIn('id', $campaign->destinataires ?? [])->orderBy('nom')->get();

        return view('campaigns.show', compact('campaign', 'recipients'));
    }

    public function edit(Campaign $campaign)
    {
        $this->authorizeMarketing();

        $contacts = Contact::orderBy('nom')->get();

        return view('campaigns.edit', compact('campaign', 'contacts'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $this->authorizeMarketing();

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|in:newsletter,promotion,relance',
            'template_id' => 'nullable|integer',
            'destinataires' => 'required|array|min:1',
            'destinataires.*' => 'exists:contacts,id',
            'date_envoi' => 'nullable|date',
            'stats' => 'nullable|array',
        ]);

        $validated['stats'] = $validated['stats'] ?? [];

        $campaign->update($validated);

        return redirect()->route('campaigns.index')->with('success', 'Campagne mise à jour.');
    }

    public function destroy(Campaign $campaign)
    {
        $this->authorizeMarketing();

        $campaign->delete();

        return redirect()->route('campaigns.index')->with('success', 'Campagne supprimée.');
    }

    public function send(Campaign $campaign)
    {
        $this->authorizeMarketing();

        // Logique d'envoi de campagne
        // Pour l'instant, on marque juste comme envoyée
        $campaign->update(['statut' => 'envoyee']);

        return redirect()->route('campaigns.index')->with('success', 'Campagne envoyée.');
    }
}
