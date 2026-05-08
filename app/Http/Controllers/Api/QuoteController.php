<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends BaseApiController
{
    public function index(Request $request)
    {
        $this->authorizeRequest($request);

        return Quote::with('contact')->latest()->paginate(20);
    }

    public function show(Request $request, Quote $quote)
    {
        $this->authorizeRequest($request);

        return $quote->load('contact');
    }
}
