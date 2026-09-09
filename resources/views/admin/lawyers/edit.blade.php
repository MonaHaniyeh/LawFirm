@extends('layouts.app')

@section('title', 'Edit Lawyer')

@section('content')

<div x-data="{ showPassword: false }" class="min-h-screen bg-[#F7F4ED]">
<div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">

    {{-- ========================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ========================================= --}}
    <div class="mb-8">

        <a
            href="{{ route('admin.lawyers.show', $lawyer) }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-[#77756F] transition hover:text-[#11110F]"
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
                    d="M15 19l-7-7 7-7"
                />
            </svg>

            Back to Lawyer
        </a>

        <div class="mt-6">

            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">

                <div>

                    <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-[#B89452]">
                        Lawyer Management
                    </p>

                    <h1 class="mt-2 font-serif text-3xl font-semibold tracking-tight text-[#11110F] sm:text-4xl">
                        Edit Lawyer
                    </h1>

                    <p class="mt-2 text-sm text-[#77756F]">
                        Update {{ $lawyer->name }}'s professional and account information.
                    </p>

                </div>

                {{-- Current Status --}}
                @php
                    $headerIsActive = (bool) $lawyer->is_active;
                @endphp

                @if ($headerIsActive)

                    <span
                        class="inline-flex w-fit items-center gap-2 rounded-full border border-[#3D8B5A]/20 bg-[#EFF8F2] px-3 py-1.5 text-xs font-semibold text-[#27633D]"
                    >
                        <span class="h-1.5 w-1.5 rounded-full bg-[#3D8B5A]"></span>
                        Active Account
                    </span>

                @else

                    <span
                        class="inline-flex w-fit items-center gap-2 rounded-full border border-[#D4D1CA] bg-white px-3 py-1.5 text-xs font-semibold text-[#77756F]"
                    >
                        <span class="h-1.5 w-1.5 rounded-full bg-[#77756F]"></span>
                        Inactive Account
                    </span>

                @endif

            </div>

        </div>

    </div>


    {{-- ========================================= --}}
    {{-- VALIDATION ERRORS --}}
    {{-- ========================================= --}}
    @if ($errors->any())

        <div class="mb-6 rounded-xl border border-[#B94A48]/25 bg-[#FDF0EF] p-5">

            <div class="flex items-start gap-3">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-[#B94A48]">

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
                            d="M12 9v4m0 4h.01M10.3 3h3.4L22 19a2 2 0 01-1.7 3H3.7A2 2 0 012 19L10.3 3z"
                        />
                    </svg>

                </div>

                <div>

                    <p class="text-sm font-semibold text-[#7D302F]">
                        Please correct the following errors:
                    </p>

                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-[#7D302F]">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    {{-- ========================================= --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ========================================= --}}
    @if (session('success'))

        <div class="mb-6 rounded-xl border border-[#3D8B5A]/20 bg-[#EFF8F2] p-4">

            <div class="flex items-center gap-3">

                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white text-[#3D8B5A]">

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

                </div>

                <p class="text-sm font-medium text-[#27633D]">
                    {{ session('success') }}
                </p>

            </div>

        </div>

    @endif


    {{-- ========================================= --}}
    {{-- FORM --}}
    {{-- ========================================= --}}
    <form
        method="POST"
        action="{{ route('admin.lawyers.update', $lawyer) }}"
        class="space-y-6"
    >

        @csrf
        @method('PUT')


        {{-- ========================================= --}}
        {{-- PERSONAL INFORMATION --}}
        {{-- ========================================= --}}
        <div class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

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
                                d="M12 12a4 4 0 100-8 4 4 0 000 8z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M4 21a8 8 0 0116 0"
                            />
                        </svg>

                    </div>

                    <div>

                        <h2 class="font-serif text-xl font-semibold text-[#11110F]">
                            Personal Information
                        </h2>

                        <p class="mt-0.5 text-xs text-[#9B9992]">
                            Update the lawyer's personal details.
                        </p>

                    </div>

                </div>

            </div>


            <div class="grid grid-cols-1 gap-5 p-6 sm:p-7 md:grid-cols-2">

                {{-- Full Name --}}
                <div class="md:col-span-2">

                    <label
                        for="name"
                        class="mb-2 block text-sm font-semibold text-[#41403C]"
                    >
                        Full Name
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', $lawyer->name) }}"
                        required
                        autocomplete="name"
                        class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white px-4 text-sm text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                    >

                    @error('name')

                        <p class="mt-1.5 text-xs text-[#B94A48]">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Email --}}
                <div>

                    <label
                        for="email"
                        class="mb-2 block text-sm font-semibold text-[#41403C]"
                    >
                        Email Address
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', $lawyer->email) }}"
                        required
                        autocomplete="email"
                        class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white px-4 text-sm text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                    >

                    @error('email')

                        <p class="mt-1.5 text-xs text-[#B94A48]">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Phone --}}
                <div>

                    <label
                        for="phone"
                        class="mb-2 block text-sm font-semibold text-[#41403C]"
                    >
                        Phone Number
                    </label>

                    <input
                        id="phone"
                        type="text"
                        name="phone"
                        value="{{ old('phone', $lawyer->phone) }}"
                        autocomplete="tel"
                        class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white px-4 text-sm text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                    >

                    @error('phone')

                        <p class="mt-1.5 text-xs text-[#B94A48]">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

            </div>

        </div>


        {{-- ========================================= --}}
        {{-- PROFESSIONAL INFORMATION --}}
        {{-- ========================================= --}}
        <div class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

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
                                d="M12 14l9-5-9-5-9 5 9 5z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M5 12v5c0 1.1 3.1 3 7 3s7-1.9 7-3v-5"
                            />
                        </svg>

                    </div>

                    <div>

                        <h2 class="font-serif text-xl font-semibold text-[#11110F]">
                            Professional Information
                        </h2>

                        <p class="mt-0.5 text-xs text-[#9B9992]">
                            Manage legal credentials and professional details.
                        </p>

                    </div>

                </div>

            </div>


            <div class="grid grid-cols-1 gap-5 p-6 sm:p-7 md:grid-cols-2">

                {{-- Specialization --}}
                <div>

                    <label
                        for="specialization"
                        class="mb-2 block text-sm font-semibold text-[#41403C]"
                    >
                        Specialization
                    </label>

                    <input
                        id="specialization"
                        type="text"
                        name="specialization"
                        value="{{ old('specialization', $lawyer->specialization) }}"
                        required
                        class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white px-4 text-sm text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                    >

                    @error('specialization')

                        <p class="mt-1.5 text-xs text-[#B94A48]">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Experience --}}
                <div>

                    <label
                        for="experience_years"
                        class="mb-2 block text-sm font-semibold text-[#41403C]"
                    >
                        Years of Experience
                    </label>

                    <input
                        id="experience_years"
                        type="number"
                        name="experience_years"
                        min="0"
                        value="{{ old('experience_years', $lawyer->experience_years) }}"
                        required
                        class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white px-4 text-sm text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                    >

                    @error('experience_years')

                        <p class="mt-1.5 text-xs text-[#B94A48]">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- License --}}
                <div>

                    <label
                        for="license_number"
                        class="mb-2 block text-sm font-semibold text-[#41403C]"
                    >
                        License Number
                    </label>

                    <input
                        id="license_number"
                        type="text"
                        name="license_number"
                        value="{{ old('license_number', $lawyer->license_number) }}"
                        required
                        class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white px-4 text-sm text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                    >

                    @error('license_number')

                        <p class="mt-1.5 text-xs text-[#B94A48]">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Billing Rate --}}
                <div>

                    <label
                        for="billing_rate"
                        class="mb-2 block text-sm font-semibold text-[#41403C]"
                    >
                        Billing Rate
                    </label>

                    <div class="relative">

                        <span
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-xs font-semibold text-[#B89452]"
                        >
                            JD
                        </span>

                        <input
                            id="billing_rate"
                            type="number"
                            step="0.01"
                            min="0"
                            name="billing_rate"
                            value="{{ old('billing_rate', $lawyer->billing_rate) }}"
                            class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white py-3 pl-12 pr-4 text-sm text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                        >

                    </div>

                    @error('billing_rate')

                        <p class="mt-1.5 text-xs text-[#B94A48]">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Biography --}}
                <div class="md:col-span-2">

                    <label
                        for="bio"
                        class="mb-2 block text-sm font-semibold text-[#41403C]"
                    >
                        Biography
                    </label>

                    <textarea
                        id="bio"
                        name="bio"
                        rows="6"
                        class="w-full resize-y rounded-lg border border-[#D4D1CA] bg-white px-4 py-3 text-sm leading-6 text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                    >{{ old('bio', $lawyer->bio) }}</textarea>

                    @error('bio')

                        <p class="mt-1.5 text-xs text-[#B94A48]">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

            </div>

        </div>


        {{-- ========================================= --}}
        {{-- ACCOUNT STATUS --}}
        {{-- ========================================= --}}
        <div class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

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
                                d="M12 3l8 4v5c0 5-3.5 8-8 9-4.5-1-8-4-8-9V7l8-4z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M9 12l2 2 4-4"
                            />
                        </svg>

                    </div>

                    <div>

                        <h2 class="font-serif text-xl font-semibold text-[#11110F]">
                            Account Status
                        </h2>

                        <p class="mt-0.5 text-xs text-[#9B9992]">
                            Control access to the law firm system.
                        </p>

                    </div>

                </div>

            </div>


            <div class="p-6 sm:p-7">

                @php
                    /*
                     * IMPORTANT:
                     * Account status comes from users.is_active.
                     * We intentionally do NOT use users.status here.
                     */
                    $isActive = old(
                        'is_active',
                        $lawyer->is_active ? '1' : '0'
                    );
                @endphp


                <label
                    class="flex cursor-pointer items-center justify-between gap-5 rounded-xl border border-[#E5E2DB] bg-[#FAF9F6] p-5 transition hover:border-[#C9A96E]/50"
                >

                    <div class="flex items-start gap-4">

                        <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-[#C9A96E]">

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

                        </div>

                        <div>

                            <p class="text-sm font-semibold text-[#11110F]">
                                Active Account
                            </p>

                            <p class="mt-1 text-xs leading-5 text-[#77756F]">
                                Allow this lawyer to access the system.
                            </p>

                        </div>

                    </div>


                    {{-- ========================================= --}}
                    {{-- ACTIVE / INACTIVE TOGGLE --}}
                    {{-- ========================================= --}}
                    <div class="relative">

                        {{-- Sends 0 when checkbox is unchecked --}}
                        <input
                            type="hidden"
                            name="is_active"
                            value="0"
                        >

                        <input
                            type="checkbox"
                            id="is_active"
                            name="is_active"
                            value="1"
                            class="peer sr-only"
                            @checked($isActive == '1')
                        >

                        <div
                            class="h-6 w-11 rounded-full bg-[#D4D1CA] transition peer-checked:bg-[#3D8B5A]"
                        ></div>

                        <div
                            class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow-sm transition peer-checked:translate-x-5"
                        ></div>

                    </div>

                </label>

            </div>

        </div>


        {{-- ========================================= --}}
        {{-- CHANGE PASSWORD --}}
        {{-- ========================================= --}}
        <div class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

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
                            Change Password
                        </h2>

                        <p class="mt-0.5 text-xs text-[#9B9992]">
                            Leave these fields empty if you do not want to change the password.
                        </p>

                    </div>

                </div>

            </div>


            <div class="grid grid-cols-1 gap-5 p-6 sm:p-7 md:grid-cols-2">

                {{-- New Password --}}
                <div>

                    <label
                        for="password"
                        class="mb-2 block text-sm font-semibold text-[#41403C]"
                    >
                        New Password
                    </label>

                    <div class="relative">

                        <input
                            id="password"
                            :type="showPassword ? 'text' : 'password'"
                            name="password"
                            autocomplete="new-password"
                            class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white px-4 pr-12 text-sm text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                        >

                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 flex items-center px-4 text-[#9B9992] transition hover:text-[#41403C]"
                            aria-label="Toggle password visibility"
                        >

                            {{-- Eye --}}
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


                            {{-- Eye Off --}}
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

                    @error('password')

                        <p class="mt-1.5 text-xs text-[#B94A48]">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Confirm Password --}}
                <div>

                    <label
                        for="password_confirmation"
                        class="mb-2 block text-sm font-semibold text-[#41403C]"
                    >
                        Confirm New Password
                    </label>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        autocomplete="new-password"
                        class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white px-4 text-sm text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                    >

                </div>

            </div>

        </div>


        {{-- ========================================= --}}
        {{-- ACTIONS --}}
        {{-- ========================================= --}}
        <div class="flex flex-col-reverse gap-3 border-t border-[#E5E2DB] pt-6 sm:flex-row sm:justify-end">

            <a
                href="{{ route('admin.lawyers.show', $lawyer) }}"
                class="inline-flex h-11 items-center justify-center rounded-lg border border-[#D4D1CA] bg-white px-5 text-sm font-semibold text-[#41403C] transition hover:border-[#C9A96E] hover:bg-[#FAF9F6]"
            >
                Cancel
            </a>

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
                        d="M5 12h14M12 5l7 7-7 7"
                    />
                </svg>

                Save Changes

            </button>

        </div>

    </form>

</div>
</div>

@endsection
