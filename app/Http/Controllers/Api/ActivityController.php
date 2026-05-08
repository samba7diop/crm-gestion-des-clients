<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends BaseApiController
{
    public function index(Request $request)
    {
        $this->authorizeRequest($request);

        return Activity::with(['contact', 'commercial'])->latest()->paginate(20);
    }

    public function show(Request $request, Activity $activity)
    {
        $this->authorizeRequest($request);

        return $activity->load(['contact', 'commercial']);
    }
}
