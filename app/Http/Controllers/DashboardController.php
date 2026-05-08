<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\Invoice;
use App\Models\Opportunity;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $cards = $user->dashboard_preferences['cards'] ?? null;
        $extra = [];

        if ($user->isCommercial()) {
            $stats = [
                'contacts' => Contact::where('commercial_id', $user->id)->count(),
                'lead_contacts' => Contact::where('commercial_id', $user->id)->where('statut', 'prospect')->count(),
                'client_contacts' => Contact::where('commercial_id', $user->id)->where('statut', 'client')->count(),
                'opportunities' => Opportunity::where('commercial_id', $user->id)->count(),
                'quotes' => Quote::whereHas('contact', function ($query) use ($user) {
                    $query->where('commercial_id', $user->id);
                })->count(),
                'activities' => Activity::where('commercial_id', $user->id)->count(),
                'invoices' => Invoice::whereHas('quote.contact', function ($query) use ($user) {
                    $query->where('commercial_id', $user->id);
                })->count(),
                'invoices_paid' => Invoice::where('statut_paiement', 'paye')
                    ->whereHas('quote.contact', fn ($query) => $query->where('commercial_id', $user->id))->count(),
                'invoices_pending' => Invoice::where('statut_paiement', 'en_attente')
                    ->whereHas('quote.contact', fn ($query) => $query->where('commercial_id', $user->id))->count(),
                'quotes_accepted' => Quote::where('statut', 'accepte')
                    ->whereHas('contact', fn ($query) => $query->where('commercial_id', $user->id))->count(),
                'forecast' => Opportunity::where('commercial_id', $user->id)->selectRaw('COALESCE(SUM(valeur * probabilite / 100), 0) as forecast')->value('forecast'),
                'inactive_opportunities' => Opportunity::where('commercial_id', $user->id)
                    ->where('updated_at', '<', now()->subDays(14))->whereNotIn('etape', ['gagne', 'perdu'])->count(),
                'users' => User::count(),
            ];

            $extra = [
                'contactsBySource' => Contact::where('commercial_id', $user->id)
                    ->selectRaw('source, COUNT(*) as count')
                    ->groupBy('source')
                    ->get(),
                'recentActivities' => Activity::where('commercial_id', $user->id)->latest()->limit(6)->get(),
                'myWinRate' => Opportunity::where('commercial_id', $user->id)->count() > 0
                    ? round(Opportunity::where('commercial_id', $user->id)->where('etape', 'gagne')->count() / Opportunity::where('commercial_id', $user->id)->count() * 100, 2)
                    : 0,
            ];

            $chartData = [
                'labels' => ['Contacts', 'Opportunités', 'Devis', 'Factures'],
                'values' => [
                    $stats['contacts'],
                    $stats['opportunities'],
                    $stats['quotes'],
                    $stats['invoices'],
                ],
            ];

            return view('dashboard.commercial', compact('stats', 'user', 'chartData', 'cards', 'extra'));
        } elseif ($user->isMarketing()) {
            $stats = [
                'contacts' => Contact::count(),
                'lead_contacts' => Contact::where('statut', 'prospect')->count(),
                'new_leads' => Contact::where('statut', 'prospect')->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count(),
                'campaigns' => Campaign::count(),
                'active_campaigns' => Campaign::where('statut', 'active')->count(),
                'high_score_leads' => Contact::where('statut', 'prospect')->where('score', '>=', 80)->count(),
                'medium_score_leads' => Contact::where('statut', 'prospect')->whereBetween('score', [50, 79])->count(),
                'low_score_leads' => Contact::where('statut', 'prospect')->where('score', '<', 50)->count(),
                'quotes' => Quote::count(),
                'invoices' => Invoice::count(),
                'invoices_paid' => Invoice::where('statut_paiement', 'paye')->count(),
                'invoices_pending' => Invoice::where('statut_paiement', 'en_attente')->count(),
                'quotes_accepted' => Quote::where('statut', 'accepte')->count(),
                'forecast' => 0,
                'inactive_opportunities' => 0,
                'users' => User::count(),
            ];

            $extra = [
                'leadsBySource' => Contact::where('statut', 'prospect')
                    ->selectRaw('source, COUNT(*) as count')
                    ->groupBy('source')
                    ->get(),
                'leadsBySector' => Contact::where('statut', 'prospect')
                    ->selectRaw('secteur, COUNT(*) as count')
                    ->groupBy('secteur')
                    ->get(),
                'leadsBySize' => Contact::where('statut', 'prospect')
                    ->selectRaw('taille, COUNT(*) as count')
                    ->groupBy('taille')
                    ->get(),
                'recentCampaigns' => Campaign::latest()->limit(5)->get(),
            ];

            $chartData = [
                'labels' => ['Leads', 'Campagnes', 'Devis', 'Factures'],
                'values' => [
                    $stats['lead_contacts'],
                    $stats['campaigns'],
                    $stats['quotes'],
                    $stats['invoices'],
                ],
            ];

            return view('dashboard.marketing', compact('stats', 'user', 'chartData', 'cards', 'extra'));
        } elseif ($user->isAdmin()) {
            $stats = [
                'users' => User::count(),
                'contacts' => Contact::count(),
                'opportunities' => Opportunity::count(),
                'quotes' => Quote::count(),
                'invoices' => Invoice::count(),
                'invoices_paid' => Invoice::where('statut_paiement', 'paye')->count(),
                'invoices_pending' => Invoice::where('statut_paiement', 'en_attente')->count(),
                'overdue_invoices' => Invoice::where('statut_paiement', 'en_retard')->count(),
                'active_campaigns' => Campaign::where('statut', 'active')->count(),
            ];

            $extra = [
                'latestUsers' => User::latest()->limit(6)->get(),
                'topContacts' => Contact::with('commercial')->orderByDesc('created_at')->limit(6)->get(),
                'totalRevenue' => Invoice::where('statut_paiement', 'paye')->sum('montant'),
            ];

            $chartData = [
                'labels' => ['Utilisateurs', 'Contacts', 'Opportunités', 'Factures'],
                'values' => [
                    $stats['users'],
                    $stats['contacts'],
                    $stats['opportunities'],
                    $stats['invoices'],
                ],
            ];

            return view('dashboard.admin', compact('stats', 'user', 'chartData', 'cards', 'extra'));
        } elseif ($user->isDirectorCommercial()) {
            $stats = [
                'contacts' => Contact::count(),
                'opportunities' => Opportunity::count(),
                'quotes' => Quote::count(),
                'invoices' => Invoice::count(),
                'invoices_paid' => Invoice::where('statut_paiement', 'paye')->count(),
                'forecast' => Opportunity::selectRaw('COALESCE(SUM(valeur * probabilite / 100), 0) as forecast')->value('forecast'),
                'win_rate' => Opportunity::count() > 0
                    ? round(Opportunity::where('etape', 'gagne')->count() / Opportunity::count() * 100, 1)
                    : 0,
                'team_opportunities' => Opportunity::count(),
                'team_quotes' => Quote::count(),
                'team_invoices' => Invoice::count(),
            ];

            $extra = [
                'pipelineByStage' => Opportunity::selectRaw('etape, COUNT(*) as total')
                    ->groupBy('etape')
                    ->orderByDesc('total')
                    ->get(),
                'topPerformers' => Contact::selectRaw('commercial_id, COUNT(*) as total_contacts')
                    ->whereNotNull('commercial_id')
                    ->groupBy('commercial_id')
                    ->with('commercial')
                    ->orderByDesc('total_contacts')
                    ->limit(5)
                    ->get(),
                'recentQuotes' => Quote::latest()->limit(5)->get(),
            ];

            $chartData = [
                'labels' => ['Contacts', 'Opportunités', 'Devis', 'Factures'],
                'values' => [
                    $stats['contacts'],
                    $stats['opportunities'],
                    $stats['quotes'],
                    $stats['invoices'],
                ],
            ];

            return view('dashboard.director', compact('stats', 'user', 'chartData', 'cards', 'extra'));
        } elseif ($user->isAdministrationRole()) {
            $stats = [
                'invoices' => Invoice::count(),
                'invoices_paid' => Invoice::where('statut_paiement', 'paye')->count(),
                'invoices_pending' => Invoice::where('statut_paiement', 'en_attente')->count(),
                'invoices_overdue' => Invoice::where('statut_paiement', 'en_retard')->count(),
                'total_due' => Invoice::where('statut_paiement', 'en_attente')->sum('montant'),
                'processed_amount' => Invoice::where('statut_paiement', 'paye')->sum('montant'),
            ];

            $extra = [
                'recentInvoices' => Invoice::latest()->limit(6)->get(),
                'pendingContacts' => Contact::where('statut', 'prospect')->count(),
            ];

            $chartData = [
                'labels' => ['Payées', 'En attente', 'En retard'],
                'values' => [
                    $stats['invoices_paid'],
                    $stats['invoices_pending'],
                    $stats['invoices_overdue'],
                ],
            ];

            return view('dashboard.administration', compact('stats', 'user', 'chartData', 'cards', 'extra'));
        }
    }
}
