@extends('layouts.app')

@section('title', 'Billing')

@section('content')

<div
    x-data="{
        search: '',
        status: 'all',

        matches(item) {
            const text = item.textContent.toLowerCase();

            const searchMatch =
                this.search === '' ||
                text.includes(this.search.toLowerCase());

            const statusMatch =
                this.status === 'all' ||
                item.dataset.status === this.status;

            return searchMatch && statusMatch;
        }
    }"
    class="min-h-screen bg-[#F7F4ED] px-4 py-6 sm:px-6 lg:px-8"
>

    <div class="mx-auto max-w-7xl">


        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <div class="mb-8">

            {{-- Breadcrumb --}}
            <div class="mb-3 flex items-center gap-2 text-sm text-[#77756F]">

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

                <span class="text-[#41403C]">
                    Billing
                </span>

            </div>


            {{-- Page Header --}}
            <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#B89452]">
                        Financial Management
                    </p>

                    <h1 class="mt-2 font-serif text-3xl font-medium tracking-tight text-[#11110F] sm:text-4xl">
                        Billing
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-[#77756F]">
                        Monitor invoices, payments, and outstanding balances across the firm.
                    </p>

                </div>


                {{-- Total Records --}}
                <div class="flex w-fit items-center gap-3 rounded-xl border border-[#E5E2DB] bg-white px-5 py-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-[#C9A96E]/30 bg-[#F7F4ED] text-[#B89452]">

                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <rect
                                x="3"
                                y="5"
                                width="18"
                                height="14"
                                rx="2"
                                stroke-width="1.8"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-width="1.8"
                                d="M7 10h10M7 14h5"
                            />
                        </svg>

                    </div>

                    <div>

                        <p class="text-[11px] font-medium uppercase tracking-[0.08em] text-[#77756F]">
                            Total Records
                        </p>

                        <p class="mt-0.5 text-lg font-semibold text-[#11110F]">
                            {{ method_exists($billings, 'total') ? $billings->total() : $billings->count() }}
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
            SUMMARY CARDS
        ========================================================== --}}
        <div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">


            {{-- Total --}}
            <div class="group rounded-2xl border border-[#E5E2DB] bg-white p-5 transition duration-200 hover:-translate-y-0.5">

                <div class="flex items-center justify-between">

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
                                stroke-width="1.8"
                                d="M12 2v20"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-width="1.8"
                                d="M17 6H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6"
                            />
                        </svg>

                    </div>

                </div>

                <p class="mt-4 text-[11px] font-medium uppercase tracking-[0.08em] text-[#77756F]">
                    Total Billing
                </p>

                <p class="mt-1 text-2xl font-semibold text-[#11110F]">
                    {{ number_format($totalAmount ?? 0, 2) }}
                    <span class="text-sm font-medium text-[#77756F]">
                        JOD
                    </span>
                </p>

            </div>


            {{-- Paid --}}
            <div class="group rounded-2xl border border-[#E5E2DB] bg-white p-5 transition duration-200 hover:-translate-y-0.5">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-[#3D8B5A]/30 bg-[#EFF8F2] text-[#3D8B5A]">

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
                            d="m5 12 4 4L19 6"
                        />
                    </svg>

                </div>

                <p class="mt-4 text-[11px] font-medium uppercase tracking-[0.08em] text-[#77756F]">
                    Paid
                </p>

                <p class="mt-1 text-2xl font-semibold text-[#11110F]">
                    {{ number_format($paidAmount ?? 0, 2) }}

                    <span class="text-sm font-medium text-[#77756F]">
                        JOD
                    </span>
                </p>

            </div>


            {{-- Pending --}}
            <div class="group rounded-2xl border border-[#E5E2DB] bg-white p-5 transition duration-200 hover:-translate-y-0.5">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-[#B98525]/30 bg-[#FFF8E8] text-[#B98525]">

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
                            d="M12 7v5l3 2"
                        />
                    </svg>

                </div>

                <p class="mt-4 text-[11px] font-medium uppercase tracking-[0.08em] text-[#77756F]">
                    Pending
                </p>

                <p class="mt-1 text-2xl font-semibold text-[#11110F]">
                    {{ number_format($pendingAmount ?? 0, 2) }}

                    <span class="text-sm font-medium text-[#77756F]">
                        JOD
                    </span>
                </p>

            </div>


            {{-- Outstanding --}}
            <div class="group rounded-2xl border border-[#E5E2DB] bg-white p-5 transition duration-200 hover:-translate-y-0.5">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-[#B94A48]/30 bg-[#FDF0EF] text-[#B94A48]">

                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-width="1.8"
                            d="M12 3v18"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-width="1.8"
                            d="M17 7H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6"
                        />
                    </svg>

                </div>

                <p class="mt-4 text-[11px] font-medium uppercase tracking-[0.08em] text-[#77756F]">
                    Outstanding
                </p>

                <p class="mt-1 text-2xl font-semibold text-[#11110F]">
                    {{ number_format($outstandingAmount ?? 0, 2) }}

                    <span class="text-sm font-medium text-[#77756F]">
                        JOD
                    </span>
                </p>

            </div>

        </div>


        {{-- =========================================================
            FILTERS
        ========================================================== --}}
        <div class="mb-6 rounded-2xl border border-[#E5E2DB] bg-white p-4">

            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">


                {{-- Search --}}
                <div class="relative w-full lg:max-w-md">

                    <svg
                        class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-[#9B9992]"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        aria-hidden="true"
                    >
                        <circle
                            cx="11"
                            cy="11"
                            r="7"
                            stroke-width="1.8"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-width="1.8"
                            d="m20 20-4-4"
                        />
                    </svg>


                    <input
                        type="text"
                        x-model="search"
                        placeholder="Search invoice, client, lawyer..."
                        class="h-11 w-full rounded-lg border border-[#D4D1CA] bg-white py-2.5 pl-11 pr-4 text-sm text-[#41403C] outline-none transition duration-200 placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-4 focus:ring-[#C9A96E]/10"
                    >

                </div>


                {{-- Status Filters --}}
                <div class="flex flex-wrap gap-2">

                    {{-- All --}}
                    <button
                        type="button"
                        @click="status = 'all'"
                        :class="status === 'all'
                            ? 'border-[#C9A96E] bg-[#C9A96E]/10 text-[#B89452]'
                            : 'border-[#E5E2DB] bg-white text-[#77756F] hover:bg-[#FAF9F6]'"
                        class="rounded-lg border px-4 py-2.5 text-sm font-semibold transition duration-200"
                    >
                        All
                    </button>


                    {{-- Paid --}}
                    <button
                        type="button"
                        @click="status = 'paid'"
                        :class="status === 'paid'
                            ? 'border-[#C9A96E] bg-[#C9A96E]/10 text-[#B89452]'
                            : 'border-[#E5E2DB] bg-white text-[#77756F] hover:bg-[#FAF9F6]'"
                        class="rounded-lg border px-4 py-2.5 text-sm font-semibold transition duration-200"
                    >
                        Paid
                    </button>


                    {{-- Pending --}}
                    <button
                        type="button"
                        @click="status = 'pending'"
                        :class="status === 'pending'
                            ? 'border-[#C9A96E] bg-[#C9A96E]/10 text-[#B89452]'
                            : 'border-[#E5E2DB] bg-white text-[#77756F] hover:bg-[#FAF9F6]'"
                        class="rounded-lg border px-4 py-2.5 text-sm font-semibold transition duration-200"
                    >
                        Pending
                    </button>


                    {{-- Overdue --}}
                    <button
                        type="button"
                        @click="status = 'overdue'"
                        :class="status === 'overdue'
                            ? 'border-[#C9A96E] bg-[#C9A96E]/10 text-[#B89452]'
                            : 'border-[#E5E2DB] bg-white text-[#77756F] hover:bg-[#FAF9F6]'"
                        class="rounded-lg border px-4 py-2.5 text-sm font-semibold transition duration-200"
                    >
                        Overdue
                    </button>


                    {{-- Void --}}
                    <button
                        type="button"
                        @click="status = 'void'"
                        :class="status === 'void'
                            ? 'border-[#C9A96E] bg-[#C9A96E]/10 text-[#B89452]'
                            : 'border-[#E5E2DB] bg-white text-[#77756F] hover:bg-[#FAF9F6]'"
                        class="rounded-lg border px-4 py-2.5 text-sm font-semibold transition duration-200"
                    >
                        Void
                    </button>

                </div>

            </div>

        </div>


        {{-- =========================================================
            BILLING TABLE
        ========================================================== --}}
        <div class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white">


            {{-- Table Header --}}
            <div class="hidden border-b border-[#E5E2DB] bg-[#F7F4ED] px-6 py-4 md:grid md:grid-cols-12 md:gap-4">

                <div class="col-span-2 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                    Invoice
                </div>

                <div class="col-span-2 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                    Client
                </div>

                <div class="col-span-2 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                    Lawyer
                </div>

                <div class="col-span-2 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                    Amount
                </div>

                <div class="col-span-2 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                    Status
                </div>

                <div class="col-span-2 text-right text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                    Action
                </div>

            </div>


            {{-- Billing Records --}}
            @forelse($billings as $billing)

                @php

                    $billingStatus = strtolower($billing->status ?? 'pending');

                    $statusClass = match ($billingStatus) {

                        'paid' =>
                            'border-[#3D8B5A]/30 bg-[#EFF8F2] text-[#27633D]',

                        'overdue' =>
                            'border-[#B94A48]/30 bg-[#FDF0EF] text-[#7D302F]',

                        'cancelled', 'canceled', 'void' =>
                            'border-[#D4D1CA] bg-[#F7F4ED] text-[#77756F]',

                        'pending' =>
                            'border-[#B98525]/30 bg-[#FFF8E8] text-[#795A18]',

                        default =>
                            'border-[#D4D1CA] bg-[#F7F4ED] text-[#77756F]',
                    };


                    $client = $billing->client ?? ($billing->user ?? null);

                    /*
                     * BillingController currently loads client + case.
                     * It does not load lawyer directly.
                     */
                    $lawyer = $billing->lawyer ?? null;

                    if (!$lawyer && $billing->case && isset($billing->case->lawyer)) {
                        $lawyer = $billing->case->lawyer;
                    }

                    $amount =
                        $billing->amount
                        ?? ($billing->total ?? ($billing->total_amount ?? 0));

                @endphp


                <div
                    x-show="matches($el)"
                    x-transition
                    data-status="{{ $billingStatus }}"
                    class="group border-b border-[#E5E2DB] px-4 py-5 transition duration-200 last:border-b-0 hover:bg-[#FAF9F6] sm:px-6"
                >

                    <div class="grid gap-5 md:grid-cols-12 md:items-center">


                        {{-- =================================================
                            INVOICE
                        ================================================== --}}
                        <div class="md:col-span-2">

                            <p class="mb-1 text-[11px] font-medium uppercase tracking-[0.08em] text-[#9B9992] md:hidden">
                                Invoice
                            </p>

                            <p class="font-semibold text-[#11110F]">
                                #{{ $billing->invoice_number ?? $billing->id }}
                            </p>

                            @if($billing->created_at)

                                <p class="mt-1 text-xs text-[#77756F]">
                                    {{ $billing->created_at->format('M d, Y') }}
                                </p>

                            @endif

                        </div>


                        {{-- =================================================
                            CLIENT
                        ================================================== --}}
                        <div class="md:col-span-2">

                            <p class="mb-1 text-[11px] font-medium uppercase tracking-[0.08em] text-[#9B9992] md:hidden">
                                Client
                            </p>


                            @if($client)

                                <div class="flex items-center gap-2.5">

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-[#C9A96E]/30 bg-[#F7F4ED] text-xs font-semibold text-[#B89452]">

                                        {{ strtoupper(substr($client->name ?? 'C', 0, 1)) }}

                                    </div>

                                    <span class="truncate text-sm font-medium text-[#41403C]">
                                        {{ $client->name ?? 'Unknown Client' }}
                                    </span>

                                </div>

                            @else

                                <span class="text-sm text-[#77756F]">
                                    —
                                </span>

                            @endif

                        </div>


                        {{-- =================================================
                            LAWYER
                        ================================================== --}}
                        <div class="md:col-span-2">

                            <p class="mb-1 text-[11px] font-medium uppercase tracking-[0.08em] text-[#9B9992] md:hidden">
                                Lawyer
                            </p>


                            @if($lawyer)

                                <div class="flex items-center gap-2.5">

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-[#C9A96E]/30 bg-[#F7F4ED] text-xs font-semibold text-[#B89452]">

                                        {{ strtoupper(substr($lawyer->name ?? 'L', 0, 1)) }}

                                    </div>

                                    <span class="truncate text-sm font-medium text-[#41403C]">
                                        {{ $lawyer->name ?? 'Unknown Lawyer' }}
                                    </span>

                                </div>

                            @else

                                <span class="text-sm text-[#77756F]">
                                    Not assigned
                                </span>

                            @endif

                        </div>


                        {{-- =================================================
                            AMOUNT
                        ================================================== --}}
                        <div class="md:col-span-2">

                            <p class="mb-1 text-[11px] font-medium uppercase tracking-[0.08em] text-[#9B9992] md:hidden">
                                Amount
                            </p>

                            <p class="font-semibold text-[#11110F]">
                                {{ number_format((float) $amount, 2) }}
                            </p>

                            <p class="mt-0.5 text-xs text-[#77756F]">
                                JOD
                            </p>

                        </div>


                        {{-- =================================================
                            STATUS
                        ================================================== --}}
                        <div class="md:col-span-2">

                            <p class="mb-1 text-[11px] font-medium uppercase tracking-[0.08em] text-[#9B9992] md:hidden">
                                Status
                            </p>

                            <span
                                class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClass }}"
                            >

                                <span class="h-1.5 w-1.5 rounded-full bg-current"></span>

                                {{ ucfirst($billingStatus) }}

                            </span>

                        </div>


                        {{-- =================================================
                            ACTION
                        ================================================== --}}
                        <div class="md:col-span-2 md:text-right">

                            <a
                                href="{{ route('admin.billing.show', $billing) }}"
                                class="inline-flex h-9 items-center gap-2 rounded-lg border border-[#C9A96E]/40 bg-white px-3 text-xs font-semibold text-[#B89452] transition duration-200 hover:-translate-y-px hover:bg-[#FAF9F6] hover:text-[#B89452]"
                            >

                                View Details

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
                                        d="m9 18 6-6-6-6"
                                    />
                                </svg>

                            </a>

                        </div>

                    </div>

                </div>

            @empty


                {{-- =================================================
                    EMPTY STATE
                ================================================== --}}
                <div class="px-6 py-20 text-center">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-[#C9A96E]/30 bg-[#F7F4ED] text-[#B89452]">

                        <svg
                            class="h-7 w-7"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <rect
                                x="3"
                                y="5"
                                width="18"
                                height="14"
                                rx="2"
                                stroke-width="1.7"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-width="1.7"
                                d="M7 10h10M7 14h5"
                            />
                        </svg>

                    </div>


                    <h3 class="mt-5 text-lg font-semibold text-[#11110F]">
                        No Billing Records Yet
                    </h3>


                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#77756F]">
                        Invoices and payments will appear here once billing
                        activity is recorded.
                    </p>

                </div>

            @endforelse


            {{-- =========================================================
                PAGINATION
            ========================================================== --}}
            @if(method_exists($billings, 'links'))

                <div class="border-t border-[#E5E2DB] px-4 py-4 sm:px-6">

                    {{ $billings->links() }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection