@extends('layouts.app')

@section('title', 'Communication Details')

@section('content')

<div class="min-h-screen bg-[#F7F4ED] px-4 py-6 sm:px-6 lg:px-8">

    <div class="mx-auto max-w-7xl">

        {{-- =========================================================
            HEADER / BACK
        ========================================================== --}}
        <div class="mb-8">
            <a
                href="{{ route('admin.communication.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-[#77756F] transition duration-200 hover:text-[#B89452]"
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
                        stroke-width="1.8"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>

                Back to Communication
            </a>
        </div>


        {{-- =========================================================
            CASE HEADER
        ========================================================== --}}
        <div class="mb-8 overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white">

            <div class="p-6 sm:p-8">

                <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">

                    {{-- Case information --}}
                    <div>

                        <div class="mb-3 flex flex-wrap items-center gap-3">

                            <span class="text-xs font-medium uppercase tracking-[0.12em] text-[#B89452]">
                                Communication
                            </span>

                            @if($case->status === 'opened')

                                <span class="inline-flex items-center gap-2 rounded-full border border-[#3D8B5A]/30 bg-[#EFF8F2] px-3 py-1 text-xs font-semibold text-[#27633D]">
                                    <span class="h-1.5 w-1.5 rounded-full bg-[#3D8B5A]"></span>
                                    Active
                                </span>

                            @elseif($case->status === 'closed')

                                <span class="inline-flex items-center gap-2 rounded-full border border-[#D4D1CA] bg-[#F7F4ED] px-3 py-1 text-xs font-semibold text-[#77756F]">
                                    <span class="h-1.5 w-1.5 rounded-full bg-[#77756F]"></span>
                                    Closed
                                </span>

                            @else

                                <span class="inline-flex items-center gap-2 rounded-full border border-[#B98525]/30 bg-[#FFF8E8] px-3 py-1 text-xs font-semibold text-[#795A18]">
                                    <span class="h-1.5 w-1.5 rounded-full bg-[#B98525]"></span>
                                    {{ ucfirst($case->status ?? 'Pending') }}
                                </span>

                            @endif

                        </div>

                        <h1 class="font-serif text-3xl font-medium tracking-tight text-[#11110F] sm:text-4xl">
                            Case Communication
                        </h1>

                        <p class="mt-3 text-sm text-[#77756F]">
                            Case #{{ $case->case_number }}
                        </p>

                    </div>


                    {{-- Administrator badge --}}
                    <div class="inline-flex w-fit items-center gap-3 rounded-xl border border-[#C9A96E]/30 bg-[#F7F4ED] px-4 py-3">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#C9A96E]/10 text-[#B89452]">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"
                                />
                            </svg>

                        </div>

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-[#B89452]">
                                Administrator
                            </p>

                            <p class="mt-0.5 text-xs text-[#77756F]">
                                Firm-wide communication access
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
            MAIN GRID
        ========================================================== --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">


            {{-- =====================================================
                MESSAGES
            ====================================================== --}}
            <div class="lg:col-span-2">

                <div class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white">

                    {{-- Section header --}}
                    <div class="flex items-center justify-between border-b border-[#E5E2DB] px-6 py-5">

                        <div>

                            <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#B89452]">
                                Messages
                            </p>

                            <h2 class="mt-1 text-lg font-semibold text-[#11110F]">
                                Communication History
                            </h2>

                        </div>

                        <div class="rounded-full border border-[#E5E2DB] bg-[#F7F4ED] px-3 py-1.5 text-xs font-semibold text-[#77756F]">

                            {{ $case->messages->count() }}

                            {{ $case->messages->count() === 1 ? 'Message' : 'Messages' }}

                        </div>

                    </div>


                    {{-- Messages --}}
                    <div class="divide-y divide-[#E5E2DB]">

                        @forelse($case->messages as $message)

                            @php

                                $sender = $message->sender ?? null;
                                $receiver = $message->receiver ?? null;

                                $senderName = $sender->name ?? 'Unknown User';
                                $senderEmail = $sender->email ?? 'No email available';
                                $senderRole = strtolower($sender->role ?? '');

                                $messageBody =
                                    $message->message
                                    ?? $message->body
                                    ?? $message->content
                                    ?? '';

                                $subject =
                                    $message->subject
                                    ?? $message->title
                                    ?? 'Case Communication';

                                $initial = strtoupper(
                                    substr($senderName, 0, 1)
                                );

                                $isUnread =
                                    ($message->is_read ?? true) === false
                                    ||
                                    (
                                        ($message->read_at ?? null) === null
                                        &&
                                        ($message->status ?? '') === 'unread'
                                    );

                            @endphp


                            <div class="p-6 transition duration-200 hover:bg-[#FAF9F6] sm:p-7">


                                {{-- Message top --}}
                                <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">


                                    {{-- Sender --}}
                                    <div class="flex items-start gap-4">


                                        {{-- Avatar --}}
                                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-[#C9A96E]/30 bg-[#F7F4ED] text-sm font-semibold text-[#B89452]">

                                            {{ $initial }}

                                        </div>


                                        {{-- Sender information --}}
                                        <div class="min-w-0">

                                            <div class="flex flex-wrap items-center gap-2">

                                                <p class="font-semibold text-[#11110F]">
                                                    {{ $senderName }}
                                                </p>


                                                @if($senderRole === 'client')

                                                    <span class="rounded-full border border-[#C9A96E]/30 bg-[#FFF8E8] px-2.5 py-1 text-[11px] font-semibold text-[#795A18]">
                                                        Client
                                                    </span>

                                                @elseif($senderRole === 'lawyer')

                                                    <span class="rounded-full border border-[#477C91]/30 bg-[#EEF5F8] px-2.5 py-1 text-[11px] font-semibold text-[#315868]">
                                                        Lawyer
                                                    </span>

                                                @elseif($senderRole === 'admin')

                                                    <span class="rounded-full border border-[#D4D1CA] bg-[#F7F4ED] px-2.5 py-1 text-[11px] font-semibold text-[#77756F]">
                                                        Admin
                                                    </span>

                                                @elseif($senderRole)

                                                    <span class="rounded-full border border-[#D4D1CA] bg-[#F7F4ED] px-2.5 py-1 text-[11px] font-semibold text-[#77756F]">
                                                        {{ ucfirst($senderRole) }}
                                                    </span>

                                                @endif

                                            </div>


                                            <p class="mt-1 text-xs text-[#77756F]">
                                                {{ $senderEmail }}
                                            </p>

                                        </div>

                                    </div>


                                    {{-- Date --}}
                                    <div class="shrink-0 text-left sm:text-right">

                                        <p class="text-xs text-[#77756F]">
                                            {{ optional($message->created_at)->format('M d, Y') ?? '—' }}
                                        </p>

                                        <p class="mt-1 text-xs text-[#77756F]">
                                            {{ optional($message->created_at)->format('h:i A') ?? '—' }}
                                        </p>

                                    </div>

                                </div>


                                {{-- Subject --}}
                                <div class="mt-6">

                                    <div class="flex flex-wrap items-center gap-3">

                                        <h3 class="text-base font-semibold text-[#11110F]">
                                            {{ $subject }}
                                        </h3>


                                        @if($isUnread)

                                            <span class="inline-flex items-center gap-1.5 rounded-full border border-[#B98525]/30 bg-[#FFF8E8] px-2.5 py-1 text-[11px] font-semibold text-[#795A18]">

                                                <span class="h-1.5 w-1.5 rounded-full bg-[#B98525]"></span>

                                                Unread

                                            </span>

                                        @else

                                            <span class="inline-flex items-center gap-1.5 rounded-full border border-[#3D8B5A]/30 bg-[#EFF8F2] px-2.5 py-1 text-[11px] font-semibold text-[#27633D]">

                                                <span class="h-1.5 w-1.5 rounded-full bg-[#3D8B5A]"></span>

                                                Read

                                            </span>

                                        @endif

                                    </div>


                                    {{-- Message body --}}
                                    <div class="mt-4 border-l-2 border-[#C9A96E]/40 pl-4">

                                        @if($messageBody)

                                            <p class="whitespace-pre-line text-sm leading-7 text-[#41403C]">
                                                {{ $messageBody }}
                                            </p>

                                        @else

                                            <p class="text-sm italic text-[#77756F]">
                                                No message content is available.
                                            </p>

                                        @endif

                                    </div>

                                </div>


                                {{-- Message footer --}}
                                <div class="mt-6 flex flex-col gap-3 border-t border-[#E5E2DB] pt-4 sm:flex-row sm:items-center sm:justify-between">


                                    <div class="flex flex-wrap items-center gap-4 text-xs text-[#77756F]">

                                        <span>
                                            Message #{{ $message->id }}
                                        </span>


                                        @if($receiver)

                                            <span class="flex items-center gap-1.5">

                                                <span class="text-[#9B9992]">
                                                    To
                                                </span>

                                                <span class="text-[#41403C]">
                                                    {{ $receiver->name }}
                                                </span>

                                            </span>

                                        @endif

                                    </div>


                                    {{-- Delete --}}
                                    @if(Route::has('admin.communication.destroy'))

                                        <form
                                            method="POST"
                                            action="{{ route('admin.communication.destroy', $message) }}"
                                            onsubmit="return confirm('Are you sure you want to remove this message?');"
                                        >

                                            @csrf

                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                aria-label="Delete message"
                                                class="inline-flex h-9 items-center gap-2 rounded-lg border border-[#B94A48]/30 bg-[#FDF0EF] px-3 text-xs font-semibold text-[#7D302F] transition duration-200 hover:-translate-y-px hover:border-[#B94A48]/50 hover:bg-[#F9E5E3]"
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
                                                        stroke-width="1.8"
                                                        d="M6 7h12M9 7V5a1 1 0 011-1h4a1 1 0 011 1v2m2 0v12a1 1 0 01-1 1H8a1 1 0 01-1-1V7m3 4v6m4-6v6"
                                                    />
                                                </svg>

                                                Remove

                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </div>


                        @empty


                            {{-- Empty state --}}
                            <div class="px-6 py-16 text-center">

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-[#C9A96E]/30 bg-[#F7F4ED] text-[#B89452]">

                                    <svg
                                        class="h-7 w-7"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.7"
                                            d="M8 10h8M8 14h5m-9 5l1.5-3A7 7 0 014 10a8 8 0 1116 0 8 8 0 01-8 8H8z"
                                        />
                                    </svg>

                                </div>


                                <h3 class="mt-5 text-lg font-semibold text-[#11110F]">
                                    No Messages Yet
                                </h3>


                                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#77756F]">
                                    There are currently no communications associated
                                    with this case.
                                </p>

                            </div>


                        @endforelse

                    </div>

                </div>

            </div>


            {{-- =====================================================
                SIDEBAR
            ====================================================== --}}
            <div class="space-y-6">


                {{-- =================================================
                    CASE INFORMATION
                ================================================== --}}
                <div class="rounded-2xl border border-[#E5E2DB] bg-white p-6">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-[#C9A96E]/30 bg-[#F7F4ED] text-[#B89452]">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z"
                                />
                            </svg>

                        </div>


                        <h2 class="text-base font-semibold text-[#11110F]">
                            Case Information
                        </h2>

                    </div>


                    <div class="mt-6 space-y-5">


                        <div>

                            <p class="text-[11px] font-medium uppercase tracking-[0.08em] text-[#77756F]">
                                Case Number
                            </p>

                            <p class="mt-1.5 text-sm font-semibold text-[#B89452]">
                                {{ $case->case_number }}
                            </p>

                        </div>


                        <div>

                            <p class="text-[11px] font-medium uppercase tracking-[0.08em] text-[#77756F]">
                                Case Type
                            </p>

                            <p class="mt-1.5 text-sm font-medium text-[#41403C]">
                                {{ $case->case_type ?? 'Not specified' }}
                            </p>

                        </div>


                        <div>

                            <p class="text-[11px] font-medium uppercase tracking-[0.08em] text-[#77756F]">
                                Status
                            </p>

                            <p class="mt-1.5 text-sm font-medium text-[#41403C]">
                                {{ ucfirst($case->status ?? 'Unknown') }}
                            </p>

                        </div>


                        @if($case->start_date)

                            <div>

                                <p class="text-[11px] font-medium uppercase tracking-[0.08em] text-[#77756F]">
                                    Started
                                </p>

                                <p class="mt-1.5 text-sm font-medium text-[#41403C]">

                                    @if($case->start_date instanceof \Carbon\Carbon)

                                        {{ $case->start_date->format('M d, Y') }}

                                    @else

                                        {{ \Carbon\Carbon::parse($case->start_date)->format('M d, Y') }}

                                    @endif

                                </p>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                    CLIENT
                ================================================== --}}
                <div class="rounded-2xl border border-[#E5E2DB] bg-white p-6">

                    <h2 class="text-xs font-medium uppercase tracking-[0.08em] text-[#B89452]">
                        Client
                    </h2>


                    <div class="mt-5">

                        @if($case->client)

                            <div class="flex items-center gap-3">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-[#C9A96E]/30 bg-[#F7F4ED] text-sm font-semibold text-[#B89452]">

                                    {{ strtoupper(substr($case->client->name ?? 'C', 0, 1)) }}

                                </div>


                                <div class="min-w-0">

                                    <p class="truncate text-sm font-semibold text-[#11110F]">
                                        {{ $case->client->name }}
                                    </p>

                                    <p class="mt-1 truncate text-xs text-[#77756F]">
                                        {{ $case->client->email ?? 'No email' }}
                                    </p>

                                </div>

                            </div>

                        @else

                            <p class="text-sm text-[#77756F]">
                                Client information unavailable.
                            </p>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                    LAWYER
                ================================================== --}}
                <div class="rounded-2xl border border-[#E5E2DB] bg-white p-6">

                    <h2 class="text-xs font-medium uppercase tracking-[0.08em] text-[#B89452]">
                        Assigned Lawyer
                    </h2>


                    <div class="mt-5">

                        @if($case->lawyer)

                            <div class="flex items-center gap-3">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-[#C9A96E]/30 bg-[#F7F4ED] text-sm font-semibold text-[#B89452]">

                                    {{ strtoupper(substr($case->lawyer->name ?? 'L', 0, 1)) }}

                                </div>


                                <div class="min-w-0">

                                    <p class="truncate text-sm font-semibold text-[#11110F]">
                                        {{ $case->lawyer->name }}
                                    </p>

                                    <p class="mt-1 truncate text-xs text-[#77756F]">
                                        {{ $case->lawyer->email ?? 'No email' }}
                                    </p>

                                </div>

                            </div>

                        @else

                            <p class="text-sm text-[#77756F]">
                                No lawyer assigned.
                            </p>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                    ADMIN NOTICE
                ================================================== --}}
                <div class="rounded-2xl border border-[#C9A96E]/30 bg-[#F7F4ED] p-6">

                    <div class="flex gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-[#C9A96E]/30 bg-white text-[#B89452]">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"
                                />
                            </svg>

                        </div>


                        <div>

                            <h3 class="text-sm font-semibold text-[#11110F]">
                                Administrator Access
                            </h3>

                            <p class="mt-2 text-xs leading-5 text-[#77756F]">
                                This communication history is available to
                                administrators for firm-wide monitoring,
                                compliance, and case management.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
            BOTTOM BACK BUTTON
        ========================================================== --}}
        <div class="mt-8">

            <a
                href="{{ route('admin.communication.index') }}"
                class="inline-flex h-11 items-center gap-2 rounded-lg border border-[#C9A96E]/40 bg-white px-5 text-sm font-semibold text-[#B89452] transition duration-200 hover:-translate-y-px hover:bg-[#FAF9F6] hover:text-[#B89452]"
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
                        stroke-width="1.8"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>

                Back to Communication

            </a>

        </div>

    </div>

</div>

@endsection