@extends('layouts.app')

@section('title', 'Messages · Law Firm')

@section('content')

<div
    x-data="{
        search: ''
    }"
    class="min-h-screen bg-[#F7F4ED] text-[#181815]"
>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

            <div>

                <div class="mb-2 text-[10px] font-bold uppercase tracking-[0.22em] text-[#B89452]">
                    Communication
                </div>

                <h1 class="font-serif text-4xl font-semibold tracking-tight text-[#181815] sm:text-5xl">
                    Messages
                </h1>

                <p class="mt-3 max-w-xl text-[12px] leading-6 text-[#77756F]">
                    Your conversations with clients, organized by case.
                    Open a conversation to continue communication directly.
                </p>

            </div>

            {{-- Search --}}
            <div class="relative w-full sm:w-64">

                <svg
                    class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#9B9992]"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    viewBox="0 0 24 24"
                >
                    <circle cx="11" cy="11" r="7"></circle>
                    <path d="m20 20-4-4"></path>
                </svg>

                <input
                    type="text"
                    x-model="search"
                    placeholder="Search conversations..."
                    class="h-10 w-full border border-[#D4D1CA] bg-white pl-9 pr-3 text-[11px] text-[#181815] outline-none transition placeholder:text-[#9B9992] focus:border-[#B89452] focus:ring-1 focus:ring-[#B89452]/20"
                >

            </div>

        </div>

        {{-- Conversations --}}
        <section class="overflow-hidden border border-[#D4D1CA] bg-white">

            {{-- Section header --}}
            <div class="flex min-h-[60px] items-center justify-between border-b border-[#E8E6E1] px-5 sm:px-6">

                <div class="text-[10px] font-bold uppercase tracking-[0.16em] text-[#181815]">
                    Conversations
                </div>

                <div class="text-[10px] text-[#9B9992]">
                    {{ $threads->count() }}
                    {{ $threads->count() === 1 ? 'conversation' : 'conversations' }}
                </div>

            </div>

            {{-- Conversation list --}}
            @if($threads->isNotEmpty())

                <div>

                    @foreach($threads as $thread)

                        @php

                            $case = $thread->case;

                            $client = $thread->client;

                            $latestMessage = $thread->latestMessage;

                            $clientName = $client?->name ?? 'Client';

                            $caseNumber = $case?->case_number ?? 'N/A';

                            $initial = strtoupper(
                                substr(
                                    trim($clientName),
                                    0,
                                    1
                                )
                            );

                            $isUnread =
                                $latestMessage &&
                                (int) $latestMessage->receiver_id === (int) Auth::id() &&
                                (bool) $latestMessage->is_new;

                            $searchText = strtolower(
                                $clientName . ' ' .
                                $caseNumber . ' ' .
                                ($latestMessage?->content ?? '')
                            );

                        @endphp

                        <a
                            href="{{ route('lawyer.messages.show', $latestMessage->id) }}"
                            x-show="
                                search === '' ||
                                @js($searchText).includes(search.toLowerCase())
                            "
                            class="group block border-b border-[#E8E6E1] transition last:border-b-0 hover:bg-[#FAF9F6]"
                        >

                            <div class="grid min-h-[88px] grid-cols-[42px_minmax(0,1fr)_auto] items-center gap-3 px-4 py-4 sm:grid-cols-[42px_minmax(170px,1fr)_minmax(220px,2fr)_auto] sm:gap-5 sm:px-6">

                                {{-- Avatar --}}
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#181815] font-serif text-base font-semibold text-[#D8BE8A]">
                                    {{ $initial }}
                                </div>

                                {{-- Client --}}
                                <div class="min-w-0">

                                    <div class="truncate text-[12px] font-semibold text-[#181815]">
                                        {{ $clientName }}
                                    </div>

                                    <div class="mt-1 truncate text-[9px] uppercase tracking-[0.1em] text-[#B89452]">
                                        Case #{{ $caseNumber }}
                                    </div>

                                </div>

                                {{-- Latest message --}}
                                <div class="col-span-2 min-w-0 sm:col-span-1">

                                    <div
                                        class="truncate text-[11px] leading-5
                                        {{ $isUnread
                                            ? 'font-semibold text-[#181815]'
                                            : 'text-[#77756F]'
                                        }}"
                                    >

                                        @if((int) $latestMessage->sender_id === (int) Auth::id())

                                            <span class="font-semibold text-[#B89452]">
                                                You:
                                            </span>

                                        @endif

                                        {{ $latestMessage->content }}

                                    </div>

                                </div>

                                {{-- Date / unread --}}
                                <div class="flex flex-col items-end gap-2">

                                    @if($latestMessage->created_at)

                                        <div class="whitespace-nowrap text-[9px] text-[#9B9992]">

                                            @if($latestMessage->created_at->isToday())

                                                {{ $latestMessage->created_at->format('g:i A') }}

                                            @elseif($latestMessage->created_at->isYesterday())

                                                Yesterday

                                            @else

                                                {{ $latestMessage->created_at->format('d M Y') }}

                                            @endif

                                        </div>

                                    @endif

                                    @if($isUnread)

                                        <span class="h-1.5 w-1.5 rounded-full bg-[#B89452]"></span>

                                    @endif

                                </div>

                            </div>

                        </a>

                    @endforeach

                </div>

            @else

                {{-- Empty --}}
                <div class="px-6 py-20 text-center">

                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full border border-[#D4D1CA] text-[#B89452]">

                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25H6.75a2.25 2.25 0 0 1-2.25-2.25V6.75m17.25 0A2.25 2.25 0 0 0 19.5 4.5h-15A2.25 2.25 0 0 0 2.25 6.75m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.92l-7.5 4.5a2.25 2.25 0 0 1-2.32 0l-7.5-4.5a2.25 2.25 0 0 1-1.07-1.92V6.75"
                            />
                        </svg>

                    </div>

                    <h2 class="mt-4 font-serif text-2xl font-semibold text-[#181815]">
                        No conversations yet
                    </h2>

                    <p class="mx-auto mt-2 max-w-sm text-[11px] leading-5 text-[#77756F]">
                        Messages from your clients will appear here once
                        a conversation is started on one of your assigned cases.
                    </p>

                </div>

            @endif

        </section>

    </div>

</div>

@endsection