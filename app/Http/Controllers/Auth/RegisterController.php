<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Support\ResolveUserRoleFromEmail;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:30'],
            'birth_date' => ['required', 'date', 'before:-18 years'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        $role = ResolveUserRoleFromEmail::resolve($data['email']);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'role' => $role,
            'status' => 'active',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->to($this->redirectPathForRole($role))
            ->with('status', 'Welcome — your account has been created.');
    }

    private function redirectPathForRole(string $role): string
    {
        return match ($role) {
            'lawyer'     => route('lawyer.dashboard'),
            'admin'      => route('admin.dashboard'),
            'accountant' => route('accountant.dashboard'),
            default      => route('client.dashboard'),
        };
    }
}