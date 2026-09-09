@extends('layouts.app')

@section('title', 'Add Lawyer')

@section('content')

    <div
        x-data="{ showPassword: false, showConfirmation: false }"
        class="min-h-screen bg-[#F7F4ED]"
    >
        <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">

            {{-- ========================================= --}}
            {{-- PAGE HEADER --}}
            {{-- ========================================= --}}

            <div class="mb-8">
                <a
                    href="{{ route('admin.lawyers.index') }}"
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

                    Back to Lawyers
                </a>

                <div class="mt-6">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-[#B89452]">
                        Lawyer Management
                    </p>

                    <h1 class="mt-2 font-serif text-3xl font-semibold tracking-tight text-[#11110F] sm:text-4xl">
                        Add Lawyer
                    </h1>

                    <p class="mt-2 text-sm text-[#77756F]">
                        Create a new lawyer account for the firm.
                    </p>
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
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>

            @endif


            {{-- ========================================= --}}
            {{-- FORM --}}
            {{-- ========================================= --}}

            <form
                method="POST"
                action="{{ route('admin.lawyers.store') }}"
                class="space-y-6"
            >
                @csrf


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
                                    Basic information about the lawyer.
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
                                value="{{ old('name') }}"
                                required
                                autocomplete="name"
                                placeholder="Enter lawyer's full name"
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
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                placeholder="lawyer@example.com"
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
                                value="{{ old('phone') }}"
                                autocomplete="tel"
                                placeholder="+962..."
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
                                    Lawyer's specialization and professional details.
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
                                value="{{ old('specialization') }}"
                                placeholder="e.g. Criminal Law"
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
                                value="{{ old('experience_years') }}"
                                min="0"
                                max="60"
                                placeholder="Years of experience"
                                class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white px-4 text-sm text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                            >

                            @error('experience_years')
                                <p class="mt-1.5 text-xs text-[#B94A48]">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- License Number --}}

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
                                value="{{ old('license_number') }}"
                                placeholder="Professional license number"
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

                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-xs font-semibold text-[#B89452]">
                                    JD
                                </span>

                                <input
                                    id="billing_rate"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    name="billing_rate"
                                    value="{{ old('billing_rate') }}"
                                    placeholder="0.00"
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
                                placeholder="Write a short professional biography..."
                                class="w-full resize-y rounded-lg border border-[#D4D1CA] bg-white px-4 py-3 text-sm leading-6 text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                            >{{ old('bio') }}</textarea>

                            @error('bio')
                                <p class="mt-1.5 text-xs text-[#B94A48]">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- ========================================= --}}
                        {{-- ACCOUNT STATUS --}}
                        {{-- ========================================= --}}

                        <div class="md:col-span-2">

                            <label
                                for="is_active"
                                class="mb-2 block text-sm font-semibold text-[#41403C]"
                            >
                                Account Status
                            </label>

                            <select
                                id="is_active"
                                name="is_active"
                                class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white px-4 text-sm text-[#11110F] outline-none transition focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                            >

                                <option
                                    value="1"
                                    {{ old('is_active', '1') == '1' ? 'selected' : '' }}
                                >
                                    Active
                                </option>

                                <option
                                    value="0"
                                    {{ old('is_active') === '0' ? 'selected' : '' }}
                                >
                                    Inactive
                                </option>

                            </select>

                            <p class="mt-1.5 text-xs text-[#9B9992]">
                                Choose whether the lawyer can access the account immediately.
                            </p>

                            @error('is_active')
                                <p class="mt-1.5 text-xs text-[#B94A48]">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>
                </div>


                {{-- ========================================= --}}
                {{-- ACCOUNT SECURITY --}}
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
                                    Account Security
                                </h2>

                                <p class="mt-0.5 text-xs text-[#9B9992]">
                                    Set the login password for the lawyer.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="grid grid-cols-1 gap-5 p-6 sm:p-7 md:grid-cols-2">

                        {{-- Password --}}

                        <div>

                            <label
                                for="password"
                                class="mb-2 block text-sm font-semibold text-[#41403C]"
                            >
                                Password
                            </label>

                            <div class="relative">

                                <input
                                    id="password"
                                    :type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                    class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white px-4 pr-12 text-sm text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                                >

                                <button
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-[#9B9992] transition hover:text-[#41403C]"
                                    aria-label="Toggle password visibility"
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
                                Confirm Password
                            </label>

                            <div class="relative">

                                <input
                                    id="password_confirmation"
                                    :type="showConfirmation ? 'text' : 'password'"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white px-4 pr-12 text-sm text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                                >

                                <button
                                    type="button"
                                    @click="showConfirmation = !showConfirmation"
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-[#9B9992] transition hover:text-[#41403C]"
                                    aria-label="Toggle password confirmation visibility"
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
                                            d="M9.9 5.2A10.7 10.7 0 0112 5c6.5 0 10 7 10 7a17.5 17.5 0 01-3.2 3.7"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M6.2 6.2C3.6 6.2 2 12 2 12s3.5 7 10 7c1.1 0 2.1-.2 3-.5"
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
                {{-- ACTIONS --}}
                {{-- ========================================= --}}

                <div class="flex flex-col-reverse gap-3 border-t border-[#E5E2DB] pt-6 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('admin.lawyers.index') }}"
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
                                d="M12 5v14M5 12h14"
                            />
                        </svg>

                        Create Lawyer

                    </button>

                </div>

            </form>

        </div>
    </div>

@endsection