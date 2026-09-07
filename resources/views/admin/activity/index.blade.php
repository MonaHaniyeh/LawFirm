@extends('layouts.app')

@section('title', 'Activity Log')

@section('content')

    <div x-data="{
        search: '',
        filter: 'all',
        showDetails: false,
        selectedActivity: null,
    
        matches(activity) {
            const text = activity.textContent.toLowerCase();
    
            const matchesSearch =
                this.search === '' ||
                text.includes(this.search.toLowerCase());
    
            const matchesFilter =
                this.filter === 'all' ||
                activity.dataset.type === this.filter;
    
            return matchesSearch && matchesFilter;
        },
    
        openDetails(activity) {
            this.selectedActivity = activity;
            this.showDetails = true;
        }
    }" class="min-h-screen bg-[#f8f8f6] p-4 sm:p-6 lg:p-8">

        {{-- Page Header --}}
        <div class="mx-auto max-w-7xl">

            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <div class="mb-2 flex items-center gap-2 text-sm text-gray-500">
                        <a href="{{ route('admin.dashboard') }}" class="transition hover:text-gray-900">
                            Dashboard
                        </a>

                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M7.21 14.77a.75.75 0 010-1.06L10.94 10 7.21 6.29a.75.75 0 111.06-1.06l4.24 4.24a.75.75 0 010 1.06l-4.24 4.24a.75.75 0 01-1.06 0z"
                                clip-rule="evenodd" />
                        </svg>

                        <span>Activity Log</span>
                    </div>

                    <h1 class="text-2xl font-semibold tracking-tight text-[#172033] sm:text-3xl">
                        Activity Log
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Monitor activity across the entire law firm system.
                    </p>
                </div>

                {{-- Total Activities --}}
                <div class="flex items-center gap-3 rounded-2xl border border-gray-200 bg-white px-5 py-3 shadow-sm">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#f5f1e8] text-[#172033]">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 2" />
                            <circle cx="12" cy="12" r="9" />
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                            Total Activities
                        </p>

                        <p class="text-lg font-semibold text-[#172033]">
                            {{ $activities->total() ?? ($activities->count() ?? 0) }}
                        </p>
                    </div>
                </div>

            </div>


            {{-- Filters --}}
            <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">

                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                    {{-- Search --}}
                    <div class="relative w-full lg:max-w-md">

                        <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="11" cy="11" r="7" />
                            <path stroke-linecap="round" d="m20 20-4-4" />
                        </svg>

                        <input type="text" x-model="search" placeholder="Search activity..."
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-11 pr-4 text-sm text-gray-700 outline-none transition focus:border-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-100">

                    </div>


                    {{-- Activity Type --}}
                    <div class="flex flex-wrap gap-2">

                        <button type="button" @click="filter = 'all'"
                            :class="filter === 'all'
                                ?
                                'bg-[#172033] text-white shadow-sm' :
                                'bg-gray-50 text-gray-600 hover:bg-gray-100'"
                            class="rounded-xl px-4 py-2.5 text-sm font-medium transition">
                            All
                        </button>

                        <button type="button" @click="filter = 'user'"
                            :class="filter === 'user'
                                ?
                                'bg-[#172033] text-white shadow-sm' :
                                'bg-gray-50 text-gray-600 hover:bg-gray-100'"
                            class="rounded-xl px-4 py-2.5 text-sm font-medium transition">
                            Users
                        </button>

                        <button type="button" @click="filter = 'case'"
                            :class="filter === 'case'
                                ?
                                'bg-[#172033] text-white shadow-sm' :
                                'bg-gray-50 text-gray-600 hover:bg-gray-100'"
                            class="rounded-xl px-4 py-2.5 text-sm font-medium transition">
                            Cases
                        </button>

                        <button type="button" @click="filter = 'appointment'"
                            :class="filter === 'appointment'
                                ?
                                'bg-[#172033] text-white shadow-sm' :
                                'bg-gray-50 text-gray-600 hover:bg-gray-100'"
                            class="rounded-xl px-4 py-2.5 text-sm font-medium transition">
                            Appointments
                        </button>

                        <button type="button" @click="filter = 'document'"
                            :class="filter === 'document'
                                ?
                                'bg-[#172033] text-white shadow-sm' :
                                'bg-gray-50 text-gray-600 hover:bg-gray-100'"
                            class="rounded-xl px-4 py-2.5 text-sm font-medium transition">
                            Documents
                        </button>

                    </div>

                </div>

            </div>


            {{-- Activity List --}}
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                {{-- Table Header --}}
                <div class="hidden border-b border-gray-100 bg-gray-50 px-6 py-4 md:grid md:grid-cols-12 md:gap-4">

                    <div class="col-span-4 text-xs font-semibold uppercase tracking-wider text-gray-400">
                        Activity
                    </div>

                    <div class="col-span-2 text-xs font-semibold uppercase tracking-wider text-gray-400">
                        User
                    </div>

                    <div class="col-span-2 text-xs font-semibold uppercase tracking-wider text-gray-400">
                        Type
                    </div>

                    <div class="col-span-2 text-xs font-semibold uppercase tracking-wider text-gray-400">
                        Date
                    </div>

                    <div class="col-span-2 text-right text-xs font-semibold uppercase tracking-wider text-gray-400">
                        Action
                    </div>

                </div>


                {{-- Activities --}}
                @forelse($activities as $activity)
                    @php
                        $type = strtolower($activity->type ?? ($activity->action_type ?? 'user'));

                        $typeClass = match ($type) {
                            'case' => 'bg-blue-50 text-blue-700',
                            'appointment' => 'bg-purple-50 text-purple-700',
                            'document' => 'bg-amber-50 text-amber-700',
                            'billing', 'payment' => 'bg-green-50 text-green-700',
                            'message', 'communication' => 'bg-indigo-50 text-indigo-700',
                            default => 'bg-gray-100 text-gray-700',
                        };

                        $iconType = match ($type) {
                            'case' => 'case',
                            'appointment' => 'appointment',
                            'document' => 'document',
                            'billing', 'payment' => 'billing',
                            'message', 'communication' => 'message',
                            default => 'user',
                        };
                    @endphp

                    <div x-show="matches($el)" x-transition data-type="{{ $type }}"
                        class="group border-b border-gray-100 px-4 py-5 transition last:border-b-0 hover:bg-[#faf9f6] sm:px-6">

                        <div class="grid gap-4 md:grid-cols-12 md:items-center">

                            {{-- Activity --}}
                            <div class="md:col-span-4">

                                <div class="flex items-start gap-3">

                                    {{-- Icon --}}
                                    <div
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#f5f1e8] text-[#172033]">

                                        @if ($iconType === 'case')
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h10v18H7z" />
                                                <path stroke-linecap="round" d="M9.5 7h5M9.5 11h5M9.5 15h3" />
                                            </svg>
                                        @elseif($iconType === 'appointment')
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <rect x="3" y="5" width="18" height="16" rx="2" />
                                                <path stroke-linecap="round" d="M16 3v4M8 3v4M3 10h18" />
                                            </svg>
                                        @elseif($iconType === 'document')
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 3h8l4 4v14H6z" />
                                                <path stroke-linecap="round" d="M14 3v5h4M9 13h6M9 17h4" />
                                            </svg>
                                        @elseif($iconType === 'billing')
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.8">
                                                <rect x="3" y="5" width="18" height="14" rx="2" />
                                                <path stroke-linecap="round" d="M7 10h10M7 14h5" />
                                            </svg>
                                        @elseif($iconType === 'message')
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M20 11.5a7.5 7.5 0 01-8 7.5 8.4 8.4 0 01-4-.9L4 20l1.2-3.5A7.2 7.2 0 014.5 12 7.5 7.5 0 0112 4.5a7.5 7.5 0 018 7z" />
                                            </svg>
                                        @else
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.8">
                                                <circle cx="12" cy="8" r="4" />
                                                <path stroke-linecap="round" d="M4 21a8 8 0 0116 0" />
                                            </svg>
                                        @endif

                                    </div>


                                    <div class="min-w-0">

                                        <p class="font-medium text-[#172033]">
                                            {{ $activity->description ?? ($activity->action ?? 'Activity recorded') }}
                                        </p>

                                        @if (isset($activity->details))
                                            <p class="mt-1 truncate text-sm text-gray-500">
                                                {{ $activity->details }}
                                            </p>
                                        @endif

                                    </div>

                                </div>

                            </div>


                            {{-- User --}}
                            <div class="md:col-span-2">

                                <p class="mb-1 text-xs text-gray-400 md:hidden">
                                    User
                                </p>

                                @if (isset($activity->user))
                                    <div class="flex items-center gap-2">

                                        <div
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-[#172033] text-xs font-semibold text-white">
                                            {{ strtoupper(substr($activity->user->name ?? 'U', 0, 1)) }}
                                        </div>

                                        <span class="truncate text-sm font-medium text-gray-700">
                                            {{ $activity->user->name ?? 'Unknown User' }}
                                        </span>

                                    </div>
                                @else
                                    <span class="text-sm text-gray-500">
                                        {{ $activity->user_name ?? 'System' }}
                                    </span>
                                @endif

                            </div>


                            {{-- Type --}}
                            <div class="md:col-span-2">

                                <p class="mb-1 text-xs text-gray-400 md:hidden">
                                    Type
                                </p>

                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $typeClass }}">
                                    {{ ucfirst($type) }}
                                </span>

                            </div>


                            {{-- Date --}}
                            <div class="md:col-span-2">

                                <p class="mb-1 text-xs text-gray-400 md:hidden">
                                    Date
                                </p>

                                @if (isset($activity->created_at))
                                    <p class="text-sm font-medium text-gray-700">
                                        {{ $activity->created_at->format('M d, Y') }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-gray-400">
                                        {{ $activity->created_at->format('h:i A') }}
                                    </p>
                                @else
                                    <span class="text-sm text-gray-500">
                                        —
                                    </span>
                                @endif

                            </div>


                            {{-- Action --}}
                            <div class="md:col-span-2 md:text-right">

                                <button type="button"
                                    @click="openDetails({
                                    description: @js($activity->description ?? ($activity->action ?? 'Activity recorded')),
                                    user: @js($activity->user->name ?? ($activity->user_name ?? 'System')),
                                    type: @js(ucfirst($type)),
                                    date: @js(isset($activity->created_at) ? $activity->created_at->format('M d, Y h:i A') : '—'),
                                    details: @js($activity->details ?? '')
                                })"
                                    class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-3 py-2 text-sm font-medium text-gray-600 transition hover:border-gray-300 hover:bg-gray-50 hover:text-[#172033]">
                                    View

                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M7.21 14.77a.75.75 0 010-1.06L10.94 10 7.21 6.29a.75.75 0 111.06-1.06l4.24 4.24a.75.75 0 010 1.06l-4.24 4.24a.75.75 0 01-1.06 0l-4.24-4.24a.75.75 0 010 1.06l3.71 3.71 3.71-3.71z"
                                            clip-rule="evenodd" />
                                    </svg>

                                </button>

                            </div>

                        </div>

                    </div>

                @empty

                    {{-- Empty State --}}
                    <div class="px-6 py-20 text-center">

                        <div
                            class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#f5f1e8] text-[#172033]">

                            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.7">
                                <circle cx="12" cy="12" r="9" />
                                <path stroke-linecap="round" d="M12 7v5l3 2" />
                            </svg>

                        </div>

                        <h3 class="mt-5 text-lg font-semibold text-[#172033]">
                            No activity yet
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                            System activity will appear here when users perform actions such as creating cases,
                            uploading documents, booking appointments, sending messages, or making payments.
                        </p>

                    </div>
                @endforelse


                {{-- Pagination --}}
                @if (method_exists($activities, 'links'))
                    <div class="border-t border-gray-100 px-4 py-4 sm:px-6">
                        {{ $activities->links() }}
                    </div>
                @endif

            </div>

        </div>


        {{-- Activity Details Modal --}}
        <div x-show="showDetails" x-cloak @keydown.escape.window="showDetails = false"
            class="fixed inset-0 z-50 flex items-center justify-center p-4">

            {{-- Overlay --}}
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showDetails = false"></div>


            {{-- Modal --}}
            <div x-show="showDetails" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                            Activity Details
                        </p>

                        <h2 class="mt-1 text-xl font-semibold text-[#172033]">
                            Activity Information
                        </h2>
                    </div>

                    <button type="button" @click="showDetails = false"
                        class="flex h-9 w-9 items-center justify-center rounded-xl text-gray-400 transition hover:bg-gray-100 hover:text-gray-700">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18" />
                        </svg>
                    </button>

                </div>


                <div class="mt-6 space-y-5">

                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                            Activity
                        </p>

                        <p class="mt-1 text-sm font-medium text-gray-800" x-text="selectedActivity?.description || '—'">
                        </p>
                    </div>


                    <div class="grid grid-cols-2 gap-4">

                        <div class="rounded-xl bg-gray-50 p-4">
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                                User
                            </p>

                            <p class="mt-1 text-sm font-medium text-gray-800" x-text="selectedActivity?.user || '—'"></p>
                        </div>


                        <div class="rounded-xl bg-gray-50 p-4">
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                                Type
                            </p>

                            <p class="mt-1 text-sm font-medium text-gray-800" x-text="selectedActivity?.type || '—'"></p>
                        </div>

                    </div>


                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                            Date & Time
                        </p>

                        <p class="mt-1 text-sm font-medium text-gray-800" x-text="selectedActivity?.date || '—'"></p>
                    </div>


                    <div x-show="selectedActivity?.details">

                        <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                            Details
                        </p>

                        <div class="mt-2 rounded-xl bg-gray-50 p-4">

                            <p class="text-sm leading-6 text-gray-600" x-text="selectedActivity?.details"></p>

                        </div>

                    </div>

                </div>


                <div class="mt-7 flex justify-end">

                    <button type="button" @click="showDetails = false"
                        class="rounded-xl bg-[#172033] px-5 py-2.5 text-sm font-medium text-white transition hover:-translate-y-0.5 hover:shadow-lg">
                        Close
                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection
