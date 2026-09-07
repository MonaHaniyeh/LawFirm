@extends('layouts.app')

@section('title', 'Lawyer Dashboard')

@section('breadcrumb', 'Lawyer Workspace')

@push('styles')
<style>
    :root {
        --charcoal: #151515;
        --ivory: #f7f4ed;
        --paper: #ffffff;
        --muted: #7d7b76;
        --line: #e8e4dc;
        --gold: #b69a68;
        --gold-dark: #927849;
        --success: #3f7458;
        --success-bg: #edf5ef;
        --warning: #9a7336;
        --warning-bg: #fbf3e4;
        --danger: #9b4c48;
        --danger-bg: #faeeee;
    }

    .lawyer-dashboard {
        width: 100%;
        max-width: 1320px;
        margin: 0 auto;
    }

    /* =========================================
       PAGE HEADER
    ========================================= */

    .page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 30px;
        margin-bottom: 38px;
    }

    .eyebrow {
        margin-bottom: 7px;
        color: var(--gold-dark);
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .19em;
    }

    .page-title {
        margin: 0;
        color: var(--charcoal);
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(38px, 4vw, 52px);
        line-height: .95;
        font-weight: 600;
        letter-spacing: -.02em;
    }

    .page-description {
        margin: 13px 0 0;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.6;
    }

    /* =========================================
       STAT CARDS
    ========================================= */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 42px;
    }

    .stat-card {
        position: relative;
        overflow: hidden;
        min-height: 132px;
        padding: 25px 27px;
        background: var(--paper);
        border: 1px solid var(--line);
        transition:
            transform .2s ease,
            box-shadow .2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(25, 25, 25, .05);
    }

    .stat-card::after {
        content: "";
        position: absolute;
        right: -22px;
        bottom: -25px;
        width: 85px;
        height: 85px;
        border: 1px solid rgba(182, 154, 104, .16);
        border-radius: 50%;
    }

    .stat-label {
        color: var(--muted);
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .15em;
    }

    .stat-number {
        margin-top: 13px;
        color: var(--charcoal);
        font-family: 'Cormorant Garamond', serif;
        font-size: 42px;
        line-height: 1;
        font-weight: 600;
    }

    /* =========================================
       SECTIONS
    ========================================= */

    .section {
        margin-bottom: 42px;
    }

    .section-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 15px;
    }

    .section-title {
        margin: 0;
        color: var(--charcoal);
        font-family: 'Cormorant Garamond', serif;
        font-size: 28px;
        line-height: 1;
        font-weight: 600;
    }

    .section-caption {
        margin-top: 6px;
        color: var(--muted);
        font-size: 11px;
    }

    .section-count {
        color: var(--gold-dark);
        font-size: 11px;
        font-weight: 600;
    }

    /* =========================================
       CASE TABLE
    ========================================= */

    .table-card {
        overflow: hidden;
        background: var(--paper);
        border: 1px solid var(--line);
    }

    .case-table {
        width: 100%;
        border-collapse: collapse;
    }

    .case-table thead {
        background: #faf9f6;
    }

    .case-table th {
        padding: 14px 20px;
        color: #918d84;
        border-bottom: 1px solid var(--line);
        font-size: 9px;
        font-weight: 700;
        text-align: left;
        text-transform: uppercase;
        letter-spacing: .14em;
        white-space: nowrap;
    }

    .case-table td {
        padding: 18px 20px;
        color: #4d4b47;
        border-bottom: 1px solid #efede8;
        font-size: 12px;
        vertical-align: middle;
    }

    .case-table tbody tr:last-child td {
        border-bottom: none;
    }

    .case-table tbody tr {
        transition: background .15s ease;
    }

    .case-table tbody tr:hover {
        background: #fcfbf8;
    }

    .case-number {
        color: var(--charcoal);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .02em;
    }

    .case-type {
        color: #66635d;
    }

    .date {
        color: #77746d;
        white-space: nowrap;
    }

    .client-name {
        color: var(--charcoal);
        font-weight: 600;
    }

    /* =========================================
       STATUS
    ========================================= */

    .status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 9px;
        border-radius: 100px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        white-space: nowrap;
    }

    .status::before {
        content: "";
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-open {
        color: var(--success);
        background: var(--success-bg);
    }

    .status-pending {
        color: var(--warning);
        background: var(--warning-bg);
    }

    .status-closed,
    .status-completed {
        color: #686761;
        background: #f0efec;
    }

    .status-rejected {
        color: var(--danger);
        background: var(--danger-bg);
    }

    /* =========================================
       DETAILS LINK
    ========================================= */

    .details-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--gold-dark);
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
        transition: gap .2s ease;
    }

    .details-link:hover {
        gap: 9px;
        color: var(--charcoal);
    }

    .details-arrow {
        font-size: 14px;
    }

    /* =========================================
       PENDING APPOINTMENTS
    ========================================= */

    .attention-section {
        position: relative;
    }

    .attention-header {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .attention-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--gold);
        box-shadow: 0 0 0 4px rgba(182, 154, 104, .11);
    }

    .appointment-list {
        background: var(--paper);
        border: 1px solid var(--line);
    }

    .appointment-row {
        display: grid;
        grid-template-columns: 1.4fr 1.2fr 1fr auto;
        align-items: center;
        gap: 24px;
        padding: 19px 21px;
        border-bottom: 1px solid #efede8;
    }

    .appointment-row:last-child {
        border-bottom: none;
    }

    .appointment-row:hover {
        background: #fcfbf8;
    }

    .appointment-client {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 0;
    }

    .client-avatar {
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e3ded3;
        border-radius: 50%;
        color: var(--gold-dark);
        background: #f8f5ed;
        font-family: 'Cormorant Garamond', serif;
        font-size: 16px;
        font-weight: 600;
    }

    .appointment-client-name {
        color: var(--charcoal);
        font-size: 12px;
        font-weight: 600;
    }

    .appointment-label {
        margin-bottom: 4px;
        color: #aaa59b;
        font-size: 8px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .13em;
    }

    .appointment-value {
        color: #56534e;
        font-size: 11px;
    }

    .appointment-case {
        color: var(--gold-dark);
        font-size: 11px;
        font-weight: 600;
    }

    .appointment-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
    }

    /* =========================================
       ACTION BUTTONS
    ========================================= */

    .action-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 72px;
        padding: 8px 13px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 700;
        cursor: pointer;
        transition:
            background .2s ease,
            color .2s ease,
            border-color .2s ease;
    }

    .accept-button {
        color: #fff;
        background: var(--charcoal);
        border: 1px solid var(--charcoal);
    }

    .accept-button:hover {
        background: #2d2d2d;
    }

    .reject-button {
        color: #746e64;
        background: transparent;
        border: 1px solid #d9d4cb;
    }

    .reject-button:hover {
        color: var(--danger);
        border-color: #d9aaa7;
        background: var(--danger-bg);
    }

    /* =========================================
       EMPTY STATES
    ========================================= */

    .empty-state {
        padding: 50px 30px;
        text-align: center;
        background: var(--paper);
        border: 1px solid var(--line);
    }

    .empty-icon {
        width: 44px;
        height: 44px;
        margin: 0 auto 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ddd8ce;
        border-radius: 50%;
        color: var(--gold-dark);
    }

    .empty-icon svg {
        width: 19px;
        height: 19px;
        stroke-width: 1.4;
    }

    .empty-title {
        margin: 0;
        color: var(--charcoal);
        font-family: 'Cormorant Garamond', serif;
        font-size: 22px;
        font-weight: 600;
    }

    .empty-text {
        max-width: 360px;
        margin: 7px auto 0;
        color: var(--muted);
        font-size: 11px;
        line-height: 1.6;
    }

    /* =========================================
       RESPONSIVE
    ========================================= */

    @media (max-width: 1100px) {
        .appointment-row {
            grid-template-columns: 1fr 1fr;
        }

        .appointment-actions {
            justify-content: flex-start;
        }
    }

    @media (max-width: 850px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .page-header {
            display: block;
        }
    }

    @media (max-width: 680px) {
        .page-title {
            font-size: 40px;
        }

        .case-table {
            min-width: 760px;
        }

        .table-card {
            overflow-x: auto;
        }

        .appointment-row {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .appointment-actions {
            justify-content: flex-start;
        }

        .section-title {
            font-size: 25px;
        }
    }
</style>
@endpush

@section('content')

<div class="lawyer-dashboard">

    {{-- =========================================
         PAGE HEADER
    ========================================== --}}

    <header class="page-header">
        <div>
            <div class="eyebrow">
                Lawyer Workspace
            </div>

            <h1 class="page-title">
                Welcome back, {{ $lawyer->name }}
            </h1>

            <p class="page-description">
                Here's an overview of your active matters and requests
                that need your attention.
            </p>
        </div>
    </header>


    {{-- =========================================
         STATISTICS
    ========================================== --}}

    <section class="stats-grid">

        <div class="stat-card">
            <div class="stat-label">
                Open Cases
            </div>

            <div class="stat-number">
                {{ $stats['open_cases'] ?? 0 }}
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-label">
                Pending Appointments
            </div>

            <div class="stat-number">
                {{ $stats['pending_appointments'] ?? 0 }}
            </div>
        </div>


        <div class="stat-card">
            <div class="stat-label">
                Clients
            </div>

            <div class="stat-number">
                {{ $stats['clients'] ?? 0 }}
            </div>
        </div>

    </section>


    {{-- =========================================
         MY CASES
    ========================================== --}}

    <section class="section">

        <div class="section-header">

            <div>
                <h2 class="section-title">
                    My Cases
                </h2>

                <div class="section-caption">
                    Your most recently assigned matters
                </div>
            </div>

            <div class="section-count">
                {{ $cases->count() }} recent
            </div>

        </div>


        @if ($cases->isNotEmpty())

            <div class="table-card">

                <table class="case-table">

                    <thead>
                        <tr>
                            <th>Case Number</th>
                            <th>Type</th>
                            <th>Start Date</th>
                            <th>Status</th>
                            <th>Client</th>
                            <th></th>
                        </tr>
                    </thead>


                    <tbody>

                        @foreach ($cases as $case)

                            <tr>

                                {{-- Case number --}}

                                <td>
                                    <div class="case-number">
                                        {{ $case->case_number }}
                                    </div>
                                </td>


                                {{-- Type --}}

                                <td>
                                    <div class="case-type">
                                        {{ $case->case_type }}
                                    </div>
                                </td>


                                {{-- Start date --}}

                                <td>
                                    <div class="date">
                                        {{ $case->start_date?->format('M d, Y') ?? '—' }}
                                    </div>
                                </td>


                                {{-- Status --}}

                                <td>

                                    @php
                                        $status = strtolower(
                                            $case->status ?? ''
                                        );
                                    @endphp

                                    <span
                                        class="status
                                            @if ($status === 'opened')
                                                status-open
                                            @elseif ($status === 'closed')
                                                status-closed
                                            @elseif ($status === 'pending')
                                                status-pending
                                            @elseif ($status === 'rejected')
                                                status-rejected
                                            @else
                                                status-closed
                                            @endif
                                        "
                                    >
                                        {{ str_replace('_', ' ', $case->status ?? 'Unknown') }}
                                    </span>

                                </td>


                                {{-- Client --}}

                                <td>
                                    <div class="client-name">
                                        {{ $case->client?->name ?? '—' }}
                                    </div>
                                </td>


                                {{-- Details --}}

                                <td>

                                    <a
                                        href="{{ route('lawyer.cases.show', $case) }}"
                                        class="details-link"
                                    >
                                        Case details

                                        <span class="details-arrow">
                                            →
                                        </span>
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        aria-hidden="true"
                    >
                        <path
                            d="M4 7.5A2.5 2.5 0 0 1 6.5 5H10l2 2h5.5A2.5 2.5 0 0 1 20 9.5v7A2.5 2.5 0 0 1 17.5 19h-11A2.5 2.5 0 0 1 4 16.5v-9Z"
                            stroke="currentColor"
                            stroke-linejoin="round"
                        />
                    </svg>

                </div>

                <h3 class="empty-title">
                    No cases assigned
                </h3>

                <p class="empty-text">
                    Cases assigned to you will appear here once they
                    are available.
                </p>

            </div>

        @endif

    </section>


    {{-- =========================================
         PENDING APPOINTMENTS
    ========================================== --}}

    <section class="section attention-section">

        <div class="section-header">

            <div>

                <div class="attention-header">

                    <span class="attention-dot"></span>

                    <h2 class="section-title">
                        Pending Appointment Requests
                    </h2>

                </div>

                <div class="section-caption">
                    Requests waiting for your response
                </div>

            </div>


            @if ($pendingAppointments->isNotEmpty())

                <div class="section-count">
                    {{ $pendingAppointments->count() }} pending
                </div>

            @endif

        </div>


        @if ($pendingAppointments->isNotEmpty())

            <div class="appointment-list">

                @foreach ($pendingAppointments as $appointment)

                    <div class="appointment-row">

                        {{-- Client --}}

                        <div class="appointment-client">

                            <div class="client-avatar">
                                {{ strtoupper(
                                    substr(
                                        $appointment->client?->name ?? 'C',
                                        0,
                                        1
                                    )
                                ) }}
                            </div>

                            <div>

                                <div class="appointment-label">
                                    Client
                                </div>

                                <div class="appointment-client-name">
                                    {{ $appointment->client?->name ?? 'Unknown client' }}
                                </div>

                            </div>

                        </div>


                        {{-- Requested date/time --}}

                        <div>

                            <div class="appointment-label">
                                Requested
                            </div>

                            <div class="appointment-value">

                                @if ($appointment->appointment_date)

                                    {{ $appointment->appointment_date->format('M d, Y') }}

                                @else

                                    —

                                @endif


                                @if ($appointment->appointment_time)

                                    ·
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}

                                @endif

                            </div>

                        </div>


                        {{-- Case reference --}}

                        <div>

                            <div class="appointment-label">
                                Case
                            </div>

                            <div class="appointment-case">
                                {{ $appointment->case?->case_number ?? '—' }}
                            </div>

                        </div>


                        {{-- Actions --}}

                        <div class="appointment-actions">

                            {{-- Accept --}}

                            <form
                                action="{{ route('lawyer.appointments.respond', $appointment) }}"
                                method="POST"
                            >

                                @csrf

                                @method('PATCH')

                                <input
                                    type="hidden"
                                    name="status"
                                    value="scheduled"
                                >

                                <button
                                    type="submit"
                                    class="action-button accept-button"
                                >
                                    Accept
                                </button>

                            </form>


                            {{-- Reject --}}

                            <form
                                action="{{ route('lawyer.appointments.respond', $appointment) }}"
                                method="POST"
                            >

                                @csrf

                                @method('PATCH')

                                <input
                                    type="hidden"
                                    name="status"
                                    value="rejected"
                                >

                                <button
                                    type="submit"
                                    class="action-button reject-button"
                                >
                                    Reject
                                </button>

                            </form>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        aria-hidden="true"
                    >
                        <path
                            d="M20 7 10 17l-5-5"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>

                </div>

                <h3 class="empty-title">
                    You're all caught up
                </h3>

                <p class="empty-text">
                    There are no appointment requests waiting for
                    your response right now.
                </p>

            </div>

        @endif

    </section>

</div>

@endsection