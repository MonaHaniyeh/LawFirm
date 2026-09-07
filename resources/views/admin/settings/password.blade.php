@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<div
    x-data="{
        showCurrent: false,
        showPassword: false,
        showConfirmation: false
    }"
    class="min-h-screen bg-slate-50"
>

    <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8">

            <div class="flex items-center gap-3">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-900 text-white">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect
                            x="4"
                            y="10"
                            width="16"
                            height="10"
                            rx="2"
                            stroke-width="1.8"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M8 10V7a4 4 0 018 0v3"
                        />
                    </svg>
                </div>

                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                        Change Password
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Keep your administrator account secure.
                    </p>
                </div>

            </div>
        </div>

        {{-- Success --}}
        @if(session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4">

                <div class="flex items-center gap-3">

                    <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                    <p class="text-sm font-medium text-emerald-700">
                        {{ session('success') }}
                    </p>

                </div>
            </div>
        @endif

        {{-- Errors --}}
        @if($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

                <div class="flex gap-3">

                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9" stroke-width="1.8"/>
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 8v4m0 4h.01"
                        />
                    </svg>

                    <div>

                        <p class="text-sm font-semibold text-red-800">
                            Please correct the following errors:
                        </p>

                        <ul class="mt-2 list-disc pl-5 text-sm text-red-700">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                    </div>

                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            {{-- Settings Navigation --}}
            <div>

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="border-b border-slate-200 p-5">
                        <h2 class="text-sm font-semibold text-slate-900">
                            Account Settings
                        </h2>
                    </div>

                    <div class="p-2">

                        <a
                            href="{{ route('admin.settings.edit') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900"
                        >

                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M12 15.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M19.4 15a1.7 1.7 0 00.34 1.88l.06.06-1.9 1.9-.06-.06a1.7 1.7 0 00-1.88-.34 1.7 1.7 0 00-1.03 1.56V20h-2.7v-.09a1.7 1.7 0 00-1.03-1.56 1.7 1.7 0 00-1.88.34l-.06.06-1.9-1.9.06-.06A1.7 1.7 0 007.8 15a1.7 1.7 0 00-1.56-1.03H6v-2.7h.24A1.7 1.7 0 007.8 10a1.7 1.7 0 00-.34-1.88L7.4 8.06l1.9-1.9.06.06a1.7 1.7 0 001.88.34 1.7 1.7 0 001.03-1.56V4h2.7v.09A1.7 1.7 0 0016 5.65a1.7 1.7 0 001.88-.34l.06-.06 1.9 1.9-.06.06A1.7 1.7 0 0019.4 9c.22.6.8 1 1.44 1H21v2.7h-.16A1.7 1.7 0 0019.4 15z"
                                />
                            </svg>

                            Profile Settings
                        </a>

                        <a
                            href="{{ route('admin.password.edit') }}"
                            class="mt-1 flex items-center gap-3 rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white"
                        >

                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect
                                    x="4"
                                    y="10"
                                    width="16"
                                    height="10"
                                    rx="2"
                                    stroke-width="1.8"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M8 10V7a4 4 0 018 0v3"
                                />
                            </svg>

                            Change Password
                        </a>

                    </div>

                </div>

            </div>

            {{-- Password Form --}}
            <div class="lg:col-span-2">

                <form
                    method="POST"
                    action="{{ route('admin.password.update') }}"
                    class="rounded-2xl border border-slate-200 bg-white shadow-sm"
                >
                    @csrf
                    @method('PUT')

                    <div class="border-b border-slate-200 px-6 py-5">

                        <h2 class="text-base font-semibold text-slate-900">
                            Password Security
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Enter your current password and choose a new password.
                        </p>

                    </div>

                    <div class="space-y-6 p-6">

                        {{-- Current Password --}}
                        <div>

                            <label
                                for="current_password"
                                class="mb-2 block text-sm font-semibold text-slate-700"
                            >
                                Current Password
                            </label>

                            <div class="relative">

                                <input
                                    id="current_password"
                                    :type="showCurrent ? 'text' : 'password'"
                                    name="current_password"
                                    required
                                    autocomplete="current-password"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 pr-12 text-sm outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200"
                                >

                                <button
                                    type="button"
                                    @click="showCurrent = !showCurrent"
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 transition hover:text-slate-700"
                                >

                                    <svg
                                        x-show="!showCurrent"
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z"
                                        />

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="2.5"
                                            stroke-width="1.8"
                                        />
                                    </svg>

                                    <svg
                                        x-show="showCurrent"
                                        x-cloak
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M3 3l18 18"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M10.6 10.6a2 2 0 002.8 2.8"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M9.9 5.2A10.7 10.7 0 0112 5c6.5 0 10 7 10 7a17.5 17.5 0 01-3.2 3.7M6.2 6.2C3.6 8.1 2 12 2 12s3.5 7 10 7c1.1 0 2.1-.2 3-.5"
                                        />
                                    </svg>

                                </button>

                            </div>

                        </div>

                        {{-- New Password --}}
                        <div>

                            <label
                                for="password"
                                class="mb-2 block text-sm font-semibold text-slate-700"
                            >
                                New Password
                            </label>

                            <div class="relative">

                                <input
                                    id="password"
                                    :type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 pr-12 text-sm outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200"
                                >

                                <button
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 transition hover:text-slate-700"
                                >

                                    <svg
                                        x-show="!showPassword"
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z"
                                        />

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="2.5"
                                            stroke-width="1.8"
                                        />
                                    </svg>

                                    <svg
                                        x-show="showPassword"
                                        x-cloak
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M3 3l18 18"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M10.6 10.6a2 2 0 002.8 2.8"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M9.9 5.2A10.7 10.7 0 0112 5c6.5 0 10 7 10 7a17.5 17.5 0 01-3.2 3.7M6.2 6.2C3.6 8.1 2 12 2 12s3.5 7 10 7c1.1 0 2.1-.2 3-.5"
                                        />
                                    </svg>

                                </button>

                            </div>

                            <p class="mt-2 text-xs text-slate-400">
                                Use at least 8 characters with a mixture of letters, numbers, and symbols.
                            </p>

                        </div>

                        {{-- Confirmation --}}
                        <div>

                            <label
                                for="password_confirmation"
                                class="mb-2 block text-sm font-semibold text-slate-700"
                            >
                                Confirm New Password
                            </label>

                            <div class="relative">

                                <input
                                    id="password_confirmation"
                                    :type="showConfirmation ? 'text' : 'password'"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 pr-12 text-sm outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200"
                                >

                                <button
                                    type="button"
                                    @click="showConfirmation = !showConfirmation"
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 transition hover:text-slate-700"
                                >

                                    <svg
                                        x-show="!showConfirmation"
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z"
                                        />

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="2.5"
                                            stroke-width="1.8"
                                        />
                                    </svg>

                                    <svg
                                        x-show="showConfirmation"
                                        x-cloak
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M3 3l18 18"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M10.6 10.6a2 2 0 002.8 2.8"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M9.9 5.2A10.7 10.7 0 0112 5c6.5 0 10 7 10 7a17.5 17.5 0 01-3.2 3.7M6.2 6.2C3.6 8.1 2 12 2 12s3.5 7 10 7c1.1 0 2.1-.2 3-.5"
                                        />
                                    </svg>

                                </button>

                            </div>

                        </div>

                        {{-- Security Notice --}}
                        <div class="rounded-xl border border-blue-100 bg-blue-50 p-4">

                            <div class="flex gap-3">

                                <svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="9"
                                        stroke-width="1.8"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M12 11v5m0-8h.01"
                                    />
                                </svg>

                                <div>
                                    <p class="text-sm font-semibold text-blue-900">
                                        Security recommendation
                                    </p>

                                    <p class="mt-1 text-sm leading-6 text-blue-800">
                                        Never share your password with other users.
                                        Use a unique password that you do not use for other accounts.
                                    </p>
                                </div>

                            </div>
                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="flex flex-col-reverse gap-3 border-t border-slate-200 px-6 py-5 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('admin.settings.edit') }}"
                            class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="rounded-xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800"
                        >
                            Update Password
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
</div>
@endsection