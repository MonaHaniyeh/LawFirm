<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
{
    return view('admin.users.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],

        'email' => [
            'required',
            'email',
            'max:255',
            'unique:users,email',
        ],

        'phone' => ['nullable', 'string', 'max:30'],

        'role' => [
            'required',
            Rule::in([
                'admin',
                'lawyer',
                'client',
                'accountant',
                'user',
            ]),
        ],

        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
        ],
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'] ?? null,
        'role' => $validated['role'],
        'password' => Hash::make($validated['password']),
    ]);

    return redirect()
        ->route('admin.users.show', $user)
        ->with('success', 'User created successfully.');
}


    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }


    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }


    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

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

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'lawyer',
                    'client',
                    'accountant',
                    'user',
                ]),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);


        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->role = $validated['role'];


        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }


        $user->save();


        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'User information updated successfully.');
    }


    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()
                ->route('admin.users.show', $user)
                ->with('error', 'You cannot delete your own account.');
        }


        $user->delete();


        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User moved to deleted users.');
    }


    public function deleted()
    {
        $users = User::onlyTrashed()
            ->latest('deleted_at')
            ->paginate(15);

        return view('admin.users.deleted', compact('users'));
    }


    public function restore(int $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $user->restore();


        return redirect()
            ->route('admin.users.deleted')
            ->with('success', 'User restored successfully.');
    }


    public function forceDelete(int $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);


        if ($user->id === Auth::id()) {
            return redirect()
                ->route('admin.users.deleted')
                ->with('error', 'You cannot permanently delete your own account.');
        }


        $user->forceDelete();


        return redirect()
            ->route('admin.users.deleted')
            ->with('success', 'User permanently deleted.');
    }
}