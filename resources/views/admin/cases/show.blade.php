@extends('layouts.app')

@section('title', 'Case Details')

@section('content')

@php
    $caseStatus = strtolower($case->status ?? 'pending');

    $client = $case->client ?? ($case->user ?? null);
    $lawyer = $case->lawyer ?? null;

    $caseTitle = $case->title
        ?? ($case->case_title ?? 'Untitled Case');

    $caseNumber = $case->case_number
        ?? ($case->reference_number ?? $case->id);

    $description = $case->description
        ?? ($case->details ?? ($case->case_description ?? null));

    $category = $case->category
        ?? ($case->case_type ?? ($case->type ?? null));

    $court = $case->court
        ?? ($case->court_name ?? null);

    $openedAt = $case->opened_at
        ?? ($case->start_date ?? $case->created_at);

    $closedAt = $case->closed_at
        ?? ($case->end_date ?? null);

    /*
    |--------------------------------------------------------------------------
    | Status styling
    |--------------------------------------------------------------------------
    */
    if (in_array($caseStatus, ['active', 'open', 'ongoing', 'in_progress'])) {
        $statusLabel = 'Active';
        $statusClass = 'bg-emerald-50 text-emerald-700 border-emerald-100';
        $statusDot = 'bg-emerald-500';
    } elseif ($caseStatus === 'pending') {
        $statusLabel = 'Pending';
        $statusClass = 'bg-amber-50 text-amber-700 border-amber-100';
        $statusDot = 'bg-amber-500';
    } elseif (in_array($caseStatus, ['closed', 'completed', 'resolved'])) {
        $statusLabel = 'Closed';
        $statusClass = 'bg-gray-100 text-gray-600 border-gray-200';
        $statusDot = 'bg-gray-400';
    } else {
        $statusLabel = ucfirst(str_replace('_', ' ', $caseStatus));
        $statusClass = 'bg-blue-50 text-blue-700 border-blue-100';
        $statusDot = 'bg-blue-500';
    }
@endphp

<div
    x-data="{ showDescription: false }"
    class="min-h-screen bg-[#F7F4ED]"
>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- ==========================================================
             BACK NAVIGATION
        =========================================================== --}}
        <div class="mb-7">
            <a
                href="{{ route('admin.cases.index') }}"
                class="group inline-flex items-center gap-2 text-sm font-medium text-[#77756F] transition hover:text-[#11110F]"
            >
                <svg
                    class="h-4 w-4 transition-transform group-hover:-translate-x-0.5"
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

                Back to Cases
            </a>
        </div>


        {{-- ==========================================================
             PAGE HEADER
        =========================================================== --}}
        <div class="mb-8">

            <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

                <div>

                    <div class="mb-3 flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.18em] text-[#9B9992]">
                        <span>Administration</span>

                        <svg
                            class="h-3.5 w-3.5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M9 5l7 7-7 7"
                            />
                        </svg>

                        <span>Cases</span>
                    </div>

                    <h1 class="text-3xl font-semibold tracking-tight text-[#11110F]">
                        Case Details
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-[#77756F]">
                        Review case information, assigned parties, status, and case activity.
                    </p>

                </div>


                {{-- Case number --}}
                <div class="flex items-center gap-3 rounded-xl border border-[#E5E2DB] bg-white px-4 py-3 shadow-sm">

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#11110F] text-[#D8BE8A]">
                        <svg
                            class="h-4.5 w-4.5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z"
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
                        <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#9B9992]">
                            Case Number
                        </p>

                        <p class="mt-0.5 text-sm font-semibold text-[#11110F]">
                            #{{ $caseNumber }}
                        </p>
                    </div>

                </div>

            </div>

        </div>


        {{-- ==========================================================
             CASE HERO
        =========================================================== --}}
        <div class="mb-6 overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

            <div class="bg-[#11110F] px-6 py-7 sm:px-8">

                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                    <div class="flex items-start gap-4">

                        {{-- Document icon --}}
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl border border-[#C9A96E]/20 bg-[#C9A96E]/10 text-[#D8BE8A]">

                            <svg
                                class="h-7 w-7"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M14 3v5h5"
                                />
                            </svg>

                        </div>


                        <div class="min-w-0">

                            <div class="flex flex-wrap items-center gap-3">

                                <h2 class="text-xl font-semibold text-white sm:text-2xl">
                                    {{ $caseTitle }}
                                </h2>

                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClass }}"
                                >
                                    <span class="h-1.5 w-1.5 rounded-full {{ $statusDot }}"></span>
                                    {{ $statusLabel }}
                                </span>

                            </div>

                            <p class="mt-2 text-sm text-gray-400">
                                Case #{{ $caseNumber }}
                            </p>

                        </div>

                    </div>


                    {{-- Administrator badge --}}
                    <div class="inline-flex w-fit items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-xs font-medium text-gray-300">

                        <svg
                            class="h-4 w-4 text-[#C9A96E]"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"
                            />
                        </svg>

                        Administrator View

                    </div>

                </div>

            </div>

        </div>


        {{-- ==========================================================
             MAIN GRID
        =========================================================== --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">


            {{-- ======================================================
                 LEFT COLUMN
            ======================================================= --}}
            <div class="space-y-6 lg:col-span-2">


                {{-- ==================================================
                     CASE INFORMATION
                =================================================== --}}
                <div class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

                    <div class="border-b border-[#E5E2DB] px-6 py-5">

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#F7F4ED] text-[#11110F]">

                                <svg
                                    class="h-4.5 w-4.5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z"
                                    />
                                </svg>

                            </div>

                            <div>
                                <h2 class="text-sm font-semibold text-[#11110F]">
                                    Case Information
                                </h2>

                                <p class="mt-0.5 text-xs text-[#9B9992]">
                                    General information about this case.
                                </p>
                            </div>

                        </div>

                    </div>


                    <div class="p-6">

                        <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">


                            {{-- Case Number --}}
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#9B9992]">
                                    Case Number
                                </p>

                                <p class="mt-1.5 text-sm font-semibold text-[#11110F]">
                                    #{{ $caseNumber }}
                                </p>
                            </div>


                            {{-- Case Type --}}
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#9B9992]">
                                    Case Type
                                </p>

                                <p class="mt-1.5 text-sm font-semibold text-[#11110F]">
                                    {{ $category ? ucfirst(str_replace('_', ' ', $category)) : 'Not specified' }}
                                </p>
                            </div>


                            {{-- Court --}}
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#9B9992]">
                                    Court
                                </p>

                                <p class="mt-1.5 text-sm font-semibold text-[#11110F]">
                                    {{ $court ?? 'Not specified' }}
                                </p>
                            </div>


                            {{-- Created --}}
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#9B9992]">
                                    Created
                                </p>

                                <p class="mt-1.5 text-sm font-semibold text-[#11110F]">
                                    {{ $case->created_at?->format('F d, Y') ?? '—' }}
                                </p>
                            </div>


                            {{-- Opened --}}
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#9B9992]">
                                    Opened
                                </p>

                                <p class="mt-1.5 text-sm font-semibold text-[#11110F]">
                                    {{ $openedAt?->format('F d, Y') ?? '—' }}
                                </p>
                            </div>


                            {{-- Closed --}}
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#9B9992]">
                                    Closed
                                </p>

                                <p class="mt-1.5 text-sm font-semibold text-[#11110F]">
                                    {{ $closedAt?->format('F d, Y') ?? 'Not closed' }}
                                </p>
                            </div>

                        </div>

                    </div>

                </div>


                {{-- ==================================================
                     DESCRIPTION
                =================================================== --}}
                <div class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

                    <div class="border-b border-[#E5E2DB] px-6 py-5">

                        <div class="flex items-center justify-between gap-4">

                            <div class="flex items-center gap-3">

                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#F7F4ED] text-[#11110F]">

                                    <svg
                                        class="h-4.5 w-4.5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"
                                        />
                                    </svg>

                                </div>

                                <div>
                                    <h2 class="text-sm font-semibold text-[#11110F]">
                                        Case Description
                                    </h2>

                                    <p class="mt-0.5 text-xs text-[#9B9992]">
                                        Details provided for this case.
                                    </p>
                                </div>

                            </div>


                            @if ($description)

                                <button
                                    type="button"
                                    @click="showDescription = !showDescription"
                                    class="inline-flex items-center gap-2 rounded-lg border border-[#E5E2DB] bg-white px-3 py-2 text-xs font-semibold text-[#55534E] transition hover:border-[#C9A96E] hover:text-[#11110F]"
                                >

                                    <span x-text="showDescription ? 'Collapse' : 'Expand'"></span>

                                    <svg
                                        class="h-3.5 w-3.5 transition-transform"
                                        :class="showDescription ? 'rotate-180' : ''"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M19 9l-7 7-7-7"
                                        />
                                    </svg>

                                </button>

                            @endif

                        </div>

                    </div>


                    <div class="p-6">

                        @if ($description)

                            <div
                                x-show="showDescription"
                                x-collapse
                                class="text-sm leading-7 text-[#55534E]"
                            >
                                {!! nl2br(e($description)) !!}
                            </div>

                            <div
                                x-show="!showDescription"
                                class="line-clamp-3 text-sm leading-7 text-[#55534E]"
                            >
                                {!! nl2br(e($description)) !!}
                            </div>

                        @else

                            <div class="rounded-xl border border-dashed border-[#E5E2DB] bg-[#F7F4ED] px-5 py-8 text-center">

                                <svg
                                    class="mx-auto h-8 w-8 text-[#B5B1A8]"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.7"
                                        d="M8 6h13M8 12h13M8 18h13"
                                    />
                                </svg>

                                <p class="mt-3 text-sm text-[#77756F]">
                                    No description has been added to this case.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- ==================================================
                     CLIENT
                =================================================== --}}
                <div class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

                    <div class="border-b border-[#E5E2DB] px-6 py-5">

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#F7F4ED] text-[#11110F]">

                                <svg
                                    class="h-4.5 w-4.5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"
                                    />
                                </svg>

                            </div>

                            <div>
                                <h2 class="text-sm font-semibold text-[#11110F]">
                                    Client
                                </h2>

                                <p class="mt-0.5 text-xs text-[#9B9992]">
                                    Client assigned to this case.
                                </p>
                            </div>

                        </div>

                    </div>


                    <div class="p-6">

                        @if ($client)

                            <div class="flex items-center justify-between gap-4">

                                <div class="flex items-center gap-4">

                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#11110F] text-sm font-semibold text-[#D8BE8A]">
                                        {{ strtoupper(substr($client->name ?? 'C', 0, 1)) }}
                                    </div>

                                    <div>

                                        <p class="text-sm font-semibold text-[#11110F]">
                                            {{ $client->name }}
                                        </p>

                                        <p class="mt-1 text-sm text-[#77756F]">
                                            {{ $client->email ?? 'No email available' }}
                                        </p>

                                        @if ($client->phone ?? null)

                                            <p class="mt-1 text-xs text-[#9B9992]">
                                                {{ $client->phone }}
                                            </p>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        @else

                            <div class="rounded-xl border border-dashed border-[#E5E2DB] bg-[#F7F4ED] px-5 py-7 text-center">

                                <p class="text-sm text-[#77756F]">
                                    No client is assigned to this case.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- ==================================================
                     LAWYER
                =================================================== --}}
                <div class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

                    <div class="border-b border-[#E5E2DB] px-6 py-5">

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#F7F4ED] text-[#11110F]">

                                <svg
                                    class="h-4.5 w-4.5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M3 21h18M6 21V9l6-4 6 4v12M9 21v-6h6v6M9 9h.01M12 9h.01M15 9h.01"
                                    />
                                </svg>

                            </div>

                            <div>
                                <h2 class="text-sm font-semibold text-[#11110F]">
                                    Assigned Lawyer
                                </h2>

                                <p class="mt-0.5 text-xs text-[#9B9992]">
                                    Lawyer responsible for this case.
                                </p>
                            </div>

                        </div>

                    </div>


                    <div class="p-6">

                        @if ($lawyer)

                            <div class="flex items-center gap-4">

                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-[#C9A96E]/30 bg-[#11110F] text-sm font-semibold text-[#D8BE8A]">
                                    {{ strtoupper(substr($lawyer->name ?? 'L', 0, 1)) }}
                                </div>

                                <div>

                                    <p class="text-sm font-semibold text-[#11110F]">
                                        {{ $lawyer->name }}
                                    </p>

                                    <p class="mt-1 text-sm text-[#77756F]">
                                        {{ $lawyer->email ?? 'No email available' }}
                                    </p>

                                    @if ($lawyer->specialization ?? null)

                                        <p class="mt-1 text-xs text-[#9B9992]">
                                            {{ $lawyer->specialization }}
                                        </p>

                                    @endif

                                </div>

                            </div>

                        @else

                            <div class="rounded-xl border border-dashed border-amber-200 bg-amber-50 px-5 py-7 text-center">

                                <svg
                                    class="mx-auto h-7 w-7 text-amber-500"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M12 9v4m0 4h.01M10.3 3.5h3.4L21 16.2a2 2 0 01-1.7 3H4.7a2 2 0 01-1.7-3L10.3 3.5z"
                                    />
                                </svg>

                                <p class="mt-2 text-sm font-medium text-amber-700">
                                    No lawyer has been assigned yet.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            </div>


            {{-- ======================================================
                 RIGHT COLUMN
            ======================================================= --}}
            <div class="space-y-6">


                {{-- ==================================================
                     STATUS
                =================================================== --}}
                <div class="rounded-2xl border border-[#E5E2DB] bg-white p-6 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#9B9992]">
                                Current Status
                            </p>

                            <h2 class="mt-1 text-base font-semibold text-[#11110F]">
                                Case Status
                            </h2>

                        </div>

                        <span class="h-2.5 w-2.5 rounded-full {{ $statusDot }}"></span>

                    </div>


                    <div class="mt-5 rounded-xl border {{ $statusClass }} p-4">

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-white/70">

                                @if ($statusLabel === 'Active')

                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 12l4 4L19 6"
                                        />
                                    </svg>

                                @elseif ($statusLabel === 'Pending')

                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="8"
                                            stroke-width="2"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-width="2"
                                            d="M12 8v4l2 2"
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
                                            stroke-width="2"
                                            d="M5 12l4 4L19 6"
                                        />
                                    </svg>

                                @endif

                            </div>


                            <div>

                                <p class="text-sm font-semibold">
                                    {{ $statusLabel }} Case
                                </p>

                                <p class="mt-0.5 text-xs opacity-80">

                                    @if ($statusLabel === 'Active')
                                        This case is currently active.
                                    @elseif ($statusLabel === 'Pending')
                                        This case is awaiting action.
                                    @elseif ($statusLabel === 'Closed')
                                        This case has been closed.
                                    @else
                                        Current case status.
                                    @endif

                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ==================================================
                     TIMELINE
                =================================================== --}}
                <div class="rounded-2xl border border-[#E5E2DB] bg-white p-6 shadow-sm">

                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#F7F4ED] text-[#11110F]">

                            <svg
                                class="h-4.5 w-4.5"
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
                                    stroke-width="1.8"
                                    d="M12 7v5l3 2"
                                />
                            </svg>

                        </div>

                        <div>

                            <h2 class="text-sm font-semibold text-[#11110F]">
                                Case Timeline
                            </h2>

                            <p class="mt-0.5 text-xs text-[#9B9992]">
                                Case activity history.
                            </p>

                        </div>

                    </div>


                    <div class="mt-7 space-y-6">


                        {{-- Created --}}
                        <div class="flex gap-3">

                            <div class="flex flex-col items-center">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#11110F] text-[#D8BE8A]">

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
                                            d="M5 12h14"
                                        />
                                    </svg>

                                </div>

                                <div class="mt-1 h-full w-px bg-[#E5E2DB]"></div>

                            </div>


                            <div class="pb-4">

                                <p class="text-sm font-semibold text-[#11110F]">
                                    Case Created
                                </p>

                                <p class="mt-1 text-xs text-[#77756F]">
                                    {{ $case->created_at?->format('M d, Y · h:i A') ?? '—' }}
                                </p>

                            </div>

                        </div>


                        {{-- Updated --}}
                        @if ($case->updated_at)

                            <div class="flex gap-3">

                                <div class="flex flex-col items-center">

                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#F7F4ED] text-[#77756F]">

                                        <svg
                                            class="h-4 w-4"
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
                                                stroke-width="1.8"
                                                d="M12 7v5l4 2"
                                            />
                                        </svg>

                                    </div>

                                </div>


                                <div>

                                    <p class="text-sm font-semibold text-[#11110F]">
                                        Last Updated
                                    </p>

                                    <p class="mt-1 text-xs text-[#77756F]">
                                        {{ $case->updated_at->format('M d, Y · h:i A') }}
                                    </p>

                                </div>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- ==================================================
                     ADMINISTRATOR NOTICE
                =================================================== --}}
                <div class="overflow-hidden rounded-2xl border border-[#2A2926] bg-[#11110F] shadow-sm">

                    <div class="p-6">

                        <div class="flex gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#C9A96E]/10 text-[#D8BE8A]">

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
                                        d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"
                                    />
                                </svg>

                            </div>


                            <div>

                                <h3 class="text-sm font-semibold text-white">
                                    Administrator Access
                                </h3>

                                <p class="mt-2 text-xs leading-5 text-gray-400">
                                    You are viewing this case as an administrator.
                                    Case information is available for firm-wide
                                    management and oversight.
                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="h-px bg-gradient-to-r from-transparent via-[#C9A96E]/40 to-transparent"></div>

                </div>

            </div>

        </div>


        {{-- ==========================================================
             BOTTOM NAVIGATION
        =========================================================== --}}
        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <a
                href="{{ route('admin.cases.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#E5E2DB] bg-white px-5 py-2.5 text-sm font-medium text-[#55534E] shadow-sm transition hover:border-[#C9A96E] hover:text-[#11110F]"
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

                Back to Cases

            </a>

        </div>

    </div>

</div>

@endsection