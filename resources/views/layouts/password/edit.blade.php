@extends('layouts.app')

@section('title', 'Change Password')

@section('breadcrumb', 'Account / Change Password')

@section('content')

    <div
        x-data
        class="min-h-screen bg-[#F7F4ED]"
    >

        <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">

            {{-- ========================================= --}}
            {{-- PAGE HEADER --}}
            {{-- ========================================= --}}
            <div class="mb-8">

                <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-[#B89452]">
                    Account Security
                </p>

                <h1 class="mt-2 font-serif text-3xl font-semibold tracking-tight text-[#11110F] sm:text-4xl">
                    Change Password
                </h1>

                <p class="mt-2 text-sm text-[#77756F]">
                    Update your password to keep your account secure.
                </p>

            </div>


            {{-- ========================================= --}}
            {{-- SUCCESS MESSAGE --}}
            {{-- ========================================= --}}
            @if(session('success'))

                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    class="relative mb-6 rounded-xl border border-[#3D8B5A]/25 bg-[#EFF8F2] p-5"
                >

                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-[#3D8B5A]">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                        </div>

                        <div class="flex-1">

                            <p class="text-sm font-semibold text-[#27633D]">
                                Password Updated
                            </p>

                            <p class="mt-1 text-sm text-[#3D8B5A]">
                                {{ session('success') }}
                            </p>

                        </div>

                        <button
                            type="button"
                            @click="show = false"
                            class="text-[#3D8B5A] transition hover:text-[#27633D]"
                            aria-label="Dismiss success message"
                        >

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>

                        </button>

                    </div>

                </div>

            @endif


            {{-- ========================================= --}}
            {{-- VALIDATION ERRORS --}}
            {{-- ========================================= --}}
            @if($errors->any())

                <div class="mb-6 rounded-xl border border-[#B94A48]/25 bg-[#FDF0EF] p-5">

                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-[#B94A48]">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
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
                                    d="M12 8v4m0 4h.01"
                                />

                            </svg>

                        </div>

                        <div>

                            <p class="text-sm font-semibold text-[#7D302F]">
                                Please correct the following errors:
                            </p>

                            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-[#7D302F]">

                                @foreach($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    </div>

                </div>

            @endif


            {{-- ========================================= --}}
            {{-- PASSWORD FORM --}}
            {{-- ========================================= --}}
            <form
                method="POST"
                action="{{ route($passwordUpdateRoute) }}"
                class="space-y-6"
            >

                @csrf
                @method('PUT')


                {{-- ========================================= --}}
                {{-- PASSWORD SECURITY CARD --}}
                {{-- ========================================= --}}
                <div class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

                    {{-- Card Header --}}
                    <div class="border-b border-[#E5E2DB] px-6 py-5 sm:px-7">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#F7F4ED] text-[#C9A96E]">

                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M7 11V8a5 5 0 0110 0v3"
                                    />

                                    <rect
                                        x="5"
                                        y="11"
                                        width="14"
                                        height="10"
                                        rx="2"
                                        stroke-width="1.8"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M12 15v2"
                                    />

                                </svg>

                            </div>

                            <div>

                                <h2 class="font-serif text-xl font-semibold text-[#11110F]">
                                    Password Security
                                </h2>

                                <p class="mt-0.5 text-xs text-[#9B9992]">
                                    Enter your current password and choose a new password.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Card Body --}}
                    <div class="space-y-6 p-6 sm:p-7">


                        {{-- ========================================= --}}
                        {{-- CURRENT PASSWORD --}}
                        {{-- ========================================= --}}
                        <div x-data="{ show: false }">

                            <label
                                for="current_password"
                                class="mb-2 block text-sm font-semibold text-[#41403C]"
                            >
                                Current Password
                            </label>

                            <div class="relative">

                                <input
                                    id="current_password"
                                    name="current_password"
                                    :type="show ? 'text' : 'password'"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Enter your current password"
                                    class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white px-4 pr-12 text-sm text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                                >

                                <button
                                    type="button"
                                    @click="show = !show"
                                    :aria-label="show ? 'Hide password' : 'Show password'"
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-[#9B9992] transition hover:text-[#41403C]"
                                >

                                    {{-- Eye --}}
                                    <svg
                                        x-show="!show"
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


                                    {{-- Eye Off --}}
                                    <svg
                                        x-show="show"
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
                                            d="M9.9 5.2A10.7 10.7 0 0112 5c6.5 0 10 7 10 7a17.5 17.5 0 01-3.2 3.7"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M6.2 6.2C3.6 8.1 2 12 2 12s3.5 7 10 7c1.1 0 2.1-.2 3-.5"
                                        />

                                    </svg>

                                </button>

                            </div>

                            @error('current_password')

                                <p class="mt-1.5 text-xs text-[#B94A48]">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- ========================================= --}}
                        {{-- NEW PASSWORD --}}
                        {{-- ========================================= --}}
                        <div x-data="{ show: false }">

                            <label
                                for="password"
                                class="mb-2 block text-sm font-semibold text-[#41403C]"
                            >
                                New Password
                            </label>

                            <div class="relative">

                                <input
                                    id="password"
                                    name="password"
                                    :type="show ? 'text' : 'password'"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Enter your new password"
                                    class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white px-4 pr-12 text-sm text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                                >

                                <button
                                    type="button"
                                    @click="show = !show"
                                    :aria-label="show ? 'Hide password' : 'Show password'"
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-[#9B9992] transition hover:text-[#41403C]"
                                >

                                    {{-- Eye --}}
                                    <svg
                                        x-show="!show"
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


                                    {{-- Eye Off --}}
                                    <svg
                                        x-show="show"
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
                                            d="M9.9 5.2A10.7 10.7 0 0112 5c6.5 0 10 7 10 7a17.5 17.5 0 01-3.2 3.7"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M6.2 6.2C3.6 8.1 2 12 2 12s3.5 7 10 7c1.1 0 2.1-.2 3-.5"
                                        />

                                    </svg>

                                </button>

                            </div>

                            <p class="mt-2 text-xs leading-5 text-[#77756F]">
                                Use at least 8 characters. A strong password should contain a mix of letters, numbers, and symbols.
                            </p>

                            @error('password')

                                <p class="mt-1.5 text-xs text-[#B94A48]">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- ========================================= --}}
                        {{-- CONFIRM PASSWORD --}}
                        {{-- ========================================= --}}
                        <div x-data="{ show: false }">

                            <label
                                for="password_confirmation"
                                class="mb-2 block text-sm font-semibold text-[#41403C]"
                            >
                                Confirm New Password
                            </label>

                            <div class="relative">

                                <input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    :type="show ? 'text' : 'password'"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Confirm your new password"
                                    class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white px-4 pr-12 text-sm text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                                >

                                <button
                                    type="button"
                                    @click="show = !show"
                                    :aria-label="show ? 'Hide password' : 'Show password'"
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-[#9B9992] transition hover:text-[#41403C]"
                                >

                                    {{-- Eye --}}
                                    <svg
                                        x-show="!show"
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


                                    {{-- Eye Off --}}
                                    <svg
                                        x-show="show"
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
                                            d="M9.9 5.2A10.7 10.7 0 0112 5c6.5 0 10 7 10 7a17.5 17.5 0 01-3.2 3.7"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M6.2 6.2C3.6 8.1 2 12 2 12s3.5 7 10 7c1.1 0 2.1-.2 3-.5"
                                        />

                                    </svg>

                                </button>

                            </div>

                            @error('password_confirmation')

                                <p class="mt-1.5 text-xs text-[#B94A48]">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                    </div>

                </div>


                {{-- ========================================= --}}
                {{-- SECURITY NOTICE --}}
                {{-- ========================================= --}}
                <div class="rounded-2xl border border-[#E5E2DB] bg-white p-5">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#F7F4ED] text-[#C9A96E]">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-5a2 2 0 00-2-2H6a2 2 0 00-2 2v5a2 2 0 002 2zm10-9V7a4 4 0 00-8 0v3h8z"
                                />
                            </svg>

                        </div>

                        <div>

                            <h3 class="text-sm font-semibold text-[#11110F]">
                                Security Recommendation
                            </h3>

                            <p class="mt-1 text-sm leading-6 text-[#77756F]">
                                Never share your password with anyone. Use a unique password that you do not use for other accounts.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- ========================================= --}}
                {{-- ACTIONS --}}
                {{-- ========================================= --}}
                <div class="flex flex-col-reverse gap-3 border-t border-[#E5E2DB] pt-6 sm:flex-row sm:justify-end">

                    {{-- Back to Settings --}}
                    <a
                        href="{{ route($settingsRoute) }}"
                        class="inline-flex h-11 items-center justify-center gap-2 rounded-lg border border-[#D4D1CA] bg-white px-5 text-sm font-semibold text-[#41403C] transition hover:border-[#C9A96E] hover:bg-[#FAF9F6]"
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
                                stroke-width="1.8"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"
                            />
                        </svg>

                        Back to Settings

                    </a>


                    {{-- Update Password --}}
                    <button
                        type="submit"
                        class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-[#C9A96E] px-6 text-sm font-semibold text-[#11110F] shadow-sm transition hover:bg-[#D8BE8A] focus:outline-none focus:ring-2 focus:ring-[#C9A96E]/40 focus:ring-offset-2"
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
                                stroke-width="1.8"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>

                        Update Password

                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection