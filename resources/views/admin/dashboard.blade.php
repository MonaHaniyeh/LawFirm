@extends('layouts.app') @section('title', 'Admin Dashboard') @section('content') <div x-data="{ showAllActivity: false, showAllAppointments: false }" class="space-y-8">
    {{-- ========================================================= HEADER ========================================================== --}} <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.12em] text-gray-500"> Administration </p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-gray-900"> Admin Dashboard </h1>
            <p class="mt-2 text-sm leading-6 text-gray-500"> Monitor and manage everything happening across the law firm.
            </p>
        </div>
        <div
            class="hidden items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm text-gray-600 shadow-sm sm:flex">
            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg> {{ now()->format('M d, Y') }} </div>
    </div> {{-- ========================================================= WELCOME CARD ========================================================== --}} <div class="overflow-hidden rounded-2xl border border-white/10 bg-[#11110F] shadow-sm">
        <div class="relative px-6 py-8 sm:px-8 lg:px-10">
            <div class="relative z-10 max-w-3xl">
                <div class="flex items-center gap-3">
                    <div class="h-px w-8 bg-[#C9A96E]"></div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#C9A96E]"> Law Firm Administration
                    </p>
                </div>
                <h2 class="mt-4 text-3xl font-semibold tracking-tight text-white"> Welcome back,
                    {{ Auth::user()->name }} </h2>
                <p class="mt-3 max-w-2xl text-sm leading-7 text-gray-400"> Here's an overview of your law firm. Review
                    cases, appointments, users, documents, billing and recent activity from one central dashboard. </p>
            </div>
            <div
                class="pointer-events-none absolute -right-16 -top-20 h-64 w-64 rounded-full border border-[#C9A96E]/10">
            </div>
            <div class="pointer-events-none absolute -right-5 -top-8 h-40 w-40 rounded-full border border-[#C9A96E]/10">
            </div>
            <div class="pointer-events-none absolute bottom-0 right-32 h-px w-32 bg-[#C9A96E]/30"></div>
        </div>
    </div> {{-- ========================================================= STATISTICS ========================================================== --}} <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        {{-- Active Cases --}} <a href="{{ Route::has('admin.cases.index') ? route('admin.cases.index') : '#' }}"
            class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[#C9A96E]/50 hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-gray-500"> Active Cases </p>
                    <p class="mt-3 text-3xl font-semibold text-gray-900"> {{ $activeCases ?? 0 }} </p>
                    <p class="mt-2 text-xs font-medium text-[#3D8B5A]"> Currently active </p>
                </div>
                <div
                    class="flex h-11 w-11 items-center justify-center rounded-lg bg-[#11110F] transition duration-200 group-hover:bg-[#C9A96E]">
                    <svg class="h-5 w-5 text-[#C9A96E] transition group-hover:text-[#0B0B0A]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 3v5h5" />
                    </svg> </div>
            </div>
        </a> {{-- Clients --}} <a
            href="{{ Route::has('admin.clients.index') ? route('admin.clients.index') : '#' }}"
            class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[#C9A96E]/50 hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-gray-500"> Registered Clients </p>
                    <p class="mt-3 text-3xl font-semibold text-gray-900"> {{ $clientsCount ?? 0 }} </p>
                    <p class="mt-2 text-xs font-medium text-gray-500"> Total clients </p>
                </div>
                <div
                    class="flex h-11 w-11 items-center justify-center rounded-lg bg-[#11110F] transition duration-200 group-hover:bg-[#C9A96E]">
                    <svg class="h-5 w-5 text-[#C9A96E] transition group-hover:text-[#0B0B0A]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2" />
                        <circle cx="9" cy="7" r="4" stroke-width="1.8" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                    </svg> </div>
            </div>
        </a> {{-- Lawyers --}} <a
            href="{{ Route::has('admin.lawyers.index') ? route('admin.lawyers.index') : '#' }}"
            class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[#C9A96E]/50 hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-gray-500"> Lawyers </p>
                    <p class="mt-3 text-3xl font-semibold text-gray-900"> {{ $lawyersCount ?? 0 }} </p>
                    <p class="mt-2 text-xs font-medium text-gray-500"> Registered lawyers </p>
                </div>
                <div
                    class="flex h-11 w-11 items-center justify-center rounded-lg bg-[#11110F] transition duration-200 group-hover:bg-[#C9A96E]">
                    <svg class="h-5 w-5 text-[#C9A96E] transition group-hover:text-[#0B0B0A]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M5 12v5c3 2 6 3 7 3s4-1 7-3v-5" />
                    </svg> </div>
            </div>
        </a> {{-- Pending Appointments --}} <a
            href="{{ Route::has('admin.appointments.index') ? route('admin.appointments.index') : '#' }}"
            class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[#C9A96E]/50 hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-gray-500"> Pending Appointments
                    </p>
                    <p class="mt-3 text-3xl font-semibold text-gray-900"> {{ $pendingAppointments ?? 0 }} </p>
                    <p class="mt-2 text-xs font-medium text-[#B98525]"> Need attention </p>
                </div>
                <div
                    class="flex h-11 w-11 items-center justify-center rounded-lg bg-[#11110F] transition duration-200 group-hover:bg-[#C9A96E]">
                    <svg class="h-5 w-5 text-[#C9A96E] transition group-hover:text-[#0B0B0A]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg> </div>
            </div>
        </a> </div> {{-- ========================================================= QUICK ACTIONS ========================================================== --}} <div>
        <div class="mb-4">
            <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#B89452]"> Administration </p>
            <h2 class="mt-1 text-xl font-semibold text-gray-900"> Quick Actions </h2>
            <p class="mt-1 text-sm text-gray-500"> Quickly access the most common administrative tasks. </p>
        </div>
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6"> {{-- Users --}} <a
                href="{{ route('admin.users.index') }}"
                class="group rounded-xl border border-[#24231F] bg-[#11110F] p-4 text-center transition duration-200 hover:-translate-y-0.5 hover:border-[#C9A96E] hover:bg-[#181815]">
                <div
                    class="mx-auto flex h-11 w-11 items-center justify-center rounded-lg border border-white/10 bg-[#181815] group-hover:border-[#C9A96E]/40 group-hover:bg-[#C9A96E]">
                    <svg class="h-5 w-5 text-[#C9A96E] group-hover:text-[#0B0B0A]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1M12 12a4 4 0 100-8 4 4 0 000 8z" />
                    </svg> </div>
                <p class="mt-3 text-xs font-semibold text-gray-200 group-hover:text-white"> Users </p>
            </a> {{-- Lawyers --}} <a href="{{ route('admin.lawyers.index') }}"
                class="group rounded-xl border border-[#24231F] bg-[#11110F] p-4 text-center transition duration-200 hover:-translate-y-0.5 hover:border-[#C9A96E] hover:bg-[#181815]">
                <div
                    class="mx-auto flex h-11 w-11 items-center justify-center rounded-lg border border-white/10 bg-[#181815] group-hover:border-[#C9A96E]/40 group-hover:bg-[#C9A96E]">
                    <svg class="h-5 w-5 text-[#C9A96E] group-hover:text-[#0B0B0A]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M5 12v5c3 2 6 3 7 3s4-1 7-3v-5" />
                    </svg> </div>
                <p class="mt-3 text-xs font-semibold text-gray-200 group-hover:text-white"> Lawyers </p>
            </a> {{-- Cases --}} <a href="{{ route('admin.cases.index') }}"
                class="group rounded-xl border border-[#24231F] bg-[#11110F] p-4 text-center transition duration-200 hover:-translate-y-0.5 hover:border-[#C9A96E] hover:bg-[#181815]">
                <div
                    class="mx-auto flex h-11 w-11 items-center justify-center rounded-lg border border-white/10 bg-[#181815] group-hover:border-[#C9A96E]/40 group-hover:bg-[#C9A96E]">
                    <svg class="h-5 w-5 text-[#C9A96E] group-hover:text-[#0B0B0A]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z" />
                    </svg> </div>
                <p class="mt-3 text-xs font-semibold text-gray-200 group-hover:text-white"> Cases </p>
            </a> {{-- Appointments --}} <a href="{{ route('admin.appointments.index') }}"
                class="group rounded-xl border border-[#24231F] bg-[#11110F] p-4 text-center transition duration-200 hover:-translate-y-0.5 hover:border-[#C9A96E] hover:bg-[#181815]">
                <div
                    class="mx-auto flex h-11 w-11 items-center justify-center rounded-lg border border-white/10 bg-[#181815] group-hover:border-[#C9A96E]/40 group-hover:bg-[#C9A96E]">
                    <svg class="h-5 w-5 text-[#C9A96E] group-hover:text-[#0B0B0A]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg> </div>
                <p class="mt-3 text-xs font-semibold text-gray-200 group-hover:text-white"> Appointments </p>
            </a> {{-- Billing --}} <a href="{{ route('admin.billing.index') }}"
                class="group rounded-xl border border-[#24231F] bg-[#11110F] p-4 text-center transition duration-200 hover:-translate-y-0.5 hover:border-[#C9A96E] hover:bg-[#181815]">
                <div
                    class="mx-auto flex h-11 w-11 items-center justify-center rounded-lg border border-white/10 bg-[#181815] group-hover:border-[#C9A96E]/40 group-hover:bg-[#C9A96E]">
                    <svg class="h-5 w-5 text-[#C9A96E] group-hover:text-[#0B0B0A]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 8c-3 0-5 1-5 3s2 3 5 3 5 1 5 3-2 3-5 3m0-15v15" />
                    </svg> </div>
                <p class="mt-3 text-xs font-semibold text-gray-200 group-hover:text-white"> Billing </p>
            </a> {{-- Messages --}} <a href="{{ route('admin.communication.index') }}"
                class="group rounded-xl border border-[#24231F] bg-[#11110F] p-4 text-center transition duration-200 hover:-translate-y-0.5 hover:border-[#C9A96E] hover:bg-[#181815]">
                <div
                    class="mx-auto flex h-11 w-11 items-center justify-center rounded-lg border border-white/10 bg-[#181815] group-hover:border-[#C9A96E]/40 group-hover:bg-[#C9A96E]">
                    <svg class="h-5 w-5 text-[#C9A96E] group-hover:text-[#0B0B0A]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10h8M8 14h5" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M21 12a8 8 0 01-8 8H5l-2 2v-5a8 8 0 1118-5z" />
                    </svg> </div>
                <p class="mt-3 text-xs font-semibold text-gray-200 group-hover:text-white"> Messages </p>
            </a> </div>
    </div> {{-- ========================================================= RECENT ACTIVITY + SYSTEM OVERVIEW ========================================================== --}} <div class="grid grid-cols-1 gap-6 xl:grid-cols-3"> {{-- ===================================================== RECENT ACTIVITY ====================================================== --}} <div
            class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm xl:col-span-2">
            <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5">
                <div>
                    <h2 class="font-semibold text-gray-900"> Recent Activity </h2>
                    <p class="mt-1 text-sm text-gray-500"> Latest actions across the system. </p>
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($activities as $activity)
                    @php
                        $activityType = strtolower($activity['type'] ?? 'system');
                        $activityIcon = match ($activityType) {
                            'user' => 'user',
                            'case' => 'case',
                            'appointment' => 'calendar',
                            'document' => 'document',
                            'message' => 'message',
                            'billing' => 'billing',
                            default => 'activity',
                        };
                    @endphp <div class="flex items-start gap-4 px-6 py-5 transition hover:bg-[#FAF9F6]">
                        {{-- Icon --}} <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#11110F]">
                            @if ($activityIcon === 'user')
                                <svg class="h-5 w-5 text-[#C9A96E]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1M12 12a4 4 0 100-8 4 4 0 000 8z" />
                                </svg>
                            @elseif ($activityIcon === 'case')
                                <svg class="h-5 w-5 text-[#C9A96E]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z" />
                                </svg>
                            @elseif ($activityIcon === 'calendar')
                                <svg class="h-5 w-5 text-[#C9A96E]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z" />
                                </svg>
                            @elseif ($activityIcon === 'document')
                                <svg class="h-5 w-5 text-[#C9A96E]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z" />
                                </svg>
                            @elseif ($activityIcon === 'message')
                                <svg class="h-5 w-5 text-[#C9A96E]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M8 10h8M8 14h5" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M21 12a8 8 0 01-8 8H5l-2 2v-5a8 8 0 1118-5z" />
                                </svg>
                            @else
                                <svg class="h-5 w-5 text-[#C9A96E]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M12 8v4l3 2" />
                                    <circle cx="12" cy="12" r="9" stroke-width="1.8" />
                                </svg>
                                @endif
                        </div> {{-- Activity Content --}} <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $activity['title'] ?? 'System activity' }} </p>
                            <p class="mt-1 text-sm text-gray-500"> {{ $activity['description'] ?? '' }} </p>
                            @if (!empty($activity['details']))
                                <p class="mt-1 text-xs text-gray-400"> {{ $activity['details'] }} </p>
                                @endif <div class="mt-2 text-xs text-gray-400">
                                    {{ $activity['created_at']?->diffForHumans() ?? 'Recently' }} </div>
                        </div>
                </div> @empty <div class="px-6 py-14 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#11110F]"> <svg
                                class="h-6 w-6 text-[#C9A96E]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M12 8v4l3 2" />
                                <circle cx="12" cy="12" r="9" stroke-width="1.8" />
                            </svg> </div>
                        <p class="mt-4 text-sm font-semibold text-gray-900"> No recent activity </p>
                        <p class="mt-1 text-sm text-gray-500"> System activity will appear here. </p>
                    </div>
                    @endforelse
            </div>
        </div> {{-- ===================================================== SYSTEM OVERVIEW ====================================================== --}} <div
            class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 px-6 py-5">
                <h2 class="font-semibold text-gray-900"> System Overview </h2>
                <p class="mt-1 text-sm text-gray-500"> Current system statistics. </p>
            </div>
            <div class="divide-y divide-gray-100"> {{-- Total Users --}} <div
                    class="flex items-center justify-between px-6 py-5"> <span
                        class="text-sm font-medium text-gray-600"> Total Users </span> <span
                        class="text-sm font-semibold text-gray-900"> {{ $totalUsers ?? 0 }} </span> </div>
                {{-- Total Cases --}} <div class="flex items-center justify-between px-6 py-5"> <span
                        class="text-sm font-medium text-gray-600"> Total Cases </span> <span
                        class="text-sm font-semibold text-gray-900"> {{ $totalCases ?? 0 }} </span> </div>
                {{-- Documents --}} <div class="flex items-center justify-between px-6 py-5"> <span
                        class="text-sm font-medium text-gray-600"> Documents </span> <span
                        class="text-sm font-semibold text-gray-900"> {{ $totalDocuments ?? 0 }} </span> </div>
                {{-- Messages --}} <div class="flex items-center justify-between px-6 py-5"> <span
                        class="text-sm font-medium text-gray-600"> Messages </span> <span
                        class="text-sm font-semibold text-gray-900"> {{ $totalMessages ?? 0 }} </span> </div>
                {{-- Appointments --}} <div class="flex items-center justify-between px-6 py-5"> <span
                        class="text-sm font-medium text-gray-600"> Appointments </span> <span
                        class="text-sm font-semibold text-gray-900"> {{ $totalAppointments ?? 0 }} </span> </div>
            </div>
        </div>
    </div> {{-- ========================================================= BOTTOM INFORMATION ========================================================== --}} <div class="grid grid-cols-1 gap-6 lg:grid-cols-2"> {{-- ===================================================== PENDING APPOINTMENTS ====================================================== --}} <div
            class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-200 px-6 py-5">
                <div>
                    <h2 class="font-semibold text-gray-900"> Pending Appointments </h2>
                    <p class="mt-1 text-sm text-gray-500"> Appointments waiting for review. </p>
                </div>
                @if (Route::has('admin.appointments.index'))
                    <a href="{{ route('admin.appointments.index') }}"
                        class="text-sm font-semibold text-[#B89452] transition hover:text-[#8F713C]"> View all </a>
                    @endif
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($appointments as $appointment)
                    <div class="flex items-center justify-between gap-4 px-6 py-5 transition hover:bg-[#FAF9F6]">
                        {{-- Appointment information --}} <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#11110F]">
                                    <svg class="h-4 w-4 text-[#C9A96E]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2v12a2 2 0 002 2z" />
                                    </svg> </div>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-gray-900">
                                        {{ $appointment->client?->name ?? 'Client' }} </p>
                                    <p class="mt-1 truncate text-xs text-gray-500"> With
                                        {{ $appointment->lawyer?->name ?? 'Lawyer' }} </p>
                                </div>
                            </div> {{-- Case --}} @if ($appointment->case)
                                <p class="mt-3 text-xs text-gray-400"> Case: <span class="font-medium text-gray-600">
                                        {{ $appointment->case->case_number ?? 'Case #' . $appointment->case->id }}
                                    </span> </p>
                                @endif
                        </div> {{-- Date / Status --}} <div class="shrink-0 text-right">
                            <p class="text-xs font-semibold text-gray-700">
                                @if ($appointment->appointment_date)
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                @else
                                    Date pending
                                    @endif
                            </p> {{-- Time --}} @if (!empty($appointment->appointment_time))
                                <p class="mt-1 text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }} </p>
                                @endif <span
                                    class="mt-2 inline-flex rounded-full border border-[#B89452]/30 bg-[#B89452]/10 px-2.5 py-1 text-[10px] font-semibold text-[#8F713C]">
                                    Pending </span>
                        </div>
                </div> @empty <div class="px-6 py-12 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#11110F]"> <svg
                                class="h-6 w-6 text-[#C9A96E]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg> </div>
                        <p class="mt-4 text-sm font-semibold text-gray-900"> No pending appointments </p>
                        <p class="mt-1 text-sm text-gray-500"> Everything is up to date. </p>
                    </div>
                    @endforelse
            </div>
        </div> {{-- ===================================================== ADMINISTRATOR ACCOUNT ====================================================== --}} <div
            class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 px-6 py-5">
                <h2 class="font-semibold text-gray-900"> Administrator Account </h2>
                <p class="mt-1 text-sm text-gray-500"> Your current account information. </p>
            </div>
            <div class="p-6"> @php
                $adminName = Auth::user()->name ?? 'Admin';
                $initials = collect(explode(' ', trim($adminName)))
                    ->filter()
                    ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                    ->take(2)
                    ->implode('');
            @endphp <div class="flex items-center gap-4">
                    <div
                        class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-[#11110F] text-lg font-semibold text-[#C9A96E]">
                        {{ $initials ?: 'AD' }} </div>
                    <div class="min-w-0">
                        <h3 class="truncate font-semibold text-gray-900"> {{ Auth::user()->name }} </h3>
                        <p class="truncate text-sm text-gray-500"> {{ Auth::user()->email }} </p> <span
                            class="mt-2 inline-flex rounded-full border border-[#C9A96E]/30 bg-[#C9A96E]/10 px-2.5 py-1 text-xs font-semibold capitalize text-[#8F713C]">
                            {{ Auth::user()->role ?? 'Administrator' }} </span>
                    </div>
                </div>
                <div class="mt-6 grid grid-cols-2 gap-3">
                    @if (Route::has('admin.settings.edit'))
                        <a href="{{ route('admin.settings.edit') }}"
                            class="inline-flex h-11 items-center justify-center gap-2 rounded-lg border border-gray-300 px-4 text-sm font-semibold text-gray-700 transition hover:border-[#C9A96E] hover:bg-[#FAF9F6] hover:text-[#8F713C]">
                            Settings </a>
                        @endif @if (Route::has('admin.password.edit'))
                            <a href="{{ route('admin.password.edit') }}"
                                class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-[#11110F] px-4 text-sm font-semibold text-[#C9A96E] transition hover:bg-[#181815] hover:text-[#D8BE8A]">
                                Password </a>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div> @endsection
