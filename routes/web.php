<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Administration (facturation / recouvrement / comptabilité)
    Route::get('administration/recouvrement', [InvoiceController::class, 'recouvrement'])
        ->name('administration.recouvrement')
        ->middleware('role:administration');
    Route::patch('invoices/{invoice}/payment-status', [InvoiceController::class, 'updatePaymentStatus'])
        ->name('invoices.payment-status')
        ->middleware('role:administration');

    // Contacts
    Route::resource('contacts', ContactController::class)
        ->middleware('role:commercial')
        ->except(['index', 'show']);
    Route::resource('contacts', ContactController::class)
        ->only(['index', 'show'])
        ->middleware('role:marketing,directeur_commercial,administration');
    Route::get('contacts/import/form', [ContactController::class, 'importForm'])
        ->name('contacts.import.form')
        ->middleware('role:commercial');
    Route::post('contacts/import', [ContactController::class, 'import'])
        ->name('contacts.import')
        ->middleware('role:commercial');
    Route::get('contacts/export/{format?}', [ContactController::class, 'export'])
        ->name('contacts.export')
        ->middleware('role:commercial,marketing,directeur_commercial,administration');

    // Opportunities (sales only + director)
    Route::resource('opportunities', OpportunityController::class)
        ->middleware('role:commercial,directeur_commercial');
    Route::get('opportunities/kanban', [OpportunityController::class, 'kanban'])
        ->name('opportunities.kanban')
        ->middleware('role:commercial,directeur_commercial');
    Route::post('opportunities/{opportunity}/move', [OpportunityController::class, 'moveStage'])
        ->name('opportunities.move')
        ->middleware('role:commercial,directeur_commercial');

    // Quotes
    Route::resource('quotes', QuoteController::class)
        ->middleware('role:commercial')
        ->except(['index', 'show']);
    Route::resource('quotes', QuoteController::class)
        ->only(['index', 'show'])
        ->middleware('role:marketing,directeur_commercial,administration');

    // Activities (sales only + director)
    Route::resource('activities', ActivityController::class)
        ->middleware('role:commercial,directeur_commercial');

    // Campaigns (marketing only)
    Route::resource('campaigns', CampaignController::class)
        ->middleware('role:marketing');
    Route::post('campaigns/{campaign}/send', [CampaignController::class, 'send'])
        ->name('campaigns.send')
        ->middleware('role:marketing');

    // Invoices (administration full, others read-only)
    Route::resource('invoices', InvoiceController::class)
        ->middleware('role:administration')
        ->except([]);
    Route::resource('invoices', InvoiceController::class)
        ->only(['index', 'show'])
        ->middleware('role:commercial,directeur_commercial,marketing');
    Route::post('invoices/{invoice}/reminder', [InvoiceController::class, 'sendReminder'])
        ->name('invoices.reminder')
        ->middleware('role:administration');
    Route::get('invoices/export/fec', [InvoiceController::class, 'exportFec'])
        ->name('invoices.export.fec')
        ->middleware('role:administration');

    // Users (admin platform only)
    Route::resource('users', UserController::class)
        ->except(['show'])
        ->middleware('role:admin');
});

