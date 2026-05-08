<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\HistoryLog;
use App\Models\Product;
use App\Models\Quote;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Quote::with('contact')->latest();

        if (Auth::user()->isCommercial()) {
            $query->whereHas('contact', function ($query) {
                $query->where('commercial_id', Auth::id());
            });
        }

        $quotes = $query->paginate(15);

        return view('quotes.index', compact('quotes'));
    }

    public function create()
    {
        $contacts = Contact::orderBy('nom')->get();
        $products = Product::orderBy('nom')->get();

        return view('quotes.create', compact('contacts', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'lignes' => 'nullable|string',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'total_ht' => 'required|numeric|min:0',
            'tva' => 'required|numeric|min:0',
            'total_ttc' => 'required|numeric|min:0',
            'statut' => 'required|in:brouillon,envoye,accepte,refuse',
            'date_validite' => 'required|date',
        ]);

        $validated['lignes'] = $this->buildQuoteLines($validated);
        $validated['signature_status'] = 'pending';

        $quote = Quote::create($validated);

        HistoryLog::create([
            'model_type' => Quote::class,
            'model_id' => $quote->id,
            'action' => 'create',
            'changes' => $validated,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('quotes.index')->with('success', 'Devis créé avec succès.');
    }

    public function show(Quote $quote)
    {
        $quote->load('contact');

        return view('quotes.show', compact('quote'));
    }

    public function edit(Quote $quote)
    {
        $contacts = Contact::orderBy('nom')->get();
        $products = Product::orderBy('nom')->get();

        return view('quotes.edit', compact('quote', 'contacts', 'products'));
    }

    public function update(Request $request, Quote $quote)
    {
        $validated = $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'lignes' => 'nullable|string',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'total_ht' => 'required|numeric|min:0',
            'tva' => 'required|numeric|min:0',
            'total_ttc' => 'required|numeric|min:0',
            'statut' => 'required|in:brouillon,envoye,accepte,refuse',
            'date_validite' => 'required|date',
            'signature_status' => 'nullable|in:pending,signed,declined',
        ]);

        $validated['lignes'] = $this->buildQuoteLines($validated);

        $quote->update($validated);

        HistoryLog::create([
            'model_type' => Quote::class,
            'model_id' => $quote->id,
            'action' => 'update',
            'changes' => $validated,
            'user_id' => Auth::id(),
        ]);

        if ($quote->statut === 'accepte' && ! $quote->invoice) {
            Invoice::create([
                'quote_id' => $quote->id,
                'numero' => 'INV-' . now()->format('Ymd') . '-' . $quote->id,
                'montant' => $quote->total_ttc,
                'date_echeance' => now()->addDays(30)->toDateString(),
                'statut_paiement' => 'en_attente',
            ]);
        }

        return redirect()->route('quotes.index')->with('success', 'Devis mis à jour.');
    }

    public function destroy(Quote $quote)
    {
        HistoryLog::create([
            'model_type' => Quote::class,
            'model_id' => $quote->id,
            'action' => 'delete',
            'changes' => $quote->toArray(),
            'user_id' => Auth::id(),
        ]);

        $quote->delete();

        return redirect()->route('quotes.index')->with('success', 'Devis supprimé.');
    }

    protected function buildQuoteLines(array $data): array
    {
        if (! empty($data['product_ids'])) {
            return Product::whereIn('id', $data['product_ids'])->get()->map(function (Product $product) {
                return [
                    'nom' => $product->nom,
                    'description' => $product->description,
                    'quantite' => 1,
                    'prix_unitaire' => $product->prix_unitaire,
                    'total' => $product->prix_unitaire,
                ];
            })->toArray();
        }

        if (! empty($data['lignes'])) {
            $lines = json_decode($data['lignes'], true);
            return is_array($lines) ? $lines : [];
        }

        return [];
    }
}
