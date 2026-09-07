@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<div class="min-h-screen bg-[#F7F4ED]">

<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

    {{-- BACK --}}
    <a
        href="{{ route('admin.users.show', $user) }}"
        class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-[#77756F] transition hover:text-[#11110F]"
    >
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M10 19l-7-7m0 0l7-7m-7 7h18"
            />
        </svg>

        Back to User Profile
    </a>

    {{-- HEADER --}}
    <div class="mb-8">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#C9A96E]">
            Administration / Users
        </p>

        <h1 class="mt-2 font-serif text-3xl font-bold text-[#11110F]">
            Edit User
        </h1>

        <p class="mt-2 text-sm text-[#77756F]">
            Update account information, role, and password settings.
        </p>
    </div>

    {{-- VALIDATION ERRORS --}}
    @if($errors->any())
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5">

            <div class="flex gap-3">

                <svg
                    class="mt-0.5 h-5 w-5 shrink-0 text-red-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"
                    />
                </svg>

                <div>

                    <p class="font-bold text-red-700">
                        Please correct the following errors:
                    </p>

                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>

            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- ========================================================= --}}
        {{-- EDIT FORM --}}
        {{-- ========================================================= --}}

        <div class="xl:col-span-2">

            <form
                method="POST"
                action="{{ route('admin.users.update', $user) }}"
                class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white shadow-sm"
            >

                @csrf
                @method('PUT')

                {{-- DARK HEADER --}}
                <div class="bg-[#11110F] px-6 py-6">

                    @php
                        $initial = strtoupper(substr($user->name ?? 'U', 0, 1));
                    @endphp

                    <div class="flex items-center gap-4">

                        <div
                            class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full border border-[#C9A96E] bg-[#181815] font-serif text-xl font-bold text-[#D8BE8A]"
                        >
                            {{ $initial }}
                        </div>

                        <div>

                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#C9A96E]">
                                User Account
                            </p>

                            <h2 class="mt-1 font-serif text-xl font-bold text-white">
                                {{ $user->name }}
                            </h2>

                            <p class="mt-1 text-sm text-[#B8B5AC]">
                                {{ $user->email }}
                            </p>

                        </div>

                    </div>
                </div>

                {{-- ================================================= --}}
                {{-- PERSONAL INFORMATION --}}
                {{-- ================================================= --}}

                <div class="border-b border-[#E5E2DB] px-6 py-6">

                    <div class="mb-6">

                        <h3 class="font-serif text-lg font-bold text-[#11110F]">
                            Personal Information
                        </h3>

                        <p class="mt-1 text-sm text-[#77756F]">
                            Update the user's basic account information.
                        </p>

                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                        {{-- NAME --}}
                        <div>

                            <label
                                for="name"
                                class="mb-2 block text-sm font-bold text-[#11110F]"
                            >
                                Full Name
                            </label>

                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name', $user->name) }}"
                                required
                                autocomplete="name"
                                class="w-full rounded-xl border border-[#E5E2DB] bg-[#FAF9F6] px-4 py-3 text-sm text-[#11110F] outline-none transition focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                            >

                            @error('name')
                                <p class="mt-2 text-xs font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- EMAIL --}}
                        <div>

                            <label
                                for="email"
                                class="mb-2 block text-sm font-bold text-[#11110F]"
                            >
                                Email Address
                            </label>

                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                autocomplete="email"
                                class="w-full rounded-xl border border-[#E5E2DB] bg-[#FAF9F6] px-4 py-3 text-sm text-[#11110F] outline-none transition focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                            >

                            @error('email')
                                <p class="mt-2 text-xs font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- PHONE --}}
                        <div>

                            <label
                                for="phone"
                                class="mb-2 block text-sm font-bold text-[#11110F]"
                            >
                                Phone Number
                            </label>

                            <input
                                id="phone"
                                name="phone"
                                type="text"
                                value="{{ old('phone', $user->phone ?? '') }}"
                                autocomplete="tel"
                                placeholder="Enter phone number"
                                class="w-full rounded-xl border border-[#E5E2DB] bg-[#FAF9F6] px-4 py-3 text-sm text-[#11110F] outline-none transition focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                            >

                            @error('phone')
                                <p class="mt-2 text-xs font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- ROLE --}}
                        <div>

                            <label
                                for="role"
                                class="mb-2 block text-sm font-bold text-[#11110F]"
                            >
                                Account Role
                            </label>

                            <select
                                id="role"
                                name="role"
                                required
                                class="w-full rounded-xl border border-[#E5E2DB] bg-[#FAF9F6] px-4 py-3 text-sm text-[#11110F] outline-none transition focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                            >

                                <option
                                    value="admin"
                                    @selected(old('role', $user->role) === 'admin')
                                >
                                    Administrator
                                </option>

                                <option
                                    value="lawyer"
                                    @selected(old('role', $user->role) === 'lawyer')
                                >
                                    Lawyer
                                </option>

                                <option
                                    value="client"
                                    @selected(old('role', $user->role) === 'client')
                                >
                                    Client
                                </option>

                                <option
                                    value="accountant"
                                    @selected(old('role', $user->role) === 'accountant')
                                >
                                    Accountant
                                </option>

                                <option
                                    value="user"
                                    @selected(old('role', $user->role) === 'user')
                                >
                                    User
                                </option>

                            </select>

                            @error('role')
                                <p class="mt-2 text-xs font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>
                </div>

                {{-- ================================================= --}}
                {{-- PASSWORD --}}
                {{-- ================================================= --}}

                <div class="border-b border-[#E5E2DB] px-6 py-6">

                    <div class="mb-6">

                        <h3 class="font-serif text-lg font-bold text-[#11110F]">
                            Change Password
                        </h3>

                        <p class="mt-1 text-sm text-[#77756F]">
                            Leave both fields empty to keep the current password.
                        </p>

                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                        {{-- PASSWORD --}}
                        <div>

                            <label
                                for="password"
                                class="mb-2 block text-sm font-bold text-[#11110F]"
                            >
                                New Password
                            </label>

                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="new-password"
                                placeholder="Enter new password"
                                class="w-full rounded-xl border border-[#E5E2DB] bg-[#FAF9F6] px-4 py-3 text-sm text-[#11110F] outline-none transition focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                            >

                            @error('password')
                                <p class="mt-2 text-xs font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- CONFIRM PASSWORD --}}
                        <div>

                            <label
                                for="password_confirmation"
                                class="mb-2 block text-sm font-bold text-[#11110F]"
                            >
                                Confirm Password
                            </label>

                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                autocomplete="new-password"
                                placeholder="Confirm new password"
                                class="w-full rounded-xl border border-[#E5E2DB] bg-[#FAF9F6] px-4 py-3 text-sm text-[#11110F] outline-none transition focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                            >

                        </div>

                    </div>
                </div>

                {{-- ================================================= --}}
                {{-- SAVE BUTTONS --}}
                {{-- ================================================= --}}

                <div class="flex flex-col gap-3 bg-[#FAF9F6] px-6 py-5 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('admin.users.show', $user) }}"
                        class="inline-flex items-center justify-center rounded-xl border border-[#E5E2DB] bg-white px-5 py-3 text-sm font-bold text-[#77756F] transition hover:border-[#C9A96E] hover:text-[#11110F]"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#11110F] px-5 py-3 text-sm font-bold text-[#D8BE8A] transition hover:bg-[#24241F]"
                    >

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>

                        Save Changes

                    </button>

                </div>

            </form>

        </div>

        {{-- ========================================================= --}}
        {{-- RIGHT SIDEBAR --}}
        {{-- ========================================================= --}}

        <div class="space-y-6">

            {{-- ACCOUNT DETAILS --}}
            <div class="rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

                <div class="border-b border-[#E5E2DB] px-6 py-5">

                    <h3 class="font-serif text-lg font-bold text-[#11110F]">
                        Account Details
                    </h3>

                    <p class="mt-1 text-sm text-[#77756F]">
                        Information about this account.
                    </p>

                </div>

                <div class="space-y-5 px-6 py-6">

                    <div>

                        <p class="text-xs font-bold uppercase tracking-wider text-[#9B9992]">
                            User ID
                        </p>

                        <p class="mt-1 text-sm font-bold text-[#11110F]">
                            #{{ $user->id }}
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

            {{-- ADMIN NOTICE --}}
            @if($user->role === 'admin')

                <div class="rounded-2xl bg-[#11110F] p-6">

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl border border-[#C9A96E]/30 bg-[#181815]"
                    >

                        <svg
                            class="h-5 w-5 text-[#D8BE8A]"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                            />
                        </svg>

                    </div>

                    <h3 class="mt-4 font-serif text-lg font-bold text-white">
                        Administrator Account
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-[#B8B5AC]">
                        This user has administrator privileges. Changing this role will remove administrator access.
                    </p>

                </div>

            @endif

            {{-- ========================================================= --}}
            {{-- DANGER ZONE --}}
            {{-- ========================================================= --}}

            @if($user->id !== request()->user()->id)

                <div class="rounded-2xl border border-red-200 bg-white shadow-sm">

                    <div class="border-b border-red-100 px-6 py-5">

                        <h3 class="font-serif text-lg font-bold text-red-700">
                            Danger Zone
                        </h3>

                        <p class="mt-1 text-sm text-[#77756F]">
                            Move this account to deleted users.
                        </p>

                    </div>

                    <div class="px-6 py-6">

                        {{-- NO FORM HERE --}}
                        {{-- NO CONFIRM() HERE --}}
                        {{-- THIS BUTTON ONLY GOES BACK TO THE PROFILE PAGE --}}

                        <a
                            href="{{ route('admin.users.show', $user) }}"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-bold text-red-600 transition hover:bg-red-100"
                        >

                            <svg
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6V11M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h14"
                                />
                            </svg>

                            Manage Deletion

                        </a>

                        <p class="mt-3 text-center text-xs text-[#9B9992]">
                            Delete confirmation is available on the user profile.
                        </p>

                    </div>

                </div>

            @else

                <div class="rounded-2xl border border-[#E5E2DB] bg-white p-6">

                    <div class="flex items-start gap-3">

                        <svg
                            class="mt-0.5 h-5 w-5 shrink-0 text-[#C9A96E]"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                            />
                        </svg>

                        <div>

                            <h3 class="text-sm font-bold text-[#11110F]">
                                Your Administrator Account
                            </h3>

                            <p class="mt-1 text-sm leading-6 text-[#77756F]">
                                You cannot delete the account you are currently using.
                            </p>

                        </div>

                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

</div>

@endsection
