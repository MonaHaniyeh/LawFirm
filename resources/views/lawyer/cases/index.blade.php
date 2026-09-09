@extends('layouts.app')

@section('title', 'My Cases | Law Firm')

@push('styles')
    <style>
        /* =========================================
               PAGE HEADER
            ========================================== */
        .page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 30px;
            margin-bottom: 34px;
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
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(40px, 4vw, 52px);
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

        .total-count {
            color: var(--gold-dark);
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }


        /* =========================================
               FILTER BAR
            ========================================== */
        .filter-card {
            margin-bottom: 22px;
            padding: 16px;
            background: var(--paper);
            border: 1px solid var(--line);
        }

        .filter-form {
            display: grid;
            grid-template-columns: minmax(220px, 1.7fr) auto 1fr 1fr auto;
            align-items: end;
            gap: 10px;
        }

        .field {
            min-width: 0;
        }

        .field-label {
            display: block;
            margin: 0 0 7px 2px;
            color: #928d84;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .14em;
        }

        .input-wrap {
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            width: 16px;
            height: 16px;
            transform: translateY(-50%);
            color: #aaa59c;
            pointer-events: none;
        }

        .search-icon svg {
            width: 16px;
            height: 16px;
        }

        .form-input,
        .form-select {
            width: 100%;
            height: 42px;
            padding: 0 13px;
            background: #fcfbf9;
            border: 1px solid #ddd9d1;
            border-radius: 4px;
            color: #393733;
            outline: none;
            font-size: 11px;
            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                background .2s ease;
            box-sizing: border-box;
        }

        .form-input.search {
            padding-left: 39px;
        }

        .form-input::placeholder {
            color: #aaa59c;
        }

        .form-input:focus,
        .form-select:focus {
            background: #fff;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(182, 154, 104, .09);
        }

        .form-select {
            cursor: pointer;
        }


        /* =========================================
               SEARCH BUTTON
               ALWAYS VISIBLE
            ========================================== */
        .search-action {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            width: auto !important;
            min-width: 78px;
            height: 42px;
            padding: 0 16px;
            border: 1px solid var(--gold-dark);
            border-radius: 4px;
            background: var(--gold-dark);
            color: #ffffff;
            font-size: 10px;
            font-weight: 700;
            line-height: 1;
            white-space: nowrap;
            cursor: pointer;
            opacity: 1 !important;
            visibility: visible !important;
            box-shadow: none;
            transition: background-color .2s ease, border-color .2s ease;
        }

        .search-action:hover {
            background: #856332;
            border-color: #856332;
            color: #ffffff;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .search-action:active {
            transform: translateY(0);
        }


        /* =========================================
               FILTER BUTTON
               ALWAYS VISIBLE
            ========================================== */
        .filter-button {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;

            width: auto !important;
            min-width: 78px;
            height: 42px;

            padding: 0 16px;

            border: 1px solid var(--gold-dark);
            border-radius: 4px;

            background: var(--gold-dark);
            color: #ffffff;

            font-size: 10px;
            font-weight: 700;
            line-height: 1;

            white-space: nowrap;

            cursor: pointer;

            opacity: 1 !important;
            visibility: visible !important;

            box-shadow: none;

            transition:
                background-color .2s ease,
                border-color .2s ease,
                transform .15s ease;
        }

        .filter-button:hover {
            background: #856332;
            border-color: #856332;
            color: #ffffff;
            opacity: 1;
            visibility: visible;
            transform: translateY(-1px);
        }

        .filter-button:active {
            transform: translateY(0);
        }


        /* =========================================
               CLEAR LINK
            ========================================== */
        .clear-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 42px;
            padding: 0 12px;
            color: #77736c;
            font-size: 10px;
            font-weight: 600;
            transition: color .2s ease;
        }

        .clear-link:hover {
            color: var(--gold-dark);
        }


        /* =========================================
               TABLE
            ========================================== */
        .table-card {
            overflow: hidden;
            background: var(--paper);
            border: 1px solid var(--line);
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .case-table {
            width: 100%;
            min-width: 900px;
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
            border-bottom: 1px solid #efede8;
            color: #4d4b47;
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

        .client-placeholder {
            color: #aaa59c;
        }


        /* =========================================
               STATUS
            ========================================== */
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

        .status-closed {
            color: #686761;
            background: #f0efec;
        }

        .status-pending {
            color: #9a7336;
            background: #fbf3e4;
        }

        .status-rejected {
            color: var(--danger);
            background: var(--danger-bg);
        }

        .details-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--gold-dark);
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
            transition:
                gap .2s ease,
                color .2s ease;
        }

        .details-link:hover {
            gap: 9px;
            color: var(--charcoal);
        }

        .details-arrow {
            font-size: 14px;
        }


        /* =========================================
               EMPTY STATE
            ========================================== */
        .empty-state {
            padding: 70px 30px;
            text-align: center;
            background: var(--paper);
            border: 1px solid var(--line);
        }

        .empty-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd8ce;
            border-radius: 50%;
            color: var(--gold-dark);
        }

        .empty-icon svg {
            width: 20px;
            height: 20px;
            stroke-width: 1.4;
        }

        .empty-title {
            margin: 0;
            font-family: 'Cormorant Garamond', serif;
            font-size: 24px;
            font-weight: 600;
        }

        .empty-text {
            max-width: 390px;
            margin: 8px auto 0;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.6;
        }


        /* =========================================
               PAGINATION
            ========================================== */
        .table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 16px 20px;
            border-top: 1px solid var(--line);
            background: #fcfbf9;
        }

        .pagination-info {
            color: #918d84;
            font-size: 10px;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .page-link {
            min-width: 31px;
            height: 31px;
            padding: 0 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd9d1;
            border-radius: 4px;
            background: white;
            color: #69665f;
            font-size: 10px;
            transition:
                background .2s ease,
                color .2s ease,
                border-color .2s ease;
        }

        .page-link:hover {
            border-color: var(--gold);
            color: var(--gold-dark);
        }

        .page-link.active {
            border-color: var(--charcoal);
            background: var(--charcoal);
            color: white;
        }

        .page-link.disabled {
            opacity: .4;
            pointer-events: none;
        }


        /* =========================================
               RESPONSIVE
            ========================================== */
        @media (max-width: 1100px) {

            .filter-form {
                grid-template-columns: minmax(200px, 1fr) auto 1fr 1fr auto;
            }

        }


        @media (max-width: 900px) {

            .filter-form {
                grid-template-columns: 1fr 1fr;
            }

            .search-field {
                grid-column: 1 / -1;
            }

            .search-button-field,
            .filter-action {
                width: auto;
            }

            .search-action,
            .filter-button {
                width: auto !important;
            }

        }


        @media (max-width: 850px) {

            .page-header {
                display: block;
            }

            .total-count {
                display: block;
                margin-top: 14px;
            }

        }


        @media (max-width: 600px) {

            .filter-form {
                grid-template-columns: 1fr;
            }

            .search-field {
                grid-column: auto;
            }

            .search-button-field,
            .filter-action {
                width: 100%;
            }

            .search-action,
            .filter-button {
                width: 100% !important;
            }

            .table-footer {
                align-items: flex-start;
                flex-direction: column;
            }

            .pagination {
                width: 100%;
                overflow-x: auto;
                padding-bottom: 2px;
            }

        }
    </style>
@endpush


@section('content')

    {{-- =========================================
         PAGE HEADER
    ========================================== --}}

    <header class="page-header">

        <div>

            <div class="eyebrow">
                Case Management
            </div>

            <h1 class="page-title">
                My Cases
            </h1>

            <p class="page-description">
                Review and manage the matters currently assigned to you.
            </p>

        </div>

        <div class="total-count">
            {{ $cases->total() }}
            {{ $cases->total() === 1 ? 'case' : 'cases' }}
        </div>

    </header>


    {{-- =========================================
         FILTERS
    ========================================== --}}

    <section class="filter-card">

        <form action="{{ route('lawyer.cases.index') }}" method="GET" class="filter-form">

            <div class="field">
                <label for="search" class="field-label">Search</label>

                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    class="form-input search" placeholder="Search case number or client name...">
            </div>

            <div class="field search-button-field">
                <label class="field-label">&nbsp;</label>

                <button type="submit" name="action" value="search" class="search-action">
                    Search
                </button>
            </div>

            <div class="field">
                <label for="status" class="field-label">Status</label>

                <select name="status" id="status" class="form-select">
                    <option value="">All statuses</option>

                    <option value="opened" {{ request('status') === 'opened' ? 'selected' : '' }}>
                        Opened
                    </option>

                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>
                        Closed
                    </option>
                </select>
            </div>

            <div class="field">
                <label for="case_type" class="field-label">Case Type</label>

                <select name="case_type" id="case_type" class="form-select">
                    <option value="">All case types</option>

                    @foreach ($caseTypes as $type)
                        <option value="{{ $type }}" {{ request('case_type') === $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field filter-action">
                <label class="field-label">&nbsp;</label>

                <button type="submit" name="action" value="filter" class="filter-button">
                    Filter
                </button>
            </div>

        </form>


        {{-- Clear Filters --}}
        @if (request()->hasAny(['search', 'status', 'case_type']))
            <div style="margin-top: 8px;">

                <a href="{{ route('lawyer.cases.index') }}" class="clear-link">
                    Clear filters
                </a>

            </div>
        @endif

    </section>


    {{-- =========================================
         CASES TABLE
    ========================================== --}}

    @if ($cases->isNotEmpty())

        <section class="table-card">

            <div class="table-wrapper">

                <table class="case-table">

                    <thead>

                        <tr>

                            <th>
                                Case Number
                            </th>

                            <th>
                                Type
                            </th>

                            <th>
                                Start Date
                            </th>

                            <th>
                                End Date
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Client
                            </th>

                            <th></th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach ($cases as $case)
                            <tr>

                                {{-- Case Number --}}
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


                                {{-- Start Date --}}
                                <td>

                                    <div class="date">

                                        {{ $case->created_at ? $case->created_at->format('M d, Y') : '—' }}

                                    </div>

                                </td>


                                {{-- End Date --}}
                                <td>

                                    <div class="date">

                                        @if ($case->end_date)
                                            {{ \Carbon\Carbon::parse($case->end_date)->format('M d, Y') }}
                                        @else
                                            —
                                        @endif

                                    </div>

                                </td>


                                {{-- Status --}}
                                <td>

                                    @php
                                        $status = strtolower($case->status ?? '');
                                    @endphp

                                    <span
                                        class="status
                                            @if (in_array($status, ['open', 'opened', 'active'])) status-open
                                            @elseif(in_array($status, ['closed', 'completed']))
                                                status-closed
                                            @elseif(in_array($status, ['pending', 'in_progress']))
                                                status-pending
                                            @elseif($status === 'rejected')
                                                status-rejected
                                            @else
                                                status-closed @endif
                                        ">

                                        {{ str_replace('_', ' ', $case->status ?? 'Unknown') }}

                                    </span>

                                </td>


                                {{-- Client --}}
                                <td>

                                    @if ($case->client)
                                        <div class="client-name">
                                            {{ $case->client->name }}
                                        </div>
                                    @else
                                        <div class="client-placeholder">
                                            —
                                        </div>
                                    @endif

                                </td>


                                {{-- Details --}}
                                <td>

                                    @if (Route::has('lawyer.cases.show'))
                                        <a href="{{ route('lawyer.cases.show', $case) }}" class="details-link">

                                            Case details

                                            <span class="details-arrow">
                                                →
                                            </span>

                                        </a>
                                    @endif

                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- =========================================
                 PAGINATION
            ========================================== --}}

            <div class="table-footer">

                <div class="pagination-info">

                    Showing
                    {{ $cases->firstItem() }}
                    –
                    {{ $cases->lastItem() }}
                    of
                    {{ $cases->total() }}

                </div>


                @if ($cases->hasPages())

                    <div class="pagination">

                        {{-- Previous --}}

                        @if ($cases->onFirstPage())
                            <span class="page-link disabled">
                                ←
                            </span>
                        @else
                            <a href="{{ $cases->previousPageUrl() }}" class="page-link">
                                ←
                            </a>
                        @endif


                        {{-- Page Numbers --}}

                        @foreach ($cases->getUrlRange(max(1, $cases->currentPage() - 2), min($cases->lastPage(), $cases->currentPage() + 2)) as $page => $url)
                            @if ($page == $cases->currentPage())
                                <span class="page-link active">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="page-link">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach


                        {{-- Next --}}

                        @if ($cases->hasMorePages())
                            <a href="{{ $cases->nextPageUrl() }}" class="page-link">
                                →
                            </a>
                        @else
                            <span class="page-link disabled">
                                →
                            </span>
                        @endif

                    </div>

                @endif

            </div>

        </section>
    @else
        {{-- =========================================
             EMPTY STATE
        ========================================== --}}

        <div class="empty-state">

            <div class="empty-icon">

                <svg viewBox="0 0 24 24" fill="none">

                    <path
                        d="M4 7.5A2.5 2.5 0 0 1 6.5 5H10l2 2h5.5A2.5 2.5 0 0 1 20 9.5v7A2.5 2.5 0 0 1 17.5 19h-11A2.5 2.5 0 0 1 4 16.5v-9Z"
                        stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />

                </svg>

            </div>


            @if (request()->hasAny(['search', 'status', 'case_type']))
                <h2 class="empty-title">
                    No matching cases
                </h2>

                <p class="empty-text">
                    No cases match the filters you've selected.
                    Try adjusting your search or clearing the filters.
                </p>

                <a href="{{ route('lawyer.cases.index') }}" class="clear-link" style="margin-top: 12px;">
                    Clear filters
                </a>
            @else
                <h2 class="empty-title">
                    No cases assigned
                </h2>

                <p class="empty-text">
                    Cases assigned to you will appear here once they
                    become part of your practice.
                </p>
            @endif

        </div>

    @endif

@endsection
