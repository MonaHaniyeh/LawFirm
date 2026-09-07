@extends('layouts.app')

@section('title', 'Edit Invoice #' . $invoice->id)

@section('breadcrumb', 'Financial Workspace / Invoices / Edit Invoice')

@push('styles')
<style>
    .invoice-edit {
        max-width: 920px;
    }

    .eyebrow {
        color: var(--gold);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .17em;
        text-transform: uppercase;
        margin-bottom: 7px;
    }

    .invoice-edit h1 {
        margin: 0;
        font-family: "Cormorant Garamond", serif;
        font-size: 46px;
        line-height: .95;
        font-weight: 600;
        color: var(--ink);
    }

    .reference {
        margin-top: 8px;
        color: var(--muted);
        font-family: "IBM Plex Mono", monospace;
        font-size: 11px;
    }

    .form-card {
        margin-top: 25px;
        padding: 30px;
        background: var(--paper, #ffffff);
        border: 1px solid var(--line);
        border-radius: 9px;
    }

    .grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 23px;
    }

    .full {
        grid-column: 1 / -1;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #37342f;
        font-size: 11px;
        font-weight: 700;
    }

    .required {
        color: var(--gold);
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        border: 1px solid var(--line);
        border-radius: 6px;
        background: #faf9f6;
        color: var(--ink);
        font-family: inherit;
        font-size: 12px;
        outline: none;
        transition: border-color .2s ease, background .2s ease;
    }

    .form-group input,
    .form-group select {
        height: 45px;
        padding: 0 13px;
    }

    .form-group textarea {
        min-height: 150px;
        padding: 13px;
        resize: vertical;
        line-height: 1.6;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: var(--gold);
        background: #ffffff;
    }

    .money {
        font-family: "IBM Plex Mono", monospace !important;
    }

    .help {
        margin-top: 7px;
        color: #8b867c;
        font-size: 10px;
        line-height: 1.5;
    }

    .error {
        margin-top: 6px;
        color: var(--danger);
        font-size: 10px;
        line-height: 1.5;
    }

    .status-note {
        margin-top: 9px;
        padding: 11px 12px;
        border-radius: 6px;
        background: #f7f0df;
        color: #6d6046;
        font-size: 10px;
        line-height: 1.5;
    }

    .actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-top: 28px;
        padding-top: 22px;
        border-top: 1px solid #eeeae1;
    }

    .back {
        color: #706c64;
        text-decoration: none;
        font-size: 11px;
        font-weight: 600;
        transition: color .2s ease;
    }

    .back:hover {
        color: var(--ink);
    }

    .button {
        min-height: 44px;
        padding: 0 22px;
        border: 0;
        border-radius: 6px;
        background: var(--ink);
        color: #ffffff;
        font: inherit;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s ease, transform .2s ease;
    }

    .button:hover {
        background: #303030;
        transform: translateY(-1px);
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

    @media (max-width: 750px) {
        .invoice-edit h1 {
            font-size: 38px;
        }

        .form-card {
            padding: 20px;
        }

        .grid {
            grid-template-columns: 1fr;
        }

        .full {
            grid-column: auto;
        }

        .actions {
            flex-direction: column;
            align-items: stretch;
        }

        .button {
            width: 100%;
        }

        .back {
            text-align: center;
        }
    }
</style>
@endpush


@section('content')

<div class="invoice-edit">

    @if(session('success'))
        <div class="flash">
            {{ session('success') }}
        </div>
    @endif


    <div class="eyebrow">
        Financial Record
    </div>

    <h1>
        Edit invoice
    </h1>

    <div class="reference">
        INV-{{ $invoice->id }}
        ·
        Case {{ $invoice->case?->case_number ?? '—' }}
    </div>


    <div class="form-card">

        <form
            method="POST"
            action="{{ route('accountant.invoices.update', $invoice) }}"
        >

            @csrf
            @method('PUT')


            <div class="grid">

                {{-- Amount --}}
                <div class="form-group">

                    <label for="amount">
                        Amount <span class="required">*</span>
                    </label>

                    <input
                        type="number"
                        id="amount"
                        name="amount"
                        value="{{ old('amount', $invoice->amount) }}"
                        min="0"
                        step="0.01"
                        class="money"
                        required
                    >

                    <div class="help">
                        Currency: JOD
                    </div>

                    @error('amount')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Due date --}}
                <div class="form-group">

                    <label for="due_date">
                        Due date
                    </label>

                    <input
                        type="date"
                        id="due_date"
                        name="due_date"
                        value="{{ old(
                            'due_date',
                            $invoice->due_date
                                ? \Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d')
                                : ''
                        ) }}"
                        min="{{ now()->format('Y-m-d') }}"
                    >

                    <div class="help">
                        The due date cannot be earlier than today.
                    </div>

                    @error('due_date')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Description --}}
                <div class="form-group full">

                    <label for="description">
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        maxlength="1000"
                        placeholder="Enter invoice description..."
                    >{{ old('description', $invoice->description) }}</textarea>

                    <div class="help">
                        Maximum 1000 characters ·
                        <span id="counter">0 / 1000</span>
                    </div>

                    @error('description')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Status --}}
                <div class="form-group full">

                    <label for="status">
                        Status <span class="required">*</span>
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                    >

                        @foreach([
                            'draft' => 'Draft',
                            'sent' => 'Sent',
                            'paid' => 'Paid',
                            'overdue' => 'Overdue',
                            'void' => 'Void',
                        ] as $value => $label)

                            <option
                                value="{{ $value }}"
                                @selected(old('status', $invoice->status) === $value)
                            >
                                {{ $label }}
                            </option>

                        @endforeach

                    </select>


                    <div class="status-note">

                        <strong>Payment timestamp:</strong>

                        Marking this invoice as
                        <strong>Paid</strong>
                        will record today's date automatically.

                        You do not need to enter a paid date yourself.

                    </div>


                    @error('status')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>


            <div class="actions">

                <a
                    href="{{ route('accountant.invoices.show', $invoice) }}"
                    class="back"
                >
                    ← Cancel
                </a>

                <button
                    type="submit"
                    class="button"
                >
                    Update invoice
                </button>

            </div>

        </form>

    </div>

</div>

@endsection


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const description = document.getElementById('description');
        const counter = document.getElementById('counter');

        if (!description || !counter) {
            return;
        }

        function updateCounter() {
            counter.textContent =
                `${description.value.length} / 1000`;
        }

        description.addEventListener('input', updateCounter);

        updateCounter();
    });
</script>
@endpush
