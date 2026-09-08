<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /** * Handle an incoming request. * * Usage: * * ->middleware('role:client') * * ->middleware('role:admin,accountant') * * Multiple roles are treated as "any of these roles". */ public function handle(Request $request, Closure $next, string ...$roles): Response
    { /* |-------------------------------------------------------------------------- | CHECK AUTHENTICATION |-------------------------------------------------------------------------- | | If the user is not authenticated, show the custom 404 page. | HTTP status will still be 404. | */
        $user = $request->user();
        if (!$user) {
            return response()->view('errors.404', [], 404);
        } /* |-------------------------------------------------------------------------- | CHECK USER ROLE |-------------------------------------------------------------------------- | | If the authenticated user's role is not allowed, | show exactly the same 404 page. | | This prevents revealing that the requested route exists. | */
        if (!in_array($user->role, $roles, true)) {
            return response()->view('errors.404', [], 404);
        } /* |-------------------------------------------------------------------------- | CHECK BANNED CLIENT |-------------------------------------------------------------------------- | | If the client is banned: | | 1. Logout the user. | 2. Invalidate the session. | 3. Regenerate the CSRF token. | 4. Display the generic 404 page. | */
        if ($user->role === 'client' && $user->status === 'banned') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return response()->view('errors.404', [], 404);
        } /* |-------------------------------------------------------------------------- | ACCESS GRANTED |-------------------------------------------------------------------------- */
        return $next($request);
    }
}
