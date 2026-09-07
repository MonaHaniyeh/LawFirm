<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class LawyerController extends Controller
{
    /**
     * Display all lawyers.
     */
    public function index()
    {
        $lawyers = User::where('role', 'lawyer')
            ->withCount([
                'casesAsLawyer as active_case_count' => function ($query) {
                    $query->where('status', 'opened');
                }
            ])
            ->orderBy('name')
            ->paginate(20);

        return view('admin.lawyers.index', compact('lawyers'));
    }

    /**
     * Show the create lawyer form.
     */
    public function create()
    {
        return view('admin.lawyers.create');
    }

    /**
     * Store a new lawyer.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:120',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'phone' => [
                'required',
                'string',
                'max:30',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers(),
            ],

            'specialization' => [
                'required',
                'string',
                'max:100',
            ],

            'experience_years' => [
                'required',
                'integer',
                'min:0',
                'max:60',
            ],

            'license_number' => [
                'required',
                'string',
                'max:50',
                'unique:users,license_number',
            ],

            'bio' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'role' => 'lawyer',
            'status' => 'active',
            'specialization' => $data['specialization'],
            'experience_years' => $data['experience_years'],
            'license_number' => $data['license_number'],
            'bio' => $data['bio'] ?? null,
        ]);

        return redirect()
            ->route('admin.lawyers.index')
            ->with('status', 'Lawyer added successfully.');
    }

    /**
     * Display a lawyer.
     */
    public function show(User $lawyer)
    {
        abort_unless($lawyer->role === 'lawyer', 404);

        $lawyer->loadCount([
            'casesAsLawyer',
        ]);

        return view('admin.lawyers.show', compact('lawyer'));
    }

    /**
     * Show the edit lawyer form.
     */
    public function edit(User $lawyer)
    {
        abort_unless($lawyer->role === 'lawyer', 404);

        return view('admin.lawyers.edit', compact('lawyer'));
    }

    /**
     * Update a lawyer.
     */
    public function update(Request $request, User $lawyer)
    {
        abort_unless($lawyer->role === 'lawyer', 404);

        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:120',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($lawyer->id),
            ],

            'phone' => [
                'required',
                'string',
                'max:30',
            ],

            'specialization' => [
                'required',
                'string',
                'max:100',
            ],

            'experience_years' => [
                'required',
                'integer',
                'min:0',
                'max:60',
            ],

            'bio' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $lawyer->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'specialization' => $data['specialization'],
            'experience_years' => $data['experience_years'],
            'bio' => $data['bio'] ?? null,
        ]);

        return redirect()
            ->route('admin.lawyers.show', $lawyer)
            ->with('status', 'Lawyer profile updated successfully.');
    }

    /**
     * Remove a lawyer.
     */
    public function destroy(User $lawyer)
    {
        abort_unless($lawyer->role === 'lawyer', 404);

        /*
         * Do not delete a lawyer who still has open cases.
         * Reassign or close those cases first.
         */
        if (
            $lawyer->casesAsLawyer()
                ->where('status', 'opened')
                ->exists()
        ) {
            return back()->with(
                'error',
                'This lawyer has open cases. Reassign them before removing this account.'
            );
        }

        $lawyer->delete();

        return redirect()
            ->route('admin.lawyers.index')
            ->with('status', 'Lawyer removed successfully.');
    }
}