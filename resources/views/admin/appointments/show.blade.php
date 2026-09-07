@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')

@php
    $status = strtolower($appointment->status ?? 'pending');

    $appointmentTitle = $appointment->title
        ?? ($appointment->subject ?? 'Legal Consultation');

    $appointmentDate =
        $appointment->appointment_date
        ?? ($appointment->scheduled_at
            ?? ($appointment->date
                ?? ($appointment->start_time ?? null)));

    $client = $appointment->client
        ?? ($appointment->user ?? null);

    $lawyer = $appointment->lawyer ?? null;

    $relatedCase = $appointment->case ?? null;

    /*
    |--------------------------------------------------------------------------
    | Status styling
    |--------------------------------------------------------------------------
    */
    if (in_array($status, ['confirmed', 'approved'])) {
        $statusLabel = 'Confirmed';
        $statusClass = 'border-emerald-200 bg-emerald-50 text-emerald-700';
        $statusDot = 'bg-emerald-500';
    } elseif ($status === 'completed') {
        $statusLabel = 'Completed';
        $statusClass = 'border-blue-200 bg-blue-50 text-blue-700';
        $statusDot = 'bg-blue-500';
    } elseif (in_array($status, ['cancelled', 'canceled', 'rejected'])) {
        $statusLabel = ucfirst($status);
        $statusClass = 'border-red-200 bg-red-50 text-red-700';
        $statusDot = 'bg-red-500';
    } else {
        $statusLabel = ucfirst($status);
        $statusClass = 'border-amber-200 bg-amber-50 text-amber-700';
        $statusDot = 'bg-amber-500';
    }
@endphp


<div
    x-data="{ showCancelModal: false }"
    @keydown.escape.window="showCancelModal = false"
    class="min-h-screen bg-[#F7F4ED]"
>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">


        {{-- ==========================================================
             BACK / BREADCRUMB
        =========================================================== --}}
        <div class="mb-7">

            <a
                href="{{ route('admin.appointments.index') }}"
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

                Back to Appointments

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

                        <span>Appointments</span>

                    </div>


                    <h1 class="text-3xl font-semibold tracking-tight text-[#11110F]">
                        Appointment Details
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-[#77756F]">
                        Review appointment information, attendees, schedule, and related case details.
                    </p>

                </div>


                {{-- Appointment number --}}
                <div class="flex items-center gap-3 rounded-xl border border-[#E5E2DB] bg-white px-4 py-3 shadow-sm">

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#11110F] text-[#D8BE8A]">

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <rect
                                x="3"
                                y="4"
                                width="18"
                                height="17"
                                rx="2"
                                stroke-width="1.8"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-width="1.8"
                                d="M8 2v4M16 2v4M3 9h18"
                            />
                        </svg>

                    </div>

                    <div>

                        <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#9B9992]">
                            Appointment
                        </p>

                        <p class="mt-0.5 text-sm font-semibold text-[#11110F]">
                            #{{ $appointment->id }}
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- ==========================================================
             APPOINTMENT HERO
        =========================================================== --}}
        <div class="mb-6 overflow-hidden rounded-2xl border border-[#2A2926] bg-[#11110F] shadow-sm">

            <div class="px-6 py-7 sm:px-8">

                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                    <div class="flex items-start gap-4">

                        {{-- Calendar icon --}}
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl border border-[#C9A96E]/20 bg-[#C9A96E]/10 text-[#D8BE8A]">

                            <svg
                                class="h-7 w-7"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <rect
                                    x="3"
                                    y="4"
                                    width="18"
                                    height="17"
                                    rx="2"
                                    stroke-width="1.7"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-width="1.7"
                                    d="M8 2v4M16 2v4M3 9h18"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-width="1.7"
                                    d="M8 13h.01M12 13h.01M16 13h.01M8 17h.01M12 17h.01"
                                />
                            </svg>

                        </div>


                        <div class="min-w-0">

                            <div class="flex flex-wrap items-center gap-3">

                                <h2 class="text-xl font-semibold text-white sm:text-2xl">
                                    {{ $appointmentTitle }}
                                </h2>

                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClass }}"
                                >

                                    <span class="h-1.5 w-1.5 rounded-full {{ $statusDot }}"></span>

                                    {{ $statusLabel }}

                                </span>

                            </div>


                            <p class="mt-2 text-sm text-gray-400">
                                Appointment #{{ $appointment->id }}
                            </p>

                        </div>

                    </div>


                    {{-- Admin badge --}}
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

            <div class="h-px bg-gradient-to-r from-transparent via-[#C9A96E]/40 to-transparent"></div>

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
                     APPOINTMENT INFORMATION
                =================================================== --}}
                <div class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

                    <div class="border-b border-[#E5E2DB] px-6 py-5">

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#F7F4ED] text-[#11110F]">

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
                                        d="M12 7v5l3 2"
                                    />
                                </svg>

                            </div>

                            <div>

                                <h2 class="text-sm font-semibold text-[#11110F]">
                                    Appointment Information
                                </h2>

                                <p class="mt-0.5 text-xs text-[#9B9992]">
                                    Schedule and appointment details.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="p-6">

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">


                            {{-- Date --}}
                            <div class="rounded-xl border border-[#E5E2DB] bg-[#F7F4ED] p-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#11110F] shadow-sm">

                                        <svg
                                            class="h-5 w-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <rect
                                                x="3"
                                                y="4"
                                                width="18"
                                                height="17"
                                                rx="2"
                                                stroke-width="1.8"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-width="1.8"
                                                d="M8 2v4M16 2v4M3 9h18"
                                            />
                                        </svg>

                                    </div>

                                    <div>

                                        <p class="text-[10px] font-semibold uppercase tracking-[0.12em] text-[#9B9992]">
                                            Date
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-[#11110F]">

                                            @if ($appointmentDate)

                                                {{ \Carbon\Carbon::parse($appointmentDate)->format('M d, Y') }}

                                            @else

                                                —

                                            @endif

                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- Time --}}
                            <div class="rounded-xl border border-[#E5E2DB] bg-[#F7F4ED] p-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#11110F] shadow-sm">

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
                                                stroke-width="1.8"
                                                d="M12 7v5l3 2"
                                            />
                                        </svg>

                                    </div>

                                    <div>

                                        <p class="text-[10px] font-semibold uppercase tracking-[0.12em] text-[#9B9992]">
                                            Time
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-[#11110F]">

                                            @if ($appointmentDate)

                                                {{ \Carbon\Carbon::parse($appointmentDate)->format('h:i A') }}

                                            @else

                                                —

                                            @endif

                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- Duration --}}
                            <div class="rounded-xl border border-[#E5E2DB] bg-[#F7F4ED] p-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#11110F] shadow-sm">

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
                                                stroke-width="1.8"
                                                d="M12 7v5l3 2"
                                            />
                                        </svg>

                                    </div>

                                    <div>

                                        <p class="text-[10px] font-semibold uppercase tracking-[0.12em] text-[#9B9992]">
                                            Duration
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-[#11110F]">
                                            {{ $appointment->duration ?? 'Not specified' }}
                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- Location --}}
                            <div class="rounded-xl border border-[#E5E2DB] bg-[#F7F4ED] p-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#11110F] shadow-sm">

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
                                                d="M12 21s7-5.2 7-11a7 7 0 10-14 0c0 5.8 7 11 7 11z"
                                            />

                                            <circle
                                                cx="12"
                                                cy="10"
                                                r="2.5"
                                                stroke-width="1.8"
                                            />
                                        </svg>

                                    </div>

                                    <div>

                                        <p class="text-[10px] font-semibold uppercase tracking-[0.12em] text-[#9B9992]">
                                            Location
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-[#11110F]">
                                            {{ $appointment->location ?? ($appointment->meeting_type ?? 'Not specified') }}
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ==================================================
                     CLIENT & LAWYER
                =================================================== --}}
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">


                    {{-- Client --}}
                    <div class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

                        <div class="border-b border-[#E5E2DB] px-6 py-5">

                            <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#9B9992]">
                                Appointment Party
                            </p>

                            <h2 class="mt-1 text-sm font-semibold text-[#11110F]">
                                Client
                            </h2>

                        </div>


                        <div class="p-6">

                            @if ($client)

                                <div class="flex items-center gap-4">

                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#11110F] text-sm font-semibold text-[#D8BE8A]">

                                        {{ strtoupper(substr($client->name ?? 'C', 0, 1)) }}

                                    </div>


                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-semibold text-[#11110F]">
                                            {{ $client->name ?? 'Unknown Client' }}
                                        </p>

                                        @if ($client->email ?? null)

                                            <p class="mt-1 truncate text-xs text-[#77756F]">
                                                {{ $client->email }}
                                            </p>

                                        @endif

                                        @if ($client->phone ?? null)

                                            <p class="mt-1 text-xs text-[#9B9992]">
                                                {{ $client->phone }}
                                            </p>

                                        @endif

                                    </div>

                                </div>

                            @else

                                <div class="rounded-xl border border-dashed border-[#E5E2DB] bg-[#F7F4ED] px-4 py-6 text-center">

                                    <p class="text-sm text-[#77756F]">
                                        No client assigned.
                                    </p>

                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- Lawyer --}}
                    <div class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

                        <div class="border-b border-[#E5E2DB] px-6 py-5">

                            <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#9B9992]">
                                Appointment Party
                            </p>

                            <h2 class="mt-1 text-sm font-semibold text-[#11110F]">
                                Assigned Lawyer
                            </h2>

                        </div>


                        <div class="p-6">

                            @if ($lawyer)

                                <div class="flex items-center gap-4">

                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-[#C9A96E]/30 bg-[#11110F] text-sm font-semibold text-[#D8BE8A]">

                                        {{ strtoupper(substr($lawyer->name ?? 'L', 0, 1)) }}

                                    </div>


                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-semibold text-[#11110F]">
                                            {{ $lawyer->name ?? 'Unknown Lawyer' }}
                                        </p>

                                        @if ($lawyer->email ?? null)

                                            <p class="mt-1 truncate text-xs text-[#77756F]">
                                                {{ $lawyer->email }}
                                            </p>

                                        @endif

                                        @if ($lawyer->specialization ?? null)

                                            <p class="mt-1 text-xs text-[#9B9992]">
                                                {{ $lawyer->specialization }}
                                            </p>

                                        @endif

                                    </div>

                                </div>

                            @else

                                <div class="rounded-xl border border-dashed border-amber-200 bg-amber-50 px-4 py-6 text-center">

                                    <p class="text-sm font-medium text-amber-700">
                                        No lawyer assigned.
                                    </p>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- ==================================================
                     NOTES
                =================================================== --}}
                <div class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

                    <div class="border-b border-[#E5E2DB] px-6 py-5">

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#F7F4ED] text-[#11110F]">

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
                                        d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"
                                    />
                                </svg>

                            </div>

                            <div>

                                <h2 class="text-sm font-semibold text-[#11110F]">
                                    Appointment Notes
                                </h2>

                                <p class="mt-0.5 text-xs text-[#9B9992]">
                                    Additional information provided for this appointment.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="p-6">

                        @if ($appointment->notes ?? ($appointment->description ?? null))

                            <div class="rounded-xl border border-[#E5E2DB] bg-[#F7F4ED] p-5">

                                <p class="whitespace-pre-line text-sm leading-7 text-[#55534E]">
                                    {{ $appointment->notes ?? $appointment->description }}
                                </p>

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
                                    No notes have been added to this appointment.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            </div>


            {{-- ======================================================
                 RIGHT SIDEBAR
            ======================================================= --}}
            <div class="space-y-6">


                {{-- ==================================================
                     CURRENT STATUS
                =================================================== --}}
                <div class="rounded-2xl border border-[#E5E2DB] bg-white p-6 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-[10px] font-semibold uppercase tracking-[0.15em] text-[#9B9992]">
                                Current Status
                            </p>

                            <h2 class="mt-1 text-base font-semibold text-[#11110F]">
                                Appointment Status
                            </h2>

                        </div>

                        <span class="h-2.5 w-2.5 rounded-full {{ $statusDot }}"></span>

                    </div>


                    <div class="mt-5 rounded-xl border {{ $statusClass }} p-4">

                        <div class="flex items-center gap-3">

                            <span class="h-2 w-2 rounded-full {{ $statusDot }}"></span>

                            <span class="text-sm font-semibold">
                                {{ $statusLabel }}
                            </span>

                        </div>

                    </div>


                    @if ($appointment->created_at)

                        <div class="mt-5 border-t border-[#E5E2DB] pt-5">

                            <p class="text-[10px] font-semibold uppercase tracking-[0.12em] text-[#9B9992]">
                                Created
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#55534E]">
                                {{ $appointment->created_at->format('M d, Y · h:i A') }}
                            </p>

                        </div>

                    @endif

                </div>


                {{-- ==================================================
                     RELATED CASE
                =================================================== --}}
                <div class="rounded-2xl border border-[#E5E2DB] bg-white p-6 shadow-sm">

                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#F7F4ED] text-[#11110F]">

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
                                    d="M7 3h10v18H7z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-width="1.8"
                                    d="M9.5 7h5M9.5 11h5M9.5 15h3"
                                />
                            </svg>

                        </div>

                        <div>

                            <h2 class="text-sm font-semibold text-[#11110F]">
                                Related Case
                            </h2>

                            <p class="mt-0.5 text-xs text-[#9B9992]">
                                Case connected to this appointment.
                            </p>

                        </div>

                    </div>


                    <div class="mt-5">

                        @if ($relatedCase)

                            <div class="rounded-xl border border-[#E5E2DB] bg-[#F7F4ED] p-4">

                                <p class="text-[10px] font-semibold uppercase tracking-[0.12em] text-[#9B9992]">
                                    Case
                                </p>

                                <p class="mt-1 text-sm font-semibold text-[#11110F]">
                                    #{{ $relatedCase->id }}
                                </p>

                                <p class="mt-1 text-sm text-[#77756F]">
                                    {{ $relatedCase->title
                                        ?? ($relatedCase->case_type ?? 'Legal Case') }}
                                </p>

                            </div>

                        @elseif ($appointment->case_id)

                            <div class="rounded-xl border border-[#E5E2DB] bg-[#F7F4ED] p-4">

                                <p class="text-[10px] font-semibold uppercase tracking-[0.12em] text-[#9B9992]">
                                    Case
                                </p>

                                <p class="mt-1 text-sm font-semibold text-[#11110F]">
                                    #{{ $appointment->case_id }}
                                </p>

                            </div>

                        @else

                            <div class="rounded-xl border border-dashed border-[#E5E2DB] bg-[#F7F4ED] px-4 py-7 text-center">

                                <p class="text-sm text-[#77756F]">
                                    No case linked to this appointment.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- ==================================================
                     ADMINISTRATOR NOTICE
                =================================================== --}}
                <div class="overflow-hidden rounded-2xl border border-[#2A2926] bg-[#11110F] shadow-sm">

                    <div class="p-6">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#C9A96E]/10 text-[#D8BE8A]">

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


                        <h3 class="mt-4 text-sm font-semibold text-white">
                            Administrator View
                        </h3>

                        <p class="mt-2 text-xs leading-6 text-gray-400">
                            You are viewing this appointment as an administrator.
                            Appointment information is available for firm-wide
                            management and oversight.
                        </p>

                    </div>


                    <div class="h-px bg-gradient-to-r from-transparent via-[#C9A96E]/40 to-transparent"></div>

                </div>


                {{-- ==================================================
                     BACK BUTTON
                =================================================== --}}
                <a
                    href="{{ route('admin.appointments.index') }}"
                    class="group flex w-full items-center justify-center gap-2 rounded-xl border border-[#E5E2DB] bg-white px-4 py-3 text-sm font-medium text-[#55534E] shadow-sm transition hover:border-[#C9A96E] hover:text-[#11110F]"
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
                            d="M15 18l-6-6 6-6"
                        />
                    </svg>

                    Back to Appointments

                </a>

            </div>

        </div>


        {{-- ==========================================================
             BOTTOM NAVIGATION
        =========================================================== --}}
        <div class="mt-6">

            <a
                href="{{ route('admin.appointments.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-[#E5E2DB] bg-white px-5 py-2.5 text-sm font-medium text-[#55534E] shadow-sm transition hover:border-[#C9A96E] hover:text-[#11110F]"
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

                Back to Appointments

            </a>

        </div>

    </div>

</div>

@endsection