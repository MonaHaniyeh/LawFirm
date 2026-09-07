@extends('layouts.app')

@section('title', 'Conversation · Law Firm')

@section('content')

@php
    $client = $case->client;

    $clientName = $client?->name ?? 'Client';

    $initial = strtoupper(
        substr(trim($clientName), 0, 1)
    );
@endphp

<div class="min-h-screen bg-[#F7F4ED] text-[#181815]">

    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="mb-6">

            <a
                href="{{ route('lawyer.messages.index') }}"
                class="inline-flex items-center gap-2 text-[10px] font-semibold uppercase tracking-[0.12em] text-[#77756F] transition hover:text-[#B89452]"
            >
                <svg
                    class="h-3.5 w-3.5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>

                Messages
            </a>

            <div class="mt-5">

                <div class="text-[10px] font-bold uppercase tracking-[0.22em] text-[#B89452]">
                    Client Communication
                </div>

                <div class="mt-2 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                    <div>

                        <h1 class="font-serif text-4xl font-semibold tracking-tight text-[#181815]">
                            Conversation
                        </h1>

                        <p class="mt-2 text-[11px] text-[#77756F]">
                            Continue your conversation regarding this case.
                        </p>

                    </div>

                    {{-- REPLY BUTTON --}}
                    <a
                        href="{{ route('lawyer.messages.reply.form', $case) }}"
                        class="inline-flex h-10 items-center justify-center gap-2 bg-[#181815] px-5 text-[9px] font-bold uppercase tracking-[0.1em] text-white transition hover:bg-[#B89452]"
                    >

                        <svg
                            class="h-3.5 w-3.5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21.5 4.5L12 14"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21.5 4.5l-6 17-3.5-7.5L4.5 10l17-5.5z"
                            />
                        </svg>

                        Reply

                    </a>

                </div>
            </div>

        </div>


        {{-- CHAT PANEL --}}
        <section class="overflow-hidden border border-[#D4D1CA] bg-white shadow-sm">

            {{-- CLIENT HEADER --}}
            <div class="flex min-h-[72px] items-center justify-between border-b border-[#E8E6E1] px-5 sm:px-6">

                <div class="flex min-w-0 items-center gap-3">

                    {{-- CLIENT INITIAL --}}
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#181815] font-serif text-base font-semibold text-[#D8BE8A]">
                        {{ $initial }}
                    </div>

                    <div class="min-w-0">

                        <div class="truncate text-[12px] font-semibold text-[#181815]">
                            {{ $clientName }}
                        </div>

                        <div class="mt-1 text-[9px] uppercase tracking-[0.12em] text-[#B89452]">
                            Case #{{ $case->case_number }}
                        </div>

                    </div>

                </div>


                {{-- CASE LINK --}}
                <a
                    href="{{ route('lawyer.cases.show', $case) }}"
                    class="hidden items-center gap-1.5 border border-[#D4D1CA] px-3 py-2 text-[9px] font-bold uppercase tracking-[0.08em] text-[#41403C] transition hover:border-[#B89452] hover:text-[#B89452] sm:flex"
                >

                    View Case

                    <svg
                        class="h-3 w-3"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.7"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 5l7 7-7 7"
                        />
                    </svg>

                </a>

            </div>


            {{-- MESSAGES --}}
            <div
                class="max-h-[560px] min-h-[420px] space-y-5 overflow-y-auto bg-[#FAF9F6] px-4 py-6 sm:px-7"
            >

                @forelse($messages as $message)

                    @php
                        $isLawyer = (int) $message->sender_id === (int) Auth::id();
                    @endphp

                    <div class="flex {{ $isLawyer ? 'justify-end' : 'justify-start' }}">

                        <div class="max-w-[82%] sm:max-w-[68%]">

                            {{-- SENDER --}}
                            <div
                                class="mb-1.5 flex items-center gap-2 {{ $isLawyer ? 'justify-end' : 'justify-start' }}"
                            >

                                <span class="text-[8px] font-bold uppercase tracking-[0.1em] text-[#9B9992]">

                                    {{ $isLawyer ? 'You' : ($message->sender?->name ?? 'Client') }}

                                </span>

                            </div>


                            {{-- MESSAGE BUBBLE --}}
                            <div
                                class="
                                    px-4 py-3 text-[11px] leading-5
                                    {{ $isLawyer
                                        ? 'rounded-[12px_3px_12px_12px] bg-[#181815] text-white'
                                        : 'rounded-[3px_12px_12px_12px] border border-[#E8E6E1] bg-white text-[#41403C]'
                                    }}
                                "
                            >

                                {{ $message->content }}

                            </div>


                            {{-- TIME --}}
                            <div
                                class="mt-1.5 text-[8px] text-[#9B9992] {{ $isLawyer ? 'text-right' : 'text-left' }}"
                            >

                                {{ $message->created_at->format('d M Y · g:i A') }}

                            </div>

                        </div>

                    </div>

                @empty

                    {{-- EMPTY STATE --}}
                    <div class="flex min-h-[350px] items-center justify-center text-center">

                        <div>

                            <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-full border border-[#D4D1CA] text-[#B89452]">

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
                                        d="M8 10h8M8 14h5m-8 5l-3 2 1-4.5A8 8 0 013 9.5C3 5.91 6.58 3 11 3h2c4.42 0 8 2.91 8 6.5S17.42 16 13 16h-2c-1.18 0-2.3-.2-3.3-.57L5 19z"
                                    />
                                </svg>

                            </div>

                            <p class="mt-3 text-[11px] text-[#77756F]">
                                No messages yet.
                            </p>

                        </div>

                    </div>

                @endforelse

            </div>


            {{-- REPLY ACTION --}}
            <div class="border-t border-[#E8E6E1] bg-white p-4 sm:p-5">

                <a
                    href="{{ route('lawyer.messages.reply.form', $case) }}"
                    class="flex h-11 w-full items-center justify-center gap-2 bg-[#181815] text-[9px] font-bold uppercase tracking-[0.1em] text-white transition hover:bg-[#B89452]"
                >

                    <svg
                        class="h-3.5 w-3.5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.7"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21.5 4.5L12 14"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21.5 4.5l-6 17-3.5-7.5L4.5 10l17-5.5z"
                        />
                    </svg>

                    Reply to {{ $clientName }}

                </a>

            </div>

        </section>

    </div>

</div>

@endsection
