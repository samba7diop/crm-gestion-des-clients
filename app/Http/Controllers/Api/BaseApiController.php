<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class BaseApiController extends BaseController
{
    protected function authorizeRequest(Request $request): User
    {
        $token = str($request->bearerToken())->trim()->toString();

        if (! $token) {
            abort(401, 'Token API manquant.');
        }

        $user = User::where('api_token', $token)->first();

        if (! $user) {
            abort(401, 'Token API invalide.');
        }

        return $user;
    }
}
