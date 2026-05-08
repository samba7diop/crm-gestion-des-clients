<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends BaseApiController
{
    public function index(Request $request)
    {
        $this->authorizeRequest($request);

        return Contact::with('commercial')->latest()->paginate(20);
    }

    public function show(Request $request, Contact $contact)
    {
        $this->authorizeRequest($request);

        return $contact->load(['commercial', 'activities', 'quotes']);
    }
}
