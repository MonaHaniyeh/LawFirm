<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to Google.
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google.
     */
    public function callback(): RedirectResponse
    {
        try {
            $socialUser = Socialite::driver('google')->user();
        } catch (Exception $e) {
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Google login was cancelled or failed. Please try again.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Make sure Google returned an email
        |--------------------------------------------------------------------------
        */

        $email = $socialUser->getEmail();

        if (! $email) {
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Google did not provide an email address. Please try again.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Find existing user
        |--------------------------------------------------------------------------
        */

        $user = User::where('email', $email)->first();

        /*
        |--------------------------------------------------------------------------
        | Existing user
        |--------------------------------------------------------------------------
        */

        if ($user) {

            /*
            |--------------------------------------------------------------------------
            | Google has authenticated the email, so mark it verified
            |--------------------------------------------------------------------------
            */

            if (! $user->hasVerifiedEmail()) {
                $user->forceFill([
                    'email_verified_at' => now(),
                ])->save();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | New Google user
        |--------------------------------------------------------------------------
        */

        else {
            $user = User::create([
                'name' => $socialUser->getName()
                    ?: $socialUser->getNickname()
                    ?: 'Google User',

                'email' => $email,

                /*
                |--------------------------------------------------------------------------
                | Google users don't need to know this password.
                |--------------------------------------------------------------------------
                */

                'password' => Hash::make(
                    Str::random(40)
                ),

                /*
                |--------------------------------------------------------------------------
                | New social-login users are clients by default.
                | Google must NEVER determine the user's role.
                |--------------------------------------------------------------------------
                */

                'role' => 'client',

                /*
                |--------------------------------------------------------------------------
                | Google authenticated the email.
                |--------------------------------------------------------------------------
                */

                'email_verified_at' => now(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Login user
        |--------------------------------------------------------------------------
        */

        Auth::login($user, remember: true);

        /*
        |--------------------------------------------------------------------------
        | Regenerate session after authentication
        |--------------------------------------------------------------------------
        */

        request()->session()->regenerate();

        /*
        |--------------------------------------------------------------------------
        | Redirect according to the user's existing role
        |--------------------------------------------------------------------------
        */

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),

            'lawyer' => redirect()->route('lawyer.dashboard'),

            'client' => redirect()->route('client.dashboard'),

            default => redirect()->route('dashboard'),
        };
    }
}
