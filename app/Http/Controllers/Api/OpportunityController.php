<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Opportunity;
use Illuminate\Http\Request;

class OpportunityController extends BaseApiController
{
    public function index(Request $request)
    {
        $this->authorizeRequest($request);

        return Opportunity::with(['contact', 'commercial'])->latest()->paginate(20);
    }

    public function show(Request $request, Opportunity $opportunity)
    {
        $this->authorizeRequest($request);

        return $opportunity->load(['contact', 'commercial']);
    }
}
