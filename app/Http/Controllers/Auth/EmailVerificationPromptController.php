<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        $user = $request->user();

        /*
         * If the user has already verified their email,
         * send them directly to the correct dashboard.
         */
        if ($user->hasVerifiedEmail()) {
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),

                'lawyer' => redirect()->route('lawyer.dashboard'),

                'client' => redirect()->route('client.dashboard'),

                'accountant' => redirect()->route('accountant.dashboard'),

                default => redirect('/'),
            };
        }

        /*
         * User is authenticated but has not verified
         * their email yet.
         */
        return view('auth.verify-email');
    }
}
