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
                },
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

            'billing_rate' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'bio' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'role' => 'lawyer',

            // 1 = active, 0 = inactive
            'is_active' => (bool) $data['is_active'],

            'specialization' => $data['specialization'],
            'experience_years' => $data['experience_years'],
            'license_number' => $data['license_number'],
            'billing_rate' => $data['billing_rate'] ?? null,
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

            'license_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'license_number')->ignore($lawyer->id),
            ],

            'billing_rate' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'bio' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],

            'password' => [
                'nullable',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers(),
            ],
        ]);

        $lawyer->name = $data['name'];
        $lawyer->email = $data['email'];
        $lawyer->phone = $data['phone'];
        $lawyer->specialization = $data['specialization'];
        $lawyer->experience_years = $data['experience_years'];
        $lawyer->license_number = $data['license_number'];
        $lawyer->billing_rate = $data['billing_rate'] ?? null;
        $lawyer->bio = $data['bio'] ?? null;

        // IMPORTANT:
        // Save the account status to is_active.
        $lawyer->is_active = (bool) $data['is_active'];

        // Only update password when a new password was entered.
        if (!empty($data['password'])) {
            $lawyer->password = Hash::make($data['password']);
        }

        $lawyer->save();

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
        |--------------------------------------------------------------------------
        | Prevent deletion when the lawyer has open cases
        |--------------------------------------------------------------------------
        |
        | We don't want to delete a lawyer who is currently responsible
        | for active/open cases.
        |
        */

        $hasOpenCases = $lawyer->casesAsLawyer()
            ->where('status', 'opened')
            ->exists();

        if ($hasOpenCases) {
            return redirect()
                ->route('admin.lawyers.show', $lawyer)
                ->with(
                    'error',
                    'This lawyer cannot be deleted because they still have open cases. Reassign or close the open cases first.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Delete lawyer
        |--------------------------------------------------------------------------
        */

        $lawyer->delete();

        return redirect()
            ->route('admin.lawyers.index')
            ->with('status', 'Lawyer removed successfully.');
    }
}