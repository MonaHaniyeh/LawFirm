@extends('layouts.app')

@section('title', 'Conversation')

@section('breadcrumb')
    Messages
@endsection

@section('content')

    <div class="mx-auto max-w-4xl space-y-6">

        {{-- ========================================================= --}}
        {{-- Header --}}
        {{-- ========================================================= --}}

        <div class="rounded-xl border border-[#ddd7ca] bg-[#f7f4ed] p-5 sm:p-6">

            <div class="flex items-start gap-4">

                {{-- Back --}}
                <a
                    href="{{ route('client.messages') }}"
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-[#ddd7ca] bg-white text-[#77736b] transition hover:bg-[#f0ece4]"
                    title="Back to messages"
                >
                    ←
                </a>

                {{-- Lawyer information --}}
                <div class="min-w-0 flex-1">

                    <p class="text-[11px] font-medium uppercase tracking-[0.16em] text-[#77736b]">
                        Conversation
                    </p>

                    <h1 class="mt-1 break-words text-xl font-semibold text-[#151515]">
                        {{ $case->lawyer?->name ?? 'Assigned Lawyer' }}
                    </h1>

                    <div class="mt-2 flex flex-wrap items-center gap-2">

                        <span class="text-[11px] font-medium text-[#8b7041]">
                            Case {{ $case->case_number }}
                        </span>

                        <span class="text-[#c9c3b8]">
                            •
                        </span>

                        <span class="text-[11px] text-[#77736b]">
                            {{ $case->case_type ?? 'Legal Case' }}
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- Status --}}
        {{-- ========================================================= --}}

        @if (session('status'))

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


        {{-- ========================================================= --}}
        {{-- Real-time connection status --}}
        {{-- ========================================================= --}}

        <div
            id="realtime-status"
            class="flex items-center gap-2 rounded-lg border border-[#ddd7ca] bg-white px-4 py-3 text-xs text-[#77736b]"
        >

            <span
                id="realtime-indicator"
                class="h-2 w-2 rounded-full bg-[#aaa59c]"
            ></span>

            <span id="realtime-text">
                Connecting to live messages...
            </span>

        </div>


        {{-- ========================================================= --}}
        {{-- Conversation --}}
        {{-- ========================================================= --}}

        <section class="overflow-hidden rounded-xl border border-[#ddd7ca] bg-white">

            {{-- Conversation header --}}
            <div class="border-b border-[#ddd7ca] px-5 py-4">

                <h2 class="text-sm font-semibold text-[#151515]">
                    Messages
                </h2>

                <p class="mt-1 text-xs text-[#77736b]">
                    Your conversation with
                    {{ $case->lawyer?->name ?? 'your lawyer' }}.
                </p>

            </div>


            {{-- ===================================================== --}}
            {{-- Messages --}}
            {{-- ===================================================== --}}

            <div
                id="messages-container"
                class="space-y-5 p-5 sm:p-6"
            >

                {{-- Existing messages --}}
                <div
                    id="messages-list"
                    class="space-y-5"
                >

                    @forelse($messages as $conversationMessage)

                        @php
                            $isMine =
                                (int) $conversationMessage->sender_id ===
                                (int) auth()->id();
                        @endphp

                        <div
                            data-message-id="{{ $conversationMessage->id }}"
                            class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}"
                        >

                            <div class="max-w-[85%] sm:max-w-[70%]">

                                {{-- Sender --}}
                                <div
                                    class="mb-1 flex items-center gap-2 {{ $isMine ? 'justify-end' : 'justify-start' }}"
                                >

                                    <span class="text-[10px] font-medium text-[#77736b]">
                                        {{ $isMine ? 'You' : ($conversationMessage->sender?->name ?? 'Lawyer') }}
                                    </span>

                                    @if ($conversationMessage->created_at)

                                        <span class="text-[9px] text-[#aaa59c]">
                                            {{ $conversationMessage->created_at->format('M d, Y · h:i A') }}
                                        </span>

                                    @endif

                                </div>


                                {{-- Message bubble --}}
                                <div
                                    class="rounded-2xl px-4 py-3
                                    {{ $isMine
                                        ? 'rounded-br-md bg-[#151515] text-white'
                                        : 'rounded-bl-md border border-[#ddd7ca] bg-[#f7f4ed] text-[#151515]' }}"
                                >

                                    @if ($conversationMessage->subject)

                                        <p
                                            class="mb-2 text-xs font-semibold
                                            {{ $isMine
                                                ? 'text-white'
                                                : 'text-[#151515]' }}"
                                        >
                                            {{ $conversationMessage->subject }}
                                        </p>

                                    @endif


                                    <p
                                        class="whitespace-pre-line break-words text-sm leading-6
                                        {{ $isMine
                                            ? 'text-white'
                                            : 'text-[#55514b]' }}"
                                    >
                                        {{ $conversationMessage->content }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div
                            id="no-messages"
                            class="py-10 text-center"
                        >

                            <div
                                class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#f5f1e8] text-[#8b7041]"
                            >
                                ✉
                            </div>

                            <h3 class="mt-4 text-sm font-semibold text-[#151515]">
                                No messages yet
                            </h3>

                            <p class="mt-2 text-xs text-[#77736b]">
                                Start the conversation below.
                            </p>

                        </div>

                    @endforelse

                </div>


                {{-- ================================================= --}}
                {{-- Typing indicator INSIDE chat --}}
                {{-- ================================================= --}}

                <div
                    id="typing-indicator"
                    class="hidden"
                >

                    <div class="flex items-end gap-2">

                        {{-- Lawyer avatar --}}
                        <div
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#151515] text-[11px] font-semibold text-[#B89452]"
                        >
                            L
                        </div>


                        {{-- Typing bubble --}}
                        <div
                            class="rounded-2xl rounded-bl-md border border-[#E8E6E1] bg-white px-4 py-2.5 shadow-sm"
                        >

                            <div class="flex items-center gap-2">

                                <span
                                    id="typing-text"
                                    class="text-xs text-[#77756F]"
                                >
                                    Lawyer is typing...
                                </span>


                                {{-- Animated dots --}}
                                <span class="flex items-center gap-1">

                                    <span
                                        class="h-1.5 w-1.5 animate-bounce rounded-full bg-[#B89452]"
                                    ></span>

                                    <span
                                        class="h-1.5 w-1.5 animate-bounce rounded-full bg-[#B89452]"
                                        style="animation-delay: 150ms"
                                    ></span>

                                    <span
                                        class="h-1.5 w-1.5 animate-bounce rounded-full bg-[#B89452]"
                                        style="animation-delay: 300ms"
                                    ></span>

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- Reply --}}
            {{-- ===================================================== --}}

            <div class="border-t border-[#ddd7ca] bg-[#faf8f3] p-5 sm:p-6">

                <form
                    id="message-form"
                    method="POST"
                    action="{{ route('client.messages.reply', $case) }}"
                >

                    @csrf

                    <label
                        for="content"
                        class="mb-2 block text-xs font-semibold text-[#151515]"
                    >
                        Reply to your lawyer
                    </label>


                    <textarea
                        id="content"
                        name="content"
                        rows="4"
                        maxlength="5000"
                        required
                        placeholder="Write your message..."
                        class="w-full rounded-xl border border-[#ddd7ca] bg-white px-4 py-3 text-sm text-[#151515] outline-none transition placeholder:text-[#aaa59c] focus:border-[#8b7041] focus:ring-1 focus:ring-[#8b7041]"
                    >{{ old('content') }}</textarea>


                    @error('content')

                        <p class="mt-2 text-xs text-[#914f49]">
                            {{ $message }}
                        </p>

                    @enderror


                    <div class="mt-3 flex justify-end">

                        <button
                            type="submit"
                            class="inline-flex items-center rounded-lg bg-[#151515] px-5 py-2.5 text-xs font-semibold text-white transition hover:bg-[#2a2a2a]"
                        >
                            Send message
                        </button>

                    </div>

                </form>

            </div>

        </section>

    </div>

@endsection


{{-- ============================================================= --}}
{{-- Laravel Echo / Pusher --}}
{{-- ============================================================= --}}

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', () => {

    /* =========================================================
       Current case and user
    ========================================================= */

    const caseId = @json($case->id);

    const currentUserId = @json(auth()->id());


    /* =========================================================
       Elements
    ========================================================= */

    const messagesContainer =
        document.getElementById('messages-container');

    const messagesList =
        document.getElementById('messages-list');

    const noMessages =
        document.getElementById('no-messages');

    const realtimeIndicator =
        document.getElementById('realtime-indicator');

    const realtimeText =
        document.getElementById('realtime-text');

    const typingIndicator =
        document.getElementById('typing-indicator');

    const typingText =
        document.getElementById('typing-text');

    const messageInput =
        document.getElementById('content');

    const messageForm =
        document.getElementById('message-form');


    /* =========================================================
       Typing variables
    ========================================================= */

    let typingTimer = null;

    let currentlyTyping = false;

    let remoteTypingTimer = null;


    /* =========================================================
       Hide typing indicator
    ========================================================= */

    function hideTypingIndicator() {

        if (!typingIndicator) {
            return;
        }

        typingIndicator.classList.add('hidden');

        clearTimeout(remoteTypingTimer);
    }


    /* =========================================================
       Show typing indicator
    ========================================================= */

    function showTypingIndicator(name = 'Lawyer') {

        if (!typingIndicator || !typingText) {

            console.error(
                'Typing indicator elements not found.'
            );

            return;
        }


        typingText.textContent =
            `${name} is typing...`;


        typingIndicator.classList.remove('hidden');


        /*
         * Keep the indicator inside the chat visible
         * while typing events continue arriving.
         */
        clearTimeout(remoteTypingTimer);


        remoteTypingTimer = setTimeout(() => {

            hideTypingIndicator();

        }, 2500);

    }


    /* =========================================================
       Escape HTML
    ========================================================= */

    function escapeHtml(value) {

        const div =
            document.createElement('div');

        div.textContent =
            value ?? '';

        return div.innerHTML;
    }


    /* =========================================================
       Send typing status to Laravel
    ========================================================= */

    async function sendTypingStatus(typing) {

        try {

            const csrfToken =
                document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute('content');


            if (!csrfToken) {

                console.error(
                    'CSRF token was not found.'
                );

                return;
            }


            const response =
                await fetch(
                    @json(route('client.messages.typing')),
                    {
                        method: 'POST',

                        headers: {
                            'Content-Type': 'application/json',

                            'X-CSRF-TOKEN': csrfToken,

                            'Accept': 'application/json',
                        },

                        body: JSON.stringify({
                            case_id: caseId,
                            typing: typing,
                        }),
                    }
                );


            if (!response.ok) {

                console.error(
                    'Typing request failed:',
                    response.status
                );

                return;
            }


            console.log(
                'Client typing status sent:',
                typing
            );

        } catch (error) {

            console.error(
                'Typing status error:',
                error
            );

        }

    }


    /* =========================================================
       Start typing
    ========================================================= */

    function startTyping() {

        if (!currentlyTyping) {

            currentlyTyping = true;

            sendTypingStatus(true);
        }


        clearTimeout(typingTimer);


        typingTimer =
            setTimeout(() => {

                stopTyping();

            }, 1500);

    }


    /* =========================================================
       Stop typing
    ========================================================= */

    function stopTyping() {

        clearTimeout(typingTimer);


        if (!currentlyTyping) {
            return;
        }


        currentlyTyping = false;


        sendTypingStatus(false);

    }


    /* =========================================================
       Detect typing in textarea
    ========================================================= */

    if (messageInput) {

        messageInput.addEventListener(
            'input',
            () => {

                if (!messageInput.value.trim()) {

                    stopTyping();

                    return;
                }


                startTyping();

            }
        );


        messageInput.addEventListener(
            'blur',
            () => {

                stopTyping();

            }
        );

    }


    /* =========================================================
       Stop typing when sending message
    ========================================================= */

    if (messageForm) {

        messageForm.addEventListener(
            'submit',
            () => {

                stopTyping();

            }
        );

    }


    /* =========================================================
       Make sure Echo is available
    ========================================================= */

    if (!window.Echo) {

        console.error(
            'Laravel Echo is not available.'
        );


        if (realtimeIndicator) {

            realtimeIndicator.classList.remove(
                'bg-[#aaa59c]'
            );

            realtimeIndicator.classList.add(
                'bg-[#914f49]'
            );

        }


        if (realtimeText) {

            realtimeText.textContent =
                'Live messages are unavailable.';

        }


        return;
    }


    /* =========================================================
       Make sure messages container exists
    ========================================================= */

    if (!messagesContainer) {

        console.error(
            'Messages container was not found.'
        );

        return;
    }


    /* =========================================================
       Subscribe to private case channel
    ========================================================= */

    const channelName =
        `case.${caseId}`;


    console.log(
        `Subscribing to private channel: ${channelName}`
    );


    const channel =
        window.Echo.private(channelName);


    /* =========================================================
       Successfully subscribed
    ========================================================= */

    channel.subscribed(() => {

        console.log(
            `Successfully subscribed to ${channelName}`
        );


        if (realtimeIndicator) {

            realtimeIndicator.classList.remove(
                'bg-[#aaa59c]',
                'bg-[#914f49]'
            );

            realtimeIndicator.classList.add(
                'bg-[#52745a]'
            );

        }


        if (realtimeText) {

            realtimeText.textContent =
                'Live messages connected.';

        }

    });


    /* =========================================================
       Subscription error
    ========================================================= */

    channel.error((error) => {

        console.error(
            'Pusher channel error:',
            error
        );


        if (realtimeIndicator) {

            realtimeIndicator.classList.remove(
                'bg-[#aaa59c]',
                'bg-[#52745a]'
            );

            realtimeIndicator.classList.add(
                'bg-[#914f49]'
            );

        }


        if (realtimeText) {

            realtimeText.textContent =
                'Unable to connect to live messages.';

        }

    });


    /* =========================================================
       Listen for new messages
    ========================================================= */

    channel.listen(
        '.message.sent',
        (event) => {

            console.log(
                'New message received:',
                event
            );


            /* =================================================
               Prevent duplicate messages
            ================================================= */

            if (
                document.querySelector(
                    `[data-message-id="${event.id}"]`
                )
            ) {

                return;
            }


            /* =================================================
               Remove empty state
            ================================================= */

            if (noMessages) {

                noMessages.remove();

            }


            /* =================================================
               Hide typing indicator
            ================================================= */

            hideTypingIndicator();


            /* =================================================
               Determine sender
            ================================================= */

            const isMine =
                Number(event.sender_id) ===
                Number(currentUserId);


            const senderName =
                isMine
                    ? 'You'
                    : (event.sender ?? 'Lawyer');


            /* =================================================
               Format date
            ================================================= */

            let formattedDate = '';


            if (event.created_at) {

                const date =
                    new Date(event.created_at);


                formattedDate =
                    date.toLocaleString([], {

                        month: 'short',

                        day: '2-digit',

                        year: 'numeric',

                        hour: '2-digit',

                        minute: '2-digit'

                    });

            }


            /* =================================================
               Create message wrapper
            ================================================= */

            const wrapper =
                document.createElement('div');


            wrapper.dataset.messageId =
                event.id;


            wrapper.className =
                `flex ${
                    isMine
                        ? 'justify-end'
                        : 'justify-start'
                }`;


            /* =================================================
               Create message HTML
            ================================================= */

            wrapper.innerHTML = `

                <div class="max-w-[85%] sm:max-w-[70%]">

                    <div
                        class="mb-1 flex items-center gap-2 ${
                            isMine
                                ? 'justify-end'
                                : 'justify-start'
                        }"
                    >

                        <span
                            class="text-[10px] font-medium text-[#77736b]"
                        >
                            ${escapeHtml(senderName)}
                        </span>

                        ${
                            formattedDate
                                ? `

                                    <span
                                        class="text-[9px] text-[#aaa59c]"
                                    >
                                        ${escapeHtml(formattedDate)}
                                    </span>

                                `
                                : ''
                        }

                    </div>


                    <div
                        class="rounded-2xl px-4 py-3 ${
                            isMine
                                ? 'rounded-br-md bg-[#151515] text-white'
                                : 'rounded-bl-md border border-[#ddd7ca] bg-[#f7f4ed] text-[#151515]'
                        }"
                    >

                        ${
                            event.subject
                                ? `

                                    <p
                                        class="mb-2 text-xs font-semibold ${
                                            isMine
                                                ? 'text-white'
                                                : 'text-[#151515]'
                                        }"
                                    >
                                        ${escapeHtml(event.subject)}
                                    </p>

                                `
                                : ''
                        }


                        <p
                            class="whitespace-pre-line break-words text-sm leading-6 ${
                                isMine
                                    ? 'text-white'
                                    : 'text-[#55514b]'
                            }"
                        >
                            ${escapeHtml(event.content)}
                        </p>

                    </div>

                </div>

            `;


            /* =================================================
               Add message BEFORE typing indicator
            ================================================= */

            if (messagesList) {

                messagesList.appendChild(wrapper);

            } else {

                messagesContainer.appendChild(wrapper);

            }


            /* =================================================
               Scroll to newest message
            ================================================= */

            messagesContainer.scrollTop =
                messagesContainer.scrollHeight;

        }
    );


    /* =========================================================
       Listen for typing events
    ========================================================= */

    channel.listen(
        '.user.typing',
        (event) => {

            console.log(
                'CLIENT RECEIVED TYPING EVENT:',
                event
            );


            /* =================================================
               Ignore our own typing event
            ================================================= */

            if (
                Number(event.user_id) ===
                Number(currentUserId)
            ) {

                console.log(
                    'Ignoring own typing event.'
                );

                return;
            }


            /* =================================================
               Client reacts only to lawyer typing
            ================================================= */

            if (event.role !== 'lawyer') {

                console.log(
                    'Ignoring non-lawyer typing event:',
                    event.role
                );

                return;
            }


            /* =================================================
               Lawyer started typing
            ================================================= */

            if (event.typing === true) {

                const name =
                    event.user_name ??
                    'Lawyer';


                console.log(
                    'LAWYER IS TYPING:',
                    name
                );


                showTypingIndicator(name);

                return;
            }


            /* =================================================
               Lawyer stopped typing
            ================================================= */

            if (event.typing === false) {

                console.log(
                    'LAWYER STOPPED TYPING'
                );


                hideTypingIndicator();

            }

        }
    );

});

</script>

@endpush