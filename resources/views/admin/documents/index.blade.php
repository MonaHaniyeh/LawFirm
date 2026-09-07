@extends('layouts.app')

@section('title', 'Documents')

@section('content')
    <div x-data="{
        search: '',
        type: 'all',
        matches(row) {
            const text = row.dataset.search || '';
            const rowType = row.dataset.type || '';
    
            const searchMatch = text.includes(this.search.toLowerCase());
            const typeMatch = this.type === 'all' || rowType === this.type;
    
            return searchMatch && typeMatch;
        }
    }" class="min-h-screen bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-900 text-white shadow-sm">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M14 3v6h5M9 13h6M9 17h6" />
                            </svg>
                        </div>

                        <div>
                            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                                Documents
                            </h1>
                            <p class="mt-1 text-sm text-slate-500">
                                Manage documents uploaded across the firm.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Statistics --}}
            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

                {{-- Total --}}
                <div
                    class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Total Documents</p>
                            <p class="mt-2 text-3xl font-bold text-slate-900">
                                {{ $documents->total() ?? $documents->count() }}
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-slate-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 3v6h5" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- PDF --}}
                <div
                    class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">PDF Documents</p>
                            <p class="mt-2 text-3xl font-bold text-slate-900">
                                {{ $documents->filter(function ($document) {
                                        $name = $document->file_name ?? ($document->filename ?? ($document->name ?? ''));
                                
                                        return strtolower(pathinfo($name, PATHINFO_EXTENSION)) === 'pdf';
                                    })->count() }}
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 3v6h5" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Recent --}}
                <div
                    class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Recent Uploads</p>
                            <p class="mt-2 text-3xl font-bold text-slate-900">
                                {{ $documents->filter(function ($document) {
                                        return $document->created_at && $document->created_at->greaterThanOrEqualTo(now()->subDays(7));
                                    })->count() }}
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M12 3v12m0 0l-4-4m4 4l4-4" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 21h14" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Cases --}}
                <div
                    class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Linked Cases</p>
                            <p class="mt-2 text-3xl font-bold text-slate-900">
                                {{ $documents->filter(function ($document) {
                                        return !empty($document->case_id) || isset($document->case);
                                    })->count() }}
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M3 7a2 2 0 012-2h5l2 2h7a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Search / Filters --}}
            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                    {{-- Search --}}
                    <div class="relative w-full lg:max-w-md">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="m21 21-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z" />
                            </svg>
                        </div>

                        <input x-model="search" type="text" placeholder="Search documents..."
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white focus:ring-2 focus:ring-slate-200">
                    </div>

                    {{-- Filters --}}
                    <div class="flex flex-wrap gap-2">
                        <button type="button" @click="type = 'all'"
                            :class="type === 'all'
                                ?
                                'bg-slate-900 text-white' :
                                'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            class="rounded-lg px-4 py-2 text-sm font-medium transition">
                            All
                        </button>

                        <button type="button" @click="type = 'pdf'"
                            :class="type === 'pdf'
                                ?
                                'bg-slate-900 text-white' :
                                'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            class="rounded-lg px-4 py-2 text-sm font-medium transition">
                            PDF
                        </button>

                        <button type="button" @click="type = 'doc'"
                            :class="type === 'doc'
                                ?
                                'bg-slate-900 text-white' :
                                'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            class="rounded-lg px-4 py-2 text-sm font-medium transition">
                            Word
                        </button>

                        <button type="button" @click="type = 'image'"
                            :class="type === 'image'
                                ?
                                'bg-slate-900 text-white' :
                                'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            class="rounded-lg px-4 py-2 text-sm font-medium transition">
                            Images
                        </button>
                    </div>
                </div>
            </div>

            {{-- Documents Table --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                {{-- Desktop --}}
                <div class="hidden overflow-x-auto md:block">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Document
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Uploaded By
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Case
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Type
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Date
                                </th>

                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse($documents as $document)

                                @php
                                    $fileName =
                                        $document->file_name ??
                                        ($document->filename ?? ($document->name ?? 'Untitled Document'));

                                    $extension = strtolower(
                                        $document->file_type ??
                                            ($document->mime_type ?? (pathinfo($fileName, PATHINFO_EXTENSION) ?? '')),
                                    );

                                    $extension = str_replace('application/', '', $extension);

                                    if (str_contains($extension, 'pdf')) {
                                        $documentType = 'pdf';
                                        $typeLabel = 'PDF';
                                    } elseif (
                                        str_contains($extension, 'word') ||
                                        in_array($extension, ['doc', 'docx'])
                                    ) {
                                        $documentType = 'doc';
                                        $typeLabel = 'Word';
                                    } elseif (
                                        str_contains($extension, 'image') ||
                                        in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])
                                    ) {
                                        $documentType = 'image';
                                        $typeLabel = 'Image';
                                    } else {
                                        $documentType = 'other';
                                        $typeLabel = strtoupper($extension ?: 'FILE');
                                    }

                                    $uploader =
                                        $document->uploader ?? ($document->user ?? ($document->uploadedBy ?? null));

                                    $case = $document->case ?? ($document->caseFile ?? null);

                                    $uploaderName = $uploader->name ?? ($document->uploaded_by_name ?? 'Unknown User');

                                    $caseTitle =
                                        $case->title ?? ($case->case_number ?? ($document->case_title ?? 'No Case'));

                                    $searchText = strtolower(
                                        $fileName . ' ' . $uploaderName . ' ' . $caseTitle . ' ' . $typeLabel,
                                    );
                                @endphp

                                <tr x-show="matches($el)" x-cloak data-search="{{ $searchText }}"
                                    data-type="{{ $documentType }}" class="group transition hover:bg-slate-50">
                                    {{-- Document --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center gap-3">

                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl
                                            {{ $documentType === 'pdf'
                                                ? 'bg-red-50 text-red-600'
                                                : ($documentType === 'doc'
                                                    ? 'bg-blue-50 text-blue-600'
                                                    : ($documentType === 'image'
                                                        ? 'bg-purple-50 text-purple-600'
                                                        : 'bg-slate-100 text-slate-600')) }}">

                                                @if ($documentType === 'image')
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <rect x="3" y="3" width="18" height="18" rx="2"
                                                            stroke-width="1.8" />
                                                        <circle cx="8.5" cy="8.5" r="1.5"
                                                            stroke-width="1.8" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.8" d="m21 15-5-5L5 21" />
                                                    </svg>
                                                @else
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.8"
                                                            d="M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.8" d="M14 3v6h5" />
                                                    </svg>
                                                @endif
                                            </div>

                                            <div class="min-w-0">
                                                <p class="max-w-xs truncate text-sm font-semibold text-slate-900">
                                                    {{ $fileName }}
                                                </p>

                                                @if (!empty($document->file_size))
                                                    <p class="mt-1 text-xs text-slate-500">
                                                        {{ number_format($document->file_size / 1024, 1) }} KB
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Uploaded By --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-900 text-xs font-bold text-white">
                                                {{ strtoupper(substr($uploaderName, 0, 1)) }}
                                            </div>

                                            <div>
                                                <p class="text-sm font-medium text-slate-900">
                                                    {{ $uploaderName }}
                                                </p>

                                                @if ($uploader && !empty($uploader->role))
                                                    <p class="text-xs capitalize text-slate-500">
                                                        {{ $uploader->role }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Case --}}
                                    <td class="px-6 py-4">
                                        @if ($case)
                                            <p class="max-w-[180px] truncate text-sm font-medium text-slate-800">
                                                {{ $caseTitle }}
                                            </p>

                                            @if (!empty($case->case_number))
                                                <p class="mt-1 text-xs text-slate-500">
                                                    #{{ $case->case_number }}
                                                </p>
                                            @endif
                                        @else
                                            <span class="text-sm text-slate-400">
                                                No Case
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Type --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span
                                            class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
                                        {{ $documentType === 'pdf'
                                            ? 'bg-red-50 text-red-700'
                                            : ($documentType === 'doc'
                                                ? 'bg-blue-50 text-blue-700'
                                                : ($documentType === 'image'
                                                    ? 'bg-purple-50 text-purple-700'
                                                    : 'bg-slate-100 text-slate-700')) }}">
                                            {{ $typeLabel }}
                                        </span>
                                    </td>

                                    {{-- Date --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        @if ($document->created_at)
                                            <p class="text-sm text-slate-700">
                                                {{ $document->created_at->format('M d, Y') }}
                                            </p>
                                            <p class="mt-1 text-xs text-slate-400">
                                                {{ $document->created_at->format('h:i A') }}
                                            </p>
                                        @else
                                            <span class="text-sm text-slate-400">—</span>
                                        @endif
                                    </td>

                                    {{-- Action --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-right">
                                        <a href="{{ route('admin.documents.show', $document) }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 hover:text-slate-900">
                                            View

                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div
                                            class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                            <svg class="h-8 w-8" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                                    d="M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                                    d="M14 3v6h5" />
                                            </svg>
                                        </div>

                                        <h3 class="mt-4 text-base font-semibold text-slate-900">
                                            No documents found
                                        </h3>

                                        <p class="mt-1 text-sm text-slate-500">
                                            Documents uploaded by users will appear here.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile --}}
                <div class="divide-y divide-slate-100 md:hidden">

                    @forelse($documents as $document)
                        @php
                            $fileName =
                                $document->file_name ??
                                ($document->filename ?? ($document->name ?? 'Untitled Document'));

                            $extension = strtolower(
                                $document->file_type ??
                                    ($document->mime_type ?? (pathinfo($fileName, PATHINFO_EXTENSION) ?? '')),
                            );

                            if (str_contains($extension, 'pdf')) {
                                $documentType = 'pdf';
                                $typeLabel = 'PDF';
                            } elseif (str_contains($extension, 'word') || in_array($extension, ['doc', 'docx'])) {
                                $documentType = 'doc';
                                $typeLabel = 'Word';
                            } elseif (
                                str_contains($extension, 'image') ||
                                in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])
                            ) {
                                $documentType = 'image';
                                $typeLabel = 'Image';
                            } else {
                                $documentType = 'other';
                                $typeLabel = strtoupper($extension ?: 'FILE');
                            }

                            $uploader = $document->uploader ?? ($document->user ?? ($document->uploadedBy ?? null));

                            $case = $document->case ?? ($document->caseFile ?? null);

                            $uploaderName = $uploader->name ?? ($document->uploaded_by_name ?? 'Unknown User');

                            $caseTitle = $case->title ?? ($case->case_number ?? ($document->case_title ?? 'No Case'));

                            $searchText = strtolower(
                                $fileName . ' ' . $uploaderName . ' ' . $caseTitle . ' ' . $typeLabel,
                            );
                        @endphp

                        <div x-show="matches($el)" x-cloak data-search="{{ $searchText }}"
                            data-type="{{ $documentType }}" class="p-5 transition hover:bg-slate-50">
                            <div class="flex items-start justify-between gap-4">

                                <div class="flex min-w-0 items-start gap-3">

                                    <div
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl
                                    {{ $documentType === 'pdf'
                                        ? 'bg-red-50 text-red-600'
                                        : ($documentType === 'doc'
                                            ? 'bg-blue-50 text-blue-600'
                                            : ($documentType === 'image'
                                                ? 'bg-purple-50 text-purple-600'
                                                : 'bg-slate-100 text-slate-600')) }}">

                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M14 3v6h5" />
                                        </svg>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-slate-900">
                                            {{ $fileName }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ $uploaderName }}
                                        </p>

                                        <div class="mt-2 flex flex-wrap items-center gap-2">
                                            <span
                                                class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                                                {{ $typeLabel }}
                                            </span>

                                            @if ($case)
                                                <span
                                                    class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                                                    {{ $caseTitle }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('admin.documents.show', $document) }}"
                                    class="shrink-0 rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>

                            <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-3">
                                <span class="text-xs text-slate-400">
                                    {{ $document->created_at ? $document->created_at->format('M d, Y h:i A') : 'No date' }}
                                </span>

                                @if (!empty($document->file_size))
                                    <span class="text-xs text-slate-400">
                                        {{ number_format($document->file_size / 1024, 1) }} KB
                                    </span>
                                @endif
                            </div>
                        </div>

                    @empty
                        <div class="px-6 py-16 text-center">
                            <div
                                class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                        d="M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                        d="M14 3v6h5" />
                                </svg>
                            </div>

                            <h3 class="mt-4 text-base font-semibold text-slate-900">
                                No documents found
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Documents uploaded by users will appear here.
                            </p>
                        </div>
                    @endforelse

                </div>
            </div>

            {{-- Pagination --}}
            @if (method_exists($documents, 'links'))
                <div class="mt-6">
                    {{ $documents->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection
