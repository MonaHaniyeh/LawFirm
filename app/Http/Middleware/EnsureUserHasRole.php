<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Restricts a route group to one or more roles.
 *
 * Registered in bootstrap/app.php (Laravel 11+) as:
 *   $middleware->alias(['role' => \App\Http\Middleware\EnsureUserHasRole::class]);
 *
 * Used in routes as:
 *   ->middleware('role:client')
 *   ->middleware('role:admin,accountant')   // comma-separated = "any of these"
 */
class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  One or more roles allowed to pass through.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        abort_unless($user, 403, 'You must be signed in to access this page.');

        // The user's role isn't one of the roles this route group allows.
        abort_unless(
            in_array($user->role, $roles, true),
            403,
            'You do not have access to this area.'
        );


        if ($user->role === 'client' && $user->status === 'banned') {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            abort(403, 'This account has been suspended. Contact the firm for assistance.');
        }

        return $next($request);
    }
}
