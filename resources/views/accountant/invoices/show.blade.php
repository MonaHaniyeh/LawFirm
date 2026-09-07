@extends('layouts.app')

@section('title', 'Invoice #' . $invoice->id)

@section('breadcrumb', 'Financial Workspace / Invoices / Invoice #' . $invoice->id)

@push('styles')
<style>
    .invoice-page {
        max-width: 1050px;
    }

    .invoice-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 25px;
        margin-bottom: 25px;
    }

    .eyebrow {
        color: var(--gold);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .17em;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .invoice-head h1 {
        margin: 0;
        font-family: "Cormorant Garamond", serif;
        font-size: 48px;
        font-weight: 600;
        line-height: .95;
        color: var(--ink);
    }

    .reference {
        margin-top: 9px;
        color: var(--muted);
        font-family: "IBM Plex Mono", monospace;
        font-size: 11px;
    }

    .actions {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .button {
        min-height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 18px;
        border-radius: 6px;
        background: var(--ink);
        color: #fff;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
        transition: background .2s ease, transform .2s ease;
    }

    .button:hover {
        background: #303030;
        transform: translateY(-1px);
    }

    .back-button {
        background: transparent;
        color: var(--ink);
        border: 1px solid var(--line);
    }

    .back-button:hover {
        background: #fff;
        color: var(--ink);
    }

    .badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 28px;
        padding: 0 11px;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
    }

    .draft {
        background: #eeeae2;
        color: #706b62;
    }

    .sent {
        background: #e8edf1;
        color: #5b6973;
    }

    .paid {
        background: #e5efe8;
        color: #49705a;
    }

    .overdue {
        background: #f2e2df;
        color: #9a5148;
    }

    .void {
        background: #e5e4e1;
        color: #777570;
    }

    .amount-card {
        padding: 27px 30px;
        margin-bottom: 18px;
        border: 1px solid var(--line);
        border-radius: 9px;
        background: var(--ink);
        color: #fff;
    }

    .amount-label {
        color: #9e9a92;
        font-size: 10px;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .amount {
        margin-top: 4px;
        font-family: "IBM Plex Mono", monospace;
        font-size: 35px;
        letter-spacing: -.05em;
    }

    .paid-note {
        margin-top: 7px;
        color: #a8c5b0;
        font-size: 11px;
    }

    .warning {
        margin-bottom: 18px;
        padding: 14px 17px;
        border: 1px solid #e2c7c2;
        border-radius: 7px;
        background: #f5e9e7;
        color: #8e514a;
        font-size: 12px;
        line-height: 1.6;
    }

    .flash {
        margin-bottom: 20px;
        padding: 13px 16px;
        border: 1px solid #c9dccd;
        background: var(--success-bg);
        color: var(--success);
        border-radius: 7px;
        font-size: 12px;
    }

    .panel {
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 9px;
        overflow: hidden;
    }

    .panel-title {
        padding: 18px 22px;
        border-bottom: 1px solid var(--line);
        font-family: "Cormorant Garamond", serif;
        font-size: 23px;
        font-weight: 600;
    }

    .details {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    .detail {
        padding: 19px 22px;
        border-bottom: 1px solid #eeeae1;
    }

    .detail:nth-child(odd) {
        border-right: 1px solid #eeeae1;
    }

    .label {
        margin-bottom: 6px;
        color: #8a857c;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .value {
        color: var(--ink);
        font-size: 13px;
        line-height: 1.6;
    }

    .description {
        grid-column: 1 / -1;
        min-height: 120px;
    }

    .case-number {
        font-family: "IBM Plex Mono", monospace;
        font-size: 11px;
    }

    .money {
        font-family: "IBM Plex Mono", monospace;
    }

    .bottom-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-top: 22px;
    }

    @media (max-width: 750px) {
        .invoice-head {
            flex-direction: column;
        }

        .invoice-head h1 {
            font-size: 40px;
        }

        .actions {
            width: 100%;
        }

        .actions .button {
            flex: 1;
        }

        .details {
            grid-template-columns: 1fr;
        }

        .detail:nth-child(odd) {
            border-right: 0;
        }

        .description {
            grid-column: auto;
        }

        .bottom-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .bottom-actions .button {
            width: 100%;
        }
    }
</style>
@endpush


@section('content')

@php
    $status = strtolower($invoice->status ?? 'draft');
@endphp

<div class="invoice-page">

    {{-- Success message --}}
    @if(session('success'))
        <div class="flash">
            {{ session('success') }}
        </div>
    @endif


    {{-- Header --}}
    <div class="invoice-head">

        <div>
            <div class="eyebrow">
                Invoice Record
            </div>

            <h1>
                INV-{{ $invoice->id }}
            </h1>

            <div class="reference">
                Case {{ $invoice->case?->case_number ?? '—' }}
            </div>
        </div>


        <div class="actions">

            <span class="badge {{ $status }}">
                {{ $status }}
            </span>

            <a
                href="{{ route('accountant.invoices.edit', $invoice) }}"
                class="button"
            >
                Edit invoice
            </a>

        </div>

    </div>


    {{-- Invoice amount --}}
    <div class="amount-card">

        <div class="amount-label">
            Invoice amount
        </div>

        <div class="amount">
            JOD {{ number_format((float) ($invoice->amount ?? 0), 2) }}
        </div>

        @if($status === 'paid' && $invoice->paid_at)

            <div class="paid-note">
                Paid on
                {{ \Carbon\Carbon::parse($invoice->paid_at)->format('d M Y, H:i') }}
            </div>

        @endif

    </div>


    {{-- Overdue warning --}}
    @if($status === 'overdue')

        <div class="warning">
            This invoice is overdue. Review the due date and payment
            status before taking further action.
        </div>

    @endif


    {{-- Invoice details --}}
    <div class="panel">

        <div class="panel-title">
            Invoice details
        </div>


        <div class="details">

            {{-- Client --}}
            <div class="detail">

                <div class="label">
                    Client
                </div>

                <div class="value">
                    {{ $invoice->client?->name ?? '—' }}
                </div>

            </div>


            {{-- Case --}}
            <div class="detail">

                <div class="label">
                    Case number
                </div>

                <div class="value case-number">
                    {{ $invoice->case?->case_number ?? '—' }}
                </div>

            </div>


            {{-- Due date --}}
            <div class="detail">

                <div class="label">
                    Due date
                </div>

                <div class="value">

                    @if($invoice->due_date)

                        {{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}

                    @else

                        —

                    @endif

                </div>

            </div>


            {{-- Paid date --}}
            <div class="detail">

                <div class="label">
                    Paid date
                </div>

                <div class="value">

                    @if($invoice->paid_at)

                        {{ \Carbon\Carbon::parse($invoice->paid_at)->format('d M Y, H:i') }}

                    @else

                        —

                    @endif

                </div>

            </div>


            {{-- Accountant --}}
            <div class="detail">

                <div class="label">
                    Accountant
                </div>

                <div class="value">
                    {{ $invoice->accountant?->name ?? '—' }}
                </div>

            </div>


            {{-- Amount --}}
            <div class="detail">

                <div class="label">
                    Amount
                </div>

                <div class="value money">
                    JOD {{ number_format((float) ($invoice->amount ?? 0), 2) }}
                </div>

            </div>


            {{-- Description --}}
            <div class="detail description">

                <div class="label">
                    Description
                </div>

                <div class="value">
                    {{ $invoice->description ?: 'No description was added to this invoice.' }}
                </div>

            </div>

        </div>

    </div>


    {{-- Bottom actions --}}
    <div class="bottom-actions">

        <a
            href="{{ route('accountant.invoices.index') }}"
            class="button back-button"
        >
            ← Back to invoices
        </a>

        <a
            href="{{ route('accountant.invoices.edit', $invoice) }}"
            class="button"
        >
            Edit invoice
        </a>

    </div>

</div>

@endsection
