@extends('layouts.app')

@section('title', 'Billing Details')

@section('content')

<div class="min-h-screen bg-[#F7F4ED] px-4 py-6 sm:px-6 lg:px-8">

    <div class="mx-auto max-w-6xl">

        {{-- =========================================================
            BREADCRUMB
        ========================================================== --}}
        <div class="mb-6 flex flex-wrap items-center gap-2 text-sm text-[#77756F]">

            <a
                href="{{ route('admin.dashboard') }}"
                class="transition duration-200 hover:text-[#B89452]"
            >
                Dashboard
            </a>

            <svg
                class="h-4 w-4 text-[#9B9992]"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.8"
                    d="m9 18 6-6-6-6"
                />
            </svg>

            <a
                href="{{ route('admin.billing.index') }}"
                class="transition duration-200 hover:text-[#B89452]"
            >
                Billing
            </a>

            <svg
                class="h-4 w-4 text-[#9B9992]"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.8"
                    d="m9 18 6-6-6-6"
                />
            </svg>

            <span class="text-[#41403C]">
                Details
            </span>

        </div>


        @php
            /*
             * The controller sends $invoice.
             * Therefore everything below must use $invoice.
             */

            $status = strtolower($invoice->status ?? 'pending');

            $statusClass = match ($status) {
                'paid' => 'border-[#3D8B5A]/30 bg-[#EFF8F2] text-[#27633D]',
                'overdue' => 'border-[#B94A48]/30 bg-[#FDF0EF] text-[#7D302F]',
                'cancelled', 'canceled', 'void' => 'border-[#D4D1CA] bg-[#F7F4ED] text-[#77756F]',
                'pending' => 'border-[#B98525]/30 bg-[#FFF8E8] text-[#795A18]',
                default => 'border-[#D4D1CA] bg-[#F7F4ED] text-[#77756F]',
            };

            $amount = $invoice->amount ?? 0;

            $client = $invoice->client ?? null;

            /*
             * Your current BillingController loads:
             * client, case, accountant
             *
             * It does NOT currently load a lawyer directly.
             */
            $case = $invoice->case ?? null;

            $accountant = $invoice->accountant ?? null;
        @endphp


        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <p class="text-sm font-medium text-[#B89452]">
                    Invoice #{{ $invoice->id }}
                </p>

                <h1 class="mt-1 font-serif text-3xl font-medium tracking-tight text-[#11110F] sm:text-4xl">
                    Billing Details
                </h1>

                <p class="mt-2 text-sm text-[#77756F]">
                    Complete invoice and payment information.
                </p>

            </div>


            {{-- Status --}}
            <span
                class="inline-flex w-fit items-center gap-2 rounded-full border px-4 py-2 text-sm font-semibold {{ $statusClass }}"
            >

                <span class="h-1.5 w-1.5 rounded-full bg-current"></span>

                {{ ucfirst($status) }}

            </span>

        </div>


        {{-- =========================================================
            MAIN GRID
        ========================================================== --}}
        <div class="grid gap-6 lg:grid-cols-3">


            {{-- =====================================================
                MAIN CONTENT
            ====================================================== --}}
            <div class="space-y-6 lg:col-span-2">


                {{-- =================================================
                    INVOICE SUMMARY
                ================================================== --}}
                <div class="rounded-2xl border border-[#E5E2DB] bg-white p-6">

                    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-[#B89452]">
                                Invoice
                            </p>

                            <h2 class="mt-1 text-xl font-semibold text-[#11110F]">
                                #{{ $invoice->id }}
                            </h2>

                        </div>


                        <div class="text-left sm:text-right">

                            <p class="text-xs text-[#77756F]">
                                Amount
                            </p>

                            <p class="mt-1 text-2xl font-semibold text-[#11110F]">
                                {{ number_format((float) $amount, 2) }}

                                <span class="text-sm font-medium text-[#77756F]">
                                    JOD
                                </span>
                            </p>

                        </div>

                    </div>


                    {{-- Invoice information --}}
                    <div class="grid gap-5 border-t border-[#E5E2DB] pt-6 sm:grid-cols-2">


                        {{-- Invoice ID --}}
                        <div>

                            <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#77756F]">
                                Invoice ID
                            </p>

                            <p class="mt-2 text-sm font-semibold text-[#41403C]">
                                #{{ $invoice->id }}
                            </p>

                        </div>


                        {{-- Invoice Date --}}
                        <div>

                            <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#77756F]">
                                Invoice Date
                            </p>

                            <p class="mt-2 text-sm font-medium text-[#41403C]">

                                @if($invoice->created_at)

                                    {{ $invoice->created_at->format('M d, Y') }}

                                @else

                                    —

                                @endif

                            </p>

                        </div>


                        {{-- Due Date --}}
                        <div>

                            <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#77756F]">
                                Due Date
                            </p>

                            <p class="mt-2 text-sm font-medium text-[#41403C]">

                                @if($invoice->due_date)

                                    {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}

                                @else

                                    —

                                @endif

                            </p>

                        </div>


                        {{-- Payment Date --}}
                        <div>

                            <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#77756F]">
                                Payment Date
                            </p>

                            <p class="mt-2 text-sm font-medium text-[#41403C]">

                                @if($invoice->paid_at)

                                    {{ \Carbon\Carbon::parse($invoice->paid_at)->format('M d, Y h:i A') }}

                                @else

                                    —

                                @endif

                            </p>

                        </div>


                        {{-- Status --}}
                        <div>

                            <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#77756F]">
                                Status
                            </p>

                            <div class="mt-2">

                                <span
                                    class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClass }}"
                                >
                                    <span class="h-1.5 w-1.5 rounded-full bg-current"></span>

                                    {{ ucfirst($status) }}
                                </span>

                            </div>

                        </div>


                        {{-- Case ID --}}
                        <div>

                            <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#77756F]">
                                Case ID
                            </p>

                            <p class="mt-2 text-sm font-medium text-[#41403C]">
                                {{ $invoice->case_id ? '#' . $invoice->case_id : '—' }}
                            </p>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    CLIENT & ACCOUNTANT
                ================================================== --}}
                <div class="grid gap-6 sm:grid-cols-2">


                    {{-- Client --}}
                    <div class="rounded-2xl border border-[#E5E2DB] bg-white p-6">

                        <p class="text-xs font-semibold uppercase tracking-[0.08em] text-[#B89452]">
                            Client
                        </p>


                        @if($client)

                            <div class="mt-5 flex items-center gap-4">

                                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border border-[#C9A96E]/30 bg-[#F7F4ED] text-lg font-semibold text-[#B89452]">

                                    {{ strtoupper(substr($client->name ?? 'C', 0, 1)) }}

                                </div>


                                <div class="min-w-0">

                                    <h3 class="truncate font-semibold text-[#11110F]">
                                        {{ $client->name ?? 'Unknown Client' }}
                                    </h3>

                                    @if($client->email)

                                        <p class="mt-1 truncate text-sm text-[#77756F]">
                                            {{ $client->email }}
                                        </p>

                                    @endif

                                    @if($client->phone)

                                        <p class="mt-1 text-xs text-[#9B9992]">
                                            {{ $client->phone }}
                                        </p>

                                    @endif

                                </div>

                            </div>

                        @else

                            <div class="mt-5">

                                <p class="text-sm text-[#77756F]">
                                    No client information available.
                                </p>

                            </div>

                        @endif

                    </div>


                    {{-- Accountant --}}
                    <div class="rounded-2xl border border-[#E5E2DB] bg-white p-6">

                        <p class="text-xs font-semibold uppercase tracking-[0.08em] text-[#B89452]">
                            Accountant
                        </p>


                        @if($accountant)

                            <div class="mt-5 flex items-center gap-4">

                                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border border-[#C9A96E]/30 bg-[#F7F4ED] text-lg font-semibold text-[#B89452]">

                                    {{ strtoupper(substr($accountant->name ?? 'A', 0, 1)) }}

                                </div>


                                <div class="min-w-0">

                                    <h3 class="truncate font-semibold text-[#11110F]">
                                        {{ $accountant->name ?? 'Accountant' }}
                                    </h3>

                                    @if($accountant->email)

                                        <p class="mt-1 truncate text-sm text-[#77756F]">
                                            {{ $accountant->email }}
                                        </p>

                                    @endif

                                </div>

                            </div>

                        @else

                            <div class="mt-5">

                                <p class="text-sm text-[#77756F]">
                                    No accountant assigned.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                    DESCRIPTION
                ================================================== --}}
                <div class="rounded-2xl border border-[#E5E2DB] bg-white p-6">

                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-[#B89452]">
                        Description
                    </p>

                    <h2 class="mt-1 text-lg font-semibold text-[#11110F]">
                        Billing Description
                    </h2>


                    <div class="mt-5 rounded-xl border border-[#E5E2DB] bg-[#F7F4ED] p-5">

                        @if($invoice->description)

                            <p class="whitespace-pre-line text-sm leading-7 text-[#41403C]">
                                {{ $invoice->description }}
                            </p>

                        @else

                            <p class="text-sm italic text-[#77756F]">
                                No description has been added to this invoice.
                            </p>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                    RELATED CASE
                ================================================== --}}
                <div class="rounded-2xl border border-[#E5E2DB] bg-white p-6">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-[#C9A96E]/30 bg-[#F7F4ED] text-[#B89452]">

                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M7 3h10v18H7z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M9.5 7h5M9.5 11h5M9.5 15h3"
                                />

                            </svg>

                        </div>


                        <div>

                            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-[#B89452]">
                                Related Case
                            </p>

                            <h2 class="mt-1 text-lg font-semibold text-[#11110F]">
                                Case Information
                            </h2>

                        </div>

                    </div>


                    @if($case)

                        <div class="mt-6 grid gap-5 sm:grid-cols-2">

                            <div>

                                <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#77756F]">
                                    Case ID
                                </p>

                                <p class="mt-2 text-sm font-semibold text-[#B89452]">
                                    #{{ $case->id }}
                                </p>

                            </div>


                            @if($case->case_number)

                                <div>

                                    <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#77756F]">
                                        Case Number
                                    </p>

                                    <p class="mt-2 text-sm font-medium text-[#41403C]">
                                        {{ $case->case_number }}
                                    </p>

                                </div>

                            @endif


                            @if($case->case_type)

                                <div>

                                    <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#77756F]">
                                        Case Type
                                    </p>

                                    <p class="mt-2 text-sm font-medium text-[#41403C]">
                                        {{ $case->case_type }}
                                    </p>

                                </div>

                            @endif


                            @if($case->status)

                                <div>

                                    <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#77756F]">
                                        Case Status
                                    </p>

                                    <p class="mt-2 text-sm font-medium text-[#41403C]">
                                        {{ ucfirst($case->status) }}
                                    </p>

                                </div>

                            @endif

                        </div>

                    @else

                        <p class="mt-5 text-sm text-[#77756F]">
                            No case is linked to this invoice.
                        </p>

                    @endif

                </div>


                {{-- =================================================
                    ADDITIONAL INFORMATION
                ================================================== --}}
                <div class="rounded-2xl border border-[#E5E2DB] bg-white p-6">

                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-[#B89452]">
                        Additional Information
                    </p>


                    <div class="mt-5 grid gap-5 sm:grid-cols-2">


                        {{-- Invoice ID --}}
                        <div>

                            <p class="text-xs text-[#77756F]">
                                Invoice ID
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#41403C]">
                                #{{ $invoice->id }}
                            </p>

                        </div>


                        {{-- Client ID --}}
                        <div>

                            <p class="text-xs text-[#77756F]">
                                Client ID
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#41403C]">
                                {{ $invoice->client_id ? '#' . $invoice->client_id : '—' }}
                            </p>

                        </div>


                        {{-- Accountant ID --}}
                        <div>

                            <p class="text-xs text-[#77756F]">
                                Accountant ID
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#41403C]">
                                {{ $invoice->accountant_id ? '#' . $invoice->accountant_id : '—' }}
                            </p>

                        </div>


                        {{-- Created --}}
                        <div>

                            <p class="text-xs text-[#77756F]">
                                Created
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#41403C]">

                                @if($invoice->created_at)

                                    {{ $invoice->created_at->format('M d, Y h:i A') }}

                                @else

                                    —

                                @endif

                            </p>

                        </div>


                        {{-- Last Updated --}}
                        <div>

                            <p class="text-xs text-[#77756F]">
                                Last Updated
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#41403C]">

                                @if($invoice->updated_at)

                                    {{ $invoice->updated_at->format('M d, Y h:i A') }}

                                @else

                                    —

                                @endif

                            </p>

                        </div>


                        {{-- Due Date --}}
                        <div>

                            <p class="text-xs text-[#77756F]">
                                Due Date
                            </p>

                            <p class="mt-1 text-sm font-medium text-[#41403C]">

                                @if($invoice->due_date)

                                    {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}

                                @else

                                    —

                                @endif

                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                RIGHT SIDEBAR
            ====================================================== --}}
            <div class="space-y-6">


                {{-- =================================================
                    PAYMENT SUMMARY
                ================================================== --}}
                <div class="rounded-2xl border border-[#E5E2DB] bg-white p-6">

                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-[#B89452]">
                        Payment Summary
                    </p>


                    <div class="mt-5">

                        <p class="text-sm text-[#77756F]">
                            Total Amount
                        </p>

                        <p class="mt-1 text-3xl font-semibold text-[#11110F]">
                            {{ number_format((float) $amount, 2) }}
                        </p>

                        <p class="mt-1 text-sm text-[#77756F]">
                            JOD
                        </p>

                    </div>


                    <div class="mt-6 border-t border-[#E5E2DB] pt-5">

                        <div class="flex items-center justify-between gap-4">

                            <span class="text-sm text-[#77756F]">
                                Status
                            </span>

                            <span
                                class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClass }}"
                            >
                                <span class="h-1.5 w-1.5 rounded-full bg-current"></span>

                                {{ ucfirst($status) }}
                            </span>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    INVOICE TIMELINE
                ================================================== --}}
                <div class="rounded-2xl border border-[#E5E2DB] bg-white p-6">

                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-[#B89452]">
                        Invoice Timeline
                    </p>


                    <div class="mt-6 space-y-6">


                        {{-- Created --}}
                        <div class="relative flex gap-4">

                            <div class="relative flex shrink-0 flex-col items-center">

                                <div class="flex h-9 w-9 items-center justify-center rounded-full border border-[#C9A96E]/30 bg-[#F7F4ED] text-[#B89452]">

                                    <svg
                                        class="h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M12 6v6l4 2"
                                        />

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="9"
                                            stroke-width="1.8"
                                        />

                                    </svg>

                                </div>

                            </div>


                            <div class="pt-1">

                                <p class="text-sm font-semibold text-[#11110F]">
                                    Invoice Created
                                </p>

                                <p class="mt-1 text-xs text-[#77756F]">

                                    @if($invoice->created_at)

                                        {{ $invoice->created_at->format('M d, Y h:i A') }}

                                    @else

                                        —

                                    @endif

                                </p>

                            </div>

                        </div>


                        {{-- Paid --}}
                        @if($invoice->paid_at)

                            <div class="relative flex gap-4">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-[#3D8B5A]/30 bg-[#EFF8F2] text-[#3D8B5A]">

                                    <svg
                                        class="h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="m5 12 4 4L19 6"
                                        />
                                    </svg>

                                </div>


                                <div class="pt-1">

                                    <p class="text-sm font-semibold text-[#11110F]">
                                        Payment Received
                                    </p>

                                    <p class="mt-1 text-xs text-[#77756F]">
                                        {{ \Carbon\Carbon::parse($invoice->paid_at)->format('M d, Y h:i A') }}
                                    </p>

                                </div>

                            </div>

                        @endif


                        {{-- Updated --}}
                        @if($invoice->updated_at && $invoice->updated_at != $invoice->created_at)

                            <div class="relative flex gap-4">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-[#D4D1CA] bg-[#F7F4ED] text-[#77756F]">

                                    <svg
                                        class="h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M20 11a8.1 8.1 0 0 0-15.5-2M4 5v4h4"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M4 13a8.1 8.1 0 0 0 15.5 2M20 19v-4h-4"
                                        />

                                    </svg>

                                </div>


                                <div class="pt-1">

                                    <p class="text-sm font-semibold text-[#11110F]">
                                        Invoice Updated
                                    </p>

                                    <p class="mt-1 text-xs text-[#77756F]">
                                        {{ $invoice->updated_at->format('M d, Y h:i A') }}
                                    </p>

                                </div>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                    ADMIN NOTICE
                ================================================== --}}
                <div class="rounded-2xl border border-[#C9A96E]/30 bg-[#F7F4ED] p-6">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-[#C9A96E]/30 bg-white text-[#B89452]">

                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            aria-hidden="true"
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
                                d="M12 10v6"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-width="2"
                                d="M12 7h.01"
                            />

                        </svg>

                    </div>


                    <h3 class="mt-4 font-semibold text-[#11110F]">
                        Administrator View
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-[#77756F]">
                        You are viewing this billing record as an administrator.
                        Financial changes should be properly recorded in the
                        activity log.
                    </p>

                </div>


                {{-- =================================================
                    BACK BUTTON
                ================================================== --}}
                <a
                    href="{{ route('admin.billing.index') }}"
                    class="flex h-11 w-full items-center justify-center gap-2 rounded-lg border border-[#C9A96E]/40 bg-white px-4 text-sm font-semibold text-[#B89452] transition duration-200 hover:-translate-y-px hover:bg-[#FAF9F6]"
                >

                    <svg
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M15 18l-6-6 6-6"
                        />
                    </svg>

                    Back to Billing

                </a>

            </div>

        </div>

    </div>

</div>

@endsection