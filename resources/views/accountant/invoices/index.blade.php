@extends('layouts.app')

@section('title', 'Invoices')

@section('breadcrumb', 'Financial Workspace / Invoices')

@section('content')

    @php
        $statuses = [
            '' => 'All',
            'draft' => 'Draft',
            'sent' => 'Sent',
            'paid' => 'Paid',
            'overdue' => 'Overdue',
            'void' => 'Void',
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

                        @if (method_exists($invoices, 'total'))
                            <span
                                class="rounded-md border border-[#D4D1CA] bg-white px-2.5 py-1 font-mono text-xs font-semibold text-[#77756F]"
                            >
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
            {{-- FILTER + SEARCH --}}
            {{-- SAME ROW --}}
            {{-- ========================================= --}}

            <div
                class="mb-6 rounded-xl border border-[#E5E2DB] bg-white p-3 shadow-sm"
            >

                <div
                    class="flex flex-col gap-3 xl:flex-row xl:items-center xl:justify-between"
                >

                    {{-- ========================================= --}}
                    {{-- STATUS FILTERS --}}
                    {{-- ========================================= --}}

                    <div class="flex flex-wrap items-center gap-2">

                        @foreach ($statuses as $value => $label)

                            <a
                                href="{{ route('accountant.invoices.index', array_filter([
                                    'status' => $value,
                                    'search' => request('search'),
                                ])) }}"
                                class="
                                    inline-flex
                                    h-9
                                    items-center
                                    justify-center
                                    rounded-lg
                                    px-3.5
                                    text-xs
                                    font-semibold
                                    transition
                                    focus:outline-none
                                    focus:ring-2
                                    focus:ring-[#C9A96E]/40

                                    {{ $currentStatus === $value
                                        ? 'bg-[#11110F] text-white shadow-sm'
                                        : 'bg-[#F7F4ED] text-[#625D55] hover:bg-[#EDE9E0] hover:text-[#11110F]'
                                    }}
                                "
                            >
                                {{ $label }}
                            </a>

                        @endforeach

                    </div>


                    {{-- ========================================= --}}
                    {{-- SEARCH --}}
                    {{-- ========================================= --}}

                    <form
                        method="GET"
                        action="{{ route('accountant.invoices.index') }}"
                        x-data="invoiceSearch()"
                        x-init="init()"
                        @submit.prevent="searchNow"
                        class="w-full xl:w-auto"
                    >

                        {{-- Keep current status --}}
                        <input
                            type="hidden"
                            name="status"
                            value="{{ request('status', '') }}"
                        >

                        <div class="flex w-full items-center gap-2">

                            {{-- SEARCH INPUT --}}
                            <div class="relative w-full xl:w-80">

                                {{-- Search icon --}}
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                                >

                                    <svg
                                        class="h-4 w-4 text-[#8D877D]"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"
                                        />
                                    </svg>

                                </div>


                                <input
                                    x-ref="searchInput"
                                    x-model="search"
                                    type="search"
                                    name="search"
                                    placeholder="Search client..."
                                    autocomplete="off"
                                    class="h-9 w-full rounded-lg border border-[#DDD8CE] bg-white pl-9 pr-10 text-xs text-[#24221E] outline-none transition placeholder:text-[#AAA49A] focus:border-[#9A763D] focus:ring-1 focus:ring-[#9A763D]"
                                    @input="handleInput"
                                    @keydown.enter.prevent="searchNow"
                                >


                                {{-- Loading --}}
                                <div
                                    x-show="loading"
                                    x-cloak
                                    class="absolute right-3 top-1/2 -translate-y-1/2"
                                >

                                    <svg
                                        class="h-4 w-4 animate-spin text-[#9A763D]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >

                                        <circle
                                            class="opacity-25"
                                            cx="12"
                                            cy="12"
                                            r="10"
                                            stroke="currentColor"
                                            stroke-width="4"
                                        />

                                        <path
                                            class="opacity-75"
                                            fill="currentColor"
                                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                                        />

                                    </svg>

                                </div>


                                {{-- Clear --}}
                                <button
                                    type="button"
                                    x-show="search.trim() !== '' && !loading"
                                    x-cloak
                                    @click="clearSearch"
                                    class="absolute right-2 top-1/2 flex h-6 w-6 -translate-y-1/2 items-center justify-center rounded-md text-[#8D877D] transition hover:bg-[#F2EFE8] hover:text-[#24221E]"
                                    aria-label="Clear search"
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
                                            stroke-width="2"
                                            d="M6 6l12 12M18 6 6 18"
                                        />
                                    </svg>

                                </button>

                            </div>


                            {{-- SEARCH BUTTON --}}
                            <button
                                type="submit"
                                class="inline-flex h-9 shrink-0 items-center justify-center gap-1.5 rounded-lg bg-[#11110F] px-3.5 text-xs font-semibold text-white shadow-sm transition hover:bg-[#292824] focus:outline-none focus:ring-2 focus:ring-[#11110F]/30"
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
                                        stroke-width="2"
                                        d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"
                                    />
                                </svg>

                                Search

                            </button>

                        </div>

                    </form>

                </div>

            </div>


            {{-- ========================================= --}}
            {{-- INVOICE TABLE --}}
            {{-- ========================================= --}}

            <div class="overflow-hidden rounded-xl border border-[#E5E2DB] bg-white shadow-sm">

                @if ($invoices->count())

                    <div class="overflow-x-auto">

                        <table class="min-w-[850px] w-full">

                            <thead>

                                <tr class="border-b border-[#E5E2DB] bg-[#F7F4ED]">

                                    <th
                                        class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]"
                                    >
                                        Client
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]"
                                    >
                                        Case Number
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]"
                                    >
                                        Amount
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]"
                                    >
                                        Status
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]"
                                    >
                                        Due Date
                                    </th>

                                    <th
                                        class="px-6 py-4 text-right text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]"
                                    >
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-[#EEEAE1]">

                                @foreach ($invoices as $invoice)

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

                                                <div
                                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#11110F] text-sm font-semibold text-[#D8BE8A]"
                                                >
                                                    {{ strtoupper(substr($clientName, 0, 1)) }}
                                                </div>

                                                <div class="min-w-0">

                                                    <p class="truncate text-sm font-semibold text-[#11110F]">
                                                        {{ $clientName }}
                                                    </p>

                                                    @if ($invoice->client?->email)

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

                                                <span
                                                    class="text-[10px] font-semibold uppercase tracking-wide text-[#B89452]"
                                                >
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

                                            @if ($invoice->due_date)

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


                            @if ($invoices->hasPages())

                                <nav
                                    class="flex items-center gap-1"
                                    aria-label="Invoice pagination"
                                >

                                    {{-- PREVIOUS --}}

                                    @if ($invoices->onFirstPage())

                                        <span
                                            class="inline-flex h-9 cursor-not-allowed items-center justify-center gap-1.5 rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] px-3 text-xs font-semibold text-[#B8B5AE]"
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

                                    @foreach (
                                        $invoices->getUrlRange(
                                            max(1, $invoices->currentPage() - 2),
                                            min($invoices->lastPage(), $invoices->currentPage() + 2)
                                        ) as $page => $url
                                    )

                                        @if ($page == $invoices->currentPage())

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

                                    @if ($invoices->hasMorePages())

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
                                            class="inline-flex h-9 cursor-not-allowed items-center justify-center gap-1.5 rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] px-3 text-xs font-semibold text-[#B8B5AE]"
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

                        <div
                            class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl border border-[#E5E2DB] bg-[#F7F4ED] text-[#C9A96E]"
                        >

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

                            @if (request('search') || request('status'))

                                No invoices match the current filters.

                            @else

                                No invoices have been created yet.

                            @endif

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


    {{-- ========================================= --}}
    {{-- ALPINE.JS --}}
    {{-- ========================================= --}}

    <script>
        function invoiceSearch() {
            return {

                search: @js(request('search', '')),

                loading: false,

                timer: null,


                init() {
                    this.search = @js(request('search', ''));
                },


                handleInput() {

                    clearTimeout(this.timer);

                    this.loading = false;


                    this.timer = setTimeout(() => {

                        this.searchNow();

                    }, 600);

                },


                searchNow() {

                    clearTimeout(this.timer);


                    const value = this.search.trim();


                    const url = new URL(
                        '{{ route('accountant.invoices.index') }}',
                        window.location.origin
                    );


                    // Add search
                    if (value !== '') {

                        url.searchParams.set(
                            'search',
                            value
                        );

                    }


                    // Keep current status
                    const status = @js(request('status', ''));


                    if (status !== '') {

                        url.searchParams.set(
                            'status',
                            status
                        );

                    }


                    // Reset pagination
                    url.searchParams.delete('page');


                    this.loading = true;


                    window.location.href = url.toString();

                },


                clearSearch() {

                    clearTimeout(this.timer);


                    this.search = '';


                    const url = new URL(
                        '{{ route('accountant.invoices.index') }}',
                        window.location.origin
                    );


                    // Keep current status
                    const status = @js(request('status', ''));


                    if (status !== '') {

                        url.searchParams.set(
                            'status',
                            status
                        );

                    }


                    // Remove search
                    url.searchParams.delete('search');


                    // Reset pagination
                    url.searchParams.delete('page');


                    this.loading = true;


                    window.location.href = url.toString();

                }

            };
        }
    </script>

@endsection