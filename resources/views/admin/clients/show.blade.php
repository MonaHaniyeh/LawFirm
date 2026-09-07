@extends('layouts.app')

@section('title', 'Client Details')

@section('content')
    @php
        $clientStatus = strtolower(
            $client->status
            ?? (($client->is_active ?? true) ? 'active' : 'inactive')
        );

        $cases = $client->casesAsClient ?? $client->cases ?? collect();
        $caseCount = $client->cases_as_client_count
            ?? $client->cases_count
            ?? $cases->count();

        $documents = $client->documents ?? collect();
        $documentCount = $client->documents_count ?? $documents->count();

        $appointments = $client->appointmentsAsClient
            ?? $client->appointments
            ?? collect();

        $appointmentCount = $client->appointments_count
            ?? $appointments->count();

        $initial = strtoupper(substr($client->name ?? 'C', 0, 1));

        $isBanned = in_array($clientStatus, ['banned', 'suspended']);
        $isActive = $clientStatus === 'active';

        $statusLabel = match ($clientStatus) {
            'active' => 'Active',
            'banned' => 'Banned',
            'suspended' => 'Suspended',
            default => 'Inactive',
        };
    @endphp

    <div class="min-h-screen bg-[#F7F4ED] px-4 py-6 sm:px-6 lg:px-8">

        <div class="mx-auto max-w-7xl">

            {{-- Breadcrumb / Back --}}
            <div class="mb-6">
                <a
                    href="{{ route('admin.clients.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-[#77756F] transition hover:text-[#B89452]"
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

                    Clients
                </a>
            </div>


            {{-- Page Header --}}
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                <div>
                    <p class="mb-2 text-[11px] font-semibold uppercase tracking-[0.14em] text-[#B89452]">
                        Client Management
                    </p>

                    <h1 class="font-serif text-3xl font-semibold tracking-tight text-[#0B0B0A] sm:text-4xl">
                        Client Details
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-[#77756F]">
                        Review client information, associated cases, and account activity.
                    </p>
                </div>

                <div class="flex items-center gap-2 text-xs text-[#77756F]">
                    <span>Admin</span>

                    <svg
                        class="h-3.5 w-3.5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="m9 18 6-6-6-6"
                        />
                    </svg>

                    <span class="text-[#41403C]">
                        Clients
                    </span>

                    <svg
                        class="h-3.5 w-3.5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="m9 18 6-6-6-6"
                        />
                    </svg>

                    <span class="max-w-[140px] truncate text-[#B89452]">
                        {{ $client->name ?? 'Client' }}
                    </span>
                </div>

            </div>


            {{-- Client Profile Header --}}
            <div class="mb-6 overflow-hidden rounded-xl border border-[#E5E2DB] bg-white">

                <div class="h-1 bg-[#C9A96E]"></div>

                <div class="p-6 sm:p-8">

                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                        {{-- Identity --}}
                        <div class="flex min-w-0 items-center gap-5">

                            {{-- Avatar --}}
                            <div
                                class="flex h-16 w-16 shrink-0 items-center justify-center rounded-xl border border-[#D8BE8A] bg-[#11110F] font-serif text-2xl font-semibold text-[#D8BE8A]"
                            >
                                {{ $initial }}
                            </div>

                            <div class="min-w-0">

                                <div class="flex flex-wrap items-center gap-3">

                                    <h2 class="truncate font-serif text-2xl font-semibold text-[#0B0B0A]">
                                        {{ $client->name ?? 'Unnamed Client' }}
                                    </h2>

                                    @if ($isActive)
                                        <span class="inline-flex items-center gap-1.5 rounded-md border border-[#B9D9C3] bg-[#EFF8F2] px-2.5 py-1 text-xs font-semibold text-[#27633D]">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#3D8B5A]"></span>
                                            Active
                                        </span>
                                    @elseif ($isBanned)
                                        <span class="inline-flex items-center gap-1.5 rounded-md border border-[#E8B8B6] bg-[#FDF0EF] px-2.5 py-1 text-xs font-semibold text-[#7D302F]">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#B94A48]"></span>
                                            {{ $statusLabel }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-md border border-[#D4D1CA] bg-[#F7F4ED] px-2.5 py-1 text-xs font-semibold text-[#77756F]">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#9B9992]"></span>
                                            Inactive
                                        </span>
                                    @endif

                                </div>

                                <p class="mt-1 text-sm text-[#9B9992]">
                                    Client #{{ $client->id }}
                                </p>

                                <div class="mt-3 flex flex-wrap gap-x-5 gap-y-2">

                                    @if ($client->email)
                                        <div class="inline-flex items-center gap-2 text-sm text-[#77756F]">
                                            <svg
                                                class="h-4 w-4 text-[#B89452]"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.7"
                                                    d="M4 6h16v12H4z"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.7"
                                                    d="m4 7 8 6 8-6"
                                                />
                                            </svg>

                                            <span class="break-all">
                                                {{ $client->email }}
                                            </span>
                                        </div>
                                    @endif

                                    @if ($client->phone)
                                        <div class="inline-flex items-center gap-2 text-sm text-[#77756F]">
                                            <svg
                                                class="h-4 w-4 text-[#B89452]"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.7"
                                                    d="M6.6 3.8l2.2-.5a1.5 1.5 0 011.7.9l1.2 3a1.5 1.5 0 01-.4 1.7L10 10.2a12.5 12.5 0 003.8 3.8l1.3-1.3a1.5 1.5 0 011.7-.4l3 1.2a2 2 0 01.9 1.7l-.5 2.2a2 2 0 01-2 1.6C10.8 18.9 5.1 13.2 4.9 5.8a2 2 0 011.7-2z"
                                                />
                                            </svg>

                                            {{ $client->phone }}
                                        </div>
                                    @endif

                                </div>

                            </div>
                        </div>


                        {{-- Admin View --}}
                        <div class="inline-flex w-fit items-center gap-2 rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] px-3.5 py-2.5 text-xs font-medium text-[#77756F]">

                            <svg
                                class="h-4 w-4 text-[#B89452]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"
                                />
                            </svg>

                            Administrator View

                        </div>

                    </div>

                </div>
            </div>


            {{-- Summary Cards --}}
            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                {{-- Cases --}}
                <div class="rounded-xl border border-[#E5E2DB] bg-white p-5">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#9B9992]">
                                Cases
                            </p>

                            <p class="mt-2 text-2xl font-semibold text-[#0B0B0A]">
                                {{ $caseCount }}
                            </p>

                            <p class="mt-1 text-xs text-[#77756F]">
                                Associated matters
                            </p>
                        </div>

                        <div class="flex h-10 w-10 items-center justify-center rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] text-[#B89452]">

                            <svg
                                class="h-5 w-5"
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

                    </div>
                </div>


                {{-- Documents --}}
                <div class="rounded-xl border border-[#E5E2DB] bg-white p-5">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#9B9992]">
                                Documents
                            </p>

                            <p class="mt-2 text-2xl font-semibold text-[#0B0B0A]">
                                {{ $documentCount }}
                            </p>

                            <p class="mt-1 text-xs text-[#77756F]">
                                Client records
                            </p>
                        </div>

                        <div class="flex h-10 w-10 items-center justify-center rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] text-[#B89452]">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M9 12h6m-6 4h4m-2-13H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V8l-5-5z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M14 3v5h5"
                                />
                            </svg>

                        </div>

                    </div>
                </div>


                {{-- Appointments --}}
                <div class="rounded-xl border border-[#E5E2DB] bg-white p-5">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#9B9992]">
                                Appointments
                            </p>

                            <p class="mt-2 text-2xl font-semibold text-[#0B0B0A]">
                                {{ $appointmentCount }}
                            </p>

                            <p class="mt-1 text-xs text-[#77756F]">
                                Scheduled meetings
                            </p>
                        </div>

                        <div class="flex h-10 w-10 items-center justify-center rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] text-[#B89452]">

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
                                    stroke-width="1.7"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-width="1.7"
                                    d="M16 2v4M8 2v4M3 10h18"
                                />

                            </svg>

                        </div>

                    </div>
                </div>


                {{-- Joined --}}
                <div class="rounded-xl border border-[#E5E2DB] bg-white p-5">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#9B9992]">
                                Joined
                            </p>

                            <p class="mt-2 text-lg font-semibold text-[#0B0B0A]">
                                {{ optional($client->created_at)->format('M d, Y') ?? '—' }}
                            </p>

                            <p class="mt-1 text-xs text-[#77756F]">
                                Registration date
                            </p>
                        </div>

                        <div class="flex h-10 w-10 items-center justify-center rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] text-[#B89452]">

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
                                    stroke-width="1.7"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-width="1.7"
                                    d="M16 2v4M8 2v4M3 10h18"
                                />

                            </svg>

                        </div>

                    </div>
                </div>

            </div>


            {{-- Main Content --}}
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

                {{-- Left Column --}}
                <div class="space-y-6 xl:col-span-2">


                    {{-- Client Information --}}
                    <div class="overflow-hidden rounded-xl border border-[#E5E2DB] bg-white">

                        <div class="border-b border-[#E5E2DB] px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#F7F4ED] text-[#B89452]">

                                    <svg
                                        class="h-4.5 w-4.5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.7"
                                            d="M20 21a8 8 0 00-16 0"
                                        />

                                        <circle
                                            cx="12"
                                            cy="7"
                                            r="4"
                                            stroke-width="1.7"
                                        />
                                    </svg>

                                </div>

                                <div>
                                    <h2 class="text-base font-semibold text-[#0B0B0A]">
                                        Client Information
                                    </h2>

                                    <p class="mt-0.5 text-xs text-[#9B9992]">
                                        Personal and contact information
                                    </p>
                                </div>

                            </div>

                        </div>


                        <div class="p-6">

                            <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">

                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                        Full Name
                                    </p>

                                    <p class="mt-1.5 text-sm font-semibold text-[#0B0B0A]">
                                        {{ $client->name ?? '—' }}
                                    </p>
                                </div>


                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                        Email
                                    </p>

                                    <p class="mt-1.5 break-all text-sm font-semibold text-[#41403C]">
                                        {{ $client->email ?? '—' }}
                                    </p>
                                </div>


                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                        Phone
                                    </p>

                                    <p class="mt-1.5 text-sm font-semibold text-[#41403C]">
                                        {{ $client->phone ?? '—' }}
                                    </p>
                                </div>


                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                        Client ID
                                    </p>

                                    <p class="mt-1.5 text-sm font-semibold text-[#41403C]">
                                        #{{ $client->id }}
                                    </p>
                                </div>


                                @if ($client->address ?? null)
                                    <div class="sm:col-span-2">

                                        <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                            Address
                                        </p>

                                        <p class="mt-1.5 text-sm font-semibold text-[#41403C]">
                                            {{ $client->address }}
                                        </p>

                                    </div>
                                @endif


                                @if ($client->date_of_birth ?? null)
                                    <div>

                                        <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                            Date of Birth
                                        </p>

                                        <p class="mt-1.5 text-sm font-semibold text-[#41403C]">
                                            {{ \Carbon\Carbon::parse($client->date_of_birth)->format('F d, Y') }}
                                        </p>

                                    </div>
                                @endif

                            </div>

                        </div>
                    </div>


                    {{-- Client Cases --}}
                    <div class="overflow-hidden rounded-xl border border-[#E5E2DB] bg-white">

                        <div class="border-b border-[#E5E2DB] px-6 py-5">

                            <div class="flex items-center justify-between gap-4">

                                <div>
                                    <h2 class="text-base font-semibold text-[#0B0B0A]">
                                        Client Cases
                                    </h2>

                                    <p class="mt-0.5 text-xs text-[#9B9992]">
                                        Cases associated with this client
                                    </p>
                                </div>

                                <div class="flex items-center gap-2">

                                    <span class="text-xs text-[#9B9992]">
                                        Total
                                    </span>

                                    <span class="min-w-[30px] rounded-md border border-[#D4D1CA] bg-[#F7F4ED] px-2 py-1 text-center text-xs font-semibold text-[#41403C]">
                                        {{ $caseCount }}
                                    </span>

                                </div>

                            </div>

                        </div>


                        <div class="divide-y divide-[#E5E2DB]">

                            @forelse ($cases as $case)

                                @php
                                    $caseStatus = strtolower($case->status ?? 'pending');

                                    $caseTitle = $case->title
                                        ?? $case->case_title
                                        ?? 'Untitled Case';

                                    $caseNumber = $case->case_number
                                        ?? $case->reference_number
                                        ?? $case->id;

                                    $lawyer = $case->lawyer ?? null;

                                    $isCaseActive = in_array(
                                        $caseStatus,
                                        ['active', 'open', 'ongoing', 'in_progress']
                                    );

                                    $isCasePending = $caseStatus === 'pending';

                                    $isCaseClosed = in_array(
                                        $caseStatus,
                                        ['closed', 'completed', 'resolved']
                                    );
                                @endphp

                                <div class="p-5 transition hover:bg-[#FAF9F6] sm:px-6">

                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                                        <div class="flex min-w-0 items-center gap-3">

                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] text-[#B89452]">

                                                <svg
                                                    class="h-5 w-5"
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

                                                <p class="truncate text-sm font-semibold text-[#0B0B0A]">
                                                    {{ $caseTitle }}
                                                </p>

                                                <div class="mt-1 flex flex-wrap items-center gap-x-2 text-xs text-[#9B9992]">

                                                    <span>
                                                        #{{ $caseNumber }}
                                                    </span>

                                                    @if ($lawyer)
                                                        <span class="text-[#D4D1CA]">•</span>

                                                        <span>
                                                            {{ $lawyer->name }}
                                                        </span>
                                                    @endif

                                                </div>

                                            </div>

                                        </div>


                                        <div class="flex items-center justify-between gap-4 sm:justify-end">

                                            {{-- Status --}}
                                            @if ($isCaseActive)

                                                <span class="inline-flex items-center gap-1.5 rounded-md border border-[#B9D9C3] bg-[#EFF8F2] px-2.5 py-1 text-xs font-semibold text-[#27633D]">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-[#3D8B5A]"></span>
                                                    Active
                                                </span>

                                            @elseif ($isCasePending)

                                                <span class="inline-flex items-center gap-1.5 rounded-md border border-[#E7D4A8] bg-[#FFF8E8] px-2.5 py-1 text-xs font-semibold text-[#795A18]">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-[#B98525]"></span>
                                                    Pending
                                                </span>

                                            @elseif ($isCaseClosed)

                                                <span class="inline-flex items-center gap-1.5 rounded-md border border-[#D4D1CA] bg-[#F7F4ED] px-2.5 py-1 text-xs font-semibold text-[#77756F]">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-[#9B9992]"></span>
                                                    Closed
                                                </span>

                                            @else

                                                <span class="inline-flex items-center gap-1.5 rounded-md border border-[#BBD1DA] bg-[#EEF5F8] px-2.5 py-1 text-xs font-semibold text-[#315868]">
                                                    {{ ucfirst(str_replace('_', ' ', $caseStatus)) }}
                                                </span>

                                            @endif


                                            @if (Route::has('admin.cases.show'))

                                                <a
                                                    href="{{ route('admin.cases.show', $case) }}"
                                                    class="inline-flex items-center gap-1 text-sm font-semibold text-[#77756F] transition hover:text-[#B89452]"
                                                >
                                                    View

                                                    <svg
                                                        class="h-4 w-4"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="1.7"
                                                            d="m9 18 6-6-6-6"
                                                        />
                                                    </svg>

                                                </a>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div class="px-6 py-14 text-center">

                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] text-[#9B9992]">

                                        <svg
                                            class="h-6 w-6"
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

                                    <p class="mt-3 text-sm font-semibold text-[#41403C]">
                                        No cases
                                    </p>

                                    <p class="mt-1 text-sm text-[#9B9992]">
                                        This client does not have any cases yet.
                                    </p>

                                </div>

                            @endforelse

                        </div>

                    </div>


                    {{-- Notes --}}
                    @if ($client->notes ?? null)

                        <div class="overflow-hidden rounded-xl border border-[#E5E2DB] bg-white">

                            <div class="border-b border-[#E5E2DB] px-6 py-5">

                                <h2 class="text-base font-semibold text-[#0B0B0A]">
                                    Notes
                                </h2>

                                <p class="mt-0.5 text-xs text-[#9B9992]">
                                    Internal client notes
                                </p>

                            </div>

                            <div class="p-6">

                                <p class="whitespace-pre-line text-sm leading-7 text-[#41403C]">
                                    {{ $client->notes }}
                                </p>

                            </div>

                        </div>

                    @endif

                </div>


                {{-- Right Column --}}
                <div class="space-y-6">


                    {{-- Account Status --}}
                    <div class="rounded-xl border border-[#E5E2DB] bg-white p-6">

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#F7F4ED] text-[#B89452]">

                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.7"
                                        d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"
                                    />

                                </svg>

                            </div>

                            <div>
                                <h2 class="text-base font-semibold text-[#0B0B0A]">
                                    Account Status
                                </h2>

                                <p class="mt-0.5 text-xs text-[#9B9992]">
                                    Current account access
                                </p>
                            </div>

                        </div>


                        <div class="mt-5">

                            @if ($isActive)

                                <div class="border border-[#B9D9C3] bg-[#EFF8F2] p-4">

                                    <div class="flex items-start gap-3">

                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-[#3D8B5A]">

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
                                                    d="M5 12l4 4L19 6"
                                                />
                                            </svg>

                                        </div>

                                        <div>
                                            <p class="text-sm font-semibold text-[#27633D]">
                                                Active Account
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-[#3D8B5A]">
                                                Client can currently access the system.
                                            </p>
                                        </div>

                                    </div>

                                </div>

                            @elseif ($isBanned)

                                <div class="border border-[#E8B8B6] bg-[#FDF0EF] p-4">

                                    <div class="flex items-start gap-3">

                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-[#B94A48]">

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
                                                    d="M6 6l12 12M18 6L6 18"
                                                />
                                            </svg>

                                        </div>

                                        <div>
                                            <p class="text-sm font-semibold text-[#7D302F]">
                                                {{ $statusLabel }} Account
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-[#B94A48]">
                                                Client access is currently restricted.
                                            </p>
                                        </div>

                                    </div>

                                </div>

                            @else

                                <div class="border border-[#D4D1CA] bg-[#F7F4ED] p-4">

                                    <div class="flex items-start gap-3">

                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-[#77756F]">

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
                                                    d="M6 6l12 12M18 6L6 18"
                                                />
                                            </svg>

                                        </div>

                                        <div>
                                            <p class="text-sm font-semibold text-[#41403C]">
                                                Inactive Account
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-[#77756F]">
                                                Client access is currently inactive.
                                            </p>
                                        </div>

                                    </div>

                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- Account Details --}}
                    <div class="rounded-xl border border-[#E5E2DB] bg-white p-6">

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#F7F4ED] text-[#B89452]">

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
                                        stroke-width="1.7"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-width="1.7"
                                        d="M12 10v6M12 7h.01"
                                    />

                                </svg>

                            </div>

                            <div>
                                <h2 class="text-base font-semibold text-[#0B0B0A]">
                                    Account Details
                                </h2>

                                <p class="mt-0.5 text-xs text-[#9B9992]">
                                    Registration information
                                </p>
                            </div>

                        </div>


                        <div class="mt-6 space-y-5">

                            <div class="flex items-start justify-between gap-4 border-b border-[#E5E2DB] pb-4">

                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                        Registered
                                    </p>

                                    <p class="mt-1.5 text-sm font-semibold text-[#41403C]">
                                        {{ optional($client->created_at)->format('F d, Y') ?? '—' }}
                                    </p>
                                </div>

                            </div>


                            <div class="flex items-start justify-between gap-4 border-b border-[#E5E2DB] pb-4">

                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                        Last Updated
                                    </p>

                                    <p class="mt-1.5 text-sm font-semibold text-[#41403C]">
                                        {{ optional($client->updated_at)->format('F d, Y') ?? '—' }}
                                    </p>
                                </div>

                            </div>


                            <div>

                                <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                    Client ID
                                </p>

                                <p class="mt-1.5 text-sm font-semibold text-[#41403C]">
                                    #{{ $client->id }}
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Administrator Notice --}}
                    <div class="rounded-xl border border-[#2C2B27] bg-[#11110F] p-6">

                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-[#C9A96E]/30 bg-[#C9A96E]/10 text-[#D8BE8A]">

                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.7"
                                        d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"
                                    />
                                </svg>

                            </div>

                            <div>

                                <p class="text-sm font-semibold text-white">
                                    Administrator Access
                                </p>

                                <p class="mt-2 text-xs leading-5 text-[#9B9992]">
                                    You are viewing this client as an administrator.
                                    Client information is available for firm-wide
                                    management and oversight.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Bottom Navigation --}}
            <div class="mt-6 border-t border-[#E5E2DB] pt-6">

                <a
                    href="{{ route('admin.clients.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-[#D4D1CA] bg-white px-4 py-2.5 text-sm font-semibold text-[#41403C] transition hover:border-[#C9A96E] hover:text-[#B89452]"
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
                            stroke-width="1.7"
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>

                    Back to Clients

                </a>

            </div>

        </div>
    </div>
@endsection