@extends('layouts.app')

@section('title', 'Invoices')

@section('breadcrumb', 'Financial Workspace / Invoices')

@section('content')

@php
    $statuses = [
        ''        => 'All',
        'draft'   => 'Draft',
        'sent'    => 'Sent',
        'paid'    => 'Paid',
        'overdue' => 'Overdue',
        'void'    => 'Void',
    ];

    $currentStatus = request('status', '');

    $statusStyles = [
        'draft' => [
            'bg' => '#F7F4ED',
            'text' => '#77756F',
            'border' => '#D4D1CA',
        ],
        'sent' => [
            'bg' => '#EEF5F8',
            'text' => '#315868',
            'border' => '#477C91',
        ],
        'paid' => [
            'bg' => '#EFF8F2',
            'text' => '#27633D',
            'border' => '#3D8B5A',
        ],
        'overdue' => [
            'bg' => '#FDF0EF',
            'text' => '#7D302F',
            'border' => '#B94A48',
        ],
        'void' => [
            'bg' => '#F1F0EC',
            'text' => '#77756F',
            'border' => '#D4D1CA',
        ],
    ];
@endphp

<div class="min-h-screen bg-[#F7F4ED]">

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- ========================================= --}}
        {{-- PAGE HEADER --}}
        {{-- ========================================= --}}
        <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

            <div>

                <p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-[#B89452]">
                    Financial Records
                </p>

                <div class="mt-2 flex items-center gap-3">

                    <h1 class="font-serif text-3xl font-semibold tracking-tight text-[#11110F] sm:text-4xl">
                        Invoices
                    </h1>

                    @if(method_exists($invoices, 'total'))
                        <span class="rounded-md border border-[#D4D1CA] bg-white px-2.5 py-1 font-mono text-xs font-semibold text-[#77756F]">
                            {{ $invoices->total() }}
                        </span>
                    @endif

                </div>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-[#77756F]">
                    Review, filter, and manage the firm's billing records.
                </p>

            </div>


            {{-- CREATE INVOICE --}}
            <a
                href="{{ route('accountant.invoices.create') }}"
                class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-[#C9A96E] px-5 text-sm font-semibold text-[#11110F] shadow-sm transition hover:bg-[#D8BE8A] focus:outline-none focus:ring-2 focus:ring-[#C9A96E]/40 focus:ring-offset-2"
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

                Create Invoice

            </a>

        </div>


        {{-- ========================================= --}}
        {{-- FILTERS --}}
        {{-- ========================================= --}}
        <div class="mb-6 rounded-xl border border-[#E5E2DB] bg-white p-3 shadow-sm">

            <form
                method="GET"
                action="{{ route('accountant.invoices.index') }}"
                class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between"
            >

                {{-- STATUS FILTERS --}}
                <div class="flex flex-wrap gap-1">

                    @foreach($statuses as $value => $label)

                        <a
                            href="{{ route(
                                'accountant.invoices.index',
                                array_filter([
                                    'status' => $value,
                                    'search' => request('search'),
                                ])
                            ) }}"
                            class="inline-flex h-9 items-center justify-center rounded-md px-3 text-xs font-semibold transition
                                {{ $currentStatus === $value
                                    ? 'bg-[#11110F] text-white'
                                    : 'text-[#77756F] hover:bg-[#F7F4ED] hover:text-[#11110F]'
                                }}"
                        >
                            {{ $label }}
                        </a>

                    @endforeach

                </div>


                {{-- SEARCH --}}
                <div class="relative w-full lg:max-w-xs">

                    <svg
                        class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#9B9992]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="m21 21-4.35-4.35m1.35-5.15a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"
                        />
                    </svg>

                    <input
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by client name..."
                        autocomplete="off"
                        class="h-10 w-full rounded-lg border border-[#D4D1CA] bg-[#FAF9F6] pl-10 pr-4 text-sm text-[#11110F] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:bg-white focus:ring-2 focus:ring-[#C9A96E]/20"
                    >

                </div>

            </form>

        </div>


        {{-- ========================================= --}}
        {{-- INVOICE TABLE --}}
        {{-- ========================================= --}}
        <div class="overflow-hidden rounded-xl border border-[#E5E2DB] bg-white shadow-sm">

            @if($invoices->count())

                {{-- TABLE --}}
                <div class="overflow-x-auto">

                    <table class="min-w-[850px] w-full">

                        <thead>

                            <tr class="border-b border-[#E5E2DB] bg-[#F7F4ED]">

                                <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                    Client
                                </th>

                                <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                    Case Number
                                </th>

                                <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                    Amount
                                </th>

                                <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                    Due Date
                                </th>

                                <th class="px-6 py-4 text-right text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-[#EEEAE1]">

                        @foreach($invoices as $invoice)

                            @php
                                $status = strtolower($invoice->status ?? 'draft');

                                $style = $statusStyles[$status] ?? $statusStyles['draft'];

                                $clientName = $invoice->client?->name ?? '—';
                                $caseNumber = $invoice->case?->case_number ?? '—';
                                $amount = (float) ($invoice->amount ?? 0);
                            @endphp

                            <tr class="group transition hover:bg-[#FAF9F6]">

                                {{-- CLIENT --}}
                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#11110F] text-sm font-semibold text-[#D8BE8A]">
                                            {{ strtoupper(substr($clientName, 0, 1)) }}
                                        </div>

                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-semibold text-[#11110F]">
                                                {{ $clientName }}
                                            </p>

                                            @if($invoice->client?->email)
                                                <p class="mt-0.5 truncate text-xs text-[#9B9992]">
                                                    {{ $invoice->client->email }}
                                                </p>
                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- CASE NUMBER --}}
                                <td class="px-6 py-5">

                                    <div class="inline-flex items-center gap-2">

                                        <svg
                                            class="h-4 w-4 shrink-0 text-[#C9A96E]"
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

                                        <span class="font-mono text-xs text-[#77756F]">
                                            {{ $caseNumber }}
                                        </span>

                                    </div>

                                </td>


                                {{-- AMOUNT --}}
                                <td class="px-6 py-5">

                                    <div class="flex items-baseline gap-1.5">

                                        <span class="text-[10px] font-semibold uppercase tracking-wide text-[#B89452]">
                                            JOD
                                        </span>

                                        <span class="font-mono text-sm font-semibold text-[#11110F]">
                                            {{ number_format($amount, 2) }}
                                        </span>

                                    </div>

                                </td>


                                {{-- STATUS --}}
                                <td class="px-6 py-5">

                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-md border px-2.5 py-1.5 text-[10px] font-semibold uppercase tracking-[0.07em]"
                                        style="
                                            background-color: {{ $style['bg'] }};
                                            color: {{ $style['text'] }};
                                            border-color: {{ $style['border'] }};
                                        "
                                    >

                                        <span
                                            class="h-1.5 w-1.5 rounded-full"
                                            style="background-color: {{ $style['text'] }};"
                                        ></span>

                                        {{ ucfirst($status) }}

                                    </span>

                                </td>


                                {{-- DUE DATE --}}
                                <td class="px-6 py-5">

                                    @if($invoice->due_date)

                                        <div class="flex items-center gap-2">

                                            <svg
                                                class="h-4 w-4 text-[#9B9992]"
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

                                            <span class="whitespace-nowrap text-xs text-[#69655D]">
                                                {{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}
                                            </span>

                                        </div>

                                    @else

                                        <span class="text-sm text-[#9B9992]">
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- VIEW --}}
                                <td class="px-6 py-5 text-right">

                                    <a
                                        href="{{ route('accountant.invoices.show', $invoice) }}"
                                        class="inline-flex h-9 items-center justify-center gap-1.5 rounded-md border border-[#D4D1CA] bg-white px-3 text-xs font-semibold text-[#41403C] transition hover:border-[#C9A96E] hover:bg-[#F7F4ED] hover:text-[#11110F]"
                                    >

                                        View

                                        <svg
                                            class="h-3.5 w-3.5 text-[#B89452]"
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

                                    </a>

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- ========================================= --}}
                {{-- PAGINATION --}}
                {{-- ========================================= --}}
                <div class="border-t border-[#E5E2DB] bg-white px-5 py-4 sm:px-6">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        {{-- Pagination information --}}
                        <p class="text-xs text-[#77756F]">

                            Showing

                            <span class="font-semibold text-[#41403C]">
                                {{ $invoices->firstItem() ?? 0 }}
                            </span>

                            to

                            <span class="font-semibold text-[#41403C]">
                                {{ $invoices->lastItem() ?? 0 }}
                            </span>

                            of

                            <span class="font-semibold text-[#41403C]">
                                {{ $invoices->total() }}
                            </span>

                            invoices

                        </p>


                        {{-- CUSTOM PAGINATION --}}
                        @if($invoices->hasPages())

                            <nav
                                class="flex items-center gap-1"
                                aria-label="Invoice pagination"
                            >

                                {{-- PREVIOUS --}}
                                @if($invoices->onFirstPage())

                                    <span
                                        class="inline-flex h-9 items-center justify-center gap-1.5 rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] px-3 text-xs font-semibold text-[#B8B5AE] cursor-not-allowed"
                                    >

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
                                                d="M15 19l-7-7 7-7"
                                            />
                                        </svg>

                                        Previous

                                    </span>

                                @else

                                    <a
                                        href="{{ $invoices->previousPageUrl() }}"
                                        class="inline-flex h-9 items-center justify-center gap-1.5 rounded-lg border border-[#D4D1CA] bg-white px-3 text-xs font-semibold text-[#41403C] transition hover:border-[#C9A96E] hover:bg-[#F7F4ED] hover:text-[#11110F]"
                                    >

                                        <svg
                                            class="h-3.5 w-3.5 text-[#B89452]"
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

                                        Previous

                                    </a>

                                @endif


                                {{-- PAGE NUMBERS --}}
                                @foreach($invoices->getUrlRange(
                                    max(1, $invoices->currentPage() - 2),
                                    min($invoices->lastPage(), $invoices->currentPage() + 2)
                                ) as $page => $url)

                                    @if($page == $invoices->currentPage())

                                        <span
                                            class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg border border-[#C9A96E] bg-[#C9A96E] px-2.5 text-xs font-semibold text-[#11110F]"
                                            aria-current="page"
                                        >
                                            {{ $page }}
                                        </span>

                                    @else

                                        <a
                                            href="{{ $url }}"
                                            class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg border border-[#E5E2DB] bg-white px-2.5 text-xs font-semibold text-[#77756F] transition hover:border-[#C9A96E] hover:bg-[#F7F4ED] hover:text-[#11110F]"
                                        >
                                            {{ $page }}
                                        </a>

                                    @endif

                                @endforeach


                                {{-- NEXT --}}
                                @if($invoices->hasMorePages())

                                    <a
                                        href="{{ $invoices->nextPageUrl() }}"
                                        class="inline-flex h-9 items-center justify-center gap-1.5 rounded-lg border border-[#D4D1CA] bg-white px-3 text-xs font-semibold text-[#41403C] transition hover:border-[#C9A96E] hover:bg-[#F7F4ED] hover:text-[#11110F]"
                                    >

                                        Next

                                        <svg
                                            class="h-3.5 w-3.5 text-[#B89452]"
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

                                    </a>

                                @else

                                    <span
                                        class="inline-flex h-9 items-center justify-center gap-1.5 rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] px-3 text-xs font-semibold text-[#B8B5AE] cursor-not-allowed"
                                    >

                                        Next

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

                                    </span>

                                @endif

                            </nav>

                        @endif

                    </div>

                </div>

            @else

                {{-- ========================================= --}}
                {{-- EMPTY STATE --}}
                {{-- ========================================= --}}
                <div class="px-6 py-20 text-center sm:px-10">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl border border-[#E5E2DB] bg-[#F7F4ED] text-[#C9A96E]">

                        <svg
                            class="h-7 w-7"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.6"
                                d="M9 12h6m-6 4h4m-2-13H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V8l-5-5z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.6"
                                d="M14 3v5h5"
                            />
                        </svg>

                    </div>

                    <h2 class="mt-5 font-serif text-2xl font-semibold text-[#11110F]">
                        No invoices found
                    </h2>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#77756F]">
                        No invoices match the current filters. Create a new invoice to begin managing the firm's billing records.
                    </p>

                    <a
                        href="{{ route('accountant.invoices.create') }}"
                        class="mt-6 inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-[#C9A96E] px-5 text-sm font-semibold text-[#11110F] shadow-sm transition hover:bg-[#D8BE8A]"
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

                        Create Invoice

                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection