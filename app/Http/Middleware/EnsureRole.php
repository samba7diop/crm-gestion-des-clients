<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Usage: ->middleware('role:admin,commercial')
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        // Platform admin can access everything.
        if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return $next($request);
        }

        $allowed = array_filter(array_map('trim', explode(',', $roles)));

        if (in_array($user->role, $allowed, true)) {
            return $next($request);
        }

        abort(403);
    }
}

