@extends('layouts.app')

@section('title', 'Reply · Law Firm')

@section('content')

    @php
        $client = $case->client;

        $clientName = $client?->name ?? 'Client';

        $initial = strtoupper(substr(trim($clientName), 0, 1));
    @endphp

    <div x-data="{
        content: '',
        sending: false,
    
        submitReply() {
            if (!this.content.trim() || this.sending) {
                return;
            }
    
            this.sending = true;
            this.$refs.replyForm.submit();
        }
    }" class="min-h-screen bg-[#F7F4ED] text-[#181815]">

        <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">

            {{-- Back --}}
            <div class="mb-6">

                <a href="{{ route('lawyer.messages.show', $messages->last()) }}"
                    class="inline-flex items-center gap-2 text-[10px] font-semibold uppercase tracking-[0.12em] text-[#77756F] transition hover:text-[#B89452]">

                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>

                    Back to Conversation

                </a>

            </div>

            {{-- Page heading --}}
            <div class="mb-7">

                <div class="mb-2 text-[10px] font-bold uppercase tracking-[0.22em] text-[#B89452]">
                    Client Communication
                </div>

                <h1 class="font-serif text-4xl font-semibold tracking-tight text-[#181815] sm:text-5xl">
                    Reply
                </h1>

                <p class="mt-3 max-w-xl text-[12px] leading-6 text-[#77756F]">
                    Send a secure message to your client regarding this case.
                </p>

            </div>

            {{-- Client / Case information --}}
            <section class="mb-5 border border-[#D4D1CA] bg-white">

                <div class="flex items-center justify-between px-5 py-5 sm:px-6">

                    <div class="flex min-w-0 items-center gap-3">

                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#181815] font-serif text-lg font-semibold text-[#D8BE8A]">
                            {{ $initial }}
                        </div>

                        <div class="min-w-0">

                            <div class="truncate text-[13px] font-semibold text-[#181815]">
                                {{ $clientName }}
                            </div>

                            <div class="mt-1 text-[9px] font-bold uppercase tracking-[0.12em] text-[#B89452]">
                                Case #{{ $case->case_number }}
                            </div>

                        </div>

                    </div>

                    <div class="hidden text-right sm:block">

                        <div class="text-[8px] font-bold uppercase tracking-[0.14em] text-[#9B9992]">
                            Recipient
                        </div>

                        <div class="mt-1 text-[10px] text-[#41403C]">
                            {{ $client?->email ?? 'Client' }}
                        </div>

                    </div>

                </div>

            </section>

            {{-- Previous conversation --}}
            @if ($messages->isNotEmpty())

                <section class="mb-5 border border-[#D4D1CA] bg-white">

                    <div class="border-b border-[#E8E6E1] px-5 py-4 sm:px-6">

                        <div class="text-[9px] font-bold uppercase tracking-[0.16em] text-[#181815]">
                            Previous Conversation
                        </div>

                    </div>

                    <div class="max-h-[360px] space-y-4 overflow-y-auto bg-[#FAF9F6] px-4 py-5 sm:px-6">

                        @foreach ($messages as $message)
                            @php
                                $isLawyer = (int) $message->sender_id === (int) Auth::id();
                            @endphp

                            <div class="flex {{ $isLawyer ? 'justify-end' : 'justify-start' }}">

                                <div class="max-w-[85%] sm:max-w-[70%]">

                                    <div
                                        class="mb-1 flex items-center gap-2
                                    {{ $isLawyer ? 'justify-end' : 'justify-start' }}">

                                        <span class="text-[8px] font-bold uppercase tracking-[0.1em] text-[#9B9992]">
                                            {{ $isLawyer ? 'You' : $message->sender?->name ?? 'Client' }}
                                        </span>

                                    </div>

                                    <div
                                        class="
                                        px-4 py-3 text-[11px] leading-5
                                        {{ $isLawyer
                                            ? 'rounded-[12px_3px_12px_12px] bg-[#181815] text-white'
                                            : 'rounded-[3px_12px_12px_12px] border border-[#E8E6E1] bg-white text-[#41403C]' }}
                                    ">
                                        {{ $message->content }}
                                    </div>

                                    <div
                                        class="mt-1.5 text-[8px] text-[#9B9992]
                                    {{ $isLawyer ? 'text-right' : 'text-left' }}">
                                        {{ $message->created_at->format('d M Y · g:i A') }}
                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>

                </section>

            @endif

            {{-- Reply form --}}
            <section class="border border-[#D4D1CA] bg-white">

                <div class="border-b border-[#E8E6E1] px-5 py-4 sm:px-6">

                    <div class="text-[9px] font-bold uppercase tracking-[0.16em] text-[#181815]">
                        Write Your Reply
                    </div>

                </div>

                <form x-ref="replyForm" method="POST" action="{{ route('lawyer.messages.reply', $case) }}"
                    @submit="sending = true" class="p-5 sm:p-6">

                    @csrf

                    {{-- Validation error --}}
                    @if ($errors->any())

                        <div class="mb-5 border border-[#B94A48]/30 bg-[#FDF0EF] px-4 py-3">

                            <div class="text-[9px] font-bold uppercase tracking-[0.1em] text-[#7D302F]">
                                Please correct the following:
                            </div>

                            <ul class="mt-2 space-y-1">

                                @foreach ($errors->all() as $error)
                                    <li class="text-[10px] text-[#7D302F]">
                                        {{ $error }}
                                    </li>
                                @endforeach

                            </ul>

                        </div>

                    @endif

                    {{-- Message --}}
                    <div>

                        <label for="content"
                            class="mb-2 block text-[9px] font-bold uppercase tracking-[0.14em] text-[#77756F]">
                            Message
                        </label>

                        <textarea id="content" name="content" x-model="content" rows="8" maxlength="5000" required autofocus
                            placeholder="Write your reply to {{ $clientName }}..."
                            class="w-full resize-y border border-[#D4D1CA] bg-[#FAF9F6] px-4 py-3 text-[12px] leading-6 text-[#181815] outline-none transition placeholder:text-[#9B9992] focus:border-[#B89452] focus:ring-1 focus:ring-[#B89452]/20"
                            @keydown.ctrl.enter="submitReply()" @keydown.meta.enter="submitReply()"></textarea>

                        <div class="mt-2 flex items-center justify-between">

                            <div class="text-[8px] text-[#9B9992]">
                                Press
                                <span class="font-semibold text-[#77756F]">
                                    Ctrl + Enter
                                </span>
                                to send.
                            </div>

                            <div class="text-[8px] text-[#9B9992]">
                                <span x-text="content.length"></span>/5000
                            </div>

                        </div>

                    </div>

                    {{-- Buttons --}}
                    <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">

                        <a href="{{ route('lawyer.messages.show', $messages->last()) }}"
                            class="inline-flex h-11 items-center justify-center border border-[#D4D1CA] px-5 text-[9px] font-bold uppercase tracking-[0.1em] text-[#41403C] transition hover:border-[#B89452] hover:text-[#B89452]">
                            Cancel
                        </a>

                        <button type="submit" :disabled="sending || !content.trim()"
                            class="inline-flex h-11 items-center justify-center gap-2 bg-[#181815] px-6 text-[9px] font-bold uppercase tracking-[0.1em] text-white transition hover:bg-[#B89452] disabled:cursor-not-allowed disabled:opacity-40">

                            <template x-if="!sending">

                                <span class="flex items-center gap-2">

                                    Send Reply

                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.7"
                                        viewBox="0 0 24 24">
                                        <path d="M22 2L11 13"></path>
                                        <path d="M22 2l-7 20-4-9-9-4 20-7z"></path>
                                    </svg>

                                </span>

                            </template>

                            <template x-if="sending">

                                <span class="flex items-center gap-2">

                                    <svg class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="3"></circle>

                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"></path>

                                    </svg>

                                    Sending...

                                </span>

                            </template>

                        </button>

                    </div>

                </form>

            </section>

        </div>

    </div>

@endsection
