<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends BaseApiController
{
    public function index(Request $request)
    {
        $this->authorizeRequest($request);

        return Invoice::with('quote.contact')->latest()->paginate(20);
    }

    public function show(Request $request, Invoice $invoice)
    {
        $this->authorizeRequest($request);

        return $invoice->load('quote.contact');
    }
}
