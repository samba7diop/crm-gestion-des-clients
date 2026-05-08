<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\HistoryLog;
use App\Models\Opportunity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpportunityController extends Controller
{
    public function index(Request $request)
    {
        $query = Opportunity::with(['contact', 'commercial'])->latest();

        if (Auth::user()->isCommercial()) {
            $query->where('commercial_id', Auth::id());
        }

        if ($request->filled('search')) {
            $query->where('titre', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('etape')) {
            $query->where('etape', $request->etape);
        }

        $opportunities = $query->paginate(15)->withQueryString();
        $stages = config('crm.default_stages');

        return view('opportunities.index', compact('opportunities', 'stages'));
    }

    public function kanban()
    {
        $user = Auth::user();
        $query = Opportunity::with(['contact', 'commercial']);

        if ($user->isCommercial()) {
            $query->where('commercial_id', $user->id);
        }

        $opportunities = $query->get()->groupBy('etape');
        $stages = config('crm.default_stages');

        return view('opportunities.kanban', compact('opportunities', 'stages'));
    }

    public function moveStage(Request $request, Opportunity $opportunity)
    {
        $validated = $request->validate([
            'etape' => 'required|string',
        ]);

        $old = $opportunity->etape;
        $opportunity->update($validated);

        HistoryLog::create([
            'model_type' => Opportunity::class,
            'model_id' => $opportunity->id,
            'action' => 'move_stage',
            'changes' => ['from' => $old, 'to' => $validated['etape']],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('opportunities.kanban')->with('success', 'Opportunité déplacée.');
    }

    public function create()
    {
        $contacts = Contact::orderBy('nom')->get();
        $commercials = User::orderBy('name')->get();
        $types = config('crm.opportunity_types');
        $stages = config('crm.default_stages');

        return view('opportunities.create', compact('contacts', 'commercials', 'types', 'stages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'titre' => 'required|string|max:255',
            'type' => 'required|string',
            'valeur' => 'required|numeric|min:0',
            'probabilite' => 'required|integer|min:0|max:100',
            'etape' => 'required|string|max:255',
            'date_cloture' => 'nullable|date',
            'commercial_id' => 'nullable|exists:users,id',
        ]);

        $validated['commercial_id'] = $validated['commercial_id'] ?? (Auth::user()->isCommercial() ? Auth::id() : null);

        $opportunity = Opportunity::create($validated);

        HistoryLog::create([
            'model_type' => Opportunity::class,
            'model_id' => $opportunity->id,
            'action' => 'create',
            'changes' => $validated,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('opportunities.index')->with('success', 'Opportunité créée avec succès.');
    }

    public function show(Opportunity $opportunity)
    {
        $opportunity->load(['contact', 'commercial', 'historyLogs']);

        return view('opportunities.show', compact('opportunity'));
    }

    public function edit(Opportunity $opportunity)
    {
        $contacts = Contact::orderBy('nom')->get();
        $commercials = User::orderBy('name')->get();
        $types = config('crm.opportunity_types');
        $stages = config('crm.default_stages');

        return view('opportunities.edit', compact('opportunity', 'contacts', 'commercials', 'types', 'stages'));
    }

    public function update(Request $request, Opportunity $opportunity)
    {
        $validated = $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'titre' => 'required|string|max:255',
            'type' => 'required|string',
            'valeur' => 'required|numeric|min:0',
            'probabilite' => 'required|integer|min:0|max:100',
            'etape' => 'required|string|max:255',
            'date_cloture' => 'nullable|date',
            'commercial_id' => 'nullable|exists:users,id',
        ]);

        $opportunity->update($validated);

        HistoryLog::create([
            'model_type' => Opportunity::class,
            'model_id' => $opportunity->id,
            'action' => 'update',
            'changes' => $validated,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('opportunities.index')->with('success', 'Opportunité mise à jour.');
    }

    public function destroy(Opportunity $opportunity)
    {
        HistoryLog::create([
            'model_type' => Opportunity::class,
            'model_id' => $opportunity->id,
            'action' => 'delete',
            'changes' => $opportunity->toArray(),
            'user_id' => Auth::id(),
        ]);

        $opportunity->delete();

        return redirect()->route('opportunities.index')->with('success', 'Opportunité supprimée.');
    }
}
