@extends('layouts.app')

@section('title', 'Lawyer Profile')

@section('content')

<div x-data="{ deleteModal: false }" class="min-h-screen bg-[#F7F4ED]">

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Back --}}
        <div class="mb-6">
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
        </div>

        @php
            /*
             * IMPORTANT:
             * Read the actual database value.
             * Do not default an existing lawyer to true.
             */
            $isActive = (bool) $lawyer->is_active;

            $openCases = $lawyer->cases_as_lawyer_count ?? 0;

            $initial = strtoupper(
                substr($lawyer->name ?? 'L', 0, 1)
            );
        @endphp


        {{-- ========================================= --}}
        {{-- PROFILE HEADER --}}
        {{-- ========================================= --}}

        <div class="mb-8 overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

            {{-- Dark Header --}}
            <div class="bg-[#11110F] px-6 py-8 sm:px-8">

                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                    {{-- Lawyer Identity --}}
                    <div class="flex items-center gap-5">

                        {{-- Avatar --}}
                        <div
                            class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl border border-[#C9A96E]/40 bg-[#181815] text-2xl font-semibold text-[#D8BE8A]"
                        >
                            {{ $initial }}
                        </div>

                        <div class="min-w-0">

                            <div class="flex flex-wrap items-center gap-3">

                                <h1 class="font-serif text-3xl font-semibold tracking-tight text-white">
                                    {{ $lawyer->name }}
                                </h1>

                                {{-- Account Status --}}
                                @if ($isActive)

                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full border border-[#3D8B5A]/30 bg-[#3D8B5A]/10 px-3 py-1 text-xs font-semibold text-[#A8D7B8]"
                                    >
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#3D8B5A]"></span>
                                        Active
                                    </span>

                                @else

                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold text-[#9B9992]"
                                    >
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#77756F]"></span>
                                        Inactive
                                    </span>

                                @endif

                            </div>

                            <p class="mt-2 break-all text-sm text-[#9B9992]">
                                {{ $lawyer->email }}
                            </p>

                            @if ($lawyer->specialization)

                                <div class="mt-4 flex items-center gap-2 text-sm text-[#D8BE8A]">

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
                                            d="M12 14l9-5-9-5-9 5 9 5z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M5 12v5c0 1.1 3.1 3 7 3s7-1.9 7-3v-5"
                                        />
                                    </svg>

                                    {{ $lawyer->specialization }}

                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- Edit --}}
                    <div class="flex shrink-0">

                        <a
                            href="{{ route('admin.lawyers.edit', $lawyer) }}"
                            class="inline-flex h-11 items-center gap-2 rounded-lg bg-[#C9A96E] px-5 text-sm font-semibold text-[#11110F] transition hover:bg-[#D8BE8A]"
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
                                    d="M12 20h9M16.5 3.5a2.1 2.1 0 013 3L8 18l-4 1 1-4L16.5 3.5z"
                                />
                            </svg>

                            Edit Lawyer

                        </a>

                    </div>

                </div>

            </div>


            {{-- ========================================= --}}
            {{-- PROFILE STATS --}}
            {{-- ========================================= --}}

            <div class="grid grid-cols-2 divide-x divide-y divide-[#E5E2DB] sm:grid-cols-4 sm:divide-y-0">

                {{-- Cases --}}
                <div class="p-5 sm:p-6">

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
                                    d="M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M14 3v5h5M9 13h6M9 17h4"
                                />
                            </svg>

                        </div>

                        <div>

                            <p class="text-2xl font-semibold text-[#11110F]">
                                {{ $openCases }}
                            </p>

                            <p class="text-xs font-medium text-[#77756F]">
                                Cases
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Experience --}}
                <div class="p-5 sm:p-6">

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
                                    d="M20 7h-4V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M8 12h8"
                                />
                            </svg>

                        </div>

                        <div>

                            <p class="text-2xl font-semibold text-[#11110F]">
                                {{ $lawyer->experience_years ?? 0 }}
                            </p>

                            <p class="text-xs font-medium text-[#77756F]">
                                Years Experience
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Billing --}}
                <div class="p-5 sm:p-6">

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
                                    d="M12 3v18M17 7.5C17 6.1 14.8 5 12 5S7 6.1 7 7.5 9.2 10 12 10s5 1.1 5 2.5S14.8 15 12 15s-5 1.1-5 2.5S9.2 20 12 20s5-1.1 5-2.5"
                                />
                            </svg>

                        </div>

                        <div>

                            <p class="text-2xl font-semibold text-[#11110F]">
                                {{ $lawyer->billing_rate ?? '—' }}
                            </p>

                            <p class="text-xs font-medium text-[#77756F]">
                                Billing Rate
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Account Status --}}
                <div class="p-5 sm:p-6">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-lg
                            {{ $isActive
                                ? 'bg-[#EFF8F2] text-[#3D8B5A]'
                                : 'bg-[#F3F2EF] text-[#77756F]' }}"
                        >

                            @if ($isActive)

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

                            @else

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
                                        d="M6 6l12 12M18 6L6 18"
                                    />
                                </svg>

                            @endif

                        </div>

                        <div>

                            <p
                                class="text-sm font-semibold
                                {{ $isActive
                                    ? 'text-[#27633D]'
                                    : 'text-[#77756F]' }}"
                            >
                                {{ $isActive ? 'Active' : 'Inactive' }}
                            </p>

                            <p class="text-xs font-medium text-[#77756F]">
                                Account Status
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ========================================= --}}
        {{-- INFORMATION GRID --}}
        {{-- ========================================= --}}

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">


            {{-- ========================================= --}}
            {{-- LAWYER INFORMATION --}}
            {{-- ========================================= --}}

            <div class="rounded-2xl border border-[#E5E2DB] bg-white p-6 shadow-sm lg:col-span-2 sm:p-7">

                <div class="flex items-center gap-3 border-b border-[#E5E2DB] pb-5">

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
                            Lawyer Information
                        </h2>

                        <p class="mt-0.5 text-xs text-[#9B9992]">
                            Professional and personal details
                        </p>

                    </div>

                </div>


                {{-- Information Fields --}}
                <div class="mt-6 grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">

                    {{-- Full Name --}}
                    <div>

                        <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                            Full Name
                        </p>

                        <p class="mt-1.5 text-sm font-semibold text-[#11110F]">
                            {{ $lawyer->name }}
                        </p>

                    </div>


                    {{-- Email --}}
                    <div>

                        <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                            Email
                        </p>

                        <p class="mt-1.5 break-all text-sm font-semibold text-[#11110F]">
                            {{ $lawyer->email }}
                        </p>

                    </div>


                    {{-- Phone --}}
                    <div>

                        <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                            Phone
                        </p>

                        <p class="mt-1.5 text-sm font-semibold text-[#11110F]">
                            {{ $lawyer->phone ?? 'Not provided' }}
                        </p>

                    </div>


                    {{-- Specialization --}}
                    <div>

                        <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                            Specialization
                        </p>

                        <p class="mt-1.5 text-sm font-semibold text-[#11110F]">
                            {{ $lawyer->specialization ?? 'Not specified' }}
                        </p>

                    </div>


                    {{-- License --}}
                    <div>

                        <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                            License Number
                        </p>

                        <p class="mt-1.5 text-sm font-semibold text-[#11110F]">
                            {{ $lawyer->license_number ?? 'Not provided' }}
                        </p>

                    </div>


                    {{-- Experience --}}
                    <div>

                        <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                            Experience
                        </p>

                        <p class="mt-1.5 text-sm font-semibold text-[#11110F]">
                            {{ $lawyer->experience_years ?? 0 }} years
                        </p>

                    </div>

                </div>


                {{-- Biography --}}
                @if ($lawyer->bio)

                    <div class="mt-7 border-t border-[#E5E2DB] pt-6">

                        <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                            Biography
                        </p>

                        <p class="mt-3 text-sm leading-7 text-[#41403C]">
                            {{ $lawyer->bio }}
                        </p>

                    </div>

                @endif

            </div>


            {{-- ========================================= --}}
            {{-- RIGHT COLUMN --}}
            {{-- ========================================= --}}

            <div class="space-y-6">


                {{-- ========================================= --}}
                {{-- ACCOUNT DETAILS --}}
                {{-- ========================================= --}}

                <div class="rounded-2xl border border-[#E5E2DB] bg-white p-6 shadow-sm">

                    <div class="flex items-center gap-3 border-b border-[#E5E2DB] pb-5">

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
                                Account Details
                            </h2>

                            <p class="mt-0.5 text-xs text-[#9B9992]">
                                Account information
                            </p>

                        </div>

                    </div>


                    <div class="mt-6 space-y-5">

                        {{-- Role --}}
                        <div>

                            <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                Role
                            </p>

                            <p class="mt-1.5 text-sm font-semibold capitalize text-[#11110F]">
                                {{ $lawyer->role ?? 'lawyer' }}
                            </p>

                        </div>


                        {{-- Joined --}}
                        <div>

                            <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                Joined
                            </p>

                            <p class="mt-1.5 text-sm font-semibold text-[#11110F]">
                                {{ $lawyer->created_at ? $lawyer->created_at->format('M d, Y') : '—' }}
                            </p>

                        </div>


                        {{-- Last Updated --}}
                        <div>

                            <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                Last Updated
                            </p>

                            <p class="mt-1.5 text-sm font-semibold text-[#11110F]">
                                {{ $lawyer->updated_at ? $lawyer->updated_at->format('M d, Y') : '—' }}
                            </p>

                        </div>

                    </div>

                </div>


                {{-- ========================================= --}}
                {{-- ADMINISTRATOR NOTICE --}}
                {{-- ========================================= --}}

                <div class="rounded-2xl border border-[#D8BE8A] bg-[#11110F] p-6 shadow-sm">

                    <div class="flex items-start gap-4">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-[#C9A96E]/30 bg-[#181815] text-[#D8BE8A]">

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
                            </svg>

                        </div>

                        <div>

                            <h3 class="text-sm font-semibold text-white">
                                Administrator Access
                            </h3>

                            <p class="mt-2 text-xs leading-6 text-[#9B9992]">
                                This profile is being viewed from the administrator
                                panel. Account and professional information should be
                                handled as confidential records.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- ========================================= --}}
                {{-- DANGER ZONE --}}
                {{-- ========================================= --}}

                <div class="rounded-2xl border border-[#B94A48]/25 bg-white p-6 shadow-sm">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#FDF0EF] text-[#B94A48]">

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

                            <h2 class="text-sm font-semibold text-[#7D302F]">
                                Danger Zone
                            </h2>

                            <p class="mt-1 text-xs leading-5 text-[#77756F]">
                                Deleting this lawyer account is permanent and
                                cannot be undone.
                            </p>

                        </div>

                    </div>


                    <button
                        type="button"
                        @click="deleteModal = true"
                        class="mt-5 w-full rounded-lg border border-[#B94A48]/30 px-4 py-2.5 text-sm font-semibold text-[#B94A48] transition hover:bg-[#FDF0EF]"
                    >
                        Delete Lawyer
                    </button>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================= --}}
    {{-- DELETE MODAL --}}
    {{-- ========================================= --}}

    <div
        x-show="deleteModal"
        x-cloak
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-[#0B0B0A]/60 px-4"
    >

        <div
            @click.outside="deleteModal = false"
            x-transition
            class="w-full max-w-md rounded-2xl border border-[#E5E2DB] bg-white p-6 shadow-2xl"
        >

            {{-- Icon --}}
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#FDF0EF] text-[#B94A48]">

                <svg
                    class="h-6 w-6"
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


            <h2 class="mt-5 font-serif text-2xl font-semibold text-[#11110F]">
                Delete Lawyer?
            </h2>


            <p class="mt-2 text-sm leading-6 text-[#77756F]">

                Are you sure you want to delete

                <strong class="font-semibold text-[#41403C]">
                    {{ $lawyer->name }}
                </strong>?

                This action cannot be undone.

            </p>


            {{-- Modal Actions --}}
            <div class="mt-7 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <button
                    type="button"
                    @click="deleteModal = false"
                    class="rounded-lg border border-[#D4D1CA] px-4 py-2.5 text-sm font-semibold text-[#41403C] transition hover:bg-[#F7F4ED]"
                >
                    Cancel
                </button>


                <form
                    method="POST"
                    action="{{ route('admin.lawyers.destroy', $lawyer) }}"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-[#B94A48] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#7D302F] sm:w-auto"
                    >
                        Delete Lawyer
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection