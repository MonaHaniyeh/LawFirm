@extends('layouts.app')

@section('title', 'Billing')

@section('content')
@php
    use App\Models\Invoice;

    $invoices = Invoice::with(['client', 'case'])
        ->latest()
        ->take(10)
        ->get();

    $totalBilled = Invoice::sum('amount');

    $paid = Invoice::where('status', 'paid')
        ->sum('amount');

    $outstanding = Invoice::whereIn('status', [
        'draft',
        'sent',
        'overdue',
    ])->sum('amount');

    $overdue = Invoice::where('status', 'overdue')
        ->sum('amount');
@endphp

<div class="min-h-screen bg-[#F7F4ED]">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

        {{-- ========================================================= --}}
        {{-- PAGE HEADER --}}
        {{-- ========================================================= --}}
        <div class="mb-8">

            {{-- Breadcrumb --}}
            <div class="mb-3 flex items-center gap-2 text-sm text-[#9B9992]">
                <a
                    href="{{ route('accountant.dashboard') }}"
                    class="transition hover:text-[#C9A96E]"
                >
                    Financial Workspace
                </a>

                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.7"
                        d="M9 5l7 7-7 7"
                    />
                </svg>

                <span class="text-[#41403C]">
                    Billing
                </span>
            </div>

            <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

                <div>
                    <p class="mb-2 text-xs font-semibold uppercase tracking-[0.12em] text-[#C9A96E]">
                        Financial Workspace
                    </p>

                    <h1 class="font-serif text-3xl font-semibold tracking-tight text-[#11110F] sm:text-4xl">
                        Billing
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-[#77756F]">
                        Monitor firm billing, payments, outstanding balances,
                        and overdue invoices.
                    </p>
                </div>

                <a
                    href="{{ route('accountant.invoices.index') }}"
                    class="inline-flex h-11 items-center justify-center gap-2 rounded-lg border border-[#C9A96E] bg-white px-5 text-sm font-semibold text-[#7A6030] transition hover:bg-[#F7F4ED]"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M7 3h8l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M15 3v5h4M9 13h6M9 17h4"
                        />
                    </svg>

                    View Invoices
                </a>
            </div>
        </div>


        {{-- ========================================================= --}}
        {{-- FINANCIAL SUMMARY --}}
        {{-- ========================================================= --}}
        <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Total Billed --}}
            <div class="rounded-xl border border-[#E5E2DB] bg-white p-6">
                <div class="flex items-start justify-between gap-4">

                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                            Total Billed
                        </p>

                        <div class="mt-3 flex items-baseline gap-2">
                            <span class="text-sm font-medium text-[#77756F]">
                                JOD
                            </span>

                            <span class="truncate text-2xl font-semibold text-[#11110F]">
                                {{ number_format($totalBilled, 2) }}
                            </span>
                        </div>

                        <p class="mt-2 text-sm text-[#9B9992]">
                            All invoices
                        </p>
                    </div>

                    {{-- Small standalone icon --}}
                    <svg
                        class="mt-1 h-6 w-6 shrink-0 text-[#C9A96E]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M7 3h8l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M15 3v5h4M9 13h6M9 17h4"
                        />
                    </svg>

                </div>
            </div>


            {{-- Paid --}}
            <div class="rounded-xl border border-[#E5E2DB] bg-white p-6">
                <div class="flex items-start justify-between gap-4">

                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                            Paid
                        </p>

                        <div class="mt-3 flex items-baseline gap-2">
                            <span class="text-sm font-medium text-[#77756F]">
                                JOD
                            </span>

                            <span class="truncate text-2xl font-semibold text-[#11110F]">
                                {{ number_format($paid, 2) }}
                            </span>
                        </div>

                        <p class="mt-2 text-sm text-[#9B9992]">
                            Successfully collected
                        </p>
                    </div>

                    {{-- Small standalone icon --}}
                    <svg
                        class="mt-1 h-6 w-6 shrink-0 text-[#3D8B5A]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                            stroke-width="1.7"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M9 12l2 2 4-4"
                        />
                    </svg>

                </div>
            </div>


            {{-- Outstanding --}}
            <div class="rounded-xl border border-[#E5E2DB] bg-white p-6">
                <div class="flex items-start justify-between gap-4">

                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                            Outstanding
                        </p>

                        <div class="mt-3 flex items-baseline gap-2">
                            <span class="text-sm font-medium text-[#77756F]">
                                JOD
                            </span>

                            <span class="truncate text-2xl font-semibold text-[#11110F]">
                                {{ number_format($outstanding, 2) }}
                            </span>
                        </div>

                        <p class="mt-2 text-sm text-[#9B9992]">
                            Pending collection
                        </p>
                    </div>

                    {{-- Small standalone icon --}}
                    <svg
                        class="mt-1 h-6 w-6 shrink-0 text-[#B98525]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                            stroke-width="1.7"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M12 8v4l2.5 2.5"
                        />
                    </svg>

                </div>
            </div>


            {{-- Overdue --}}
            <div class="rounded-xl border border-[#E5E2DB] bg-white p-6">
                <div class="flex items-start justify-between gap-4">

                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                            Overdue
                        </p>

                        <div class="mt-3 flex items-baseline gap-2">
                            <span class="text-sm font-medium text-[#77756F]">
                                JOD
                            </span>

                            <span class="truncate text-2xl font-semibold text-[#11110F]">
                                {{ number_format($overdue, 2) }}
                            </span>
                        </div>

                        <p class="mt-2 text-sm text-[#9B9992]">
                            Requires attention
                        </p>
                    </div>

                    {{-- Small standalone icon --}}
                    <svg
                        class="mt-1 h-6 w-6 shrink-0 text-[#B94A48]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M10.3 4.5L3.8 16a2 2 0 001.7 3h13a2 2 0 001.7-3L13.7 4.5a2 2 0 00-3.4 0z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M12 9v4"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 16h.01"
                        />
                    </svg>

                </div>
            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- BILLING OVERVIEW --}}
        {{-- ========================================================= --}}
        <div class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white">

            {{-- Card Header --}}
            <div class="border-b border-[#E5E2DB] px-6 py-5 sm:px-7">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#F7F4ED]">
                            <svg
                                class="h-5 w-5 text-[#C9A96E]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M7 3h8l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M15 3v5h4M9 13h6M9 17h4"
                                />
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-[#11110F]">
                                Billing Overview
                            </h2>

                            <p class="mt-0.5 text-sm text-[#9B9992]">
                                Recent firm billing activity
                            </p>
                        </div>
                    </div>

                    <a
                        href="{{ route('accountant.invoices.index') }}"
                        class="text-sm font-semibold text-[#8A6D39] transition hover:text-[#C9A96E]"
                    >
                        Manage All Invoices
                    </a>
                </div>
            </div>


            {{-- ===================================================== --}}
            {{-- DESKTOP TABLE --}}
            {{-- ===================================================== --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="min-w-full divide-y divide-[#E5E2DB]">

                    <thead class="bg-[#F7F4ED]">
                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                Invoice
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                Client
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                Case
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                Amount
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                Status
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                Due Date
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                Action
                            </th>

                        </tr>
                    </thead>


                    <tbody class="divide-y divide-[#E5E2DB]">

                        @forelse($invoices as $invoice)

                            @php
                                $status = strtolower($invoice->status ?? 'draft');

                                $statusClasses = match ($status) {
                                    'paid' => 'bg-[#EFF8F2] text-[#27633D] border-[#CDE7D5]',
                                    'overdue' => 'bg-[#FDF0EF] text-[#7D302F] border-[#EBC8C6]',
                                    'sent' => 'bg-[#EEF5F8] text-[#315868] border-[#D0E2E8]',
                                    'void', 'cancelled', 'canceled' => 'bg-[#F0EFEC] text-[#77756F] border-[#D8D5CE]',
                                    default => 'bg-[#FFF8E8] text-[#795A18] border-[#E8D6A7]',
                                };

                                $statusLabel = ucfirst($status);
                            @endphp

                            <tr class="transition hover:bg-[#FAF9F6]">

                                {{-- Invoice --}}
                                <td class="whitespace-nowrap px-6 py-5">
                                    <div class="flex items-center gap-3">

                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#11110F]">
                                            <svg
                                                class="h-4 w-4 text-[#C9A96E]"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                aria-hidden="true"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.7"
                                                    d="M7 3h8l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.7"
                                                    d="M15 3v5h4M9 13h6M9 17h4"
                                                />
                                            </svg>
                                        </div>

                                        <div>
                                            <p class="font-mono text-sm font-semibold text-[#11110F]">
                                                #{{ $invoice->id }}
                                            </p>

                                            <p class="mt-0.5 text-xs text-[#9B9992]">
                                                {{ $invoice->created_at?->format('d M Y') }}
                                            </p>
                                        </div>

                                    </div>
                                </td>


                                {{-- Client --}}
                                <td class="whitespace-nowrap px-6 py-5">

                                    @if($invoice->client)
                                        <div class="flex items-center gap-3">

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#F7F4ED] text-sm font-semibold text-[#8A6D39]">
                                                {{ strtoupper(substr($invoice->client->name ?? 'C', 0, 1)) }}
                                            </div>

                                            <div>
                                                <p class="text-sm font-medium text-[#41403C]">
                                                    {{ $invoice->client->name }}
                                                </p>

                                                @if($invoice->client->email)
                                                    <p class="mt-0.5 text-xs text-[#9B9992]">
                                                        {{ $invoice->client->email }}
                                                    </p>
                                                @endif
                                            </div>

                                        </div>
                                    @else
                                        <span class="text-sm text-[#9B9992]">
                                            Unknown client
                                        </span>
                                    @endif

                                </td>


                                {{-- Case --}}
                                <td class="whitespace-nowrap px-6 py-5">

                                    @if($invoice->case)

                                        <div class="flex items-center gap-2">

                                            <svg
                                                class="h-4 w-4 shrink-0 text-[#C9A96E]"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                aria-hidden="true"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.7"
                                                    d="M7 3h8l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.7"
                                                    d="M15 3v5h4"
                                                />
                                            </svg>

                                            <span class="font-mono text-sm text-[#41403C]">
                                                {{ $invoice->case->case_number ?? 'Case #' . $invoice->case->id }}
                                            </span>

                                        </div>

                                    @else

                                        <span class="text-sm text-[#9B9992]">
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- Amount --}}
                                <td class="whitespace-nowrap px-6 py-5 text-right">

                                    <span class="text-sm font-semibold text-[#11110F]">
                                        JOD {{ number_format($invoice->amount, 2) }}
                                    </span>

                                </td>


                                {{-- Status --}}
                                <td class="whitespace-nowrap px-6 py-5">

                                    <span class="inline-flex items-center rounded-md border px-2.5 py-1 text-xs font-semibold {{ $statusClasses }}">
                                        {{ $statusLabel }}
                                    </span>

                                </td>


                                {{-- Due Date --}}
                                <td class="whitespace-nowrap px-6 py-5">

                                    @if($invoice->due_date)

                                        <div class="flex items-center gap-2 text-sm text-[#41403C]">

                                            <svg
                                                class="h-4 w-4 shrink-0 text-[#C9A96E]"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                aria-hidden="true"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.7"
                                                    d="M8 7V3m8 4V3m-9 5h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                />
                                            </svg>

                                            {{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}

                                        </div>

                                    @else

                                        <span class="text-sm text-[#9B9992]">
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- Action --}}
                                <td class="whitespace-nowrap px-6 py-5 text-right">

                                    <a
                                        href="{{ route('accountant.invoices.show', $invoice) }}"
                                        class="inline-flex items-center gap-1.5 rounded-lg border border-[#D4D1CA] bg-white px-3 py-2 text-xs font-semibold text-[#41403C] transition hover:border-[#C9A96E] hover:text-[#8A6D39]"
                                    >
                                        View

                                        <svg
                                            class="h-3.5 w-3.5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.7"
                                                d="M9 5l7 7-7 7"
                                            />
                                        </svg>
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">

                                    <div class="mx-auto flex max-w-sm flex-col items-center">

                                        <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-[#F7F4ED]">
                                            <svg
                                                class="h-7 w-7 text-[#C9A96E]"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                aria-hidden="true"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.7"
                                                    d="M7 3h8l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.7"
                                                    d="M15 3v5h4"
                                                />
                                            </svg>
                                        </div>

                                        <h3 class="mt-4 text-base font-semibold text-[#11110F]">
                                            No billing records
                                        </h3>

                                        <p class="mt-1 text-sm leading-6 text-[#9B9992]">
                                            There are currently no invoices to display.
                                        </p>

                                        <a
                                            href="{{ route('accountant.invoices.create') }}"
                                            class="mt-5 inline-flex h-10 items-center gap-2 rounded-lg bg-[#C9A96E] px-4 text-sm font-semibold text-[#11110F] transition hover:bg-[#D8BE8A]"
                                        >
                                            Create Invoice
                                        </a>

                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- ===================================================== --}}
            {{-- MOBILE CARDS --}}
            {{-- ===================================================== --}}
            <div class="divide-y divide-[#E5E2DB] md:hidden">

                @forelse($invoices as $invoice)

                    @php
                        $status = strtolower($invoice->status ?? 'draft');

                        $statusClasses = match ($status) {
                            'paid' => 'bg-[#EFF8F2] text-[#27633D] border-[#CDE7D5]',
                            'overdue' => 'bg-[#FDF0EF] text-[#7D302F] border-[#EBC8C6]',
                            'sent' => 'bg-[#EEF5F8] text-[#315868] border-[#D0E2E8]',
                            'void', 'cancelled', 'canceled' => 'bg-[#F0EFEC] text-[#77756F] border-[#D8D5CE]',
                            default => 'bg-[#FFF8E8] text-[#795A18] border-[#E8D6A7]',
                        };
                    @endphp

                    <div class="p-5">

                        <div class="flex items-start justify-between gap-4">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#11110F]">
                                    <svg
                                        class="h-4 w-4 text-[#C9A96E]"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.7"
                                            d="M7 3h8l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.7"
                                            d="M15 3v5h4"
                                        />
                                    </svg>
                                </div>

                                <div>
                                    <p class="font-mono text-sm font-semibold text-[#11110F]">
                                        #{{ $invoice->id }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-[#9B9992]">
                                        {{ $invoice->created_at?->format('d M Y') }}
                                    </p>
                                </div>

                            </div>

                            <span class="inline-flex shrink-0 items-center rounded-md border px-2.5 py-1 text-xs font-semibold {{ $statusClasses }}">
                                {{ ucfirst($status) }}
                            </span>

                        </div>


                        <div class="mt-5 space-y-4">

                            {{-- Client --}}
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                    Client
                                </p>

                                <div class="mt-1 flex items-center gap-2">

                                    <div class="flex h-7 w-7 items-center justify-center rounded-full bg-[#F7F4ED] text-xs font-semibold text-[#8A6D39]">
                                        {{ strtoupper(substr($invoice->client->name ?? 'C', 0, 1)) }}
                                    </div>

                                    <span class="text-sm font-medium text-[#41403C]">
                                        {{ $invoice->client->name ?? 'Unknown client' }}
                                    </span>

                                </div>
                            </div>


                            {{-- Case --}}
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                    Case
                                </p>

                                <div class="mt-1 flex items-center gap-2">

                                    <svg
                                        class="h-4 w-4 text-[#C9A96E]"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.7"
                                            d="M7 3h8l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.7"
                                            d="M15 3v5h4"
                                        />
                                    </svg>

                                    <span class="font-mono text-sm text-[#41403C]">
                                        @if($invoice->case)
                                            {{ $invoice->case->case_number ?? 'Case #' . $invoice->case->id }}
                                        @else
                                            —
                                        @endif
                                    </span>

                                </div>
                            </div>


                            {{-- Amount --}}
                            <div class="flex items-center justify-between border-t border-[#E5E2DB] pt-4">

                                <span class="text-sm text-[#77756F]">
                                    Amount
                                </span>

                                <span class="text-base font-semibold text-[#11110F]">
                                    JOD {{ number_format($invoice->amount, 2) }}
                                </span>

                            </div>


                            {{-- Due Date --}}
                            <div class="flex items-center justify-between">

                                <span class="text-sm text-[#77756F]">
                                    Due Date
                                </span>

                                <span class="flex items-center gap-1.5 text-sm text-[#41403C]">

                                    <svg
                                        class="h-4 w-4 text-[#C9A96E]"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.7"
                                            d="M8 7V3m8 4V3m-9 5h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>

                                    @if($invoice->due_date)
                                        {{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}
                                    @else
                                        —
                                    @endif

                                </span>

                            </div>

                        </div>


                        {{-- View --}}
                        <div class="mt-5">

                            <a
                                href="{{ route('accountant.invoices.show', $invoice) }}"
                                class="flex h-10 w-full items-center justify-center gap-2 rounded-lg border border-[#C9A96E] bg-white text-sm font-semibold text-[#8A6D39] transition hover:bg-[#F7F4ED]"
                            >
                                View Invoice

                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.7"
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                            </a>

                        </div>

                    </div>

                @empty

                    <div class="px-5 py-12 text-center">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-[#F7F4ED]">
                            <svg
                                class="h-7 w-7 text-[#C9A96E]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M7 3h8l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M15 3v5h4"
                                />
                            </svg>
                        </div>

                        <h3 class="mt-4 text-base font-semibold text-[#11110F]">
                            No billing records
                        </h3>

                        <p class="mt-1 text-sm text-[#9B9992]">
                            There are currently no invoices to display.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- FOOTER ACTION --}}
        {{-- ========================================================= --}}
        <div class="mt-6 flex justify-center">

            <a
                href="{{ route('accountant.invoices.index') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-[#8A6D39] transition hover:text-[#C9A96E]"
            >
                View all invoices

                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.7"
                        d="M5 12h14M13 6l6 6-6 6"
                    />
                </svg>
            </a>

        </div>

    </div>
</div>
@endsection