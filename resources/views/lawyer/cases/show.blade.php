@extends('layouts.app')

@section('title', $case->case_number . ' | Case Details')

@push('styles')

<style>

    /* =====================================================
       CASE DETAILS PAGE
    ===================================================== */

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 25px;
        color: #99948b;
        font-size: 10px;
    }

    .breadcrumb a {
        transition: color .2s ease;
        text-decoration: none;
    }

    .breadcrumb a:hover {
        color: var(--gold-dark);
    }

    .breadcrumb-arrow {
        color: #b7b2aa;
    }

    .breadcrumb-current {
        color: #625f59;
    }


    /* =====================================================
       PAGE HEADER
    ===================================================== */

    .page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 30px;
        margin-bottom: 34px;
    }

    .case-stamp {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 11px;
    }

    .case-number {
        color: var(--gold-dark);
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .15em;
    }

    .stamp-divider {
        width: 1px;
        height: 11px;
        background: #cfc8bb;
    }

    .case-type {
        color: #89847b;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .1em;
    }

    .page-title {
        margin: 0;
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(38px, 4vw, 54px);
        line-height: .94;
        font-weight: 600;
        letter-spacing: -.025em;
    }

    .header-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 14px;
        color: var(--muted);
        font-size: 11px;
        flex-wrap: wrap;
    }

    .meta-separator {
        color: #bbb5aa;
    }


    /* =====================================================
       STATUS
    ===================================================== */

    .status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 100px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        white-space: nowrap;
    }

    .status::before {
        content: "";
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-open {
        color: var(--success);
        background: var(--success-bg);
    }

    .status-closed {
        color: #686761;
        background: #f0efec;
    }

    .status-pending {
        color: #9a7336;
        background: #fbf3e4;
    }

    .status-rejected {
        color: var(--danger);
        background: var(--danger-bg);
    }


    /* =====================================================
       EDIT BUTTON
    ===================================================== */

    .edit-button {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 11px 17px;
        border: 1px solid var(--charcoal);
        border-radius: 4px;
        background: var(--charcoal);
        color: white;
        font-size: 10px;
        font-weight: 700;
        text-decoration: none;
        transition:
            background .2s ease,
            transform .2s ease;
    }

    .edit-button:hover {
        background: #2c2c2c;
        transform: translateY(-1px);
    }

    .edit-icon {
        width: 14px;
        height: 14px;
    }


    /* =====================================================
       TWO COLUMN LAYOUT
    ===================================================== */

    .case-layout {
        display: grid;
        grid-template-columns:
            minmax(0, 1.35fr)
            minmax(360px, .85fr);
        gap: 20px;
        align-items: start;
    }

    .left-column,
    .right-column {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }


    /* =====================================================
       PANELS
    ===================================================== */

    .panel {
        background: var(--paper);
        border: 1px solid var(--line);
    }

    .panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 19px 21px;
        border-bottom: 1px solid var(--line);
    }

    .panel-title {
        margin: 0;
        font-family: 'Cormorant Garamond', serif;
        font-size: 25px;
        line-height: 1;
        font-weight: 600;
    }

    .panel-subtitle {
        margin-top: 5px;
        color: var(--muted);
        font-size: 10px;
    }


    /* =====================================================
       DESCRIPTION
    ===================================================== */

    .description-content {
        padding: 24px 22px 27px;
    }

    .description-label {
        margin-bottom: 10px;
        color: #98938a;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .14em;
    }

    .description-text {
        margin: 0;
        color: #4f4c47;
        font-size: 13px;
        line-height: 1.85;
        white-space: pre-line;
    }

    .description-empty {
        color: #aaa59c;
        font-size: 12px;
        font-style: italic;
    }


    /* =====================================================
       DOCUMENTS
    ===================================================== */

    .document-upload {
        margin: 19px 21px 17px;
        padding: 23px 20px;
        border: 1px dashed #d5cfc4;
        border-radius: 5px;
        background: #fcfbf8;
        text-align: center;
        transition:
            border-color .2s ease,
            background .2s ease;
    }

    .document-upload:hover {
        border-color: var(--gold);
        background: #fbf8f1;
    }

    .upload-icon {
        width: 36px;
        height: 36px;
        margin: 0 auto 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ded8ce;
        border-radius: 50%;
        color: var(--gold-dark);
    }

    .upload-icon svg {
        width: 17px;
        height: 17px;
    }

    .upload-title {
        margin: 0;
        color: #44413c;
        font-size: 11px;
        font-weight: 600;
    }

    .upload-description {
        margin: 5px 0 18px;
        color: #99948b;
        font-size: 9px;
        line-height: 1.5;
    }


    /* =====================================================
       DOCUMENT TITLE FIELD
    ===================================================== */

    .document-title-field {
        width: 100%;
        max-width: 360px;
        margin: 0 auto 16px;
        text-align: left;
    }

    .document-title-label {
        display: block;
        margin-bottom: 6px;
        color: #777269;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .1em;
    }

    .document-title-input {
        width: 100%;
        box-sizing: border-box;
        padding: 10px 12px;
        border: 1px solid #d8d2c8;
        border-radius: 4px;
        outline: none;
        background: white;
        color: #44413c;
        font-family: inherit;
        font-size: 11px;
        transition:
            border-color .2s ease,
            box-shadow .2s ease;
    }

    .document-title-input::placeholder {
        color: #aaa59c;
    }

    .document-title-input:focus {
        border-color: var(--gold);
        box-shadow:
            0 0 0 3px
            rgba(182,154,104,.08);
    }


    /* =====================================================
       CHOOSE FILE
    ===================================================== */

    .document-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    .file-input {
        display: none;
    }

    .choose-file {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 9px 16px;
        border: 1px solid #d5d0c7;
        border-radius: 4px;
        background: white;
        color: #605c55;
        font-size: 9px;
        font-weight: 700;
        cursor: pointer;
        transition:
            border-color .2s ease,
            color .2s ease,
            background .2s ease,
            transform .2s ease;
    }

    .choose-file:hover {
        border-color: var(--gold);
        color: var(--gold-dark);
        background: #fffdf9;
        transform: translateY(-1px);
    }


    /* =====================================================
       HIDE ANY SUBMIT BUTTON
    ===================================================== */

    .document-submit {
        display: none !important;
    }


    /* =====================================================
       DOCUMENT LIST
    ===================================================== */

    .document-list {
        border-top: 1px solid #efede8;
    }

    .document-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px 21px;
        border-bottom: 1px solid #efede8;
    }

    .document-row:last-child {
        border-bottom: none;
    }

    .document-icon {
        width: 35px;
        height: 35px;
        flex: 0 0 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 5px;
        background: #f4f1eb;
        color: var(--gold-dark);
    }

    .document-icon svg {
        width: 17px;
        height: 17px;
    }

    .document-info {
        min-width: 0;
        flex: 1;
    }

    .document-name {
        color: #44413d;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .document-meta {
        margin-top: 4px;
        color: #aaa59c;
        font-size: 9px;
    }

    .document-download {
        color: var(--gold-dark);
        font-size: 10px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: color .2s ease;
    }

    .document-download:hover {
        color: var(--charcoal);
    }

    .documents-empty {
        padding: 28px 21px;
        color: #aaa59c;
        text-align: center;
        font-size: 11px;
    }


    /* =====================================================
       MESSAGES
    ===================================================== */

    .messages-panel {
        display: flex;
        flex-direction: column;
        min-height: 650px;
    }

    .message-list {
        flex: 1;
        padding: 21px;
        max-height: 530px;
        overflow-y: auto;
    }

    .message-list::-webkit-scrollbar {
        width: 4px;
    }

    .message-list::-webkit-scrollbar-thumb {
        background: #d8d2c7;
        border-radius: 10px;
    }

    .message {
        display: flex;
        margin-bottom: 17px;
    }

    .message:last-child {
        margin-bottom: 0;
    }

    .message.client {
        justify-content: flex-start;
    }

    .message.lawyer {
        justify-content: flex-end;
    }

    .message-content {
        max-width: 82%;
    }

    .message-author {
        margin-bottom: 5px;
        color: #969188;
        font-size: 9px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .08em;
    }

    .message.lawyer .message-author {
        text-align: right;
    }

    .message-bubble {
        padding: 11px 13px;
        border-radius: 8px;
        font-size: 11px;
        line-height: 1.65;
        word-break: break-word;
    }

    .message.client .message-bubble {
        background: #f2f0eb;
        color: #504d47;
        border-bottom-left-radius: 2px;
    }

    .message.lawyer .message-bubble {
        background: var(--charcoal);
        color: rgba(255,255,255,.88);
        border-bottom-right-radius: 2px;
    }

    .message-time {
        margin-top: 5px;
        color: #aaa59c;
        font-size: 8px;
    }

    .message.lawyer .message-time {
        text-align: right;
    }

    .messages-empty {
        min-height: 340px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .message-empty-icon {
        width: 42px;
        height: 42px;
        margin-bottom: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ded9d0;
        border-radius: 50%;
        color: var(--gold-dark);
    }

    .message-empty-icon svg {
        width: 18px;
        height: 18px;
    }

    .messages-empty-title {
        margin: 0;
        font-family: 'Cormorant Garamond', serif;
        font-size: 21px;
        font-weight: 600;
    }

    .messages-empty-text {
        max-width: 260px;
        margin: 6px 0 0;
        color: var(--muted);
        font-size: 10px;
        line-height: 1.6;
    }


    /* =====================================================
       MESSAGE COMPOSER
    ===================================================== */

    .message-composer {
        padding: 15px 17px;
        border-top: 1px solid var(--line);
        background: #fcfbf9;
    }

    .message-form {
        display: flex;
        align-items: flex-end;
        gap: 9px;
    }

    .message-textarea {
        flex: 1;
        min-height: 72px;
        resize: vertical;
        padding: 11px 12px;
        border: 1px solid #ddd8cf;
        border-radius: 5px;
        outline: none;
        background: white;
        color: #3f3d39;
        font-size: 11px;
        line-height: 1.55;
        transition:
            border-color .2s ease,
            box-shadow .2s ease;
    }

    .message-textarea::placeholder {
        color: #aaa59c;
    }

    .message-textarea:focus {
        border-color: var(--gold);
        box-shadow:
            0 0 0 3px
            rgba(182,154,104,.08);
    }

    .send-button {
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 0 15px;
        border: 1px solid var(--charcoal);
        border-radius: 4px;
        background: var(--charcoal);
        color: white;
        font-size: 10px;
        font-weight: 700;
        cursor: pointer;
        transition:
            background .2s ease,
            transform .2s ease;
    }

    .send-button:hover {
        background: #2d2d2d;
        transform: translateY(-1px);
    }

    .send-button svg {
        width: 14px;
        height: 14px;
    }


    /* =====================================================
       ALERTS
    ===================================================== */

    .alert {
        margin-bottom: 20px;
        padding: 12px 15px;
        border-radius: 4px;
        font-size: 11px;
    }

    .alert-success {
        border: 1px solid #cfe1d4;
        background: #f0f7f2;
        color: #3e6b50;
    }

    .alert-error {
        border: 1px solid #ead0ce;
        background: #fbf0ef;
        color: #8c4844;
    }


    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 1150px) {

        .case-layout {
            grid-template-columns:
                minmax(0, 1.2fr)
                minmax(320px, .8fr);
        }

    }


    @media (max-width: 900px) {

        .page-header {
            display: block;
        }

        .edit-button {
            margin-top: 20px;
        }

        .case-layout {
            grid-template-columns: 1fr;
        }

        .messages-panel {
            min-height: 550px;
        }

    }


    @media (max-width: 600px) {

        .breadcrumb {
            margin-bottom: 20px;
        }

        .page-title {
            font-size: 40px;
        }

        .header-meta {
            flex-wrap: wrap;
        }

        .document-upload {
            margin-left: 15px;
            margin-right: 15px;
        }

        .document-actions {
            width: 100%;
        }

        .choose-file {
            min-width: 120px;
        }

        .document-title-field {
            max-width: 100%;
        }

        .message-content {
            max-width: 88%;
        }

        .message-form {
            flex-direction: column;
            align-items: stretch;
        }

        .send-button {
            width: 100%;
        }

        .document-row {
            align-items: flex-start;
        }

        .document-download {
            font-size: 9px;
        }

    }

</style>

@endpush


@section('content')

    {{-- =====================================================
         BREADCRUMB
    ===================================================== --}}

    <div class="breadcrumb">

        <a href="{{ route('lawyer.cases.index') }}">
            My Cases
        </a>

        <span class="breadcrumb-arrow">
            /
        </span>

        <span class="breadcrumb-current">
            {{ $case->case_number }}
        </span>

    </div>


    {{-- =====================================================
         FLASH MESSAGES
    ===================================================== --}}

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-error">
            {{ session('error') }}
        </div>

    @endif


    {{-- =====================================================
         VALIDATION ERRORS
    ===================================================== --}}

    @if($errors->any())

        <div class="alert alert-error">

            @foreach($errors->all() as $error)

                <div>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    @endif


    {{-- =====================================================
         PAGE HEADER
    ===================================================== --}}

    <header class="page-header">

        <div>

            <div class="case-stamp">

                <span class="case-number">
                    {{ $case->case_number }}
                </span>

                <span class="stamp-divider"></span>

                <span class="case-type">
                    {{ $case->case_type }}
                </span>

            </div>


            <h1 class="page-title">
                Case Details
            </h1>


            <div class="header-meta">

                <span>

                    Opened

                    {{ $case->created_at
                        ? $case->created_at->format('M d, Y')
                        : '—'
                    }}

                </span>


                <span class="meta-separator">
                    ·
                </span>


                <span>

                    Client:

                    {{ $case->client?->name ?? '—' }}

                </span>


                <span class="meta-separator">
                    ·
                </span>


                @php
                    $status = strtolower($case->status ?? '');
                @endphp


                <span class="status

                    @if(in_array($status, ['open', 'opened', 'active']))
                        status-open

                    @elseif(in_array($status, ['closed', 'completed']))
                        status-closed

                    @elseif(in_array($status, ['pending', 'in_progress']))
                        status-pending

                    @elseif($status === 'rejected')
                        status-rejected

                    @else
                        status-closed
                    @endif

                ">

                    {{ str_replace('_', ' ', $case->status ?? 'Unknown') }}

                </span>

            </div>

        </div>


        {{-- EDIT CASE --}}

        @if(Route::has('lawyer.cases.edit'))

            <a
                href="{{ route('lawyer.cases.edit', $case) }}"
                class="edit-button"
            >

                <svg
                    class="edit-icon"
                    viewBox="0 0 24 24"
                    fill="none"
                >

                    <path
                        d="M12 20h9"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                    />

                    <path
                        d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4 11.5-11.5Z"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linejoin="round"
                    />

                </svg>

                Edit case

            </a>

        @endif

    </header>


    {{-- =====================================================
         CASE LAYOUT
    ===================================================== --}}

    <div class="case-layout">


        {{-- =================================================
             LEFT COLUMN
        ================================================== --}}

        <div class="left-column">


            {{-- =================================================
                 CASE DESCRIPTION
            ================================================== --}}

            <section class="panel">

                <div class="panel-header">

                    <div>

                        <h2 class="panel-title">
                            Case Description
                        </h2>

                        <div class="panel-subtitle">
                            Official case record
                        </div>

                    </div>

                </div>


                <div class="description-content">

                    <div class="description-label">
                        Matter description
                    </div>


                    @if($case->description)

                        <p class="description-text">
                            {{ $case->description }}
                        </p>

                    @else

                        <p class="description-empty">
                            No case description has been provided.
                        </p>

                    @endif

                </div>

            </section>



            {{-- =================================================
                 DOCUMENTS
            ================================================== --}}

            <section class="panel">


                {{-- DOCUMENT HEADER --}}

                <div class="panel-header">

                    <div>

                        <h2 class="panel-title">
                            Documents
                        </h2>

                        <div class="panel-subtitle">
                            Files shared within this case
                        </div>

                    </div>


                    <div style="color:#928d84;font-size:10px;">

                        {{ $case->documents->count() }}

                        {{ $case->documents->count() === 1
                            ? 'file'
                            : 'files'
                        }}

                    </div>

                </div>



                {{-- =================================================
                     DOCUMENT UPLOAD
                ================================================== --}}

                @if(Route::has('lawyer.cases.documents.store'))

                    <form
                        id="document-upload-form"
                        action="{{ route(
                            'lawyer.cases.documents.store',
                            $case
                        ) }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="document-upload"
                    >

                        @csrf


                        {{-- UPLOAD ICON --}}

                        <div class="upload-icon">

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                            >

                                <path
                                    d="M12 16V4"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                />

                                <path
                                    d="m7 9 5-5 5 5"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />

                                <path
                                    d="M5 20h14"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                />

                            </svg>

                        </div>


                        <h3 class="upload-title">
                            Add a document
                        </h3>


                        <p class="upload-description">
                            Enter a title for the document, then choose your file.
                            PDF or DOC/DOCX · Maximum file size 10 MB
                        </p>


                        {{-- =================================================
                             DOCUMENT TITLE
                        ================================================== --}}

                        <div class="document-title-field">

                            <label
                                for="document-title"
                                class="document-title-label"
                            >
                                Document title
                            </label>


                            <input
                                type="text"
                                name="title"
                                id="document-title"
                                class="document-title-input"
                                placeholder="e.g. Client Contract"
                                value="{{ old('title') }}"
                                maxlength="255"
                                required
                            >

                        </div>


                        {{-- =================================================
                             CHOOSE FILE
                        ================================================== --}}

                        <div class="document-actions">

                            <label class="choose-file">

                                Choose file

                                <input
                                    type="file"
                                    name="document"
                                    class="file-input"
                                    accept=".pdf,.doc,.docx"
                                    required
                                >

                            </label>

                        </div>

                    </form>

                @endif



                {{-- =================================================
                     DOCUMENT LIST
                ================================================== --}}

                @if($case->documents->isNotEmpty())

                    <div class="document-list">

                        @foreach($case->documents as $document)

                            <div class="document-row">


                                {{-- DOCUMENT ICON --}}

                                <div class="document-icon">

                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="none"
                                    >

                                        <path
                                            d="M6 3h8l4 4v14H6V3Z"
                                            stroke="currentColor"
                                            stroke-width="1.4"
                                            stroke-linejoin="round"
                                        />

                                        <path
                                            d="M14 3v5h5"
                                            stroke="currentColor"
                                            stroke-width="1.4"
                                            stroke-linejoin="round"
                                        />

                                    </svg>

                                </div>



                                {{-- DOCUMENT INFO --}}

                                <div class="document-info">

                                    <div class="document-name">

                                        {{ $document->title
                                            ?? $document->name
                                            ?? $document->original_name
                                            ?? 'Document'
                                        }}

                                    </div>


                                    <div class="document-meta">

                                        @if($document->created_at)

                                            {{ $document->created_at->format('M d, Y') }}

                                        @endif


                                        @if($document->file_size)

                                            ·

                                            {{ number_format(
                                                $document->file_size / 1024 / 1024,
                                                2
                                            ) }}

                                            MB

                                        @endif

                                    </div>

                                </div>



                                {{-- DOWNLOAD --}}

                                @if(Route::has('lawyer.documents.download'))

                                    <a
                                        href="{{ route(
                                            'lawyer.documents.download',
                                            $document
                                        ) }}"
                                        class="document-download"
                                    >
                                        Download
                                    </a>

                                @elseif(Route::has(
                                    'lawyer.cases.documents.download'
                                ))

                                    <a
                                        href="{{ route(
                                            'lawyer.cases.documents.download',
                                            [$case, $document]
                                        ) }}"
                                        class="document-download"
                                    >
                                        Download
                                    </a>

                                @endif

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="documents-empty">

                        No documents have been added to this case yet.

                    </div>

                @endif

            </section>

        </div>



        {{-- =================================================
             RIGHT COLUMN — MESSAGES
        ================================================== --}}

        <div class="right-column">

            <section class="panel messages-panel">


                {{-- MESSAGE HEADER --}}

                <div class="panel-header">

                    <div>

                        <h2 class="panel-title">
                            Messages
                        </h2>

                        <div class="panel-subtitle">

                            Conversation with

                            {{ $case->client?->name ?? 'client' }}

                        </div>

                    </div>

                </div>



                {{-- MESSAGE LIST --}}

                <div class="message-list">

                    @if($case->messages->isNotEmpty())

                        @foreach($case->messages as $message)

                            @php

                                $isLawyerMessage =
                                    (int) $message->user_id ===
                                    (int) auth()->id();

                            @endphp


                            <div class="message
                                {{ $isLawyerMessage
                                    ? 'lawyer'
                                    : 'client'
                                }}
                            ">

                                <div class="message-content">

                                    <div class="message-author">

                                        @if($isLawyerMessage)

                                            You

                                        @else

                                            {{ $message->user?->name ?? 'Client' }}

                                        @endif

                                    </div>


                                    <div class="message-bubble">

                                        {{ $message->message }}

                                    </div>


                                    <div class="message-time">

                                        {{ $message->created_at
                                            ? $message->created_at->format(
                                                'M d, Y · g:i A'
                                            )
                                            : ''
                                        }}

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    @else

                        <div class="messages-empty">

                            <div class="message-empty-icon">

                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                >

                                    <path
                                        d="M5 6.5A2.5 2.5 0 0 1 7.5 4h9A2.5 2.5 0 0 1 19 6.5v7a2.5 2.5 0 0 1-2.5 2.5H12l-4.5 4v-4h0A2.5 2.5 0 0 1 5 13.5v-7Z"
                                        stroke="currentColor"
                                        stroke-width="1.4"
                                        stroke-linejoin="round"
                                    />

                                </svg>

                            </div>


                            <h3 class="messages-empty-title">
                                No messages yet
                            </h3>


                            <p class="messages-empty-text">

                                Start the conversation with your client
                                using the message box below.

                            </p>

                        </div>

                    @endif

                </div>



                {{-- MESSAGE COMPOSER --}}

                @if(Route::has('lawyer.messages.store'))

                    <div class="message-composer">

                        <form
                            action="{{ route(
                                'lawyer.messages.store',
                                $case
                            ) }}"
                            method="POST"
                            class="message-form"
                        >

                            @csrf


                            <textarea
                                name="message"
                                class="message-textarea"
                                placeholder="Write a message to your client..."
                                required
                            >{{ old('message') }}</textarea>


                            <button
                                type="submit"
                                class="send-button"
                            >

                                Send

                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                >

                                    <path
                                        d="M22 2 11 13"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />

                                    <path
                                        d="m22 2-7 20-4-9-9-4 20-7Z"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linejoin="round"
                                    />

                                </svg>

                            </button>

                        </form>

                    </div>

                @endif

            </section>

        </div>

    </div>


    {{-- =====================================================
         AUTO UPLOAD WHEN FILE IS SELECTED
    ===================================================== --}}

    @if(Route::has('lawyer.cases.documents.store'))

        <script>

            document.addEventListener('DOMContentLoaded', function () {

                const fileInput = document.querySelector(
                    '.document-upload .file-input'
                );

                const uploadForm = document.getElementById(
                    'document-upload-form'
                );

                const titleInput = document.getElementById(
                    'document-title'
                );


                if (!fileInput || !uploadForm || !titleInput) {
                    return;
                }


                fileInput.addEventListener('change', function () {

                    /*
                     * Do not upload if the lawyer
                     * has not entered a title.
                     */

                    if (!titleInput.value.trim()) {

                        alert('Please enter a document title first.');

                        this.value = '';

                        titleInput.focus();

                        return;
                    }


                    /*
                     * File selected and title exists.
                     * Submit the complete form.
                     */

                    if (this.files.length > 0) {

                        uploadForm.submit();

                    }

                });

            });

        </script>

    @endif

@endsection