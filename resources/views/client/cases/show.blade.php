@extends('layouts.app')

@section('title', $case->case_type ?? 'Case Details')

@section('breadcrumb')

    <a
        href="{{ route('client.cases.index') }}"
        class="transition hover:text-[#9a763d]"
    >
        My Cases
    </a>

    <span class="mx-2 text-[#bbb5a9]">/</span>

    <span>
        {{ $case->case_type ?? 'Case Details' }}
    </span>

@endsection


@section('content')

<div class="space-y-6">

    {{-- ========================================================= --}}
    {{-- SUCCESS STATUS MESSAGE --}}
    {{-- ========================================================= --}}

    @if(session('status'))

        <div class="rounded-lg border border-[#cddbcf] bg-[#eef5ef] px-4 py-3 text-xs text-[#52745a]">
            {{ session('status') }}
        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- GENERAL ERRORS --}}
    {{-- ========================================================= --}}

    @if($errors->any())

        <div class="rounded-lg border border-[#e0c7c3] bg-[#faf0ee] px-4 py-3">

            <p class="text-xs font-medium text-[#914f49]">
                Please correct the following:
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5 text-xs text-[#914f49]">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif



    {{-- ========================================================= --}}
    {{-- CASE HEADER --}}
    {{-- ========================================================= --}}

    <div class="rounded-xl border border-[#ddd7ca] bg-[#fffdf8]">

        <div class="px-5 py-6 sm:px-6">

            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">

                {{-- Main information --}}
                <div class="min-w-0">

                    <div class="flex flex-wrap items-center gap-2">

                        <span class="rounded-full bg-[#eef5ef] px-2.5 py-1 text-[10px] font-medium text-[#52745a]">
                            {{ ucfirst($case->status ?? 'opened') }}
                        </span>

                        @if($case->case_number)

                            <span class="font-mono text-[10px] text-[#99958d]">
                                {{ $case->case_number }}
                            </span>

                        @endif

                    </div>


                    <h1
                        class="mt-3 break-words text-3xl font-semibold text-[#151515]"
                        style="font-family: 'Cormorant Garamond', serif;"
                    >
                        {{ $case->title ?? $case->case_type ?? 'Legal Matter' }}
                    </h1>


                    @if($case->case_type)

                        <p class="mt-1 text-xs text-[#9a763d]">
                            {{ $case->case_type }}
                        </p>

                    @endif


                    <p class="mt-2 text-xs text-[#77736b]">

                        Filed

                        {{ $case->start_date?->format('F d, Y') ?? '—' }}

                    </p>

                </div>


                {{-- Lawyer --}}
                <div class="shrink-0 rounded-lg border border-[#eeeae0] bg-[#f7f4ed] px-4 py-3 lg:min-w-[220px]">

                    <p class="text-[10px] uppercase tracking-wider text-[#99958d]">
                        Assigned Lawyer
                    </p>

                    @if($case->lawyer)

                        <p class="mt-1 text-xs font-semibold text-[#151515]">
                            {{ $case->lawyer->name }}
                        </p>

                        @if($case->lawyer->specialization)

                            <p class="mt-0.5 text-[10px] text-[#77736b]">
                                {{ $case->lawyer->specialization }}
                            </p>

                        @endif

                        @if($case->lawyer->email)

                            <p class="mt-1 break-all text-[10px] text-[#99958d]">
                                {{ $case->lawyer->email }}
                            </p>

                        @endif

                    @else

                        <p class="mt-1 text-xs text-[#99958d]">
                            Not assigned
                        </p>

                    @endif

                </div>

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- CASE DESCRIPTION --}}
    {{-- ========================================================= --}}

    <section class="rounded-xl border border-[#ddd7ca] bg-[#fffdf8]">

        <div class="border-b border-[#ddd7ca] px-5 py-4 sm:px-6">

            <h2
                class="text-xl font-semibold text-[#151515]"
                style="font-family: 'Cormorant Garamond', serif;"
            >
                Case Description
            </h2>

            <p class="mt-1 text-xs text-[#77736b]">
                Details provided when this legal matter was filed.
            </p>

        </div>


        <div class="p-5 sm:p-6">

            <div class="max-h-[420px] overflow-y-auto rounded-lg border border-[#eeeae0] bg-[#f7f4ed] p-4 sm:p-5">

                <p class="break-words whitespace-pre-line text-sm leading-7 text-[#555149]">
                    {{ $case->description ?? 'No description available.' }}
                </p>

            </div>

        </div>

    </section>



    {{-- ========================================================= --}}
    {{-- DOCUMENTS --}}
    {{-- ========================================================= --}}

    <section class="overflow-hidden rounded-xl border border-[#ddd7ca] bg-[#fffdf8]">

        <div class="flex flex-col gap-3 border-b border-[#ddd7ca] px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2
                    class="text-xl font-semibold text-[#151515]"
                    style="font-family: 'Cormorant Garamond', serif;"
                >
                    Documents
                </h2>

                <p class="mt-1 text-xs text-[#77736b]">
                    Files associated with this case
                </p>

            </div>


            <span class="text-[10px] text-[#99958d]">
                PDF / DOCX · Max 10 MB
            </span>

        </div>


        <div class="p-5 sm:p-6">

            {{-- ================================================= --}}
            {{-- DOCUMENT LIST --}}
            {{-- ================================================= --}}

            @if($documents->isNotEmpty())

                <div class="space-y-2">

                    @foreach($documents as $document)

                        <div class="flex flex-col gap-3 rounded-lg border border-[#eeeae0] bg-[#f7f4ed] px-4 py-3 sm:flex-row sm:items-center sm:justify-between">

                            <div class="flex min-w-0 items-center gap-3">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-md bg-[#f4eddf] text-[#9a763d]">

                                    <svg
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.6"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M7 3.5h7l4 4V20.5H7V3.5Z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M14 3.5v4h4"
                                        />

                                    </svg>

                                </div>


                                <div class="min-w-0">

                                    <p class="break-words text-xs font-medium text-[#151515]">
                                        {{ $document->title }}
                                    </p>


                                    <p class="mt-0.5 break-words text-[10px] text-[#99958d]">

                                        @if($document->mime_type)
                                            {{ $document->mime_type }}
                                        @else
                                            Document
                                        @endif


                                        @if($document->size_bytes)

                                            ·

                                            {{ number_format($document->size_bytes / 1024 / 1024, 2) }}
                                            MB

                                        @endif


                                        @if($document->uploader)

                                            · Uploaded by
                                            {{ $document->uploader->name }}

                                        @endif

                                    </p>

                                </div>

                            </div>


                            <a
                                href="{{ route('client.cases.documents.download', [$case, $document]) }}"
                                class="inline-flex w-fit shrink-0 items-center gap-1.5 rounded-md border border-[#ddd7ca] bg-white px-3 py-1.5 text-[10px] font-medium text-[#555149] transition hover:border-[#b99a63] hover:bg-[#f4eddf] hover:text-[#9a763d]"
                            >

                                <svg
                                    class="h-3.5 w-3.5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 3v12m0 0 4-4m-4 4-4-4M5 21h14"
                                    />

                                </svg>

                                Download

                            </a>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="rounded-lg border border-dashed border-[#ddd7ca] bg-[#f7f4ed] px-5 py-8 text-center">

                    <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-[#eeeae0] text-[#99958d]">

                        <svg
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.5"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M7 3.5h7l4 4V20.5H7V3.5Z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M14 3.5v4h4"
                            />

                        </svg>

                    </div>


                    <p class="mt-3 text-sm font-medium text-[#555149]">
                        No documents yet
                    </p>


                    <p class="mt-1 text-xs text-[#99958d]">
                        Upload a document related to this case below.
                    </p>

                </div>

            @endif



            {{-- ================================================= --}}
            {{-- UPLOAD DOCUMENT --}}
            {{-- ================================================= --}}

            <div class="mt-6 border-t border-[#ddd7ca] pt-6">

                <div class="mb-4">

                    <h3 class="text-sm font-semibold text-[#151515]">
                        Upload a document
                    </h3>

                    <p class="mt-1 text-[10px] leading-5 text-[#99958d]">
                        Upload supporting documents related to this case.
                        Only PDF and DOCX files up to 10 MB are accepted.
                    </p>

                </div>


                <form
                    method="POST"
                    action="{{ route('client.cases.documents.store', $case) }}"
                    enctype="multipart/form-data"
                    class="space-y-4"
                    x-data="{
                        fileName: '',
                        fileSize: ''
                    }"
                >

                    @csrf


                    <div>

                        <label
                            for="document_title"
                            class="mb-1.5 block text-xs font-medium text-[#555149]"
                        >
                            Document Title
                            <span class="text-[#914f49]">*</span>
                        </label>


                        <input
                            id="document_title"
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            required
                            maxlength="150"
                            placeholder="Example: Property Agreement"
                            class="block w-full rounded-md border border-[#ddd7ca] bg-white px-3 py-2.5 text-xs text-[#555149] outline-none transition placeholder:text-[#aaa59b] focus:border-[#b99a63] focus:ring-1 focus:ring-[#b99a63]"
                        >


                        @error('title')

                            <p class="mt-1.5 text-[10px] text-[#914f49]">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>



                    <div>

                        <label
                            for="document"
                            class="mb-1.5 block text-xs font-medium text-[#555149]"
                        >
                            Select Document
                            <span class="text-[#914f49]">*</span>
                        </label>


                        <input
                            id="document"
                            type="file"
                            name="document"
                            required
                            accept=".pdf,.docx,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            @change="
                                fileName = $event.target.files[0]?.name ?? '';
                                fileSize = $event.target.files[0]
                                    ? ($event.target.files[0].size / 1024 / 1024).toFixed(2) + ' MB'
                                    : '';
                            "
                            class="block w-full rounded-md border border-[#ddd7ca] bg-[#f7f4ed] px-3 py-2.5 text-xs text-[#555149] file:mr-3 file:rounded-md file:border-0 file:bg-[#151515] file:px-3 file:py-1.5 file:text-[11px] file:font-medium file:text-[#f5f1e8] hover:file:bg-[#b99a63]"
                        >


                        <div
                            x-show="fileName"
                            x-cloak
                            class="mt-2 rounded-md border border-[#eeeae0] bg-[#f7f4ed] px-3 py-2"
                        >

                            <p
                                class="break-all text-[10px] font-medium text-[#555149]"
                                x-text="fileName"
                            ></p>

                            <p
                                class="mt-0.5 text-[10px] text-[#99958d]"
                                x-text="fileSize"
                            ></p>

                        </div>


                        <p class="mt-1.5 text-[10px] text-[#99958d]">
                            Accepted formats: PDF, DOCX · Maximum size: 10 MB
                        </p>


                        @error('document')

                            <p class="mt-1.5 text-[10px] text-[#914f49]">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>



                    <div class="flex justify-end">

                        <button
                            type="submit"
                            class="inline-flex items-center gap-1.5 rounded-md bg-[#151515] px-3.5 py-2 text-[11px] font-medium text-[#f5f1e8] transition hover:bg-[#b99a63] hover:text-[#151515]"
                        >

                            <svg
                                class="h-3.5 w-3.5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.6"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 16V4m0 0L8 8m4-4 4 4"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 13v5.5h14V13"
                                />

                            </svg>

                            Upload

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>



    {{-- ========================================================= --}}
    {{-- CASE MESSAGES --}}
    {{-- ========================================================= --}}

    <section class="overflow-hidden rounded-xl border border-[#ddd7ca] bg-[#fffdf8]">

        {{-- Header --}}
        <div class="border-b border-[#ddd7ca] px-5 py-4 sm:px-6">

            <h2
                class="text-xl font-semibold text-[#151515]"
                style="font-family: 'Cormorant Garamond', serif;"
            >
                Case Messages
            </h2>

            <p class="mt-1 text-xs text-[#77736b]">
                Communicate securely with your assigned lawyer.
            </p>

        </div>


        <div class="p-5 sm:p-6">

            {{-- ================================================= --}}
            {{-- EXISTING MESSAGES --}}
            {{-- ================================================= --}}

            @if($messages->isNotEmpty())

                <div class="max-h-[420px] space-y-3 overflow-y-auto pr-1">

                    @foreach($messages as $message)

                        @php
                            $isMine = (int) $message->sender_id === (int) auth()->id();
                        @endphp


                        <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">

                            <div
                                class="max-w-[85%] rounded-lg border px-4 py-3 {{ $isMine ? 'border-[#d8c9ab] bg-[#f4eddf]' : 'border-[#eeeae0] bg-[#f7f4ed]' }}"
                            >

                                @if($message->subject)

                                    <p class="text-[10px] font-semibold text-[#151515]">
                                        {{ $message->subject }}
                                    </p>

                                @endif


                                <p class="mt-1 whitespace-pre-line break-words text-xs leading-6 text-[#555149]">
                                    {{ $message->content }}
                                </p>


                                <div class="mt-2 flex flex-wrap items-center gap-2 text-[9px] text-[#99958d]">

                                    <span>
                                        {{ $message->sender?->name ?? 'User' }}
                                    </span>

                                    <span>·</span>

                                    <span>
                                        {{ $message->created_at?->format('M d, Y · h:i A') }}
                                    </span>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="rounded-lg border border-dashed border-[#ddd7ca] bg-[#f7f4ed] px-5 py-8 text-center">

                    <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-[#eeeae0] text-[#99958d]">

                        <svg
                            class="h-5 w-5 text-[#99958d]"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.5"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v7a2.5 2.5 0 0 1-2.5 2.5H10l-5 4v-4.5A2.5 2.5 0 0 1 4 13.5v-7Z"
                            />

                        </svg>

                    </div>


                    <p class="mt-3 text-sm font-medium text-[#555149]">
                        No messages yet
                    </p>


                    <p class="mt-1 text-xs text-[#99958d]">
                        Send a message below to contact your lawyer.
                    </p>

                </div>

            @endif



            {{-- ================================================= --}}
            {{-- NEW MESSAGE --}}
            {{-- ================================================= --}}

            <div class="mt-6 border-t border-[#ddd7ca] pt-6">

                <h3 class="mb-4 text-sm font-semibold text-[#151515]">
                    Send a Message
                </h3>


                {{-- IMPORTANT: MESSAGE FORM --}}
                <form
                    id="case-message-form"
                    method="POST"
                    action="{{ route('client.cases.messages.store', ['case' => $case->id]) }}"
                    class="space-y-4"
                >

                    @csrf


                    {{-- Subject --}}
                    <div>

                        <label
                            for="message_subject"
                            class="mb-1.5 block text-xs font-medium text-[#555149]"
                        >
                            Subject
                        </label>


                        <input
                            id="message_subject"
                            type="text"
                            name="subject"
                            value="{{ old('subject') }}"
                            maxlength="150"
                            placeholder="Message subject"
                            class="block w-full rounded-md border border-[#ddd7ca] bg-white px-3 py-2.5 text-xs text-[#555149] outline-none transition placeholder:text-[#aaa59b] focus:border-[#b99a63] focus:ring-1 focus:ring-[#b99a63]"
                        >


                        @error('subject')

                            <p class="mt-1.5 text-[10px] text-[#914f49]">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>



                    {{-- ================================================= --}}
                    {{-- MESSAGE CONTENT --}}
                    {{-- ================================================= --}}

                    <div>

                        <label
                            for="case_message_content"
                            class="mb-1.5 block text-xs font-medium text-[#555149]"
                        >
                            Message
                            <span class="text-[#914f49]">*</span>
                        </label>


                        <textarea
                            id="case_message_content"
                            name="content"
                            required
                            maxlength="5000"
                            rows="6"
                            placeholder="Write your message..."
                            class="block w-full resize-y rounded-md border border-[#ddd7ca] bg-white px-3 py-3 text-xs leading-6 text-[#555149] outline-none transition placeholder:text-[#aaa59b] focus:border-[#b99a63] focus:ring-1 focus:ring-[#b99a63]"
                        >{{ old('content') }}</textarea>


                        <div class="mt-1.5 flex items-start justify-between gap-3">

                            <div>

                                @error('content')

                                    <p class="text-[10px] text-[#914f49]">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            <span class="shrink-0 text-[9px] text-[#99958d]">
                                Maximum 5000 characters
                            </span>

                        </div>

                    </div>



                    {{-- ================================================= --}}
                    {{-- SEND BUTTON --}}
                    {{-- ================================================= --}}

                    <div class="flex justify-end">

                        <button
                            type="submit"
                            class="inline-flex items-center gap-1.5 rounded-md bg-[#151515] px-3.5 py-2 text-[11px] font-medium text-[#f5f1e8] transition hover:bg-[#b99a63] hover:text-[#151515]"
                        >

                            <svg
                                class="h-3.5 w-3.5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.6"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m4 4 16 8-16 8 3-8-3-8Z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M7 12h13"
                                />

                            </svg>

                            Send

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>



    {{-- ========================================================= --}}
    {{-- BACK --}}
    {{-- ========================================================= --}}

    <div>

        <a
            href="{{ route('client.cases.index') }}"
            class="inline-flex items-center gap-1.5 text-xs font-medium text-[#77736b] transition hover:text-[#9a763d]"
        >

            <svg
                class="h-3.5 w-3.5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.7"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m15 18-6-6 6-6"
                />

            </svg>

            Back to My Cases

        </a>

    </div>

</div>

@endsection