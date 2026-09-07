
@extends('layouts.app')

@section('title', 'Appointments')

@section('content')

<div class="min-h-screen bg-[#F7F4ED]">

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <div class="mb-5 flex items-center gap-2 text-[11px] text-[#9B9992]">
            <a
                href="{{ route('lawyer.dashboard') }}"
                class="transition hover:text-[#B89452]"
            >
                Dashboard
            </a>

            <span>/</span>

            <span class="text-[#41403C]">
                Appointments
            </span>
        </div>

        {{-- Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>
                <p class="mb-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-[#B89452]">
                    Lawyer Portal
                </p>

                <h1 class="font-serif text-3xl font-semibold tracking-tight text-[#181815] sm:text-4xl">
                    Appointments
                </h1>

                <p class="mt-1.5 text-[12px] text-[#77756F]">
                    Review and manage your client appointments.
                </p>
            </div>

            <a
                href="{{ route('lawyer.appointments.schedule') }}"
                class="inline-flex w-fit items-center gap-2 rounded-md bg-[#B89452] px-3.5 py-2 text-[11px] font-semibold text-white shadow-sm transition hover:bg-[#9F7D43]"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-3.5 w-3.5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4v16m8-8H4"
                    />
                </svg>

                Schedule Appointment
            </a>

        </div>

        {{-- Success Message --}}
        @if (session('status'))

            <div class="mb-5 flex items-start gap-3 rounded-lg border border-[#CFE5D5] bg-[#EFF8F2] px-4 py-3">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="mt-0.5 h-4 w-4 shrink-0 text-[#3D8B5A]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7"
                    />
                </svg>

                <p class="text-[11px] font-medium text-[#27633D]">
                    {{ session('status') }}
                </p>

            </div>

        @endif

        {{-- Error Message --}}
        @if (session('error'))

            <div class="mb-5 flex items-start gap-3 rounded-lg border border-[#E8C9C8] bg-[#FDF0EF] px-4 py-3">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="mt-0.5 h-4 w-4 shrink-0 text-[#B94A48]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 9v3.5m0 3h.01M10.3 4.6l-7.4 13a1.5 1.5 0 001.3 2.2h15.6a1.5 1.5 0 001.3-2.2l-7.4-13a1.5 1.5 0 00-2.6 0z"
                    />
                </svg>

                <p class="text-[11px] font-medium text-[#7D302F]">
                    {{ session('error') }}
                </p>

            </div>

        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())

            <div class="mb-5 rounded-lg border border-[#E8C9C8] bg-[#FDF0EF] px-4 py-3">

                <p class="mb-1 text-[11px] font-semibold text-[#7D302F]">
                    Please correct the following:
                </p>

                <ul class="list-inside list-disc space-y-0.5 text-[10px] text-[#7D302F]">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif

        {{-- Appointments Card --}}
        <div class="overflow-hidden rounded-xl border border-[#E5E2DB] bg-white shadow-sm">

            {{-- Card Header --}}
            <div class="flex items-center justify-between border-b border-[#E5E2DB] px-5 py-4">

                <div>
                    <h2 class="text-sm font-semibold text-[#181815]">
                        All Appointments
                    </h2>

                    <p class="mt-0.5 text-[10px] text-[#9B9992]">
                        {{ $appointments->total() }}
                        {{ \Illuminate\Support\Str::plural('appointment', $appointments->total()) }}
                    </p>
                </div>

                <div class="hidden items-center gap-2 sm:flex">

                    <span class="h-1.5 w-1.5 rounded-full bg-[#3D8B5A]"></span>

                    <span class="text-[9px] font-medium uppercase tracking-wider text-[#77756F]">
                        Appointment Management
                    </span>

                </div>

            </div>

            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto md:block">

                @if ($appointments->count() > 0)

                    <table class="w-full table-auto text-left text-[12px]">

                        <thead class="border-b border-[#E5E2DB] bg-[#FAF9F6]">

                            <tr>

                                <th class="px-5 py-3 text-[9px] font-semibold uppercase tracking-wider text-[#77756F]">
                                    Client
                                </th>

                                <th class="px-5 py-3 text-[9px] font-semibold uppercase tracking-wider text-[#77756F]">
                                    Date
                                </th>

                                <th class="px-5 py-3 text-[9px] font-semibold uppercase tracking-wider text-[#77756F]">
                                    Time
                                </th>

                                <th class="px-5 py-3 text-[9px] font-semibold uppercase tracking-wider text-[#77756F]">
                                    Note
                                </th>

                                <th class="px-5 py-3 text-[9px] font-semibold uppercase tracking-wider text-[#77756F]">
                                    Status
                                </th>

                                <th class="px-5 py-3 text-right text-[9px] font-semibold uppercase tracking-wider text-[#77756F]">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-[#E5E2DB]">

                            @foreach ($appointments as $appointment)

                                @php

                                    $status = strtolower(
                                        trim((string) $appointment->status)
                                    );

                                    $clientName = optional($appointment->client)->name
                                        ?? 'Unknown Client';

                                    $clientEmail = optional($appointment->client)->email
                                        ?? 'No email';

                                    $initials = collect(
                                        preg_split(
                                            '/\s+/',
                                            trim($clientName)
                                        )
                                    )
                                        ->filter()
                                        ->take(2)
                                        ->map(
                                            fn ($part) => strtoupper(
                                                substr($part, 0, 1)
                                            )
                                        )
                                        ->implode('');

                                @endphp

                                <tr class="transition hover:bg-[#FCFBF8]">

                                    {{-- Client --}}
                                    <td class="px-5 py-3">

                                        <div class="flex min-w-[180px] items-center gap-2.5">

                                            <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#F0E8D8] text-[9px] font-semibold text-[#795A18]">
                                                {{ $initials ?: 'C' }}
                                            </div>

                                            <div class="min-w-0">

                                                <p class="truncate text-[12px] font-semibold text-[#181815]">
                                                    {{ $clientName }}
                                                </p>

                                                <p class="truncate text-[10px] text-[#9B9992]">
                                                    {{ $clientEmail }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>

                                    {{-- Date --}}
                                    <td class="whitespace-nowrap px-5 py-3">

                                        <span class="text-[11px] font-medium text-[#41403C]">
                                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                        </span>

                                    </td>

                                    {{-- Time --}}
                                    <td class="whitespace-nowrap px-5 py-3">

                                        <span class="text-[10px] text-[#77756F]">
                                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                        </span>

                                    </td>

                                    {{-- Note --}}
                                    <td class="px-5 py-3">

                                        <p
                                            class="max-w-[220px] truncate text-[11px] text-[#77756F]"
                                            title="{{ $appointment->note }}"
                                        >
                                            {{ $appointment->note ?: '—' }}
                                        </p>

                                    </td>

                                    {{-- Status --}}
                                    <td class="whitespace-nowrap px-5 py-3">

                                        @if ($status === 'approved')

                                            <span class="inline-flex items-center rounded-full bg-[#EFF8F2] px-2 py-0.5 text-[9px] font-semibold text-[#27633D]">
                                                Approved
                                            </span>

                                        @elseif ($status === 'rejected')

                                            <span class="inline-flex items-center rounded-full bg-[#FDF0EF] px-2 py-0.5 text-[9px] font-semibold text-[#7D302F]">
                                                Rejected
                                            </span>

                                        @elseif ($status === 'pending')

                                            <span class="inline-flex items-center rounded-full bg-[#FFF8E8] px-2 py-0.5 text-[9px] font-semibold text-[#795A18]">
                                                Pending
                                            </span>

                                        @elseif ($status === 'completed')

                                            <span class="inline-flex items-center rounded-full bg-[#EEF5F8] px-2 py-0.5 text-[9px] font-semibold text-[#315868]">
                                                Completed
                                            </span>

                                        @else

                                            <span class="inline-flex items-center rounded-full bg-[#F3F3F1] px-2 py-0.5 text-[9px] font-semibold text-[#41403C]">
                                                {{ ucfirst($status ?: 'Unknown') }}
                                            </span>

                                        @endif

                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-5 py-3">

                                        <div class="flex items-center justify-end gap-1.5">

                                            @if ($status === 'pending')

                                                {{-- Approve --}}
                                                <form
                                                    method="POST"
                                                    action="{{ route('lawyer.appointments.respond', $appointment) }}"
                                                >

                                                    @csrf

                                                    <input
                                                        type="hidden"
                                                        name="status"
                                                        value="approved"
                                                    >

                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center gap-1 rounded-md bg-[#3D8B5A] px-2.5 py-1.5 text-[10px] font-semibold text-white transition hover:bg-[#27633D] focus:outline-none focus:ring-2 focus:ring-[#3D8B5A] focus:ring-offset-1"
                                                    >

                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="h-3 w-3"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke="currentColor"
                                                            stroke-width="2"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M5 13l4 4L19 7"
                                                            />
                                                        </svg>

                                                        Approve

                                                    </button>

                                                </form>

                                                {{-- Reject --}}
                                                <form
                                                    method="POST"
                                                    action="{{ route('lawyer.appointments.respond', $appointment) }}"
                                                >

                                                    @csrf

                                                    <input
                                                        type="hidden"
                                                        name="status"
                                                        value="rejected"
                                                    >

                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center gap-1 rounded-md bg-[#B94A48] px-2.5 py-1.5 text-[10px] font-semibold text-white transition hover:bg-[#7D302F] focus:outline-none focus:ring-2 focus:ring-[#B94A48] focus:ring-offset-1"
                                                    >

                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="h-3 w-3"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke="currentColor"
                                                            stroke-width="2"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M6 18L18 6M6 6l12 12"
                                                            />
                                                        </svg>

                                                        Reject

                                                    </button>

                                                </form>

                                            @else

                                                <span class="text-[10px] text-[#9B9992]">
                                                    No actions
                                                </span>

                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                @else

                    <div class="flex flex-col items-center justify-center px-6 py-16 text-center">

                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[#F7F4ED]">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-[#B89452]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"
                                />
                            </svg>

                        </div>

                        <h3 class="text-sm font-semibold text-[#181815]">
                            No appointments yet
                        </h3>

                        <p class="mt-1 max-w-sm text-[11px] text-[#9B9992]">
                            You don't have any client appointments at the moment.
                        </p>

                    </div>

                @endif

            </div>

            {{-- Mobile Cards --}}
            <div class="divide-y divide-[#E5E2DB] md:hidden">

                @forelse ($appointments as $appointment)

                    @php

                        $status = strtolower(
                            trim((string) $appointment->status)
                        );

                        $clientName = optional($appointment->client)->name
                            ?? 'Unknown Client';

                        $clientEmail = optional($appointment->client)->email
                            ?? 'No email';

                        $initials = collect(
                            preg_split(
                                '/\s+/',
                                trim($clientName)
                            )
                        )
                            ->filter()
                            ->take(2)
                            ->map(
                                fn ($part) => strtoupper(
                                    substr($part, 0, 1)
                                )
                            )
                            ->implode('');

                    @endphp

                    <div class="p-4">

                        {{-- Client --}}
                        <div class="mb-4 flex items-center justify-between gap-3">

                            <div class="flex min-w-0 items-center gap-2.5">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#F0E8D8] text-[10px] font-semibold text-[#795A18]">
                                    {{ $initials ?: 'C' }}
                                </div>

                                <div class="min-w-0">

                                    <p class="truncate text-[12px] font-semibold text-[#181815]">
                                        {{ $clientName }}
                                    </p>

                                    <p class="truncate text-[10px] text-[#9B9992]">
                                        {{ $clientEmail }}
                                    </p>

                                </div>

                            </div>

                            {{-- Status --}}
                            @if ($status === 'approved')

                                <span class="shrink-0 rounded-full bg-[#EFF8F2] px-2 py-0.5 text-[9px] font-semibold text-[#27633D]">
                                    Approved
                                </span>

                            @elseif ($status === 'rejected')

                                <span class="shrink-0 rounded-full bg-[#FDF0EF] px-2 py-0.5 text-[9px] font-semibold text-[#7D302F]">
                                    Rejected
                                </span>

                            @elseif ($status === 'pending')

                                <span class="shrink-0 rounded-full bg-[#FFF8E8] px-2 py-0.5 text-[9px] font-semibold text-[#795A18]">
                                    Pending
                                </span>

                            @elseif ($status === 'completed')

                                <span class="shrink-0 rounded-full bg-[#EEF5F8] px-2 py-0.5 text-[9px] font-semibold text-[#315868]">
                                    Completed
                                </span>

                            @else

                                <span class="shrink-0 rounded-full bg-[#F3F3F1] px-2 py-0.5 text-[9px] font-semibold text-[#41403C]">
                                    {{ ucfirst($status ?: 'Unknown') }}
                                </span>

                            @endif

                        </div>

                        {{-- Appointment Details --}}
                        <div class="mb-4 grid grid-cols-2 gap-3">

                            <div>

                                <p class="mb-0.5 text-[9px] font-semibold uppercase tracking-wider text-[#9B9992]">
                                    Date
                                </p>

                                <p class="text-[11px] font-medium text-[#41403C]">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                </p>

                            </div>

                            <div>

                                <p class="mb-0.5 text-[9px] font-semibold uppercase tracking-wider text-[#9B9992]">
                                    Time
                                </p>

                                <p class="text-[11px] text-[#41403C]">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                </p>

                            </div>

                        </div>

                        {{-- Note --}}
                        <div class="mb-4">

                            <p class="mb-0.5 text-[9px] font-semibold uppercase tracking-wider text-[#9B9992]">
                                Note
                            </p>

                            <p class="text-[11px] leading-5 text-[#77756F]">
                                {{ $appointment->note ?: 'No note provided.' }}
                            </p>

                        </div>

                        {{-- Mobile Actions --}}
                        @if ($status === 'pending')

                            <div class="flex items-center gap-2">

                                {{-- Approve --}}
                                <form
                                    method="POST"
                                    action="{{ route('lawyer.appointments.respond', $appointment) }}"
                                    class="flex-1"
                                >

                                    @csrf

                                    <input
                                        type="hidden"
                                        name="status"
                                        value="approved"
                                    >

                                    <button
                                        type="submit"
                                        class="flex w-full items-center justify-center gap-1.5 rounded-md bg-[#3D8B5A] px-3 py-2 text-[10px] font-semibold text-white transition hover:bg-[#27633D]"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-3 w-3"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M5 13l4 4L19 7"
                                            />
                                        </svg>

                                        Approve

                                    </button>

                                </form>

                                {{-- Reject --}}
                                <form
                                    method="POST"
                                    action="{{ route('lawyer.appointments.respond', $appointment) }}"
                                    class="flex-1"
                                >

                                    @csrf

                                    <input
                                        type="hidden"
                                        name="status"
                                        value="rejected"
                                    >

                                    <button
                                        type="submit"
                                        class="flex w-full items-center justify-center gap-1.5 rounded-md bg-[#B94A48] px-3 py-2 text-[10px] font-semibold text-white transition hover:bg-[#7D302F]"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-3 w-3"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12"
                                            />
                                        </svg>

                                        Reject

                                    </button>

                                </form>

                            </div>

                        @endif

                    </div>

                @empty

                    <div class="px-5 py-14 text-center">

                        <div class="mx-auto mb-4 flex h-11 w-11 items-center justify-center rounded-full bg-[#F7F4ED]">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-[#B89452]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 4h10"
                                />
                            </svg>

                        </div>

                        <h3 class="text-sm font-semibold text-[#181815]">
                            No appointments yet
                        </h3>

                        <p class="mt-1 text-[11px] text-[#9B9992]">
                            You don't have any client appointments at the moment.
                        </p>

                    </div>

                @endforelse

            </div>

            {{-- Pagination --}}
            @if ($appointments->hasPages())

                <div class="border-t border-[#E5E2DB] px-5 py-3">
                    {{ $appointments->links() }}
                </div>

            @endif

        </div>

    </div>

</div>

@endsection
