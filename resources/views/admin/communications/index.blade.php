@extends('layouts.app')

@section('title', 'Communication')

@section('content')

<div
    x-data="{
        search: '',
        type: 'all',

        matches(el) {
            const text = el.innerText.toLowerCase();

            const searchMatch =
                this.search === '' ||
                text.includes(this.search.toLowerCase());

            const typeMatch =
                this.type === 'all' ||
                el.dataset.type === this.type;

            return searchMatch && typeMatch;
        }
    }"
    class="min-h-screen px-4 py-6 sm:px-6 lg:px-8"
>

    <div class="mx-auto max-w-7xl">

        {{-- ============================================================
            PAGE HEADER
        ============================================================ --}}

        <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

            <div>

                <div class="mb-3 flex items-center gap-2">

                    <span class="h-px w-8 bg-[#C9A96E]"></span>

                    <span class="text-[11px] font-semibold uppercase tracking-[0.14em] text-[#C9A96E]">
                        Administration
                    </span>

                </div>

                <h1 class="font-serif text-3xl font-medium tracking-tight text-[#11110F] sm:text-4xl">
                    Communication
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-[#77756F]">
                    Monitor communication between clients, lawyers, and the firm.
                </p>

            </div>

            <div class="inline-flex w-fit items-center gap-2 rounded-full border border-[#C9A96E]/30 bg-white px-4 py-2">

                <span class="h-1.5 w-1.5 rounded-full bg-[#C9A96E]"></span>

                <span class="text-xs font-semibold text-[#B89452]">
                    {{ $communications->total() }}
                    {{ $communications->total() === 1 ? 'Conversation' : 'Conversations' }}
                </span>

            </div>

        </div>


        {{-- ============================================================
            SUMMARY CARDS
        ============================================================ --}}

        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

            {{-- Total Conversations --}}
            <div class="rounded-2xl border border-[#E5E2DB] bg-white p-5 transition duration-200 hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(0,0,0,0.08)]">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#77756F]">
                            Conversations
                        </p>

                        <p class="mt-3 text-3xl font-semibold tracking-tight text-[#11110F]">
                            {{ $communications->total() }}
                        </p>

                        <p class="mt-2 text-xs text-[#77756F]">
                            Active communication records
                        </p>

                    </div>

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-[#C9A96E]/25 bg-[#C9A96E]/10 text-[#B89452]">

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
                                d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6A8.38 8.38 0 0112.5 3h.5a8.5 8.5 0 018 8v.5z"
                            />
                        </svg>

                    </div>

                </div>

            </div>


            {{-- Unread --}}
            <div class="rounded-2xl border border-[#E5E2DB] bg-white p-5 transition duration-200 hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(0,0,0,0.08)]">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#77756F]">
                            Unread
                        </p>

                        <p class="mt-3 text-3xl font-semibold tracking-tight text-[#11110F]">

                            {{ $communications->filter(function ($case) {

                                $message = $case->messages->first();

                                if (!$message) {
                                    return false;
                                }

                                return
                                    ($message->is_read ?? true) === false ||
                                    (
                                        ($message->read_at ?? null) === null &&
                                        ($message->status ?? '') === 'unread'
                                    );

                            })->count() }}

                        </p>

                        <p class="mt-2 text-xs text-[#77756F]">
                            Requiring attention
                        </p>

                    </div>

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-[#B98525]/30 bg-[#FFF8E8] text-[#B98525]">

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
                                d="M3 8l9 6 9-6"
                            />

                            <rect
                                x="3"
                                y="5"
                                width="18"
                                height="14"
                                rx="2"
                                stroke-width="1.8"
                            />
                        </svg>

                    </div>

                </div>

            </div>


            {{-- Client Conversations --}}
            <div class="rounded-2xl border border-[#E5E2DB] bg-white p-5 transition duration-200 hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(0,0,0,0.08)]">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#77756F]">
                            Client
                        </p>

                        <p class="mt-3 text-3xl font-semibold tracking-tight text-[#11110F]">

                            {{ $communications->filter(function ($case) {

                                return strtolower($case->client->role ?? '') === 'client';

                            })->count() }}

                        </p>

                        <p class="mt-2 text-xs text-[#77756F]">
                            Client conversations
                        </p>

                    </div>

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-[#477C91]/25 bg-[#EEF5F8] text-[#477C91]">

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
                                d="M20 14a4 4 0 01-4 4H8l-4 3v-7a4 4 0 014-4h8a4 4 0 014 4z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M8 7a4 4 0 014-4h4a4 4 0 014 4v1"
                            />

                        </svg>

                    </div>

                </div>

            </div>


            {{-- Lawyer Conversations --}}
            <div class="rounded-2xl border border-[#E5E2DB] bg-white p-5 transition duration-200 hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(0,0,0,0.08)]">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#77756F]">
                            Lawyer
                        </p>

                        <p class="mt-3 text-3xl font-semibold tracking-tight text-[#11110F]">

                            {{ $communications->filter(function ($case) {

                                return strtolower($case->lawyer->role ?? '') === 'lawyer';

                            })->count() }}

                        </p>

                        <p class="mt-2 text-xs text-[#77756F]">
                            Lawyer conversations
                        </p>

                    </div>

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-[#C9A96E]/25 bg-[#C9A96E]/10 text-[#B89452]">

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
                                d="M21 15a4 4 0 01-4 4H8l-5 3V8a4 4 0 014-4h10a4 4 0 014 4v7z"
                            />
                        </svg>

                    </div>

                </div>

            </div>

        </div>


        {{-- ============================================================
            FILTERS
        ============================================================ --}}

        <div class="mb-6 rounded-2xl border border-[#E5E2DB] bg-white p-4">

            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                {{-- Search --}}
                <div class="relative w-full lg:max-w-md">

                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">

                        <svg
                            class="h-5 w-5 text-[#77756F]"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"
                            />
                        </svg>

                    </div>

                    <input
                        type="text"
                        x-model="search"
                        placeholder="Search cases, clients, lawyers..."
                        aria-label="Search communications"
                        class="block h-11 w-full rounded-lg border border-[#D4D1CA] bg-white py-2.5 pl-10 pr-4 text-sm text-[#11110F] placeholder-[#9B9992] outline-none transition duration-200 focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/15"
                    >

                </div>


                {{-- Type Filters --}}
                <div class="flex flex-wrap gap-2">

                    <button
                        type="button"
                        @click="type = 'all'"
                        :class="type === 'all'
                            ? 'border-[#C9A96E]/40 bg-[#C9A96E]/10 text-[#B89452]'
                            : 'border-[#E5E2DB] bg-white text-[#77756F] hover:border-[#C9A96E]/30 hover:text-[#B89452]'"
                        class="h-10 rounded-lg border px-4 text-sm font-semibold transition duration-200"
                    >
                        All
                    </button>

                    <button
                        type="button"
                        @click="type = 'client'"
                        :class="type === 'client'
                            ? 'border-[#C9A96E]/40 bg-[#C9A96E]/10 text-[#B89452]'
                            : 'border-[#E5E2DB] bg-white text-[#77756F] hover:border-[#C9A96E]/30 hover:text-[#B89452]'"
                        class="h-10 rounded-lg border px-4 text-sm font-semibold transition duration-200"
                    >
                        Clients
                    </button>

                    <button
                        type="button"
                        @click="type = 'lawyer'"
                        :class="type === 'lawyer'
                            ? 'border-[#C9A96E]/40 bg-[#C9A96E]/10 text-[#B89452]'
                            : 'border-[#E5E2DB] bg-white text-[#77756F] hover:border-[#C9A96E]/30 hover:text-[#B89452]'"
                        class="h-10 rounded-lg border px-4 text-sm font-semibold transition duration-200"
                    >
                        Lawyers
                    </button>

                </div>

            </div>

        </div>


        {{-- ============================================================
            COMMUNICATION TABLE
        ============================================================ --}}

        <div class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white">

            {{-- DESKTOP TABLE --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="min-w-full">

                    <thead class="bg-[#F7F4ED]">

                        <tr>

                            <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#41403C]">
                                Case
                            </th>

                            <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#41403C]">
                                Client
                            </th>

                            <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#41403C]">
                                Lawyer
                            </th>

                            <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#41403C]">
                                Latest Message
                            </th>

                            <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#41403C]">
                                Date
                            </th>

                            <th class="px-6 py-4 text-right text-[11px] font-semibold uppercase tracking-[0.08em] text-[#41403C]">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-[#E5E2DB]">

                        @forelse($communications as $communication)

                            @php

                                $latestMessage = $communication->messages->first();

                                $client = $communication->client;

                                $lawyer = $communication->lawyer;

                                $clientName = $client->name ?? 'Unassigned';

                                $lawyerName = $lawyer->name ?? 'Unassigned';

                                $body = $latestMessage
                                    ? (
                                        $latestMessage->message
                                        ?? $latestMessage->body
                                        ?? $latestMessage->content
                                        ?? 'No message content'
                                    )
                                    : 'No message content';

                                $sender = $latestMessage?->sender;

                                $senderRole = strtolower($sender->role ?? '');

                                $messageType = in_array(
                                    $senderRole,
                                    ['client', 'lawyer']
                                )
                                    ? $senderRole
                                    : 'other';

                                $isUnread = $latestMessage && (
                                    ($latestMessage->is_read ?? true) === false ||
                                    (
                                        ($latestMessage->read_at ?? null) === null &&
                                        ($latestMessage->status ?? '') === 'unread'
                                    )
                                );

                            @endphp


                            <tr
                                x-show="matches($el)"
                                data-type="{{ $messageType }}"
                                class="transition duration-200 hover:bg-[#FAF9F6]"
                            >

                                {{-- CASE --}}
                                <td class="whitespace-nowrap px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#C9A96E]/25 bg-[#C9A96E]/10 text-[#B89452]">

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

                                        <div>

                                            <p class="font-semibold text-[#11110F]">
                                                #{{ $communication->case_number }}
                                            </p>

                                            <p class="mt-1 text-xs text-[#77756F]">
                                                {{ $communication->case_type ?? 'Case' }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- CLIENT --}}
                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-[#C9A96E]/25 bg-[#F7F4ED] text-xs font-semibold text-[#B89452]">
                                            {{ strtoupper(substr($clientName, 0, 1)) }}
                                        </div>

                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-semibold text-[#11110F]">
                                                {{ $clientName }}
                                            </p>

                                            <p class="mt-1 max-w-[180px] truncate text-xs text-[#77756F]">
                                                {{ $client->email ?? 'No email' }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- LAWYER --}}
                                <td class="px-6 py-5">

                                    @if($lawyer)

                                        <div class="flex items-center gap-3">

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-[#477C91]/25 bg-[#EEF5F8] text-xs font-semibold text-[#477C91]">
                                                {{ strtoupper(substr($lawyerName, 0, 1)) }}
                                            </div>

                                            <div class="min-w-0">

                                                <p class="truncate text-sm font-semibold text-[#11110F]">
                                                    {{ $lawyerName }}
                                                </p>

                                                <p class="mt-1 max-w-[180px] truncate text-xs text-[#77756F]">
                                                    {{ $lawyer->email ?? 'No email' }}
                                                </p>

                                            </div>

                                        </div>

                                    @else

                                        <span class="text-sm text-[#77756F]">
                                            No lawyer assigned
                                        </span>

                                    @endif

                                </td>


                                {{-- LATEST MESSAGE --}}
                                <td class="max-w-sm px-6 py-5">

                                    <div class="max-w-sm">

                                        @if($latestMessage)

                                            <div class="mb-2">

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

                                            <p class="truncate text-sm text-[#77756F]">
                                                {{ $body }}
                                            </p>

                                        @else

                                            <p class="text-sm italic text-[#77756F]">
                                                No messages
                                            </p>

                                        @endif

                                    </div>

                                </td>


                                {{-- DATE --}}
                                <td class="whitespace-nowrap px-6 py-5">

                                    @if($latestMessage)

                                        <p class="text-sm text-[#41403C]">
                                            {{ optional($latestMessage->created_at)->format('M d, Y') ?? '—' }}
                                        </p>

                                        <p class="mt-1 text-xs text-[#77756F]">
                                            {{ optional($latestMessage->created_at)->format('h:i A') ?? '' }}
                                        </p>

                                    @else

                                        <span class="text-sm text-[#77756F]">
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- ACTION --}}
                                <td class="whitespace-nowrap px-6 py-5 text-right">

                                    <a
                                        href="{{ route('admin.communication.show', $communication) }}"
                                        class="inline-flex h-9 items-center gap-2 rounded-lg border border-[#C9A96E]/35 bg-white px-3.5 text-xs font-semibold text-[#B89452] transition duration-200 hover:-translate-y-px hover:bg-[#F7F4ED] hover:text-[#C9A96E]"
                                    >

                                        View

                                        <svg
                                            class="h-4 w-4 text-[#B89452]"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            aria-hidden="true"
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


                        @empty

                            <tr>

                                <td colspan="6" class="px-6 py-16 text-center">

                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-[#C9A96E]/25 bg-[#F7F4ED] text-[#B89452]">

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
                                                stroke-width="1.8"
                                                d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8A8.5 8.5 0 014.7 7.6 8.38 8.38 0 0112.5 3h.5a8.5 8.5 0 018 8v.5z"
                                            />
                                        </svg>

                                    </div>

                                    <h3 class="mt-5 text-base font-semibold text-[#11110F]">
                                        No Communications Yet
                                    </h3>

                                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#77756F]">
                                        There are currently no conversations between clients, lawyers, and the firm.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- ========================================================
                MOBILE
            ========================================================= --}}

            <div class="divide-y divide-[#E5E2DB] md:hidden">

                @forelse($communications as $communication)

                    @php

                        $latestMessage = $communication->messages->first();

                        $client = $communication->client;

                        $lawyer = $communication->lawyer;

                        $clientName = $client->name ?? 'Unassigned';

                        $lawyerName = $lawyer->name ?? 'Unassigned';

                        $body = $latestMessage
                            ? (
                                $latestMessage->message
                                ?? $latestMessage->body
                                ?? $latestMessage->content
                                ?? 'No message content'
                            )
                            : 'No message content';

                        $sender = $latestMessage?->sender;

                        $senderRole = strtolower($sender->role ?? '');

                        $messageType = in_array(
                            $senderRole,
                            ['client', 'lawyer']
                        )
                            ? $senderRole
                            : 'other';

                        $isUnread = $latestMessage && (
                            ($latestMessage->is_read ?? true) === false ||
                            (
                                ($latestMessage->read_at ?? null) === null &&
                                ($latestMessage->status ?? '') === 'unread'
                            )
                        );

                    @endphp


                    <div
                        x-show="matches($el)"
                        data-type="{{ $messageType }}"
                        class="p-5 transition duration-200 hover:bg-[#FAF9F6]"
                    >

                        {{-- Top --}}
                        <div class="flex items-start justify-between gap-4">

                            <div class="flex min-w-0 items-center gap-3">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-[#C9A96E]/25 bg-[#F7F4ED] text-[#B89452]">

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

                                <div class="min-w-0">

                                    <p class="truncate text-sm font-semibold text-[#11110F]">
                                        #{{ $communication->case_number }}
                                    </p>

                                    <p class="mt-1 truncate text-xs text-[#77756F]">
                                        {{ $communication->case_type ?? 'Case' }}
                                    </p>

                                </div>

                            </div>


                            @if($isUnread)

                                <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full border border-[#B98525]/30 bg-[#FFF8E8] px-2.5 py-1 text-[11px] font-semibold text-[#795A18]">

                                    <span class="h-1.5 w-1.5 rounded-full bg-[#B98525]"></span>

                                    Unread

                                </span>

                            @else

                                <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full border border-[#3D8B5A]/30 bg-[#EFF8F2] px-2.5 py-1 text-[11px] font-semibold text-[#27633D]">

                                    <span class="h-1.5 w-1.5 rounded-full bg-[#3D8B5A]"></span>

                                    Read

                                </span>

                            @endif

                        </div>


                        {{-- People --}}
                        <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">

                            <div class="rounded-xl border border-[#E5E2DB] bg-[#F7F4ED] p-4">

                                <p class="text-[11px] font-medium uppercase tracking-[0.08em] text-[#77756F]">
                                    Client
                                </p>

                                <p class="mt-2 text-sm font-semibold text-[#11110F]">
                                    {{ $clientName }}
                                </p>

                                <p class="mt-1 truncate text-xs text-[#77756F]">
                                    {{ $client->email ?? 'No email' }}
                                </p>

                            </div>


                            <div class="rounded-xl border border-[#E5E2DB] bg-[#F7F4ED] p-4">

                                <p class="text-[11px] font-medium uppercase tracking-[0.08em] text-[#77756F]">
                                    Lawyer
                                </p>

                                <p class="mt-2 text-sm font-semibold text-[#11110F]">
                                    {{ $lawyerName }}
                                </p>

                                <p class="mt-1 truncate text-xs text-[#77756F]">
                                    {{ $lawyer->email ?? 'No email' }}
                                </p>

                            </div>

                        </div>


                        {{-- Message --}}
                        <div class="mt-5">

                            <p class="text-[11px] font-medium uppercase tracking-[0.08em] text-[#77756F]">
                                Latest Message
                            </p>

                            <p class="mt-2 line-clamp-3 text-sm leading-6 text-[#77756F]">
                                {{ $body }}
                            </p>

                        </div>


                        {{-- Bottom --}}
                        <div class="mt-5 flex items-center justify-between gap-4 border-t border-[#E5E2DB] pt-4">

                            <span class="text-xs text-[#77756F]">

                                @if($latestMessage)

                                    {{ optional($latestMessage->created_at)->format('M d, Y · h:i A') ?? '—' }}

                                @else

                                    —

                                @endif

                            </span>


                            <a
                                href="{{ route('admin.communication.show', $communication) }}"
                                class="inline-flex h-9 items-center gap-2 rounded-lg border border-[#C9A96E]/35 bg-white px-3 text-xs font-semibold text-[#B89452] transition duration-200 hover:bg-[#F7F4ED] hover:text-[#C9A96E]"
                            >

                                View

                                <svg
                                    class="h-4 w-4 text-[#B89452]"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>

                            </a>

                        </div>

                    </div>

                @empty

                    <div class="px-5 py-16 text-center">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-[#C9A96E]/25 bg-[#F7F4ED] text-[#B89452]">

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
                                    stroke-width="1.8"
                                    d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8A8.5 8.5 0 014.7 7.6 8.38 8.38 0 0112.5 3h.5a8.5 8.5 0 018 8v.5z"
                                />
                            </svg>

                        </div>

                        <h3 class="mt-5 text-base font-semibold text-[#11110F]">
                            No Communications Yet
                        </h3>

                        <p class="mt-2 text-sm text-[#77756F]">
                            There are currently no conversations to display.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>


        {{-- ============================================================
            CUSTOM PAGINATION
        ============================================================ --}}

        @if($communications->hasPages())

            <div class="mt-6 rounded-xl border border-[#E5E2DB] bg-white px-4 py-3">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">


                    {{-- Results --}}
                    <div class="text-xs text-[#77756F]">

                        Showing

                        <span class="font-semibold text-[#41403C]">
                            {{ $communications->firstItem() }}
                        </span>

                        to

                        <span class="font-semibold text-[#41403C]">
                            {{ $communications->lastItem() }}
                        </span>

                        of

                        <span class="font-semibold text-[#41403C]">
                            {{ $communications->total() }}
                        </span>

                        conversations

                    </div>


                    {{-- Pagination --}}
                    <nav
                        class="flex items-center gap-1.5"
                        aria-label="Pagination"
                    >

                        {{-- ==================================================
                            PREVIOUS
                        ================================================== --}}

                        @if($communications->onFirstPage())

                            <span
                                class="inline-flex h-9 cursor-not-allowed items-center gap-2 rounded-lg border border-[#E5E2DB] bg-white px-3 text-xs font-semibold text-[#9B9992]"
                                aria-disabled="true"
                            >

                                <svg
                                    class="h-4 w-4 text-[#9B9992]"
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

                                <span class="text-[#9B9992]">
                                    Previous
                                </span>

                            </span>

                        @else

                            <a
                                href="{{ $communications->previousPageUrl() }}"
                                rel="prev"
                                aria-label="Go to previous page"
                                class="inline-flex h-9 items-center gap-2 rounded-lg border border-[#E5E2DB] bg-white px-3 text-xs font-semibold text-[#C9A96E] transition duration-200 hover:border-[#C9A96E]/50 hover:bg-white hover:text-[#D8BE8A]"
                            >

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
                                        stroke-width="1.8"
                                        d="M15 19l-7-7 7-7"
                                    />
                                </svg>

                                <span class="text-[#C9A96E] hover:text-[#D8BE8A]">
                                    Previous
                                </span>

                            </a>

                        @endif


                        {{-- ==================================================
                            DESKTOP PAGE NUMBERS
                        ================================================== --}}

                        <div class="hidden items-center gap-1 sm:flex">

                            @php

                                $currentPage = $communications->currentPage();

                                $lastPage = $communications->lastPage();

                                $startPage = max(
                                    1,
                                    $currentPage - 1
                                );

                                $endPage = min(
                                    $lastPage,
                                    $currentPage + 1
                                );

                            @endphp


                            {{-- First Page --}}
                            @if($startPage > 1)

                                <a
                                    href="{{ $communications->url(1) }}"
                                    class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg border border-[#E5E2DB] bg-white px-3 text-xs font-semibold text-[#77756F] transition duration-200 hover:border-[#C9A96E]/40 hover:bg-white hover:text-[#C9A96E]"
                                >
                                    1
                                </a>

                                @if($startPage > 2)

                                    <span class="px-1 text-xs text-[#9B9992]">
                                        ...
                                    </span>

                                @endif

                            @endif


                            {{-- Page Numbers --}}
                            @for($page = $startPage; $page <= $endPage; $page++)

                                @if($page == $currentPage)

                                    <span
                                        class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg border border-[#C9A96E]/40 bg-[#F7F4ED] px-3 text-xs font-semibold text-[#C9A96E]"
                                        aria-current="page"
                                    >
                                        {{ $page }}
                                    </span>

                                @else

                                    <a
                                        href="{{ $communications->url($page) }}"
                                        class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg border border-[#E5E2DB] bg-white px-3 text-xs font-semibold text-[#77756F] transition duration-200 hover:border-[#C9A96E]/40 hover:bg-white hover:text-[#C9A96E]"
                                    >
                                        {{ $page }}
                                    </a>

                                @endif

                            @endfor


                            {{-- Last Page --}}
                            @if($endPage < $lastPage)

                                @if($endPage < $lastPage - 1)

                                    <span class="px-1 text-xs text-[#9B9992]">
                                        ...
                                    </span>

                                @endif

                                <a
                                    href="{{ $communications->url($lastPage) }}"
                                    class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg border border-[#E5E2DB] bg-white px-3 text-xs font-semibold text-[#77756F] transition duration-200 hover:border-[#C9A96E]/40 hover:bg-white hover:text-[#C9A96E]"
                                >
                                    {{ $lastPage }}
                                </a>

                            @endif

                        </div>


                        {{-- Mobile Page Indicator --}}
                        <span
                            class="inline-flex h-9 items-center rounded-lg border border-[#C9A96E]/30 bg-[#F7F4ED] px-3 text-xs font-semibold text-[#C9A96E] sm:hidden"
                        >

                            {{ $communications->currentPage() }}

                            /

                            {{ $communications->lastPage() }}

                        </span>


                        {{-- ==================================================
                            NEXT
                        ================================================== --}}

                        @if($communications->hasMorePages())

                            <a
                                href="{{ $communications->nextPageUrl() }}"
                                rel="next"
                                aria-label="Go to next page"
                                class="inline-flex h-9 items-center gap-2 rounded-lg border border-[#E5E2DB] bg-white px-3 text-xs font-semibold text-[#C9A96E] transition duration-200 hover:border-[#C9A96E]/50 hover:bg-white hover:text-[#D8BE8A]"
                            >

                                <span class="text-[#C9A96E] hover:text-[#D8BE8A]">
                                    Next
                                </span>

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
                                        stroke-width="1.8"
                                        d="M9 5l7 7-7 7"
                                    />

                                </svg>

                            </a>

                        @else

                            <span
                                class="inline-flex h-9 cursor-not-allowed items-center gap-2 rounded-lg border border-[#E5E2DB] bg-white px-3 text-xs font-semibold text-[#9B9992]"
                                aria-disabled="true"
                            >

                                <span class="text-[#9B9992]">
                                    Next
                                </span>

                                <svg
                                    class="h-4 w-4 text-[#9B9992]"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
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

                </div>

            </div>

        @endif

    </div>

</div>

@endsection