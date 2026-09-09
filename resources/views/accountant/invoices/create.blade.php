@extends('layouts.app')

@section('title', 'Create Invoice')

@section('breadcrumb', 'Financial Workspace')

@push('styles')
<style>
    .invoice-create {
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

    .invoice-create h1 {
        margin: 0;
        font-family: "Cormorant Garamond", serif;
        font-size: 46px;
        line-height: .95;
        font-weight: 600;
        color: var(--ink);
    }

    .intro {
        margin-top: 10px;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.7;
    }

    .draft-note {
        margin-top: 24px;
        padding: 15px 17px;
        border: 1px solid #ddd2b8;
        background: #f7f0df;
        border-radius: 7px;
        color: #6d6046;
        font-size: 12px;
        line-height: 1.6;
    }

    .form-card {
        margin-top: 22px;
        background: var(--paper-white, #ffffff);
        border: 1px solid var(--line);
        border-radius: 9px;
        padding: 30px;
    }

    .invoice-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 23px;
    }

    .form-full {
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
        transition:
            border-color .2s ease,
            background .2s ease,
            box-shadow .2s ease;
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
        box-shadow: 0 0 0 3px rgba(201, 169, 110, 0.10);
    }

    .help {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-top: 6px;
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

    .create-button {
        border: 0;
        min-height: 44px;
        padding: 0 22px;
        border-radius: 6px;
        background: var(--ink);
        color: #ffffff;
        font: inherit;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition:
            background .2s ease,
            transform .2s ease;
    }

    .create-button:hover {
        background: #303030;
        transform: translateY(-1px);
    }

    .money {
        font-family: "IBM Plex Mono", monospace !important;
    }

    .status-preview {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 7px;
        color: #8b867c;
        font-size: 10px;
    }

    .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #a89d8b;
    }

    @media (max-width: 750px) {
        .invoice-create h1 {
            font-size: 38px;
        }

        .form-card {
            padding: 20px;
        }

        .invoice-form-grid {
            grid-template-columns: 1fr;
        }

        .form-full {
            grid-column: auto;
        }

        .actions {
            flex-direction: column;
            align-items: stretch;
        }

        .create-button {
            width: 100%;
        }

        .back {
            text-align: center;
        }
    }
</style>
@endpush


@section('content')

<div class="invoice-create">

    {{-- Header --}}
    <div class="eyebrow">
        Financial Records
    </div>

    <h1>
        Create invoice
    </h1>

    <div class="intro">
        Generate a new invoice against an open case.
        The client and accountant are assigned automatically.
    </div>


    {{-- Draft Notice --}}
    <div class="draft-note">
        <strong>Invoice status.</strong>
        Choose the current status below.
        Draft is selected by default.
    </div>


    {{-- Form --}}
    <div class="form-card">

        <form
            method="POST"
            action="{{ route('accountant.invoices.store') }}"
        >

            @csrf

            <div class="invoice-form-grid">

                {{-- Case --}}
                <div class="form-group form-full">

                    <label for="case_id">
                        Case <span class="required">*</span>
                    </label>

                    <select
                        name="case_id"
                        id="case_id"
                        required
                    >

                        <option value="">
                            Select an open case
                        </option>

                        @foreach($cases as $case)

                            <option
                                value="{{ $case->id }}"
                                @selected(old('case_id') == $case->id)
                            >
                                {{ $case->case_number }}
                                —
                                {{ $case->client?->name ?? 'Unknown client' }}
                            </option>

                        @endforeach

                    </select>

                    <div class="help">
                        <span>
                            Only open cases are available for invoicing.
                        </span>
                    </div>

                    @error('case_id')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Amount --}}
                <div class="form-group">

                    <label for="amount">
                        Amount <span class="required">*</span>
                    </label>

                    <input
                        type="number"
                        name="amount"
                        id="amount"
                        value="{{ old('amount') }}"
                        min="0"
                        step="0.01"
                        placeholder="0.00"
                        class="money"
                        required
                    >

                    <div class="help">
                        <span>
                            Currency: JOD
                        </span>
                    </div>

                    @error('amount')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Due Date --}}
                <div class="form-group">

                    <label for="due_date">
                        Due date
                    </label>

                    <input
                        type="date"
                        name="due_date"
                        id="due_date"
                        value="{{ old('due_date') }}"
                        min="{{ now()->format('Y-m-d') }}"
                    >

                    <div class="help">
                        <span>
                            Leave blank if no due date has been set.
                        </span>
                    </div>

                    @error('due_date')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Status --}}
                <div class="form-group">

                    <label for="status">
                        Status <span class="required">*</span>
                    </label>

                    <select
                        name="status"
                        id="status"
                        required
                    >

                        <option
                            value="draft"
                            @selected(old('status', 'draft') === 'draft')
                        >
                            Draft
                        </option>

                        <option
                            value="sent"
                            @selected(old('status') === 'sent')
                        >
                            Sent
                        </option>

                        <option
                            value="paid"
                            @selected(old('status') === 'paid')
                        >
                            Paid
                        </option>

                        <option
                            value="overdue"
                            @selected(old('status') === 'overdue')
                        >
                            Overdue
                        </option>

                        <option
                            value="void"
                            @selected(old('status') === 'void')
                        >
                            Void
                        </option>

                    </select>

                    <div class="status-preview">
                        <span class="status-dot"></span>
                        <span>
                            Draft is selected by default.
                        </span>
                    </div>

                    @error('status')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Description --}}
                <div class="form-group form-full">

                    <label for="description">
                        Description
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        maxlength="1000"
                        placeholder="e.g. Consultation and initial filing fees"
                    >{{ old('description') }}</textarea>

                    <div class="help">

                        <span>
                            Optional · Maximum 1000 characters
                        </span>

                        <span id="counter">
                            0 / 1000
                        </span>

                    </div>

                    @error('description')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>


            {{-- Actions --}}
            <div class="actions">

                <a
                    href="{{ route('accountant.invoices.index') }}"
                    class="back"
                >
                    ← Back to invoices
                </a>

                <button
                    type="submit"
                    class="create-button"
                >
                    Create invoice
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

        description.addEventListener(
            'input',
            updateCounter
        );

        updateCounter();
    });
</script>
@endpush