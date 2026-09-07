@extends('layouts.app')

@section('title', 'Document Details')

@section('content')
    <div class="min-h-screen bg-slate-50">
        <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8">

            {{-- Back --}}
            <div class="mb-6">
                <a href="{{ route('admin.documents.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 transition hover:text-slate-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19l-7-7 7-7" />
                    </svg>

                    Back to Documents
                </a>
            </div>

            @php
                $fileName = $document->file_name ?? ($document->filename ?? ($document->name ?? 'Untitled Document'));

                $filePath =
                    $document->file_path ??
                    ($document->path ?? ($document->filepath ?? ($document->storage_path ?? null)));

                $mimeType = $document->mime_type ?? ($document->file_type ?? null);

                $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $uploader = $document->uploader ?? ($document->user ?? ($document->uploadedBy ?? null));

                $case = $document->case ?? ($document->caseFile ?? null);

                $client = $document->client ?? ($case->client ?? null);

                $lawyer = $document->lawyer ?? ($case->lawyer ?? null);

                $uploaderName = $uploader->name ?? ($document->uploaded_by_name ?? 'Unknown User');

                $caseTitle = $case->title ?? ($case->case_number ?? ($document->case_title ?? null));

                $isPdf = $extension === 'pdf' || $mimeType === 'application/pdf';

                $isImage =
                    in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']) ||
                    str_starts_with((string) $mimeType, 'image/');

                $isWord = in_array($extension, ['doc', 'docx']);

                $downloadUrl = null;

                if ($filePath) {
                    try {
                        $downloadUrl = \Illuminate\Support\Facades\Storage::url($filePath);
                    } catch (\Throwable $e) {
                        $downloadUrl = null;
                    }
                }
            @endphp

            {{-- Header --}}
            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">

                    <div class="flex min-w-0 items-start gap-4">

                        {{-- File Icon --}}
                        <div
                            class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl
                        {{ $isPdf
                            ? 'bg-red-50 text-red-600'
                            : ($isImage
                                ? 'bg-purple-50 text-purple-600'
                                : ($isWord
                                    ? 'bg-blue-50 text-blue-600'
                                    : 'bg-slate-100 text-slate-600')) }}">

                            @if ($isImage)
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18" rx="2" stroke-width="1.8" />
                                    <circle cx="8.5" cy="8.5" r="1.5" stroke-width="1.8" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="m21 15-5-5L5 21" />
                                </svg>
                            @else
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 3v6h5" />
                                </svg>
                            @endif
                        </div>

                        <div class="min-w-0">
                            <h1 class="break-words text-xl font-bold text-slate-900 sm:text-2xl">
                                {{ $fileName }}
                            </h1>

                            <div class="mt-2 flex flex-wrap items-center gap-2">
                                @if ($extension)
                                    <span
                                        class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase text-slate-600">
                                        {{ $extension }}
                                    </span>
                                @endif

                                @if ($document->created_at)
                                    <span class="text-sm text-slate-400">
                                        Uploaded {{ $document->created_at->format('M d, Y') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Download --}}
                    @if ($downloadUrl)
                        <a href="{{ $downloadUrl }}" target="_blank"
                            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M12 3v12m0 0l-4-4m4 4l4-4" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 21h14" />
                            </svg>

                            Download
                        </a>
                    @endif

                </div>
            </div>

            {{-- Main Grid --}}
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                {{-- Preview --}}
                <div class="lg:col-span-2">
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-200 px-6 py-4">
                            <h2 class="text-base font-semibold text-slate-900">
                                Document Preview
                            </h2>
                        </div>

                        <div class="min-h-[420px] bg-slate-100 p-4 sm:p-6">

                            @if ($isImage && $downloadUrl)

                                <div class="flex min-h-[380px] items-center justify-center">
                                    <img src="{{ $downloadUrl }}" alt="{{ $fileName }}"
                                        class="max-h-[600px] max-w-full rounded-xl object-contain shadow-sm">
                                </div>
                            @elseif($isPdf && $downloadUrl)
                                <iframe src="{{ $downloadUrl }}"
                                    class="h-[600px] w-full rounded-xl border border-slate-200 bg-white"
                                    title="{{ $fileName }}"></iframe>
                            @else
                                <div class="flex min-h-[380px] flex-col items-center justify-center text-center">

                                    <div
                                        class="flex h-20 w-20 items-center justify-center rounded-2xl bg-white text-slate-400 shadow-sm">
                                        <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M14 3v6h5" />
                                        </svg>
                                    </div>

                                    <h3 class="mt-5 text-base font-semibold text-slate-900">
                                        Preview unavailable
                                    </h3>

                                    <p class="mt-2 max-w-md text-sm text-slate-500">
                                        This file type cannot be previewed in the browser.
                                        Use the download button to open the document.
                                    </p>

                                    @if ($downloadUrl)
                                        <a href="{{ $downloadUrl }}" target="_blank"
                                            class="mt-5 inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                                            Open Document

                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    @endif

                                </div>

                            @endif

                        </div>
                    </div>
                </div>

                {{-- Information --}}
                <div class="space-y-6">

                    {{-- Document Information --}}
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                        <h2 class="text-base font-semibold text-slate-900">
                            Document Information
                        </h2>

                        <div class="mt-5 divide-y divide-slate-100">

                            <div class="flex items-start justify-between gap-4 py-3 first:pt-0">
                                <span class="text-sm text-slate-500">
                                    File Name
                                </span>

                                <span class="max-w-[180px] break-words text-right text-sm font-medium text-slate-900">
                                    {{ $fileName }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between gap-4 py-3">
                                <span class="text-sm text-slate-500">
                                    File Type
                                </span>

                                <span class="text-sm font-medium uppercase text-slate-900">
                                    {{ $extension ?: 'Unknown' }}
                                </span>
                            </div>

                            @if ($mimeType)
                                <div class="flex items-start justify-between gap-4 py-3">
                                    <span class="text-sm text-slate-500">
                                        MIME Type
                                    </span>

                                    <span class="max-w-[180px] break-all text-right text-xs font-medium text-slate-700">
                                        {{ $mimeType }}
                                    </span>
                                </div>
                            @endif

                            @if (!empty($document->file_size))
                                <div class="flex items-center justify-between gap-4 py-3">
                                    <span class="text-sm text-slate-500">
                                        File Size
                                    </span>

                                    <span class="text-sm font-medium text-slate-900">
                                        {{ number_format($document->file_size / 1024, 1) }} KB
                                    </span>
                                </div>
                            @endif

                            <div class="flex items-center justify-between gap-4 py-3">
                                <span class="text-sm text-slate-500">
                                    Uploaded
                                </span>

                                <span class="text-right text-sm font-medium text-slate-900">
                                    {{ $document->created_at ? $document->created_at->format('M d, Y') : '—' }}
                                </span>
                            </div>

                            @if ($document->created_at)
                                <div class="flex items-center justify-between gap-4 py-3 last:pb-0">
                                    <span class="text-sm text-slate-500">
                                        Time
                                    </span>

                                    <span class="text-sm font-medium text-slate-900">
                                        {{ $document->created_at->format('h:i A') }}
                                    </span>
                                </div>
                            @endif

                        </div>
                    </div>

                    {{-- Uploaded By --}}
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                        <h2 class="text-base font-semibold text-slate-900">
                            Uploaded By
                        </h2>

                        <div class="mt-5 flex items-center gap-3">

                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-full bg-slate-900 text-sm font-bold text-white">
                                {{ strtoupper(substr($uploaderName, 0, 1)) }}
                            </div>

                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-slate-900">
                                    {{ $uploaderName }}
                                </p>

                                @if ($uploader && !empty($uploader->email))
                                    <p class="truncate text-xs text-slate-500">
                                        {{ $uploader->email }}
                                    </p>
                                @endif

                                @if ($uploader && !empty($uploader->role))
                                    <p class="mt-1 text-xs capitalize text-slate-400">
                                        {{ $uploader->role }}
                                    </p>
                                @endif
                            </div>

                        </div>
                    </div>

                    {{-- Case --}}
                    @if ($case)
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                            <h2 class="text-base font-semibold text-slate-900">
                                Related Case
                            </h2>

                            <div class="mt-5">

                                <p class="text-sm font-semibold text-slate-900">
                                    {{ $caseTitle }}
                                </p>

                                @if (!empty($case->case_number))
                                    <p class="mt-1 text-xs text-slate-500">
                                        Case #{{ $case->case_number }}
                                    </p>
                                @endif

                                @if (!empty($case->status))
                                    <span
                                        class="mt-3 inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold capitalize text-blue-700">
                                        {{ $case->status }}
                                    </span>
                                @endif

                                @if (\Illuminate\Support\Facades\Route::has('admin.cases.show'))
                                    <a href="{{ route('admin.cases.show', $case) }}"
                                        class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-slate-700 transition hover:text-slate-900">
                                        View Case

                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                @endif

                            </div>
                        </div>
                    @endif

                </div>
            </div>

            {{-- Additional Relationships --}}
            @if ($client || $lawyer)
                <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">

                    @if ($client)
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2" />
                                        <circle cx="9" cy="7" r="4" stroke-width="1.8" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M19 8v6m3-3h-6" />
                                    </svg>
                                </div>

                                <div>
                                    <h2 class="text-base font-semibold text-slate-900">
                                        Client
                                    </h2>

                                    <p class="text-xs text-slate-500">
                                        Related client
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5">
                                <p class="text-sm font-semibold text-slate-900">
                                    {{ $client->name ?? 'Unknown Client' }}
                                </p>

                                @if (!empty($client->email))
                                    <p class="mt-1 text-sm text-slate-500">
                                        {{ $client->email }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if ($lawyer)
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M12 14l9-5-9-5-9 5 9 5z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M5 12v4c0 1.5 3.13 3 7 3s7-1.5 7-3v-4" />
                                    </svg>
                                </div>

                                <div>
                                    <h2 class="text-base font-semibold text-slate-900">
                                        Lawyer
                                    </h2>

                                    <p class="text-xs text-slate-500">
                                        Assigned lawyer
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5">
                                <p class="text-sm font-semibold text-slate-900">
                                    {{ $lawyer->name ?? 'Unknown Lawyer' }}
                                </p>

                                @if (!empty($lawyer->email))
                                    <p class="mt-1 text-sm text-slate-500">
                                        {{ $lawyer->email }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>
            @endif

            {{-- Admin Notice --}}
            <div class="mt-6 rounded-2xl border border-blue-100 bg-blue-50 p-5">
                <div class="flex gap-3">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9" stroke-width="1.8" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 11v5m0-8h.01" />
                    </svg>

                    <div>
                        <p class="text-sm font-semibold text-blue-900">
                            Administrator Access
                        </p>

                        <p class="mt-1 text-sm leading-6 text-blue-800">
                            This document is visible to administrators for firm-wide
                            document management and auditing.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
