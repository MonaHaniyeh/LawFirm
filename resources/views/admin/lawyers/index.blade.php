@extends('layouts.app')

@section('title', 'Lawyers')

@section('content')
    <div
        x-data="{
            search: '',
            status: 'all',

            matches(row) {
                const text = row.dataset.search || '';
                const rowStatus = row.dataset.status || '';

                const searchMatch = text.includes(this.search.toLowerCase());
                const statusMatch = this.status === 'all' || rowStatus === this.status;

                return searchMatch && statusMatch;
            }
        }"
        class="min-h-screen bg-[#F7F4ED]"
    >

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

                <div>
                    <p class="mb-2 text-[11px] font-semibold uppercase tracking-[0.14em] text-[#B89452]">
                        Firm Management
                    </p>

                    <h1 class="font-serif text-3xl font-semibold tracking-tight text-[#0B0B0A] sm:text-4xl">
                        Lawyers
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-[#77756F]">
                        Manage lawyers, specializations, experience, and firm access.
                    </p>
                </div>

                <a
                    href="{{ route('admin.lawyers.create') }}"
                    class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-[#C9A96E] px-5 text-sm font-semibold text-[#11110F] transition hover:bg-[#B89452]"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 5v14M5 12h14"
                        />
                    </svg>

                    Add Lawyer
                </a>

            </div>


            {{-- Statistics --}}
            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                {{-- Total --}}
                <div class="rounded-xl border border-[#E5E2DB] bg-white p-5">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#9B9992]">
                                Total Lawyers
                            </p>

                            <p class="mt-2 text-2xl font-semibold text-[#0B0B0A]">
                                {{ $lawyers->total() }}
                            </p>

                            <p class="mt-1 text-xs text-[#77756F]">
                                Registered with the firm
                            </p>
                        </div>

                        <div class="flex h-10 w-10 items-center justify-center rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] text-[#B89452]">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M12 14l9-5-9-5-9 5 9 5z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M5 12v4c0 1.5 3.13 3 7 3s7-1.5 7-3v-4"
                                />
                            </svg>

                        </div>

                    </div>

                </div>


                {{-- Active --}}
                <div class="rounded-xl border border-[#E5E2DB] bg-white p-5">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#9B9992]">
                                Active Lawyers
                            </p>

                            <p class="mt-2 text-2xl font-semibold text-[#27633D]">
                                {{ $lawyers->where('is_active', true)->count() }}
                            </p>

                            <p class="mt-1 text-xs text-[#77756F]">
                                Currently active
                            </p>
                        </div>

                        <div class="flex h-10 w-10 items-center justify-center rounded-lg border border-[#B9D9C3] bg-[#EFF8F2] text-[#3D8B5A]">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                        </div>

                    </div>

                </div>


                {{-- Specializations --}}
                <div class="rounded-xl border border-[#E5E2DB] bg-white p-5">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#9B9992]">
                                Specializations
                            </p>

                            <p class="mt-2 text-2xl font-semibold text-[#0B0B0A]">
                                {{ $lawyers->pluck('specialization')->filter()->unique()->count() }}
                            </p>

                            <p class="mt-1 text-xs text-[#77756F]">
                                Practice areas
                            </p>
                        </div>

                        <div class="flex h-10 w-10 items-center justify-center rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] text-[#B89452]">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M9 12h6M9 16h6M7 3h7l5 5v13H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                                />
                            </svg>

                        </div>

                    </div>

                </div>


                {{-- New This Month --}}
                <div class="rounded-xl border border-[#E5E2DB] bg-white p-5">

                    <div class="flex items-start justify-between">

                        <div>
                            <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#9B9992]">
                                New This Month
                            </p>

                            <p class="mt-2 text-2xl font-semibold text-[#0B0B0A]">
                                {{ $lawyers->filter(fn ($lawyer) => $lawyer->created_at?->isCurrentMonth())->count() }}
                            </p>

                            <p class="mt-1 text-xs text-[#77756F]">
                                Recently registered
                            </p>
                        </div>

                        <div class="flex h-10 w-10 items-center justify-center rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] text-[#B89452]">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M12 4v16M4 12h16"
                                />
                            </svg>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Search / Filters --}}
            <div class="mb-6 rounded-xl border border-[#E5E2DB] bg-white p-4">

                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                    {{-- Search --}}
                    <div class="relative w-full lg:max-w-md">

                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">

                            <svg
                                class="h-5 w-5 text-[#9B9992]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="m21 21-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"
                                />
                            </svg>

                        </div>

                        <input
                            x-model="search"
                            type="text"
                            placeholder="Search lawyers..."
                            class="h-11 w-full rounded-lg border border-[#D4D1CA] bg-white py-2.5 pl-10 pr-4 text-sm text-[#41403C] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/15"
                        >

                    </div>


                    {{-- Filters --}}
                    <div class="flex flex-wrap gap-2">

                        <button
                            @click="status = 'all'"
                            :class="status === 'all'
                                ? 'border-[#C9A96E] bg-[#11110F] text-white'
                                : 'border-[#E5E2DB] bg-white text-[#77756F] hover:border-[#C9A96E] hover:text-[#B89452]'"
                            class="rounded-lg border px-4 py-2 text-sm font-medium transition"
                        >
                            All
                        </button>

                        <button
                            @click="status = 'active'"
                            :class="status === 'active'
                                ? 'border-[#C9A96E] bg-[#11110F] text-white'
                                : 'border-[#E5E2DB] bg-white text-[#77756F] hover:border-[#C9A96E] hover:text-[#B89452]'"
                            class="rounded-lg border px-4 py-2 text-sm font-medium transition"
                        >
                            Active
                        </button>

                        <button
                            @click="status = 'inactive'"
                            :class="status === 'inactive'
                                ? 'border-[#C9A96E] bg-[#11110F] text-white'
                                : 'border-[#E5E2DB] bg-white text-[#77756F] hover:border-[#C9A96E] hover:text-[#B89452]'"
                            class="rounded-lg border px-4 py-2 text-sm font-medium transition"
                        >
                            Inactive
                        </button>

                    </div>

                </div>

            </div>


            {{-- Lawyers Table --}}
            <div class="overflow-hidden rounded-xl border border-[#E5E2DB] bg-white">

                {{-- Desktop --}}
                <div class="hidden overflow-x-auto md:block">

                    <table class="min-w-full">

                        <thead class="border-b border-[#E5E2DB] bg-[#F7F4ED]">

                            <tr>

                                <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                    Lawyer
                                </th>

                                <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                    Specialization
                                </th>

                                <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                    Experience
                                </th>

                                <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                    Cases
                                </th>

                                <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-right text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-[#E5E2DB]">

                            @forelse ($lawyers as $lawyer)

                                @php
                                    $isActive = $lawyer->is_active ?? true;

                                    $searchText = strtolower(
                                        ($lawyer->name ?? '') . ' ' .
                                        ($lawyer->email ?? '') . ' ' .
                                        ($lawyer->specialization ?? '') . ' ' .
                                        ($lawyer->license_number ?? '')
                                    );
                                @endphp

                                <tr
                                    x-show="matches($el)"
                                    data-search="{{ $searchText }}"
                                    data-status="{{ $isActive ? 'active' : 'inactive' }}"
                                    class="transition hover:bg-[#FAF9F6]"
                                >

                                    {{-- Lawyer --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        <div class="flex items-center gap-3">

                                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg border border-[#D8BE8A] bg-[#11110F] font-serif text-sm font-semibold text-[#D8BE8A]">
                                                {{ strtoupper(substr($lawyer->name ?? 'L', 0, 1)) }}
                                            </div>

                                            <div class="min-w-0">

                                                <p class="truncate text-sm font-semibold text-[#0B0B0A]">
                                                    {{ $lawyer->name }}
                                                </p>

                                                <p class="mt-1 max-w-[220px] truncate text-xs text-[#9B9992]">
                                                    {{ $lawyer->email }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Specialization --}}
                                    <td class="px-6 py-4">

                                        <span class="inline-flex max-w-[180px] items-center rounded-md border border-[#E5E2DB] bg-[#F7F4ED] px-2.5 py-1 text-xs font-medium text-[#41403C]">
                                            {{ $lawyer->specialization ?? 'General Practice' }}
                                        </span>

                                    </td>


                                    {{-- Experience --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        <div class="flex items-center gap-2">

                                            <svg
                                                class="h-4 w-4 text-[#B89452]"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.7"
                                                    d="M20 7h-3V5a2 2 0 00-2-2H9a2 2 0 00-2 2v2H4a1 1 0 00-1 1v10a2 2 0 002 2h14a2 2 0 002-2V8a1 1 0 00-1-1z"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-width="1.7"
                                                    d="M9 7V5h6v2"
                                                />

                                            </svg>

                                            <span class="text-sm text-[#41403C]">
                                                {{ $lawyer->experience_years ?? 0 }} years
                                            </span>

                                        </div>

                                    </td>


                                    {{-- Cases --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        <div class="inline-flex items-center gap-1.5">

                                            <svg
                                                class="h-4 w-4 text-[#C9A96E]"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.7"
                                                    d="M9 12h6m-6 4h4m-2-13H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V8l-5-5z"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.7"
                                                    d="M14 3v5h5"
                                                />

                                            </svg>

                                            <span class="min-w-[28px] rounded-md border border-[#D4D1CA] bg-[#F7F4ED] px-2 py-1 text-center text-xs font-semibold text-[#41403C]">
                                                {{ $lawyer->cases_as_lawyer_count ?? 0 }}
                                            </span>

                                        </div>

                                    </td>


                                    {{-- Status --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        @if ($isActive)

                                            <span class="inline-flex items-center gap-1.5 rounded-md border border-[#B9D9C3] bg-[#EFF8F2] px-2.5 py-1 text-xs font-semibold text-[#27633D]">

                                                <span class="h-1.5 w-1.5 rounded-full bg-[#3D8B5A]"></span>

                                                Active

                                            </span>

                                        @else

                                            <span class="inline-flex items-center gap-1.5 rounded-md border border-[#D4D1CA] bg-[#F7F4ED] px-2.5 py-1 text-xs font-semibold text-[#77756F]">

                                                <span class="h-1.5 w-1.5 rounded-full bg-[#9B9992]"></span>

                                                Inactive

                                            </span>

                                        @endif

                                    </td>


                                    {{-- Actions --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        <div class="flex justify-end gap-2">

                                            <a
                                                href="{{ route('admin.lawyers.show', $lawyer) }}"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-[#D4D1CA] bg-white px-3 py-2 text-sm font-semibold text-[#41403C] transition hover:border-[#C9A96E] hover:text-[#B89452]"
                                            >

                                                <svg
                                                    class="h-4 w-4"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.7"
                                                        d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6z"
                                                    />

                                                    <circle
                                                        cx="12"
                                                        cy="12"
                                                        r="2.5"
                                                        stroke-width="1.7"
                                                    />

                                                </svg>

                                                View

                                            </a>


                                            <a
                                                href="{{ route('admin.lawyers.edit', $lawyer) }}"
                                                class="inline-flex items-center gap-1.5 rounded-lg bg-[#C9A96E] px-3 py-2 text-sm font-semibold text-[#11110F] transition hover:bg-[#B89452]"
                                            >

                                                <svg
                                                    class="h-4 w-4"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.7"
                                                        d="M12 20h9"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.7"
                                                        d="M16.5 3.5a2.1 2.1 0 013 3L8 18l-4 1 1-4L16.5 3.5z"
                                                    />

                                                </svg>

                                                Edit

                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6" class="px-6 py-16 text-center">

                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] text-[#9B9992]">

                                            <svg
                                                class="h-7 w-7"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.7"
                                                    d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                                                />

                                                <circle
                                                    cx="9"
                                                    cy="7"
                                                    r="4"
                                                    stroke-width="1.7"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.7"
                                                    d="M19 8v6M22 11h-6"
                                                />

                                            </svg>

                                        </div>

                                        <h3 class="mt-4 text-base font-semibold text-[#41403C]">
                                            No lawyers found
                                        </h3>

                                        <p class="mt-1 text-sm text-[#9B9992]">
                                            Add your first lawyer to the firm.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- Mobile --}}
                <div class="divide-y divide-[#E5E2DB] md:hidden">

                    @forelse ($lawyers as $lawyer)

                        @php
                            $isActive = $lawyer->is_active ?? true;
                        @endphp

                        <div class="p-5">

                            <div class="flex items-start justify-between gap-4">

                                <div class="flex min-w-0 items-center gap-3">

                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg border border-[#D8BE8A] bg-[#11110F] font-serif text-sm font-semibold text-[#D8BE8A]">
                                        {{ strtoupper(substr($lawyer->name ?? 'L', 0, 1)) }}
                                    </div>

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-semibold text-[#0B0B0A]">
                                            {{ $lawyer->name }}
                                        </p>

                                        <p class="truncate text-xs text-[#9B9992]">
                                            {{ $lawyer->email }}
                                        </p>

                                    </div>

                                </div>


                                @if ($isActive)

                                    <span class="inline-flex shrink-0 items-center gap-1.5 rounded-md border border-[#B9D9C3] bg-[#EFF8F2] px-2 py-1 text-[11px] font-semibold text-[#27633D]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#3D8B5A]"></span>
                                        Active
                                    </span>

                                @else

                                    <span class="inline-flex shrink-0 items-center gap-1.5 rounded-md border border-[#D4D1CA] bg-[#F7F4ED] px-2 py-1 text-[11px] font-semibold text-[#77756F]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#9B9992]"></span>
                                        Inactive
                                    </span>

                                @endif

                            </div>


                            <div class="mt-5 grid grid-cols-2 gap-3">

                                <div class="rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] p-3">

                                    <p class="text-[11px] font-medium uppercase tracking-[0.06em] text-[#9B9992]">
                                        Specialization
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-[#41403C]">
                                        {{ $lawyer->specialization ?? 'General Practice' }}
                                    </p>

                                </div>


                                <div class="rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] p-3">

                                    <p class="text-[11px] font-medium uppercase tracking-[0.06em] text-[#9B9992]">
                                        Experience
                                    </p>

                                    <p class="mt-1 text-sm font-semibold text-[#41403C]">
                                        {{ $lawyer->experience_years ?? 0 }} years
                                    </p>

                                </div>


                                <div class="rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] p-3">

                                    <p class="text-[11px] font-medium uppercase tracking-[0.06em] text-[#9B9992]">
                                        Cases
                                    </p>

                                    <div class="mt-1 inline-flex items-center gap-1.5">

                                        <svg
                                            class="h-4 w-4 text-[#C9A96E]"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.7"
                                                d="M9 12h6m-6 4h4m-2-13H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V8l-5-5z"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.7"
                                                d="M14 3v5h5"
                                            />

                                        </svg>

                                        <span class="text-sm font-semibold text-[#41403C]">
                                            {{ $lawyer->cases_as_lawyer_count ?? 0 }}
                                        </span>

                                    </div>

                                </div>


                                <div class="rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] p-3">

                                    <p class="text-[11px] font-medium uppercase tracking-[0.06em] text-[#9B9992]">
                                        License
                                    </p>

                                    <p class="mt-1 truncate text-sm font-semibold text-[#41403C]">
                                        {{ $lawyer->license_number ?? '—' }}
                                    </p>

                                </div>

                            </div>


                            <div class="mt-5 flex gap-2">

                                <a
                                    href="{{ route('admin.lawyers.show', $lawyer) }}"
                                    class="flex-1 rounded-lg border border-[#D4D1CA] bg-white px-4 py-2.5 text-center text-sm font-semibold text-[#41403C] transition hover:border-[#C9A96E] hover:text-[#B89452]"
                                >
                                    View
                                </a>

                                <a
                                    href="{{ route('admin.lawyers.edit', $lawyer) }}"
                                    class="flex-1 rounded-lg bg-[#C9A96E] px-4 py-2.5 text-center text-sm font-semibold text-[#11110F] transition hover:bg-[#B89452]"
                                >
                                    Edit
                                </a>

                            </div>

                        </div>

                    @empty

                        <div class="px-6 py-16 text-center">

                            <p class="text-sm text-[#77756F]">
                                No lawyers found.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>


            {{-- Pagination --}}
            @if (method_exists($lawyers, 'links'))

                <div class="mt-6">
                    {{ $lawyers->links() }}
                </div>

            @endif

        </div>

    </div>
@endsection