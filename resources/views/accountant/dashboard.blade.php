@extends('layouts.app')

@section('title', 'Billing Overview | Law Firm')

@section('breadcrumb')
    Workspace / <span>Billing Overview</span>
@endsection

@section('content')

<div class="w-full">

    {{-- PAGE HEADER --}}
    <div class="mb-8 flex w-full flex-col items-start justify-between gap-6 lg:flex-row lg:items-start">

        {{-- LEFT --}}
        <div class="text-left">

            <div class="mb-2 text-[10px] font-bold uppercase tracking-[0.20em] text-amber-700">
                Financial Overview
            </div>

            <h1 class="m-0 font-serif text-4xl font-semibold leading-none tracking-tight text-stone-900 md:text-[43px]">
                Billing overview
            </h1>

            <p class="mt-3 max-w-[650px] text-left text-[13px] leading-7 text-stone-500">
                Monitor the firm's outstanding balances, recent payments,
                overdue invoices, and current billing activity.
            </p>

        </div>

    </div>


    {{-- STATISTICS --}}
    <div class="mb-6 grid grid-cols-1 gap-3.5 sm:grid-cols-2 xl:grid-cols-4">

        {{-- TOTAL OUTSTANDING --}}
        <div class="relative min-h-[145px] overflow-hidden rounded-lg border border-stone-200 border-t-2 border-t-amber-600 bg-white p-[22px]">

            <div class="text-[10px] font-bold uppercase tracking-[0.13em] text-stone-500">
                Total outstanding
            </div>

            <div class="mt-[18px] font-mono text-[25px] font-semibold leading-tight tracking-tight text-stone-900 md:text-[31px]">
                JOD {{ number_format($stats['total_outstanding'] ?? 0, 2) }}
            </div>

            <div class="mt-3 text-[10px] text-stone-400">
                Sent and overdue invoices
            </div>

        </div>


        {{-- PAID THIS MONTH --}}
        <div class="relative min-h-[145px] overflow-hidden rounded-lg border border-stone-200 bg-white p-[22px]">

            <div class="text-[10px] font-bold uppercase tracking-[0.13em] text-stone-500">
                Paid this month
            </div>

            <div class="mt-[18px] font-mono text-[25px] font-semibold leading-tight tracking-tight text-stone-900">
                JOD {{ number_format($stats['paid_this_month'] ?? 0, 2) }}
            </div>

            <div class="mt-3 text-[10px] text-stone-400">
                Current calendar month
            </div>

        </div>


        {{-- OVERDUE --}}
        <div class="relative min-h-[145px] overflow-hidden rounded-lg border border-stone-200 bg-white p-[22px]">

            <div class="text-[10px] font-bold uppercase tracking-[0.13em] text-stone-500">
                Overdue count
            </div>

            <div class="mt-[18px] font-mono text-[29px] font-semibold leading-tight text-stone-900">
                {{ number_format($stats['overdue_count'] ?? 0) }}
            </div>

            <div class="mt-3 text-[10px] text-stone-400">
                Invoices past their due date
            </div>

        </div>


        {{-- DRAFT --}}
        <div class="relative min-h-[145px] overflow-hidden rounded-lg border border-stone-200 bg-white p-[22px]">

            <div class="text-[10px] font-bold uppercase tracking-[0.13em] text-stone-500">
                Draft count
            </div>

            <div class="mt-[18px] font-mono text-[29px] font-semibold leading-tight text-stone-900">
                {{ number_format($stats['draft_count'] ?? 0) }}
            </div>

            <div class="mt-3 text-[10px] text-stone-400">
                Created but not yet sent
            </div>

        </div>

    </div>


    {{-- RECENT INVOICES --}}
    <section class="overflow-hidden rounded-lg border border-stone-200 bg-white">

        {{-- PANEL HEADER --}}
        <div class="flex min-h-[73px] flex-col items-start justify-between gap-4 border-b border-stone-200 px-[23px] py-[19px] sm:flex-row sm:items-center">

            <div class="text-left">

                <h2 class="m-0 font-serif text-[25px] font-semibold text-stone-900">
                    Recent invoices
                </h2>

                <div class="mt-1 text-[11px] text-stone-500">
                    The 10 most recently created invoices
                </div>

            </div>

            <a
                href="{{ route('accountant.invoices.index') }}"
                class="text-[11px] font-bold text-amber-700 no-underline hover:underline hover:underline-offset-4"
            >
                View all invoices →
            </a>

        </div>


        {{-- INVOICE TABLE --}}
        @if($recentInvoices->isNotEmpty())

            <div class="overflow-x-auto">

                <table class="w-full border-collapse">

                    <thead>
                        <tr>

                            <th class="bg-stone-100 px-[23px] py-[13px] text-left text-[9px] font-bold uppercase tracking-[0.13em] text-stone-500">
                                Client
                            </th>

                            <th class="bg-stone-100 px-[23px] py-[13px] text-left text-[9px] font-bold uppercase tracking-[0.13em] text-stone-500">
                                Case number
                            </th>

                            <th class="bg-stone-100 px-[23px] py-[13px] text-left text-[9px] font-bold uppercase tracking-[0.13em] text-stone-500">
                                Amount
                            </th>

                            <th class="bg-stone-100 px-[23px] py-[13px] text-left text-[9px] font-bold uppercase tracking-[0.13em] text-stone-500">
                                Status
                            </th>

                            <th class="bg-stone-100 px-[23px] py-[13px] text-left text-[9px] font-bold uppercase tracking-[0.13em] text-stone-500">
                                Due date
                            </th>

                            <th class="bg-stone-100 px-[23px] py-[13px] text-left text-[9px] font-bold uppercase tracking-[0.13em] text-stone-500">
                                Action
                            </th>

                        </tr>
                    </thead>

                    <tbody>

                        @foreach($recentInvoices as $invoice)

                            <tr class="transition-colors duration-150 hover:bg-stone-50">

                                {{-- CLIENT --}}
                                <td class="border-t border-stone-200 px-[23px] py-[17px] text-xs">

                                    <div class="font-semibold text-stone-900">
                                        {{ $invoice->client->name ?? '—' }}
                                    </div>

                                </td>


                                {{-- CASE --}}
                                <td class="border-t border-stone-200 px-[23px] py-[17px] text-xs">

                                    <span class="font-mono text-[11px] text-stone-500">
                                        {{ $invoice->case->case_number ?? '—' }}
                                    </span>

                                </td>


                                {{-- AMOUNT --}}
                                <td class="border-t border-stone-200 px-[23px] py-[17px] text-xs">

                                    <span class="font-mono text-xs font-medium tracking-tight text-stone-900">
                                        JOD {{ number_format($invoice->amount ?? 0, 2) }}
                                    </span>

                                </td>


                                {{-- STATUS --}}
                                <td class="border-t border-stone-200 px-[23px] py-[17px] text-xs">

                                    @php
                                        $status = strtolower($invoice->status ?? 'draft');

                                        $statusClasses = match ($status) {
                                            'paid' => 'bg-green-50 text-green-700',
                                            'sent' => 'bg-stone-100 text-stone-600',
                                            'overdue' => 'bg-red-50 text-red-700',
                                            'pending' => 'bg-amber-50 text-amber-700',
                                            default => 'bg-stone-100 text-stone-500',
                                        };
                                    @endphp

                                    <span class="inline-flex min-w-[72px] items-center justify-center gap-1.5 rounded-full px-2.5 py-1.5 text-[9px] font-bold uppercase tracking-[0.08em] {{ $statusClasses }}">

                                        <span class="h-[5px] w-[5px] rounded-full bg-current"></span>

                                        {{ ucfirst($status) }}

                                    </span>

                                </td>


                                {{-- DUE DATE --}}
                                <td class="border-t border-stone-200 px-[23px] py-[17px] text-xs">

                                    <span class="text-stone-600">
                                        {{ $invoice->due_date
                                            ? \Carbon\Carbon::parse($invoice->due_date)->format('d M Y')
                                            : '—'
                                        }}
                                    </span>

                                </td>


                                {{-- ACTION --}}
                                <td class="border-t border-stone-200 px-[23px] py-[17px] text-xs">

                                    <a
                                        href="{{ route('accountant.invoices.show', $invoice) }}"
                                        class="text-[11px] font-bold text-amber-700 no-underline hover:underline hover:underline-offset-4"
                                    >
                                        View
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            {{-- EMPTY STATE --}}
            <div class="px-6 py-[68px] text-center">

                <div class="mx-auto mb-[17px] flex h-12 w-12 items-center justify-center rounded-full border border-stone-200 bg-stone-100 text-amber-700">

                    <svg
                        width="21"
                        height="21"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.6"
                    >
                        <path d="M6 3h12a2 2 0 0 1 2 2v16l-3-2-3 2-3-2-3 2-3-2-3 2V5a2 2 0 0 1 2-2z"/>
                        <path d="M8 8h8"/>
                        <path d="M8 12h5"/>
                    </svg>

                </div>

                <h3 class="m-0 font-serif text-2xl font-semibold text-stone-900">
                    No invoices have been created
                </h3>

                <p class="mx-auto mb-5 mt-2 max-w-[390px] text-xs leading-relaxed text-stone-500">
                    Once an invoice is created, your recent billing
                    activity will appear here.
                </p>

                <a
                    href="{{ route('accountant.invoices.create') }}"
                    class="inline-flex items-center justify-center rounded-md bg-stone-900 px-[18px] py-3 text-xs font-bold text-white no-underline transition hover:bg-stone-800"
                >
                    Create invoice
                </a>

            </div>

        @endif

    </section>

</div>

@endsection
