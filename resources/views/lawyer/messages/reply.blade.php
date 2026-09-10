@extends('layouts.app')

@section('title', 'Reply · Law Firm')

@section('content')

@php
    $client = $case->client;
    $clientName = $client?->name ?? 'Client';

    $initial = strtoupper(
        substr(trim($clientName), 0, 1)
    );
@endphp

<div
    x-data="{
        content: '',
        sending: false,

        submitReply() {
            if (!this.content.trim() || this.sending) {
                return;
            }

            this.sending = true;

            this.$refs.replyForm.submit();
        }
    }"
    class="min-h-screen bg-[#F7F4ED] text-[#181815]"
>

    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- ================================================= --}}
        {{-- BACK --}}
        {{-- ================================================= --}}

        <div class="mb-6">

            <a
                href="{{ route('lawyer.messages.show', $case) }}"
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

                Back to Conversation

            </a>

        </div>


        {{-- ================================================= --}}
        {{-- PAGE HEADING --}}
        {{-- ================================================= --}}

        <div class="mb-7">

            <div
                class="mb-2 text-[10px] font-bold uppercase tracking-[0.22em] text-[#B89452]"
            >
                Client Communication
            </div>

            <h1
                class="font-serif text-4xl font-semibold tracking-tight text-[#181815] sm:text-5xl"
            >
                Reply
            </h1>

            <p
                class="mt-3 max-w-xl text-[12px] leading-6 text-[#77756F]"
            >
                Send a secure message to your client regarding this case.
            </p>

        </div>


        {{-- ================================================= --}}
        {{-- CLIENT / CASE INFORMATION --}}
        {{-- ================================================= --}}

        <section
            class="mb-5 border border-[#D4D1CA] bg-white"
        >

            <div
                class="flex items-center justify-between px-5 py-5 sm:px-6"
            >

                <div
                    class="flex min-w-0 items-center gap-3"
                >

                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#181815] font-serif text-lg font-semibold text-[#D8BE8A]"
                    >
                        {{ $initial }}
                    </div>

                    <div class="min-w-0">

                        <div
                            class="truncate text-[13px] font-semibold text-[#181815]"
                        >
                            {{ $clientName }}
                        </div>

                        <div
                            class="mt-1 text-[9px] font-bold uppercase tracking-[0.12em] text-[#B89452]"
                        >
                            Case #{{ $case->case_number }}
                        </div>

                    </div>

                </div>


                {{-- Recipient --}}

                <div class="hidden text-right sm:block">

                    <div
                        class="text-[8px] font-bold uppercase tracking-[0.14em] text-[#9B9992]"
                    >
                        Recipient
                    </div>

                    <div
                        class="mt-1 text-[10px] text-[#41403C]"
                    >
                        {{ $client?->email ?? 'Client' }}
                    </div>

                </div>

            </div>

        </section>


        {{-- ================================================= --}}
        {{-- PREVIOUS CONVERSATION --}}
        {{-- ================================================= --}}

        @if ($messages->isNotEmpty())

            <section
                class="mb-5 border border-[#D4D1CA] bg-white"
            >

                <div
                    class="border-b border-[#E8E6E1] px-5 py-4 sm:px-6"
                >

                    <div
                        class="text-[9px] font-bold uppercase tracking-[0.16em] text-[#181815]"
                    >
                        Previous Conversation
                    </div>

                </div>


                <div
                    class="max-h-[360px] space-y-4 overflow-y-auto bg-[#FAF9F6] px-4 py-5 sm:px-6"
                >

                    @foreach ($messages as $message)

                        @php
                            $isLawyer =
                                (int) $message->sender_id ===
                                (int) Auth::id();
                        @endphp

                        <div
                            class="flex {{ $isLawyer ? 'justify-end' : 'justify-start' }}"
                            data-message-id="{{ $message->id }}"
                        >

                            <div
                                class="max-w-[85%] sm:max-w-[70%]"
                            >

                                <div
                                    class="mb-1 flex items-center gap-2 {{ $isLawyer ? 'justify-end' : 'justify-start' }}"
                                >

                                    <span
                                        class="text-[8px] font-bold uppercase tracking-[0.1em] text-[#9B9992]"
                                    >
                                        {{
                                            $isLawyer
                                                ? 'You'
                                                : ($message->sender?->name ?? 'Client')
                                        }}
                                    </span>

                                </div>


                                <div
                                    class="
                                        px-4 py-3 text-[11px] leading-5
                                        {{
                                            $isLawyer
                                                ? 'rounded-[12px_3px_12px_12px] bg-[#181815] text-white'
                                                : 'rounded-[3px_12px_12px_12px] border border-[#E8E6E1] bg-white text-[#41403C]'
                                        }}
                                    "
                                >

                                    @if ($message->subject)

                                        <p
                                            class="mb-2 text-[10px] font-bold uppercase tracking-[0.08em] {{
                                                $isLawyer
                                                    ? 'text-[#D8BE8A]'
                                                    : 'text-[#B89452]'
                                            }}"
                                        >
                                            {{ $message->subject }}
                                        </p>

                                    @endif


                                    <div
                                        class="whitespace-pre-line break-words"
                                    >
                                        {{ $message->content }}
                                    </div>

                                </div>


                                <div
                                    class="mt-1.5 text-[8px] text-[#9B9992] {{ $isLawyer ? 'text-right' : 'text-left' }}"
                                >
                                    {{ $message->created_at->format('d M Y · g:i A') }}
                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </section>

        @endif


        {{-- ================================================= --}}
        {{-- REPLY FORM --}}
        {{-- ================================================= --}}

        <section
            class="border border-[#D4D1CA] bg-white"
        >

            {{-- Section header --}}

            <div
                class="border-b border-[#E8E6E1] px-5 py-4 sm:px-6"
            >

                <div
                    class="text-[9px] font-bold uppercase tracking-[0.16em] text-[#181815]"
                >
                    Write Your Reply
                </div>

            </div>


            {{-- ================================================= --}}
            {{-- TYPING INDICATOR --}}
            {{-- ================================================= --}}

            <div
                id="typing-indicator"
                class="hidden border-b border-[#E8E6E1] bg-[#FAF9F6] px-5 py-3 sm:px-6"
            >

                <div
                    class="flex items-center gap-2 text-[11px] text-[#77756F]"
                >

                    <span
                        class="inline-flex items-center gap-1.5 rounded-full border border-[#DDD7CA] bg-[#F7F4ED] px-3 py-1.5"
                    >

                        {{-- Animated dots --}}

                        <span class="flex items-center gap-1">

                            <span
                                class="h-1.5 w-1.5 animate-bounce rounded-full bg-[#8B7041]"
                                style="animation-delay: 0ms;"
                            ></span>

                            <span
                                class="h-1.5 w-1.5 animate-bounce rounded-full bg-[#8B7041]"
                                style="animation-delay: 150ms;"
                            ></span>

                            <span
                                class="h-1.5 w-1.5 animate-bounce rounded-full bg-[#8B7041]"
                                style="animation-delay: 300ms;"
                            ></span>

                        </span>

                        <span id="typing-text">
                            Client is typing...
                        </span>

                    </span>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- FORM --}}
            {{-- ================================================= --}}

            <form
                id="message-form"
                x-ref="replyForm"
                method="POST"
                action="{{ route('lawyer.messages.reply', $case) }}"
                @submit="sending = true"
                class="p-5 sm:p-6"
            >

                @csrf


                {{-- ================================================= --}}
                {{-- VALIDATION ERRORS --}}
                {{-- ================================================= --}}

                @if ($errors->any())

                    <div
                        class="mb-5 border border-[#B94A48]/30 bg-[#FDF0EF] px-4 py-3"
                    >

                        <div
                            class="text-[9px] font-bold uppercase tracking-[0.1em] text-[#7D302F]"
                        >
                            Please correct the following:
                        </div>

                        <ul class="mt-2 space-y-1">

                            @foreach ($errors->all() as $error)

                                <li
                                    class="text-[10px] text-[#7D302F]"
                                >
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- ================================================= --}}
                {{-- MESSAGE --}}
                {{-- ================================================= --}}

                <div>

                    <label
                        for="content"
                        class="mb-2 block text-[9px] font-bold uppercase tracking-[0.14em] text-[#77756F]"
                    >
                        Message
                    </label>


                    <textarea
                        id="content"
                        name="content"
                        x-model="content"
                        rows="8"
                        maxlength="5000"
                        required
                        autofocus
                        placeholder="Write your reply to {{ $clientName }}..."
                        class="w-full resize-y border border-[#D4D1CA] bg-[#FAF9F6] px-4 py-3 text-[12px] leading-6 text-[#181815] outline-none transition placeholder:text-[#9B9992] focus:border-[#B89452] focus:ring-1 focus:ring-[#B89452]/20"
                        @keydown.ctrl.enter="submitReply()"
                        @keydown.meta.enter="submitReply()"
                    ></textarea>


                    {{-- Character counter / shortcut --}}

                    <div
                        class="mt-2 flex items-center justify-between"
                    >

                        <div
                            class="text-[8px] text-[#9B9992]"
                        >

                            Press

                            <span
                                class="font-semibold text-[#77756F]"
                            >
                                Ctrl + Enter
                            </span>

                            to send.

                        </div>


                        <div
                            class="text-[8px] text-[#9B9992]"
                        >
                            <span x-text="content.length"></span>/5000
                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- BUTTONS --}}
                {{-- ================================================= --}}

                <div
                    class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end"
                >

                    {{-- Cancel --}}

                    <a
                        href="{{ route('lawyer.messages.show', $case) }}"
                        class="inline-flex h-11 items-center justify-center border border-[#D4D1CA] px-5 text-[9px] font-bold uppercase tracking-[0.1em] text-[#41403C] transition hover:border-[#B89452] hover:text-[#B89452]"
                    >
                        Cancel
                    </a>


                    {{-- Send --}}

                    <button
                        type="submit"
                        :disabled="sending || !content.trim()"
                        class="inline-flex h-11 items-center justify-center gap-2 bg-[#181815] px-6 text-[9px] font-bold uppercase tracking-[0.1em] text-white transition hover:bg-[#B89452] disabled:cursor-not-allowed disabled:opacity-40"
                    >

                        {{-- Normal state --}}

                        <template x-if="!sending">

                            <span
                                class="flex items-center gap-2"
                            >

                                Send Reply

                                <svg
                                    class="h-3.5 w-3.5"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M22 2L11 13"
                                    />

                                    <path
                                        d="M22 2l-7 20-4-9-9-4 20-7z"
                                    />
                                </svg>

                            </span>

                        </template>


                        {{-- Sending state --}}

                        <template x-if="sending">

                            <span
                                class="flex items-center gap-2"
                            >

                                <svg
                                    class="h-3.5 w-3.5 animate-spin"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >

                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="3"
                                    ></circle>

                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"
                                    ></path>

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


{{-- ============================================================= --}}
{{-- LAWYER TYPING / ECHO --}}
{{-- ============================================================= --}}

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', () => {

    /*
    |--------------------------------------------------------------------------
    | Current case / user
    |--------------------------------------------------------------------------
    */

    const caseId = @json($case->id);
    const currentUserId = @json(auth()->id());


    /*
    |--------------------------------------------------------------------------
    | DOM elements
    |--------------------------------------------------------------------------
    */

    const messageInput =
        document.getElementById('content');

    const messageForm =
        document.getElementById('message-form');

    const typingIndicator =
        document.getElementById('typing-indicator');

    const typingText =
        document.getElementById('typing-text');


    /*
    |--------------------------------------------------------------------------
    | Typing state
    |--------------------------------------------------------------------------
    */

    let typingTimeout = null;
    let isTyping = false;


    /*
    |--------------------------------------------------------------------------
    | Hide typing indicator
    |--------------------------------------------------------------------------
    */

    function hideTypingIndicator() {

        if (typingIndicator) {

            typingIndicator.classList.add('hidden');

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Send typing status to Laravel
    |--------------------------------------------------------------------------
    */

    async function sendTypingStatus(typing) {

        try {

            const response = await fetch(
                @json(route('lawyer.messages.typing')),
                {
                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',

                        'X-CSRF-TOKEN':
                            document
                                .querySelector(
                                    'meta[name="csrf-token"]'
                                )
                                ?.getAttribute('content'),

                        'Accept': 'application/json',
                    },

                    body: JSON.stringify({
                        case_id: caseId,
                        typing: typing,
                    }),
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Check HTTP response
            |--------------------------------------------------------------------------
            */

            if (!response.ok) {

                console.error(
                    'Typing request failed:',
                    response.status,
                    await response.text()
                );

                return;
            }


            console.log(
                'Typing status sent:',
                typing
            );

        } catch (error) {

            console.error(
                'Typing status error:',
                error
            );

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Start typing
    |--------------------------------------------------------------------------
    */

    function startTyping() {

        if (!isTyping) {

            isTyping = true;

            console.log(
                'Lawyer started typing'
            );

            sendTypingStatus(true);

        }


        clearTimeout(typingTimeout);


        /*
        |--------------------------------------------------------------------------
        | Automatically stop after 1.5 seconds
        |--------------------------------------------------------------------------
        */

        typingTimeout = setTimeout(() => {

            stopTyping();

        }, 1500);

    }


    /*
    |--------------------------------------------------------------------------
    | Stop typing
    |--------------------------------------------------------------------------
    */

    function stopTyping() {

        clearTimeout(typingTimeout);


        if (!isTyping) {

            return;
        }


        isTyping = false;


        console.log(
            'Lawyer stopped typing'
        );


        sendTypingStatus(false);

    }


    /*
    |--------------------------------------------------------------------------
    | Detect lawyer typing
    |--------------------------------------------------------------------------
    */

    if (messageInput) {

        messageInput.addEventListener(
            'input',
            () => {

                /*
                |--------------------------------------------------------------------------
                | Empty textarea
                |--------------------------------------------------------------------------
                */

                if (!messageInput.value.trim()) {

                    stopTyping();

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | User is typing
                |--------------------------------------------------------------------------
                */

                startTyping();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Stop when textarea loses focus
        |--------------------------------------------------------------------------
        */

        messageInput.addEventListener(
            'blur',
            () => {

                stopTyping();

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Stop typing when submitting
    |--------------------------------------------------------------------------
    */

    if (messageForm) {

        messageForm.addEventListener(
            'submit',
            () => {

                stopTyping();

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Listen for CLIENT typing
    |--------------------------------------------------------------------------
    */

    if (window.Echo) {

        console.log(
            'Echo is available.'
        );

        console.log(
            'Subscribing to:',
            `case.${caseId}`
        );


        window.Echo
            .private(`case.${caseId}`)
            .listen(
                '.user.typing',
                (event) => {

                    console.log(
                        'Typing event received:',
                        event
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Ignore our own event
                    |--------------------------------------------------------------------------
                    */

                    if (
                        Number(event.user_id) ===
                        Number(currentUserId)
                    ) {

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Make sure indicator exists
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !typingIndicator ||
                        !typingText
                    ) {

                        console.error(
                            'Typing indicator elements not found.'
                        );

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CLIENT STARTED TYPING
                    |--------------------------------------------------------------------------
                    */

                    if (event.typing) {

                        typingText.textContent =
                            `${event.user_name ?? 'Client'} is typing...`;


                        typingIndicator.classList.remove(
                            'hidden'
                        );


                        console.log(
                            'Showing client typing indicator.'
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CLIENT STOPPED TYPING
                    |--------------------------------------------------------------------------
                    */

                    else {

                        hideTypingIndicator();


                        console.log(
                            'Hiding client typing indicator.'
                        );

                    }

                }
            );


    } else {

        console.error(
            'Laravel Echo is NOT available.'
        );

    }

});
</script>

@endpush