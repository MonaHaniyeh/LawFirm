@extends('layouts.app')

@section('title', 'Edit Case · ' . $case->case_number)

@section('breadcrumb')
    <a href="{{ route('lawyer.cases.index') }}">My Cases</a>
    <span>/</span>

    <a href="{{ route('lawyer.cases.show', $case) }}">
        {{ $case->case_number }}
    </a>

    <span>/</span>

    <span class="breadcrumb-current">Edit</span>
@endsection

@push('styles')
<style>
    /* =========================
       PAGE HEADER
    ========================== */

    .page-header {
        margin-bottom: 34px;
    }

    .eyebrow {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .2em;
        color: var(--gold);
        font-weight: 700;
        margin-bottom: 8px;
    }

    .page-header h1 {
        margin: 0;
        font-family: "Cormorant Garamond", serif;
        font-size: 48px;
        line-height: .98;
        font-weight: 600;
        letter-spacing: -.02em;
    }

    .page-description {
        margin: 12px 0 0;
        max-width: 600px;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.7;
    }


    /* =========================
       CASE CONTEXT
    ========================== */

    .context-card {
        background: var(--paper);
        border: 1px solid var(--line);
        margin-bottom: 22px;
    }

    .context-header {
        padding: 18px 22px;
        border-bottom: 1px solid var(--line);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .context-title {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .readonly-label {
        color: var(--muted);
        font-size: 10px;
    }

    .context-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
    }

    .context-item {
        padding: 20px 22px;
        border-right: 1px solid var(--line);
    }

    .context-item:last-child {
        border-right: 0;
    }

    .context-label {
        color: var(--muted);
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .12em;
        margin-bottom: 7px;
    }

    .context-value {
        color: var(--ink);
        font-size: 13px;
        font-weight: 600;
        line-height: 1.4;
    }

    .case-number {
        color: var(--gold);
        font-family: "DM Sans", sans-serif;
    }


    /* =========================
       FORM
    ========================== */

    .form-card {
        background: var(--paper);
        border: 1px solid var(--line);
    }

    .form-header {
        padding: 24px 28px;
        border-bottom: 1px solid var(--line);
    }

    .form-title {
        font-family: "Cormorant Garamond", serif;
        font-size: 29px;
        font-weight: 600;
        margin: 0 0 4px;
    }

    .form-subtitle {
        color: var(--muted);
        font-size: 12px;
        line-height: 1.6;
    }

    .case-edit-form {
        padding: 30px 28px;
    }

    .field {
        margin-bottom: 27px;
    }

    .field:last-of-type {
        margin-bottom: 0;
    }

    .field-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 9px;
    }

    .field-label label {
        font-size: 12px;
        font-weight: 700;
        color: var(--ink);
    }

    .field-hint {
        color: var(--muted);
        font-size: 10px;
    }

    .case-edit-form textarea,
    .case-edit-form input[type="date"],
    .case-edit-form select {
        width: 100%;
        border: 1px solid #d5d0c6;
        background: #fff;
        color: var(--ink);
        border-radius: 5px;
        outline: none;
        transition:
            border-color .2s ease,
            box-shadow .2s ease;
    }

    .case-edit-form textarea {
        min-height: 210px;
        resize: vertical;
        padding: 15px 16px;
        font-size: 13px;
        line-height: 1.75;
    }

    .case-edit-form input[type="date"],
    .case-edit-form select {
        height: 47px;
        padding: 0 14px;
        font-size: 13px;
    }

    .case-edit-form textarea:focus,
    .case-edit-form input[type="date"]:focus,
    .case-edit-form select:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(183,154,98,.10);
    }

    .case-edit-form textarea.is-invalid,
    .case-edit-form input.is-invalid,
    .case-edit-form select.is-invalid {
        border-color: var(--danger);
    }


    /* =========================
       CHARACTER COUNT
    ========================== */

    .character-row {
        display: flex;
        justify-content: space-between;
        margin-top: 7px;
        color: var(--muted);
        font-size: 10px;
    }


    /* =========================
       ERRORS
    ========================== */

    .error {
        color: var(--danger);
        font-size: 11px;
        margin-top: 7px;
    }


    /* =========================
       FORM GRID
    ========================== */

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }


    /* =========================
       STATUS
    ========================== */

    .status-help {
        margin-top: 7px;
        font-size: 10px;
        color: var(--muted);
        line-height: 1.5;
    }

    .end-date-help {
        margin-top: 7px;
        font-size: 10px;
        color: var(--muted);
        line-height: 1.5;
    }

    .end-date-help.closed {
        color: var(--gold);
    }


    /* =========================
       FORM FOOTER
    ========================== */

    .form-footer {
        margin: 6px -28px -30px;
        padding: 20px 28px;
        border-top: 1px solid var(--line);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .footer-note {
        color: var(--muted);
        font-size: 10px;
        line-height: 1.5;
    }

    .actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn {
        min-height: 43px;
        border-radius: 5px;
        padding: 0 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s ease;
    }

    .btn-secondary {
        border: 1px solid var(--line);
        background: transparent;
        color: var(--ink);
    }

    .btn-secondary:hover {
        background: #eeeae2;
    }

    .btn-primary {
        border: 1px solid var(--gold);
        background: var(--charcoal);
        color: #fff;
    }

    .btn-primary:hover {
        background: #000;
        border-color: var(--gold-light);
    }


    /* =========================
       FLASH MESSAGE
    ========================== */

    .case-alert {
        margin-bottom: 24px;
        padding: 13px 16px;
        border: 1px solid #d5c7a7;
        background: #f8f3e7;
        color: #6d5a35;
        font-size: 12px;
    }


    /* =========================
       RESPONSIVE
    ========================== */

    @media (max-width: 1050px) {

        .context-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .context-item:nth-child(3) {
            border-right: 0;
        }

        .context-item:nth-child(-n+3) {
            border-bottom: 1px solid var(--line);
        }

        .context-item:nth-child(4) {
            border-right: 1px solid var(--line);
        }
    }


    @media (max-width: 800px) {

        .page-header h1 {
            font-size: 40px;
        }

        .context-grid {
            grid-template-columns: 1fr 1fr;
        }

        .context-item {
            border-right: 0;
            border-bottom: 1px solid var(--line);
        }

        .context-item:nth-child(odd) {
            border-right: 1px solid var(--line);
        }

        .context-item:nth-last-child(-n+2) {
            border-bottom: 0;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .form-footer {
            flex-direction: column;
            align-items: stretch;
        }

        .actions {
            width: 100%;
        }

        .actions .btn {
            flex: 1;
        }
    }


    @media (max-width: 520px) {

        .context-grid {
            grid-template-columns: 1fr;
        }

        .context-item,
        .context-item:nth-child(odd) {
            border-right: 0;
            border-bottom: 1px solid var(--line);
        }

        .context-item:last-child {
            border-bottom: 0;
        }

        .form-header,
        .case-edit-form {
            padding-left: 20px;
            padding-right: 20px;
        }

        .form-footer {
            margin-left: -20px;
            margin-right: -20px;
            padding-left: 20px;
            padding-right: 20px;
        }

        .actions {
            flex-direction: column-reverse;
        }

        .actions .btn {
            width: 100%;
        }
    }
</style>
@endpush


@section('content')

    {{-- Flash message --}}
    @if(session('success'))
        <div class="case-alert">
            {{ session('success') }}
        </div>
    @endif


    {{-- =========================
         PAGE HEADER
    ========================== --}}

    <div class="page-header">

        <div class="eyebrow">
            Case Management
        </div>

        <h1>
            Edit case
        </h1>

        <p class="page-description">
            Update the official case record. Case identification
            details remain fixed after filing and are shown below
            for reference.
        </p>

    </div>


    {{-- =========================
         READ-ONLY CASE CONTEXT
    ========================== --}}

    <section class="context-card">

        <div class="context-header">

            <div class="context-title">
                Case reference
            </div>

            <div class="readonly-label">
                Read-only information
            </div>

        </div>


        <div class="context-grid">

            {{-- Case number --}}
            <div class="context-item">

                <div class="context-label">
                    Case number
                </div>

                <div class="context-value case-number">
                    {{ $case->case_number }}
                </div>

            </div>


            {{-- Case type --}}
            <div class="context-item">

                <div class="context-label">
                    Case type
                </div>

                <div class="context-value">
                    {{ $case->case_type }}
                </div>

            </div>


            {{-- Client --}}
            <div class="context-item">

                <div class="context-label">
                    Client
                </div>

                <div class="context-value">
                    {{ $case->client->name }}
                </div>

            </div>


            {{-- Start date --}}
            <div class="context-item">

                <div class="context-label">
                    Start date
                </div>

                <div class="context-value">

                    {{
                        $case->start_date
                            ? \Carbon\Carbon::parse($case->start_date)->format('d M Y')
                            : $case->created_at->format('d M Y')
                    }}

                </div>

            </div>


            {{-- Current status --}}
            <div class="context-item">

                <div class="context-label">
                    Current status
                </div>

                <div class="context-value">
                    {{ ucfirst($case->status) }}
                </div>

            </div>

        </div>

    </section>


    {{-- =========================
         EDIT FORM
    ========================== --}}

    <section class="form-card">

        <div class="form-header">

            <h2 class="form-title">
                Case record
            </h2>

            <div class="form-subtitle">
                Only the case description, status and end date
                can be changed from this page.
            </div>

        </div>


        <form
            method="POST"
            action="{{ route('lawyer.cases.update', $case) }}"
            class="case-edit-form"
        >

            @csrf
            @method('PUT')


            {{-- =========================
                 DESCRIPTION
            ========================== --}}

            <div class="field">

                <div class="field-label">

                    <label for="description">
                        Description
                    </label>

                    <span class="field-hint">
                        Minimum 10 characters
                    </span>

                </div>


                <textarea
                    id="description"
                    name="description"
                    minlength="10"
                    required
                    class="@error('description') is-invalid @enderror"
                    placeholder="Enter the official case description..."
                >{{ old('description', $case->description) }}</textarea>


                <div class="character-row">

                    <span>
                        Case description
                    </span>

                    <span id="characterCount">
                        0 characters
                    </span>

                </div>


                @error('description')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- =========================
                 STATUS + END DATE
            ========================== --}}

            <div class="form-grid">


                {{-- STATUS --}}

                <div class="field">

                    <div class="field-label">

                        <label for="status">
                            Status
                        </label>

                    </div>


                    <select
                        id="status"
                        name="status"
                        required
                        class="@error('status') is-invalid @enderror"
                    >

                        <option
                            value="Opened"
                            {{ old('status', $case->status) === 'Opened' ? 'selected' : '' }}
                        >
                            Opened
                        </option>

                        <option
                            value="Closed"
                            {{ old('status', $case->status) === 'Closed' ? 'selected' : '' }}
                        >
                            Closed
                        </option>

                    </select>


                    <div class="status-help">
                        Closing the case marks the matter as
                        completed. You can provide the end date
                        alongside it.
                    </div>


                    @error('status')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- END DATE --}}

                <div class="field">

                    <div class="field-label">

                        <label for="end_date">
                            End date
                        </label>

                        <span class="field-hint">
                            Optional
                        </span>

                    </div>


                    <input
                        type="date"
                        id="end_date"
                        name="end_date"
                        value="{{ old(
                            'end_date',
                            $case->end_date
                                ? \Carbon\Carbon::parse($case->end_date)->format('Y-m-d')
                                : ''
                        ) }}"
                        min="{{ $case->start_date
                            ? \Carbon\Carbon::parse($case->start_date)->format('Y-m-d')
                            : ''
                        }}"
                        class="@error('end_date') is-invalid @enderror"
                    >


                    <div
                        class="end-date-help"
                        id="endDateHelp"
                    >
                        Optional while the case is open.
                    </div>


                    @error('end_date')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>


            {{-- =========================
                 FORM FOOTER
            ========================== --}}

            <div class="form-footer">

                <div class="footer-note">
                    Changes will update the official case record
                    immediately after submission.
                </div>


                <div class="actions">

                    <a
                        href="{{ route('lawyer.cases.show', $case) }}"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Save changes
                    </button>

                </div>

            </div>

        </form>

    </section>

@endsection


@push('scripts')
<script>

    /* =========================
       DESCRIPTION CHARACTER COUNT
    ========================== */

    const description =
        document.getElementById('description');

    const characterCount =
        document.getElementById('characterCount');


    function updateCharacterCount() {

        if (!description || !characterCount) {
            return;
        }

        const length = description.value.length;

        characterCount.textContent =
            `${length} character${length === 1 ? '' : 's'}`;
    }


    if (description) {

        description.addEventListener(
            'input',
            updateCharacterCount
        );

        updateCharacterCount();
    }


    /* =========================
       STATUS / END DATE
    ========================== */

    const status =
        document.getElementById('status');

    const endDate =
        document.getElementById('end_date');

    const endDateHelp =
        document.getElementById('endDateHelp');


    function updateEndDateState() {

        if (!status || !endDateHelp) {
            return;
        }

        if (status.value === 'Closed') {

            endDateHelp.textContent =
                'A closing date is recommended when the case is closed.';

            endDateHelp.classList.add('closed');

        } else {

            endDateHelp.textContent =
                'Optional while the case is open.';

            endDateHelp.classList.remove('closed');
        }
    }


    if (status) {

        status.addEventListener(
            'change',
            updateEndDateState
        );

        updateEndDateState();
    }

</script>
@endpush
