<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController
{
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user->hasVerifiedEmail()) {
            if ($user->markEmailAsVerified()) {
                event(new Verified($user));
            }
        }

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),

            'lawyer' => redirect()->route('lawyer.dashboard'),

            'client' => redirect()->route('client.dashboard'),

            'accountant' => redirect()->route('accountant.dashboard'),

            default => redirect('/'),
        };
    }
}
