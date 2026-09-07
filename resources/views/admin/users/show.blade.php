@extends('layouts.app')

@section('title', 'User Profile')

@section('content')

    @php
        $initial = strtoupper(substr($user->name ?? 'U', 0, 1));

        $role = strtolower($user->role ?? 'user');

        $status = isset($user->is_active)
            ? ($user->is_active
                ? 'active'
                : 'inactive')
            : (isset($user->status)
                ? strtolower($user->status)
                : 'active');

        $roleLabel = match ($role) {
            'admin' => 'Administrator',
            'lawyer' => 'Lawyer',
            'client' => 'Client',
            'accountant' => 'Accountant',
            default => ucfirst($role),
        };
    @endphp

    <div x-data="{ deleteModal: false }" class="min-h-screen bg-[#F7F4ED]">

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

            {{-- BACK --}}
            <a href="{{ route('admin.users.index') }}"
                class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-[#77756F] transition hover:text-[#11110F]">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Users
            </a>

            {{-- SUCCESS MESSAGE --}}
            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4">
                    <div class="flex items-center gap-3 text-sm font-medium text-emerald-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>

                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- ERROR MESSAGE --}}
            @if (session('error'))
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4">
                    <div class="flex items-center gap-3 text-sm font-medium text-red-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" />
                        </svg>

                        {{ session('error') }}
                    </div>
                </div>
            @endif

            {{-- PROFILE HEADER --}}
            <div class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

                <div class="bg-[#11110F] px-6 py-8 sm:px-8">

                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                        {{-- PROFILE --}}
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center">

                            {{-- AVATAR --}}
                            <div
                                class="flex h-24 w-24 shrink-0 items-center justify-center rounded-full border-2 border-[#C9A96E] bg-[#181815] font-serif text-3xl font-bold text-[#D8BE8A]">
                                {{ $initial }}
                            </div>

                            <div>

                                <div class="flex flex-wrap items-center gap-3">

                                    <h1 class="font-serif text-3xl font-bold text-white">
                                        {{ $user->name }}
                                    </h1>

                                    {{-- STATUS --}}
                                    @if ($status === 'active')
                                        <span
                                            class="inline-flex items-center gap-2 rounded-full border border-emerald-400/20 bg-emerald-400/10 px-3 py-1 text-xs font-bold text-emerald-300">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-bold text-[#B8B5AC]">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#9B9992]"></span>
                                            Inactive
                                        </span>
                                    @endif

                                </div>

                                <p class="mt-2 text-sm text-[#B8B5AC]">
                                    {{ $user->email }}
                                </p>

                                <div class="mt-4 flex flex-wrap items-center gap-4 text-sm text-[#B8B5AC]">

                                    <span class="inline-flex items-center gap-2">
                                        <svg class="h-4 w-4 text-[#C9A96E]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-9.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9c0-.676-.056-1.338-.162-1.976z" />
                                        </svg>

                                        {{ $roleLabel }}
                                    </span>

                                    <span class="hidden h-4 w-px bg-white/10 sm:block"></span>

                                    <span class="inline-flex items-center gap-2">
                                        <svg class="h-4 w-4 text-[#C9A96E]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>

                                        Joined {{ $user->created_at?->format('M d, Y') ?? '—' }}
                                    </span>

                                </div>

                            </div>

                        </div>

                        {{-- EDIT BUTTON --}}
                        <div>
                            <a href="{{ route('admin.users.edit', $user) }}"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#C9A96E] px-5 py-3 text-sm font-bold text-[#11110F] transition hover:bg-[#D8BE8A]">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>

                                Edit User
                            </a>
                        </div>

                    </div>
                </div>

                {{-- STATS --}}
                <div
                    class="grid grid-cols-2 divide-x divide-y divide-[#E5E2DB] border-t border-[#E5E2DB] sm:grid-cols-4 sm:divide-y-0">

                    <div class="p-6">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#9B9992]">
                            User ID
                        </p>

                        <p class="mt-2 font-serif text-xl font-bold text-[#11110F]">
                            #{{ $user->id }}
                        </p>
                    </div>

                    <div class="p-6">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#9B9992]">
                            Role
                        </p>

                        <p class="mt-2 font-serif text-xl font-bold text-[#11110F]">
                            {{ $roleLabel }}
                        </p>
                    </div>

                    <div class="p-6">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#9B9992]">
                            Joined
                        </p>

                        <p class="mt-2 font-serif text-xl font-bold text-[#11110F]">
                            {{ $user->created_at?->format('M Y') ?? '—' }}
                        </p>
                    </div>

                    <div class="p-6">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#9B9992]">
                            Status
                        </p>

                        <p
                            class="mt-2 font-serif text-xl font-bold {{ $status === 'active' ? 'text-emerald-600' : 'text-[#77756F]' }}">
                            {{ ucfirst($status) }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- INFORMATION GRID --}}
            <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">

                {{-- LEFT COLUMN --}}
                <div class="xl:col-span-2">

                    {{-- PERSONAL INFORMATION --}}
                    <div class="rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

                        <div class="border-b border-[#E5E2DB] px-6 py-5">
                            <h2 class="font-serif text-xl font-bold text-[#11110F]">
                                Personal Information
                            </h2>

                            <p class="mt-1 text-sm text-[#77756F]">
                                Basic information associated with this account.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">

                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-[#9B9992]">
                                    Full Name
                                </p>

                                <p class="mt-2 text-sm font-bold text-[#11110F]">
                                    {{ $user->name ?? '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-[#9B9992]">
                                    Email Address
                                </p>

                                <p class="mt-2 break-all text-sm font-bold text-[#11110F]">
                                    {{ $user->email ?? '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-[#9B9992]">
                                    Phone Number
                                </p>

                                <p class="mt-2 text-sm font-bold text-[#11110F]">
                                    {{ $user->phone ?? 'Not provided' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-[#9B9992]">
                                    Account Role
                                </p>

                                <p class="mt-2 text-sm font-bold text-[#11110F]">
                                    {{ $roleLabel }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-[#9B9992]">
                                    Account Created
                                </p>

                                <p class="mt-2 text-sm font-bold text-[#11110F]">
                                    {{ $user->created_at?->format('F d, Y h:i A') ?? '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-[#9B9992]">
                                    Last Updated
                                </p>

                                <p class="mt-2 text-sm font-bold text-[#11110F]">
                                    {{ $user->updated_at?->format('F d, Y h:i A') ?? '—' }}
                                </p>
                            </div>

                        </div>
                    </div>

                    {{-- LAWYER INFORMATION --}}
                    @if ($role === 'lawyer')

                        <div class="mt-6 rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

                            <div class="border-b border-[#E5E2DB] px-6 py-5">

                                <h2 class="font-serif text-xl font-bold text-[#11110F]">
                                    Lawyer Information
                                </h2>

                                <p class="mt-1 text-sm text-[#77756F]">
                                    Professional information associated with this lawyer account.
                                </p>

                            </div>

                            <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">

                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-[#9B9992]">
                                        Specialization
                                    </p>

                                    <p class="mt-2 text-sm font-bold text-[#11110F]">
                                        {{ $user->specialization ?? 'Not provided' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-[#9B9992]">
                                        License Number
                                    </p>

                                    <p class="mt-2 text-sm font-bold text-[#11110F]">
                                        {{ $user->license_number ?? 'Not provided' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-[#9B9992]">
                                        Experience
                                    </p>

                                    <p class="mt-2 text-sm font-bold text-[#11110F]">

                                        @if (isset($user->experience))
                                            {{ $user->experience }} years
                                        @elseif (isset($user->experience_years))
                                            {{ $user->experience_years }} years
                                        @else
                                            Not provided
                                        @endif

                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-[#9B9992]">
                                        Billing Rate
                                    </p>

                                    <p class="mt-2 text-sm font-bold text-[#11110F]">

                                        @if (isset($user->billing_rate))
                                            {{ number_format($user->billing_rate, 2) }}
                                        @else
                                            Not provided
                                        @endif

                                    </p>
                                </div>

                                @if (!empty($user->bio))
                                    <div class="sm:col-span-2">

                                        <p class="text-xs font-bold uppercase tracking-wider text-[#9B9992]">
                                            Biography
                                        </p>

                                        <p class="mt-2 text-sm leading-7 text-[#77756F]">
                                            {{ $user->bio }}
                                        </p>

                                    </div>
                                @endif

                            </div>
                        </div>

                    @endif

                </div>

                {{-- RIGHT COLUMN --}}
                <div class="space-y-6">

                    {{-- ACCOUNT DETAILS --}}
                    <div class="rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

                        <div class="border-b border-[#E5E2DB] px-6 py-5">

                            <h2 class="font-serif text-xl font-bold text-[#11110F]">
                                Account Details
                            </h2>

                            <p class="mt-1 text-sm text-[#77756F]">
                                System information for this account.
                            </p>

                        </div>

                        <div class="space-y-5 px-6 py-6">

                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-[#9B9992]">
                                    Account ID
                                </p>

                                <p class="mt-1 text-sm font-bold text-[#11110F]">
                                    #{{ $user->id }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-[#9B9992]">
                                    Role
                                </p>

                                <p class="mt-1 text-sm font-bold text-[#11110F]">
                                    {{ $roleLabel }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-[#9B9992]">
                                    Registered
                                </p>

                                <p class="mt-1 text-sm font-bold text-[#11110F]">
                                    {{ $user->created_at?->format('M d, Y') ?? '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-[#9B9992]">
                                    Last Updated
                                </p>

                                <p class="mt-1 text-sm font-bold text-[#11110F]">
                                    {{ $user->updated_at?->format('M d, Y') ?? '—' }}
                                </p>
                            </div>

                        </div>
                    </div>

                    {{-- ADMIN ACCESS --}}
                    @if ($role === 'admin')
                        <div class="rounded-2xl bg-[#11110F] p-6">

                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-xl border border-[#C9A96E]/30 bg-[#181815]">
                                <svg class="h-5 w-5 text-[#D8BE8A]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>

                            <h3 class="mt-4 font-serif text-lg font-bold text-white">
                                Administrator Access
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-[#B8B5AC]">
                                This account has administrator privileges and can manage users,
                                lawyers, cases, appointments, billing, and system settings.
                            </p>

                        </div>
                    @endif

                    {{-- DANGER ZONE --}}
                    @if ($user->id !== request()->user()->id)
                        <div class="rounded-2xl border border-red-200 bg-white shadow-sm">

                            <div class="border-b border-red-100 px-6 py-5">

                                <h2 class="font-serif text-xl font-bold text-red-700">
                                    Danger Zone
                                </h2>

                                <p class="mt-1 text-sm text-[#77756F]">
                                    Remove this user from the active users list.
                                </p>

                            </div>

                            <div class="px-6 py-6">

                                {{-- IMPORTANT: THIS BUTTON DOES NOT SUBMIT ANY FORM --}}
                                <button type="button" x-on:click="deleteModal = true"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-bold text-red-600 transition hover:bg-red-100">

                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h14" />
                                    </svg>

                                    Move to Deleted Users

                                </button>

                            </div>

                        </div>
                    @else
                        <div class="rounded-2xl border border-[#E5E2DB] bg-white p-6">

                            <div class="flex items-start gap-3">

                                <svg class="mt-0.5 h-5 w-5 shrink-0 text-[#C9A96E]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>

                                <div>

                                    <h3 class="text-sm font-bold text-[#11110F]">
                                        Your Administrator Account
                                    </h3>

                                    <p class="mt-1 text-sm leading-6 text-[#77756F]">
                                        You cannot delete the administrator account you are currently using.
                                    </p>

                                </div>

                            </div>

                        </div>
                    @endif

                </div>

            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- CUSTOM DELETE MODAL --}}
        {{-- ========================================================= --}}

        <div x-show="deleteModal" x-cloak x-transition.opacity
            class="fixed inset-0 z-[99999] flex items-center justify-center p-4" aria-modal="true" role="dialog">

            {{-- BACKDROP --}}
            <div class="absolute inset-0 bg-[#11110F]/80 backdrop-blur-sm" x-on:click="deleteModal = false"></div>

            {{-- MODAL --}}
            <div x-show="deleteModal" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95" x-on:click.stop
                class="relative z-10 w-full max-w-md overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white shadow-2xl">

                {{-- MODAL HEADER --}}
                <div class="bg-[#11110F] px-6 py-7">

                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-red-500/10">

                        <svg class="h-7 w-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" />
                        </svg>

                    </div>

                    <h3 class="mt-5 font-serif text-2xl font-bold text-white">
                        Move User to Deleted Users?
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-[#B8B5AC]">
                        This account will be removed from the active users list.
                        You can restore it later.
                    </p>

                </div>

                {{-- MODAL BODY --}}
                <div class="px-6 py-6">

                    {{-- USER PREVIEW --}}
                    <div class="rounded-xl border border-[#E5E2DB] bg-[#FAF9F6] p-4">

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#11110F] font-serif text-lg font-bold text-[#D8BE8A]">
                                {{ $initial }}
                            </div>

                            <div class="min-w-0">

                                <p class="truncate text-sm font-bold text-[#11110F]">
                                    {{ $user->name }}
                                </p>

                                <p class="truncate text-xs text-[#77756F]">
                                    {{ $user->email }}
                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4">

                        <div class="flex gap-3">

                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-amber-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z" />
                            </svg>

                            <p class="text-sm leading-6 text-amber-800">
                                This is a soft delete. The user will not be permanently
                                deleted and can be restored from the Deleted Users section.
                            </p>

                        </div>

                    </div>

                    {{-- BUTTONS --}}
                    <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                        {{-- CANCEL --}}
                        <button type="button" x-on:click="deleteModal = false"
                            class="inline-flex items-center justify-center rounded-xl border border-[#E5E2DB] bg-white px-5 py-3 text-sm font-bold text-[#77756F] transition hover:border-[#C9A96E] hover:text-[#11110F]">
                            Cancel
                        </button>

                        {{-- ACTUAL DELETE --}}
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-red-700 sm:w-auto">

                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h14" />
                                </svg>

                                Yes, Move to Deleted

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- ALPINE --}}
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                // Alpine is loaded globally.
            });
        </script>
    @endpush

    {{-- HIDE ALPINE ELEMENTS BEFORE ALPINE LOADS --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

@endsection
