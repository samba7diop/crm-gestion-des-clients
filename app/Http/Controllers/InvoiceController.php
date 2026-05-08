<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceReminderMail;
use App\Models\HistoryLog;
use App\Models\Invoice;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('quote')->latest();

        if (Auth::user()->isCommercial()) {
            $query->whereHas('quote.contact', function ($query) {
                $query->where('commercial_id', Auth::id());
            });
        }

        if ($request->filled('statut_paiement')) {
            $query->where('statut_paiement', $request->string('statut_paiement'));
        }

        if ($request->boolean('overdue')) {
            $query->whereDate('date_echeance', '<', now()->toDateString())
                ->whereIn('statut_paiement', ['en_attente', 'en_retard']);
        }

        $invoices = $query->paginate(15);

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $quotes = Quote::orderBy('id', 'desc')->get();

        return view('invoices.create', compact('quotes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'quote_id' => 'required|exists:quotes,id',
            'numero' => 'required|string|max:255|unique:invoices,numero',
            'montant' => 'required|numeric|min:0',
            'date_echeance' => 'required|date',
            'statut_paiement' => 'required|in:en_attente,paye,en_retard,annule',
        ]);

        $invoice = Invoice::create($validated);

        HistoryLog::create([
            'model_type' => Invoice::class,
            'model_id' => $invoice->id,
            'action' => 'create',
            'changes' => $validated,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('invoices.index')->with('success', 'Facture créée.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('quote.contact');

        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $quotes = Quote::orderBy('id', 'desc')->get();

        return view('invoices.edit', compact('invoice', 'quotes'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'quote_id' => 'required|exists:quotes,id',
            'numero' => 'required|string|max:255|unique:invoices,numero,' . $invoice->id,
            'montant' => 'required|numeric|min:0',
            'date_echeance' => 'required|date',
            'statut_paiement' => 'required|in:en_attente,paye,en_retard,annule',
        ]);

        $invoice->update($validated);

        HistoryLog::create([
            'model_type' => Invoice::class,
            'model_id' => $invoice->id,
            'action' => 'update',
            'changes' => $validated,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('invoices.index')->with('success', 'Facture mise à jour.');
    }

    public function destroy(Invoice $invoice)
    {
        HistoryLog::create([
            'model_type' => Invoice::class,
            'model_id' => $invoice->id,
            'action' => 'delete',
            'changes' => $invoice->toArray(),
            'user_id' => Auth::id(),
        ]);

        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Facture supprimée.');
    }

    public function sendReminder(Invoice $invoice)
    {
        $invoice->load('quote.contact');

        if (! $invoice->quote || ! $invoice->quote->contact) {
            return back()->with('error', 'Impossible d’envoyer la relance : contact ou devis introuvable.');
        }

        Mail::to($invoice->quote->contact->email)->send(new InvoiceReminderMail($invoice));

        $invoice->update(['statut_paiement' => 'en_retard']);

        HistoryLog::create([
            'model_type' => Invoice::class,
            'model_id' => $invoice->id,
            'action' => 'send_reminder',
            'changes' => ['status' => $invoice->statut_paiement],
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Relance envoyée au contact.');
    }

    public function recouvrement(Request $request)
    {
        $query = Invoice::with('quote.contact')
            ->orderBy('date_echeance');

        if ($request->filled('statut_paiement')) {
            $query->where('statut_paiement', $request->string('statut_paiement'));
        } else {
            $query->whereIn('statut_paiement', ['en_attente', 'en_retard']);
        }

        $query->whereDate('date_echeance', '<=', now()->toDateString());

        $invoices = $query->paginate(20)->withQueryString();

        $stats = [
            'pending' => Invoice::where('statut_paiement', 'en_attente')->count(),
            'overdue' => Invoice::where('statut_paiement', 'en_retard')->count(),
            'total_due' => Invoice::whereIn('statut_paiement', ['en_attente', 'en_retard'])->sum('montant'),
        ];

        return view('administration.recouvrement', compact('invoices', 'stats'));
    }

    public function updatePaymentStatus(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'statut_paiement' => 'required|in:en_attente,paye,en_retard,annule',
        ]);

        $invoice->update($validated);

        HistoryLog::create([
            'model_type' => Invoice::class,
            'model_id' => $invoice->id,
            'action' => 'update_payment_status',
            'changes' => $validated,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Statut de paiement mis à jour.');
    }

    public function exportFec()
    {
        $invoices = Invoice::with('quote.contact')->orderBy('date_echeance')->get();
        $csv = 'Numero,Contact,Montant,DateFacture,DateEcheance,Statut\n';

        foreach ($invoices as $invoice) {
            $csv .= sprintf(
                '"%s","%s","%s","%s","%s","%s"\n',
                $invoice->numero,
                $invoice->quote?->contact?->nom ?? '—',
                $invoice->montant,
                $invoice->created_at->toDateString(),
                $invoice->date_echeance->toDateString(),
                $invoice->statut_paiement,
            );
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="fec-invoices.csv"',
        ]);
    }
}
