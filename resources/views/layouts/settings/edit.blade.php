@extends('layouts.app')

@section('title', 'Settings')

@section('breadcrumb', 'Account / Settings')

@section('content')

    <div class="min-h-screen bg-[#F7F4ED]">

        <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">

            {{-- ========================================= --}}
            {{-- PAGE HEADER --}}
            {{-- ========================================= --}}
            <div class="mb-8">

                <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-[#B89452]">
                    Account Management
                </p>

                <h1 class="mt-2 font-serif text-3xl font-semibold tracking-tight text-[#11110F] sm:text-4xl">
                    Account Settings
                </h1>

                <p class="mt-2 text-sm text-[#77756F]">
                    Manage your personal information and account preferences.
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
                                Settings Updated
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
            {{-- SETTINGS FORM --}}
            {{-- ========================================= --}}
            <form
                method="POST"
                action="{{ route($settingsUpdateRoute) }}"
                class="space-y-6"
            >

                @csrf
                @method('PUT')


                {{-- ========================================= --}}
                {{-- PERSONAL INFORMATION --}}
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
                                    Update your basic account information.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Card Body --}}
                    <div class="grid grid-cols-1 gap-5 p-6 sm:p-7 md:grid-cols-2">


                        {{-- ========================================= --}}
                        {{-- FULL NAME --}}
                        {{-- ========================================= --}}
                        <div>

                            <label
                                for="name"
                                class="mb-2 block text-sm font-semibold text-[#41403C]"
                            >
                                Full Name
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', Auth::user()->name) }}"
                                required
                                autocomplete="name"
                                placeholder="Enter your full name"
                                class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white px-4 text-sm text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                            >

                            @error('name')

                                <p class="mt-1.5 text-xs text-[#B94A48]">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- ========================================= --}}
                        {{-- EMAIL --}}
                        {{-- ========================================= --}}
                        <div>

                            <label
                                for="email"
                                class="mb-2 block text-sm font-semibold text-[#41403C]"
                            >
                                Email Address
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', Auth::user()->email) }}"
                                required
                                autocomplete="email"
                                placeholder="Enter your email address"
                                class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white px-4 text-sm text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                            >

                            @error('email')

                                <p class="mt-1.5 text-xs text-[#B94A48]">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- ========================================= --}}
                        {{-- PHONE --}}
                        {{-- ========================================= --}}
                        <div>

                            <label
                                for="phone"
                                class="mb-2 block text-sm font-semibold text-[#41403C]"
                            >
                                Phone Number
                            </label>

                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                value="{{ old('phone', Auth::user()->phone) }}"
                                autocomplete="tel"
                                placeholder="Enter your phone number"
                                class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white px-4 text-sm text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                            >

                            @error('phone')

                                <p class="mt-1.5 text-xs text-[#B94A48]">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- ========================================= --}}
                        {{-- LANGUAGE --}}
                        {{-- ========================================= --}}
                        <div>

                            <label
                                for="language"
                                class="mb-2 block text-sm font-semibold text-[#41403C]"
                            >
                                Language
                            </label>

                            <select
                                id="language"
                                name="language"
                                class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white px-4 text-sm text-[#11110F] outline-none transition focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                            >

                                <option
                                    value="en"
                                    {{ old('language', Auth::user()->language ?? 'en') === 'en' ? 'selected' : '' }}
                                >
                                    English
                                </option>

                                <option
                                    value="ar"
                                    {{ old('language', Auth::user()->language ?? 'en') === 'ar' ? 'selected' : '' }}
                                >
                                    Arabic
                                </option>

                            </select>

                            @error('language')

                                <p class="mt-1.5 text-xs text-[#B94A48]">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                    </div>

                </div>


                {{-- ========================================= --}}
                {{-- ACCOUNT INFORMATION --}}
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
                                        d="M9 12h6m-6 4h4m-2-13H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V8l-5-5z"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M14 3v5h5"
                                    />

                                </svg>

                            </div>

                            <div>

                                <h2 class="font-serif text-xl font-semibold text-[#11110F]">
                                    Account Information
                                </h2>

                                <p class="mt-0.5 text-xs text-[#9B9992]">
                                    Information about your account and role.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Card Body --}}
                    <div class="grid grid-cols-1 gap-5 p-6 sm:p-7 md:grid-cols-2">


                        {{-- ========================================= --}}
                        {{-- ACCOUNT ROLE --}}
                        {{-- ========================================= --}}
                        <div>

                            <label class="mb-2 block text-sm font-semibold text-[#41403C]">
                                Account Role
                            </label>

                            <div class="flex items-center gap-3 rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] px-4 py-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-[#C9A96E]">

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
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                        />

                                    </svg>

                                </div>

                                <div class="min-w-0">

                                    <p class="truncate text-sm font-semibold capitalize text-[#11110F]">
                                        {{ Auth::user()->role }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-[#77756F]">
                                        Your account role
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- ========================================= --}}
                        {{-- ACCOUNT CREATED --}}
                        {{-- ========================================= --}}
                        <div>

                            <label class="mb-2 block text-sm font-semibold text-[#41403C]">
                                Account Created
                            </label>

                            <div class="flex items-center gap-3 rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] px-4 py-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-[#C9A96E]">

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
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />

                                    </svg>

                                </div>

                                <div class="min-w-0">

                                    <p class="text-sm font-semibold text-[#11110F]">
                                        {{ Auth::user()->created_at?->format('M d, Y') ?? 'N/A' }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-[#77756F]">
                                        Account creation date
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ========================================= --}}
                {{-- PASSWORD & SECURITY --}}
                {{-- ========================================= --}}
                <div class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

                    <div class="flex flex-col gap-4 px-6 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">

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
                                    Password & Security
                                </h2>

                                <p class="mt-0.5 text-sm text-[#77756F]">
                                    Keep your account secure by using a strong password.
                                </p>

                            </div>

                        </div>


                        <a
                            href="{{ route($passwordRoute) }}"
                            class="inline-flex h-10 shrink-0 items-center justify-center gap-2 rounded-lg border border-[#C9A96E] bg-white px-4 text-sm font-semibold text-[#41403C] transition hover:bg-[#F7F4ED]"
                        >

                            <svg
                                class="h-4 w-4 text-[#B89452]"
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

                            Change Password

                        </a>

                    </div>

                </div>


                {{-- ========================================= --}}
                {{-- ACTIONS --}}
                {{-- ========================================= --}}
                <div class="flex flex-col-reverse gap-3 border-t border-[#E5E2DB] pt-6 sm:flex-row sm:justify-end">

                    <a
                        href="{{ url()->previous() }}"
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
                                d="M5 13l4 4L19 7"
                            />
                        </svg>

                        Update Settings

                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection