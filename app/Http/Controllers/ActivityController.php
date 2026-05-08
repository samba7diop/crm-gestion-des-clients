<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index()
    {
        $query = Activity::with(['contact', 'commercial'])->latest();

        if (Auth::user()->isCommercial()) {
            $query->where('commercial_id', Auth::id());
        }

        $activities = $query->paginate(15);

        return view('activities.index', compact('activities'));
    }

    public function create()
    {
        $contacts = Contact::orderBy('nom')->get();
        $commercials = User::orderBy('name')->get();

        return view('activities.create', compact('contacts', 'commercials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'type' => 'required|in:appel,email,reunion,tache',
            'description' => 'required|string',
            'date' => 'required|date',
            'commercial_id' => 'nullable|exists:users,id',
            'resultat' => 'nullable|string',
            'rappel' => 'sometimes|boolean',
        ]);

        $validated['rappel'] = $request->has('rappel');

        Activity::create($validated);

        return redirect()->route('activities.index')->with('success', 'Activité enregistrée.');
    }

    public function show(Activity $activity)
    {
        $activity->load(['contact', 'commercial']);

        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity)
    {
        $contacts = Contact::orderBy('nom')->get();
        $commercials = User::orderBy('name')->get();

        return view('activities.edit', compact('activity', 'contacts', 'commercials'));
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'type' => 'required|in:appel,email,reunion,tache',
            'description' => 'required|string',
            'date' => 'required|date',
            'commercial_id' => 'nullable|exists:users,id',
            'resultat' => 'nullable|string',
            'rappel' => 'sometimes|boolean',
        ]);

        $validated['rappel'] = $request->has('rappel');

        $activity->update($validated);

        return redirect()->route('activities.index')->with('success', 'Activité mise à jour.');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->route('activities.index')->with('success', 'Activité supprimée.');
    }
}
