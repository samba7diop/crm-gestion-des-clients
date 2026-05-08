<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\OpportunityController;
use App\Http\Controllers\Api\QuoteController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('contacts', [ContactController::class, 'index']);
    Route::get('contacts/{contact}', [ContactController::class, 'show']);

    Route::get('opportunities', [OpportunityController::class, 'index']);
    Route::get('opportunities/{opportunity}', [OpportunityController::class, 'show']);

    Route::get('quotes', [QuoteController::class, 'index']);
    Route::get('quotes/{quote}', [QuoteController::class, 'show']);

    Route::get('invoices', [InvoiceController::class, 'index']);
    Route::get('invoices/{invoice}', [InvoiceController::class, 'show']);

    Route::get('activities', [ActivityController::class, 'index']);
    Route::get('activities/{activity}', [ActivityController::class, 'show']);
});
