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

            @forelse($messages as $conversationMessage)

                @php
                    $isMine =
                        (int) $conversationMessage->sender_id ===
                        (int) auth()->id();
                @endphp

                <div
                    class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}"
                >

                    <div class="max-w-[85%] sm:max-w-[70%]">

                        {{-- Sender --}}
                        <div
                            class="mb-1 flex items-center gap-2 {{ $isMine ? 'justify-end' : 'justify-start' }}"
                        >

                            <span class="text-[10px] font-medium text-[#77736b]">

                                {{ $isMine
                                    ? 'You'
                                    : ($conversationMessage->sender?->name ?? 'Lawyer')
                                }}

                            </span>

                            @if($conversationMessage->created_at)

                                <span class="text-[9px] text-[#aaa59c]">

                                    {{ $conversationMessage->created_at->format('M d, Y · h:i A') }}

                                </span>

                            @endif

                        </div>


                        {{-- Message bubble --}}
                        <div
                            class="rounded-2xl px-4 py-3
                            {{
                                $isMine
                                    ? 'rounded-br-md bg-[#151515] text-white'
                                    : 'rounded-bl-md border border-[#ddd7ca] bg-[#f7f4ed] text-[#151515]'
                            }}"
                        >

                            @if($conversationMessage->subject)

                                <p
                                    class="mb-2 text-xs font-semibold
                                    {{
                                        $isMine
                                            ? 'text-white'
                                            : 'text-[#151515]'
                                    }}"
                                >
                                    {{ $conversationMessage->subject }}
                                </p>

                            @endif


                            <p
                                class="whitespace-pre-line break-words text-sm leading-6
                                {{
                                    $isMine
                                        ? 'text-white'
                                        : 'text-[#55514b]'
                                }}"
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


        {{-- ===================================================== --}}
        {{-- Reply --}}
        {{-- ===================================================== --}}

        <div class="border-t border-[#ddd7ca] bg-[#faf8f3] p-5 sm:p-6">

            <form
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

        /*
        |--------------------------------------------------------------------------
        | Current case and user
        |--------------------------------------------------------------------------
        */

        const caseId = @json($case->id);

        const currentUserId = @json(auth()->id());

        const messagesContainer =
            document.getElementById('messages-container');

        const noMessages =
            document.getElementById('no-messages');

        const realtimeIndicator =
            document.getElementById('realtime-indicator');

        const realtimeText =
            document.getElementById('realtime-text');


        /*
        |--------------------------------------------------------------------------
        | Make sure Echo is available
        |--------------------------------------------------------------------------
        */

        if (!window.Echo) {

            console.error(
                'Laravel Echo is not available.'
            );

            if (realtimeIndicator) {
                realtimeIndicator.classList.remove('bg-[#aaa59c]');
                realtimeIndicator.classList.add('bg-[#914f49]');
            }

            if (realtimeText) {
                realtimeText.textContent =
                    'Live messages are unavailable.';
            }

            return;
        }


        if (!messagesContainer) {

            console.error(
                'Messages container was not found.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Subscribe to this case's private channel
        |--------------------------------------------------------------------------
        |
        | The channel must match:
        |
        | routes/channels.php
        |
        | Broadcast::channel('case.{caseId}', ...)
        |
        */

        const channelName = `case.${caseId}`;

        console.log(
            `Subscribing to private channel: ${channelName}`
        );


        window.Echo
            .private(channelName)

            /*
            |--------------------------------------------------------------------------
            | Channel subscribed successfully
            |--------------------------------------------------------------------------
            */

            .subscribed(() => {

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

            })

            /*
            |--------------------------------------------------------------------------
            | Subscription error
            |--------------------------------------------------------------------------
            */

            .error((error) => {

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

            })

            /*
            |--------------------------------------------------------------------------
            | Listen for MessageSent event
            |--------------------------------------------------------------------------
            |
            | Laravel:
            |
            | broadcastAs():
            |     message.sent
            |
            | Therefore Echo listens with:
            |
            |     .listen('.message.sent')
            |
            */

            .listen('.message.sent', (event) => {

                console.log(
                    'New message received:',
                    event
                );


                /*
                |--------------------------------------------------------------------------
                | Prevent duplicate messages
                |--------------------------------------------------------------------------
                |
                | If the same event somehow arrives twice, don't
                | display the same message twice.
                |
                */

                if (
                    document.querySelector(
                        `[data-message-id="${event.id}"]`
                    )
                ) {
                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Remove "No messages yet"
                |--------------------------------------------------------------------------
                */

                if (noMessages) {

                    noMessages.remove();

                }


                /*
                |--------------------------------------------------------------------------
                | Determine sender
                |--------------------------------------------------------------------------
                */

                const isMine =
                    Number(event.sender_id) ===
                    Number(currentUserId);


                const senderName =
                    isMine
                        ? 'You'
                        : (event.sender ?? 'Lawyer');


                /*
                |--------------------------------------------------------------------------
                | Format date
                |--------------------------------------------------------------------------
                */

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


                /*
                |--------------------------------------------------------------------------
                | Create message wrapper
                |--------------------------------------------------------------------------
                */

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


                /*
                |--------------------------------------------------------------------------
                | Create message HTML
                |--------------------------------------------------------------------------
                */

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


                /*
                |--------------------------------------------------------------------------
                | Add message to conversation
                |--------------------------------------------------------------------------
                */

                messagesContainer.appendChild(
                    wrapper
                );


                /*
                |--------------------------------------------------------------------------
                | Scroll to newest message
                |--------------------------------------------------------------------------
                */

                messagesContainer.scrollTop =
                    messagesContainer.scrollHeight;

            });


        /*
        |--------------------------------------------------------------------------
        | Escape HTML
        |--------------------------------------------------------------------------
        |
        | Important security step.
        |
        | We never insert the user's message content directly
        | into innerHTML without escaping it.
        |
        */

        function escapeHtml(value) {

            const div =
                document.createElement('div');

            div.textContent =
                value ?? '';

            return div.innerHTML;
        }

    });

</script>

@endpush
