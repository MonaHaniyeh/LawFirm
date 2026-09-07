<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    private function rolePrefix(): string
    {
        return Auth::user()->role;
    }

    public function settings()
    {
        $role = $this->rolePrefix();

        return view('layouts.settings.edit', [
            'user' => Auth::user(),
            'settingsUpdateRoute' => $role . '.settings.update',
            'passwordRoute' => $role . '.password.edit',
        ]);
    }

    public function updateSettings(Request $request)
    {
         /** @var \App\Models\User  */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'language' => [
                'required',
                Rule::in(['en', 'ar']),
            ],
        ]);

        $user->update($validated);

        return back()->with(
            'success',
            'Your account settings have been updated successfully.'
        );
    }

    public function password()
    {
        $role = $this->rolePrefix();

        return view('layouts.password.edit', [
            'user' => Auth::user(),
            'passwordUpdateRoute' => $role . '.password.update',
            'settingsRoute' => $role . '.settings.edit',
        ]);
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

         /** @var \App\Models\User  */
        $user = Auth::user();

        if (!Hash::check(
            $validated['current_password'],
            $user->password
        )) {
            throw ValidationException::withMessages([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with(
            'success',
            'Your password has been changed successfully.'
        );
    }
}