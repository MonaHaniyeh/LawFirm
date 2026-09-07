<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate the user
        $request->authenticate();

        // Regenerate session for security
        $request->session()->regenerate();

        // Get authenticated user
        $user = Auth::user();

        // Redirect according to user's role
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'lawyer' => redirect()->route('lawyer.dashboard'),
            'accountant' => redirect()->route('accountant.dashboard'),
            'client' => redirect()->route('client.dashboard'),

            // If no valid role exists
            default => redirect()->route('welcome'),
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }
}
