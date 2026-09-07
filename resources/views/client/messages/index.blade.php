@extends('layouts.app')

@section('title', 'Messages')

@section('breadcrumb')
    Messages
@endsection

@section('content')

<div class="space-y-6">

    {{-- ========================================================= --}}
    {{-- Header --}}
    {{-- ========================================================= --}}

    <div class="rounded-xl border border-[#ddd7ca] bg-[#f7f4ed] p-5 sm:p-6">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="min-w-0">

                <p class="text-[11px] font-medium uppercase tracking-[0.16em] text-[#77736b]">
                    Communication
                </p>

                <h1 class="mt-1 text-xl font-semibold text-[#151515] sm:text-2xl">
                    Messages
                </h1>

                <p class="mt-2 text-sm leading-6 text-[#77736b]">
                    Communicate directly with the lawyers handling your cases.
                </p>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- Status --}}
    {{-- ========================================================= --}}

    @if(session('status'))

        <div
            x-data="{ show: true }"
            x-show="show"
            class="flex items-start justify-between gap-4 rounded-lg border border-[#cddbcf] bg-[#f1f7f2] px-4 py-3 text-xs text-[#52745a]"
        >

            <span>
                {{ session('status') }}
            </span>

            <button
                type="button"
                @click="show = false"
                class="shrink-0"
            >
                ×
            </button>

        </div>

    @endif


    @if(session('error'))

        <div
            x-data="{ show: true }"
            x-show="show"
            class="flex items-start justify-between gap-4 rounded-lg border border-[#e1c9c5] bg-[#faf1ef] px-4 py-3 text-xs text-[#914f49]"
        >

            <span>
                {{ session('error') }}
            </span>

            <button
                type="button"
                @click="show = false"
                class="shrink-0"
            >
                ×
            </button>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- Message Threads --}}
    {{-- ========================================================= --}}

    <section class="overflow-hidden rounded-xl border border-[#ddd7ca] bg-white">

        <div class="border-b border-[#ddd7ca] px-5 py-4">

            <h2 class="text-sm font-semibold text-[#151515]">
                Conversations
            </h2>

            <p class="mt-1 text-xs text-[#77736b]">
                Your conversations with your lawyers.
            </p>

        </div>


        @if($threads->count())

            <div class="divide-y divide-[#eee9df]">

                @foreach($threads as $thread)

                    @php

                        $latestMessage = $thread->latestMessage;

                        $isUnread =
                            $latestMessage
                            && (int) $latestMessage->receiver_id === (int) auth()->id()
                            && (bool) $latestMessage->is_new;

                    @endphp


                    {{-- ================================================= --}}
                    {{-- Conversation --}}
                    {{-- ================================================= --}}

                    <a
                        href="{{ route('client.messages.show', $thread->latestMessage) }}"
                        class="block p-5 transition hover:bg-[#faf8f3]"
                    >

                        <div class="flex gap-4">


                            {{-- Avatar --}}

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#151515] text-sm font-semibold text-white"
                            >

                                {{ strtoupper(
                                    substr(
                                        $thread->lawyer?->name ?? 'L',
                                        0,
                                        1
                                    )
                                ) }}

                            </div>


                            {{-- Content --}}

                            <div class="min-w-0 flex-1">

                                {{-- Top row --}}

                                <div class="flex flex-col gap-1 sm:flex-row sm:items-start sm:justify-between">

                                    <div class="min-w-0">

                                        <div class="flex flex-wrap items-center gap-2">

                                            <h3 class="break-words text-sm font-semibold text-[#151515]">

                                                {{ $thread->lawyer?->name ?? 'Assigned Lawyer' }}

                                            </h3>


                                            @if($isUnread)

                                                <span
                                                    class="rounded-full bg-[#e9f1eb] px-2 py-0.5 text-[9px] font-medium text-[#52745a]"
                                                >
                                                    New
                                                </span>

                                            @endif

                                        </div>


                                        <p class="mt-1 break-words text-[11px] text-[#8b7041]">

                                            {{ $thread->case_number }}

                                        </p>

                                    </div>


                                    @if($latestMessage)

                                        <span class="shrink-0 text-[10px] text-[#99958d]">

                                            {{ $latestMessage->created_at?->diffForHumans() }}

                                        </span>

                                    @endif

                                </div>


                                {{-- Message preview --}}

                                @if($latestMessage)

                                    @if($latestMessage->subject)

                                        <p class="mt-3 break-words text-xs font-medium text-[#151515]">

                                            {{ $latestMessage->subject }}

                                        </p>

                                    @endif


                                    <p class="mt-1 line-clamp-2 break-words text-xs leading-5 text-[#77736b]">

                                        {{ $latestMessage->content }}

                                    </p>

                                @else

                                    <p class="mt-3 text-xs italic text-[#99958d]">

                                        No messages yet. Start a conversation with your lawyer.

                                    </p>

                                @endif


                                {{-- Bottom information --}}

                                <div class="mt-3 flex items-center gap-2">

                                    <span class="text-[10px] font-medium text-[#8b7041]">

                                        {{ $thread->case?->case_type ?? 'Legal Case' }}

                                    </span>

                                    <span class="text-[#c9c3b8]">
                                        •
                                    </span>

                                    <span class="text-[10px] text-[#99958d]">

                                        View conversation →

                                    </span>

                                </div>

                            </div>

                        </div>

                    </a>

                @endforeach

            </div>


        @else

            {{-- ================================================= --}}
            {{-- Empty State --}}
            {{-- ================================================= --}}

            <div class="px-5 py-14 text-center">

                <div
                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#f5f1e8] text-[#8b7041]"
                >
                    ✉
                </div>


                <h3 class="mt-4 text-sm font-semibold text-[#151515]">
                    No messages yet
                </h3>


                <p class="mx-auto mt-2 max-w-sm text-xs leading-5 text-[#77736b]">

                    Once your lawyer sends you a message, your conversation will appear here.

                </p>


                <a
                    href="{{ route('client.cases.index') }}"
                    class="mt-4 inline-flex rounded-lg border border-[#ddd7ca] bg-white px-3.5 py-2 text-xs font-medium text-[#151515] hover:bg-[#f7f4ed]"
                >
                    View my cases
                </a>

            </div>

        @endif

    </section>

</div>

@endsection