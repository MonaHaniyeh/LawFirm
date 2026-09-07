@extends('layouts.app')

@section('title', 'Appointments')

@section('breadcrumb')
    Appointments
@endsection

@section('content')

<div class="space-y-8">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div>
        <div class="mb-2 flex items-center gap-2">
            <span class="h-px w-7 bg-[#b69a68]"></span>

            <span class="text-[10px] font-semibold uppercase tracking-[0.22em] text-[#b69a68]">
                Client Portal
            </span>
        </div>

        <h1 class="font-serif text-4xl font-semibold tracking-tight text-[#151515]">
            Appointments
        </h1>

        <p class="mt-2 max-w-2xl text-sm leading-6 text-[#7d7b76]">
            Schedule a meeting with your lawyer and keep track of your appointments.
        </p>
    </div>


    {{-- =========================================================
        SUCCESS MESSAGE
    ========================================================== --}}
    @if (session('success'))
        <div
            class="flex items-center gap-3 rounded-xl border border-[#d9e9dc] bg-[#f3f8f4] px-5 py-4 text-sm text-[#3f7458]"
        >
            <div
                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7"
                    />
                </svg>
            </div>

            <span>
                {{ session('success') }}
            </span>
        </div>
    @endif


    {{-- =========================================================
        ERROR MESSAGE
    ========================================================== --}}
    @if (session('error'))
        <div
            class="flex items-center gap-3 rounded-xl border border-[#efd7d5] bg-[#fcf3f2] px-5 py-4 text-sm text-[#9b4c48]"
        >
            <div
                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 8v4m0 4h.01"
                    />

                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                    />
                </svg>
            </div>

            <span>
                {{ session('error') }}
            </span>
        </div>
    @endif


    {{-- =========================================================
        VALIDATION ERRORS
    ========================================================== --}}
    @if ($errors->any())
        <div
            class="rounded-xl border border-[#efd7d5] bg-[#fcf3f2] px-5 py-4"
        >
            <p class="mb-2 text-sm font-semibold text-[#9b4c48]">
                Please correct the following:
            </p>

            <ul class="space-y-1 text-sm text-[#9b4c48]">
                @foreach ($errors->all() as $error)
                    <li>
                        • {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- =========================================================
        MAIN GRID
    ========================================================== --}}
    <div class="grid grid-cols-1 gap-7 xl:grid-cols-[0.9fr_1.1fr]">


        {{-- =====================================================
            REQUEST APPOINTMENT
        ====================================================== --}}
        <div
            class="overflow-hidden rounded-2xl border border-[#e7e3db] bg-white shadow-[0_8px_30px_rgba(21,21,21,0.04)]"
        >

            {{-- Header --}}
            <div class="border-b border-[#e7e3db] px-7 py-6">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <div class="mb-2 flex items-center gap-2">
                            <span class="h-px w-5 bg-[#b69a68]"></span>

                            <span
                                class="text-[9px] font-semibold uppercase tracking-[0.2em] text-[#b69a68]"
                            >
                                Schedule
                            </span>
                        </div>

                        <h2 class="font-serif text-2xl font-semibold text-[#151515]">
                            Arrange a Meeting
                        </h2>

                        <p class="mt-1.5 text-xs leading-5 text-[#7d7b76]">
                            Send a meeting request to your lawyer.
                        </p>

                    </div>


                    {{-- Calendar Icon --}}
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#f7f4ed]"
                    >
                        <svg
                            class="h-5 w-5 text-[#927849]"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            viewBox="0 0 24 24"
                        >
                            <rect
                                x="3"
                                y="4"
                                width="18"
                                height="18"
                                rx="2"
                            />

                            <path
                                stroke-linecap="round"
                                d="M16 2v4M8 2v4M3 10h18"
                            />
                        </svg>
                    </div>

                </div>
            </div>


            {{-- =================================================
                FORM
            ================================================== --}}
            <form
                method="POST"
                action="{{ route('client.appointments.store') }}"
                class="space-y-5 px-7 py-7"
            >

                @csrf


                {{-- =================================================
                    RELATED CASE
                ================================================== --}}
                <div>

                    <label
                        for="case_id"
                        class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.12em] text-[#5f5d58]"
                    >
                        Related Case
                    </label>


                    <div class="relative">

                        <select
                            id="case_id"
                            name="case_id"
                            required
                            class="w-full appearance-none rounded-xl border border-[#e7e3db] bg-[#faf9f6] px-4 py-3.5 pr-10 text-sm text-[#151515] outline-none transition focus:border-[#b69a68] focus:bg-white focus:ring-2 focus:ring-[#b69a68]/10"
                        >

                            <option value="">
                                Select the case you need to discuss
                            </option>


                            {{-- CASE NUMBER --}}
                            @foreach ($cases as $case)

                                <option
                                    value="{{ $case->id }}"
                                    {{ old('case_id') == $case->id ? 'selected' : '' }}
                                >
                                    {{ $case->case_number }}
                                </option>

                            @endforeach

                        </select>


                        {{-- Dropdown Arrow --}}
                        <svg
                            class="pointer-events-none absolute right-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#7d7b76]"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 9l6 6 6-6"
                            />
                        </svg>

                    </div>


                    <p class="mt-2 text-[11px] text-[#99958e]">
                        Choose the case you would like to discuss with your lawyer.
                    </p>

                </div>


                {{-- =================================================
                    DATE / TIME
                ================================================== --}}
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">


                    {{-- Date --}}
                    <div>

                        <label
                            for="date"
                            class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.12em] text-[#5f5d58]"
                        >
                            Preferred Date
                        </label>

                        <input
                            id="date"
                            type="date"
                            name="date"
                            value="{{ old('date') }}"
                            required
                            class="w-full rounded-xl border border-[#e7e3db] bg-[#faf9f6] px-4 py-3.5 text-sm text-[#151515] outline-none transition focus:border-[#b69a68] focus:bg-white focus:ring-2 focus:ring-[#b69a68]/10"
                        >

                    </div>


                    {{-- Time --}}
                    <div>

                        <label
                            for="time"
                            class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.12em] text-[#5f5d58]"
                        >
                            Preferred Time
                        </label>

                        <input
                            id="time"
                            type="time"
                            name="time"
                            value="{{ old('time') }}"
                            required
                            class="w-full rounded-xl border border-[#e7e3db] bg-[#faf9f6] px-4 py-3.5 text-sm text-[#151515] outline-none transition focus:border-[#b69a68] focus:bg-white focus:ring-2 focus:ring-[#b69a68]/10"
                        >

                    </div>

                </div>


                {{-- =================================================
                    LOCATION
                ================================================== --}}
                <div>

                    <label
                        for="location"
                        class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.12em] text-[#5f5d58]"
                    >
                        Meeting Location
                    </label>

                    <input
                        id="location"
                        type="text"
                        name="location"
                        value="{{ old('location') }}"
                        placeholder="Office, phone call, or online meeting"
                        required
                        class="w-full rounded-xl border border-[#e7e3db] bg-[#faf9f6] px-4 py-3.5 text-sm text-[#151515] placeholder:text-[#aaa69e] outline-none transition focus:border-[#b69a68] focus:bg-white focus:ring-2 focus:ring-[#b69a68]/10"
                    >

                </div>


                {{-- =================================================
                    NOTE
                ================================================== --}}
                <div>

                    <label
                        for="note"
                        class="mb-2 block text-[11px] font-semibold uppercase tracking-[0.12em] text-[#5f5d58]"
                    >
                        Note
                    </label>

                    <textarea
                        id="note"
                        name="note"
                        rows="4"
                        placeholder="Briefly describe what you would like to discuss..."
                        class="w-full resize-none rounded-xl border border-[#e7e3db] bg-[#faf9f6] px-4 py-3.5 text-sm leading-6 text-[#151515] placeholder:text-[#aaa69e] outline-none transition focus:border-[#b69a68] focus:bg-white focus:ring-2 focus:ring-[#b69a68]/10"
                    >{{ old('note') }}</textarea>

                </div>


                {{-- =================================================
                    ACTION
                ================================================== --}}
                <div
                    class="flex items-center justify-between gap-4 border-t border-[#eeeae2] pt-5"
                >

                    <p
                        class="hidden text-[11px] leading-5 text-[#99958e] sm:block"
                    >
                        Your lawyer will review your request.
                    </p>


                    {{-- SMALL BUTTON --}}
                    <button
                        type="submit"
                        class="group inline-flex shrink-0 items-center gap-2 rounded-lg bg-[#151515] px-4 py-2.5 text-white transition-all duration-200 hover:bg-[#b69a68] hover:text-[#151515]"
                    >

                        <span class="font-serif text-[14px] font-semibold">
                            Request a Meeting
                        </span>

                        <svg
                            class="h-3.5 w-3.5 transition-transform duration-200 group-hover:translate-x-0.5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 12h14M13 6l6 6-6 6"
                            />
                        </svg>

                    </button>

                </div>

            </form>

        </div>



        {{-- =====================================================
            APPOINTMENTS LIST
        ====================================================== --}}
        <div
            class="overflow-hidden rounded-2xl border border-[#e7e3db] bg-white shadow-[0_8px_30px_rgba(21,21,21,0.04)]"
        >

            {{-- Header --}}
            <div
                class="flex items-center justify-between border-b border-[#e7e3db] px-7 py-6"
            >

                <div>

                    <div class="mb-2 flex items-center gap-2">

                        <span class="h-px w-5 bg-[#b69a68]"></span>

                        <span
                            class="text-[9px] font-semibold uppercase tracking-[0.2em] text-[#b69a68]"
                        >
                            Schedule
                        </span>

                    </div>

                    <h2 class="font-serif text-2xl font-semibold text-[#151515]">
                        Your Appointments
                    </h2>

                </div>


                {{-- Appointment Count --}}
                <div class="rounded-full bg-[#f7f4ed] px-3 py-1.5">

                    <span class="text-[11px] font-semibold text-[#927849]">
                        {{ $appointments->count() }}
                    </span>

                </div>

            </div>


            {{-- =================================================
                APPOINTMENT LIST
            ================================================== --}}
            <div class="px-7 py-6">

                @forelse ($appointments as $appointment)

                    @php

                        $status = strtolower(
                            $appointment->status ?? 'pending'
                        );

                        $statusStyles = match ($status) {

                            'confirmed' => [
                                'badge' => 'bg-[#edf5ef] text-[#3f7458]',
                                'dot' => 'bg-[#3f7458]',
                                'label' => 'Confirmed',
                            ],

                            'scheduled' => [
                                'badge' => 'bg-[#edf5ef] text-[#3f7458]',
                                'dot' => 'bg-[#3f7458]',
                                'label' => 'Scheduled',
                            ],

                            'completed' => [
                                'badge' => 'bg-[#f1f1ef] text-[#65635e]',
                                'dot' => 'bg-[#65635e]',
                                'label' => 'Completed',
                            ],

                            'rejected' => [
                                'badge' => 'bg-[#faeeee] text-[#9b4c48]',
                                'dot' => 'bg-[#9b4c48]',
                                'label' => 'Declined',
                            ],

                            default => [
                                'badge' => 'bg-[#f7f4ed] text-[#927849]',
                                'dot' => 'bg-[#b69a68]',
                                'label' => 'Pending',
                            ],

                        };

                    @endphp


                    {{-- =================================================
                        TIMELINE ITEM
                    ================================================== --}}
                    <div
                        class="relative flex gap-5 {{ !$loop->last ? 'pb-7' : '' }}"
                    >


                        {{-- Timeline --}}
                        <div
                            class="relative flex w-12 shrink-0 flex-col items-center"
                        >

                            <div
                                class="relative z-10 flex h-10 w-10 items-center justify-center rounded-full border border-[#e7e3db] bg-[#faf9f6]"
                            >

                                <svg
                                    class="h-4 w-4 text-[#927849]"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    viewBox="0 0 24 24"
                                >
                                    <rect
                                        x="3"
                                        y="4"
                                        width="18"
                                        height="18"
                                        rx="2"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        d="M16 2v4M8 2v4M3 10h18"
                                    />
                                </svg>

                            </div>


                            @if (!$loop->last)

                                <div
                                    class="absolute top-10 h-full w-px bg-[#e7e3db]"
                                ></div>

                            @endif

                        </div>


                        {{-- =================================================
                            APPOINTMENT CARD
                        ================================================== --}}
                        <div
                            class="min-w-0 flex-1 rounded-xl border border-[#e7e3db] bg-[#faf9f6] p-5"
                        >


                            {{-- Date / Status --}}
                            <div
                                class="flex flex-wrap items-start justify-between gap-3"
                            >

                                <div>

                                    <p
                                        class="font-serif text-xl font-semibold text-[#151515]"
                                    >
                                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                                    </p>


                                    @if ($appointment->appointment_time)

                                        <p class="mt-1 text-xs text-[#7d7b76]">
                                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                                        </p>

                                    @endif

                                </div>


                                {{-- Status --}}
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-[10px] font-semibold {{ $statusStyles['badge'] }}"
                                >

                                    <span
                                        class="h-1.5 w-1.5 rounded-full {{ $statusStyles['dot'] }}"
                                    ></span>

                                    {{ $statusStyles['label'] }}

                                </span>

                            </div>


                            {{-- =================================================
                                DETAILS
                            ================================================== --}}
                            <div
                                class="mt-5 space-y-3 border-t border-[#e7e3db] pt-4"
                            >


                                {{-- =================================================
                                    LAWYER
                                ================================================== --}}
                                @if ($appointment->lawyer)

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white"
                                        >

                                            <svg
                                                class="h-4 w-4 text-[#927849]"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    d="M20 21a8 8 0 00-16 0M12 13a4 4 0 100-8 4 4 0 000 8z"
                                                />
                                            </svg>

                                        </div>


                                        <div>

                                            <p
                                                class="text-[10px] uppercase tracking-[0.1em] text-[#99958e]"
                                            >
                                                Lawyer
                                            </p>

                                            <p
                                                class="text-sm font-medium text-[#151515]"
                                            >
                                                {{ $appointment->lawyer->name }}
                                            </p>

                                        </div>

                                    </div>

                                @endif


                                {{-- =================================================
                                    CASE
                                ================================================== --}}
                                @if ($appointment->case)

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white"
                                        >

                                            <svg
                                                class="h-4 w-4 text-[#927849]"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M4 6h16M4 12h16M4 18h10"
                                                />
                                            </svg>

                                        </div>


                                        <div class="min-w-0">

                                            <p
                                                class="text-[10px] uppercase tracking-[0.1em] text-[#99958e]"
                                            >
                                                Case
                                            </p>


                                            {{-- CASE NUMBER --}}
                                            <p
                                                class="truncate text-sm font-medium text-[#151515]"
                                                title="{{ $appointment->case->case_number }}"
                                            >
                                                {{ $appointment->case->case_number }}
                                            </p>

                                        </div>

                                    </div>

                                @endif


                                {{-- =================================================
                                    LOCATION
                                ================================================== --}}
                                @if ($appointment->location)

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white"
                                        >

                                            <svg
                                                class="h-4 w-4 text-[#927849]"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M12 21s7-6.1 7-12a7 7 0 10-14 0c0 5.9 7 12 7 12z"
                                                />

                                                <circle
                                                    cx="12"
                                                    cy="9"
                                                    r="2.2"
                                                />

                                            </svg>

                                        </div>


                                        <div>

                                            <p
                                                class="text-[10px] uppercase tracking-[0.1em] text-[#99958e]"
                                            >
                                                Location
                                            </p>

                                            <p class="text-sm text-[#151515]">
                                                {{ $appointment->location }}
                                            </p>

                                        </div>

                                    </div>

                                @endif

                            </div>


                            {{-- =================================================
                                CLIENT NOTE
                            ================================================== --}}
                            @if ($appointment->note)

                                <div
                                    class="mt-4 rounded-lg border border-[#e7e3db] bg-white px-4 py-3"
                                >

                                    <p
                                        class="text-[10px] font-semibold uppercase tracking-[0.1em] text-[#99958e]"
                                    >
                                        Your Note
                                    </p>

                                    <p
                                        class="mt-1 text-xs leading-5 text-[#65635e]"
                                    >
                                        {{ $appointment->note }}
                                    </p>

                                </div>

                            @endif


                            {{-- =================================================
                                LAWYER RESPONSE
                            ================================================== --}}
                            @if ($appointment->response)

                                <div
                                    class="mt-4 rounded-lg border border-[#e4dccb] bg-[#f9f5ec] px-4 py-3"
                                >

                                    <p
                                        class="text-[10px] font-semibold uppercase tracking-[0.1em] text-[#927849]"
                                    >
                                        Lawyer's Response
                                    </p>

                                    <p
                                        class="mt-1 text-xs leading-5 text-[#5f5d58]"
                                    >
                                        {{ $appointment->response }}
                                    </p>

                                </div>

                            @endif

                        </div>

                    </div>


                @empty

                    {{-- =================================================
                        EMPTY STATE
                    ================================================== --}}
                    <div
                        class="flex min-h-[360px] flex-col items-center justify-center rounded-xl border border-dashed border-[#ddd8ce] bg-[#faf9f6] px-6 text-center"
                    >

                        <div
                            class="flex h-14 w-14 items-center justify-center rounded-full bg-white"
                        >

                            <svg
                                class="h-6 w-6 text-[#b69a68]"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.5"
                                viewBox="0 0 24 24"
                            >
                                <rect
                                    x="3"
                                    y="4"
                                    width="18"
                                    height="18"
                                    rx="2"
                                />

                                <path
                                    stroke-linecap="round"
                                    d="M16 2v4M8 2v4M3 10h18"
                                />
                            </svg>

                        </div>


                        <h3
                            class="mt-5 font-serif text-xl font-semibold text-[#151515]"
                        >
                            No appointments yet
                        </h3>


                        <p
                            class="mt-2 max-w-sm text-xs leading-5 text-[#7d7b76]"
                        >
                            Your scheduled meetings and appointment requests
                            will appear here.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection