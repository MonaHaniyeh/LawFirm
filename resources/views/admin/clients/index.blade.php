@extends('layouts.app')

@section('title', 'Clients')

@section('content')

    @php
        $totalClients = method_exists($clients, 'total')
            ? $clients->total()
            : $clients->count();

        $clientItems = method_exists($clients, 'items')
            ? collect($clients->items())
            : collect($clients);

        $activeClients = $clientItems->filter(function ($client) {
            return ($client->status ?? 'active') === 'active';
        })->count();

        $clientsWithCases = $clientItems->filter(function ($client) {
            return (int) ($client->cases_as_client_count ?? $client->cases_count ?? 0) > 0;
        })->count();

        $newClients = $clientItems->filter(function ($client) {
            return $client->created_at
                && $client->created_at->isCurrentMonth();
        })->count();
    @endphp


    <div
        x-data="{
            search: '',
            status: 'all',

            matches(el) {
                const text = el.innerText.toLowerCase();

                const searchMatch =
                    this.search.trim() === '' ||
                    text.includes(this.search.toLowerCase());

                const statusMatch =
                    this.status === 'all' ||
                    el.dataset.status === this.status;

                return searchMatch && statusMatch;
            }
        }"
        class="min-h-screen bg-[#F7F4ED] px-4 py-6 sm:px-6 lg:px-8"
    >

        <div class="mx-auto max-w-7xl">

            {{-- Page Header --}}
            <div class="mb-8 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

                <div>

                    <div class="mb-3 flex items-center gap-2 text-xs font-medium text-[#9B9992]">

                        <span>Admin</span>

                        <svg
                            class="h-3.5 w-3.5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="m9 18 6-6-6-6"
                            />
                        </svg>

                        <span class="text-[#77756F]">
                            Clients
                        </span>

                    </div>


                    <h1 class="font-serif text-3xl font-semibold tracking-tight text-[#11110F] sm:text-4xl">
                        Clients
                    </h1>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-[#77756F]">
                        View and manage all clients registered with the law firm.
                    </p>

                </div>


                <div
                    class="inline-flex w-fit items-center gap-2 rounded-full border border-[#D4D1CA] bg-white px-4 py-2 text-xs font-semibold text-[#41403C]"
                >

                    <span class="h-1.5 w-1.5 rounded-full bg-[#C9A96E]"></span>

                    {{ $totalClients }} Total Clients

                </div>

            </div>


            {{-- Summary Cards --}}
            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                {{-- Total --}}
                <div
                    class="rounded-2xl border border-[#E5E2DB] bg-white p-5 transition duration-200 hover:-translate-y-0.5"
                >

                    <div class="flex items-start justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                Total Clients
                            </p>

                            <p class="mt-3 text-2xl font-semibold tracking-tight text-[#11110F]">
                                {{ $totalClients }}
                            </p>

                            <p class="mt-1 text-xs text-[#9B9992]">
                                Registered clients
                            </p>

                        </div>


                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#F7F4ED] text-[#C9A96E]"
                        >

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
                                    d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"
                                />

                                <circle
                                    cx="9"
                                    cy="7"
                                    r="4"
                                    stroke-width="1.8"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"
                                />

                            </svg>

                        </div>

                    </div>

                </div>


                {{-- Active --}}
                <div
                    class="rounded-2xl border border-[#E5E2DB] bg-white p-5 transition duration-200 hover:-translate-y-0.5"
                >

                    <div class="flex items-start justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                Active
                            </p>

                            <p class="mt-3 text-2xl font-semibold tracking-tight text-[#11110F]">
                                {{ $activeClients }}
                            </p>

                            <p class="mt-1 text-xs text-[#9B9992]">
                                Currently active
                            </p>

                        </div>


                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EFF8F2] text-[#3D8B5A]"
                        >

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
                                    d="M5 12l4 4L19 6"
                                />

                            </svg>

                        </div>

                    </div>

                </div>


                {{-- With Cases --}}
                <div
                    class="rounded-2xl border border-[#E5E2DB] bg-white p-5 transition duration-200 hover:-translate-y-0.5"
                >

                    <div class="flex items-start justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                With Cases
                            </p>

                            <p class="mt-3 text-2xl font-semibold tracking-tight text-[#11110F]">
                                {{ $clientsWithCases }}
                            </p>

                            <p class="mt-1 text-xs text-[#9B9992]">
                                Clients with cases
                            </p>

                        </div>


                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EEF5F8] text-[#477C91]"
                        >

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
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M14 3v5h5"
                                />

                            </svg>

                        </div>

                    </div>

                </div>


                {{-- New --}}
                <div
                    class="rounded-2xl border border-[#E5E2DB] bg-white p-5 transition duration-200 hover:-translate-y-0.5"
                >

                    <div class="flex items-start justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                New This Month
                            </p>

                            <p class="mt-3 text-2xl font-semibold tracking-tight text-[#11110F]">
                                {{ $newClients }}
                            </p>

                            <p class="mt-1 text-xs text-[#9B9992]">
                                Recently registered
                            </p>

                        </div>


                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#FFF8E8] text-[#B98525]"
                        >

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
                                    d="M12 4v16m8-8H4"
                                />

                            </svg>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Filters --}}
            <div
                class="mb-6 rounded-2xl border border-[#E5E2DB] bg-white p-4"
            >

                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                    {{-- Search --}}
                    <div class="relative w-full lg:max-w-md">

                        <div
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#9B9992]"
                        >

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
                                    d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0z"
                                />

                            </svg>

                        </div>


                        <input
                            type="text"
                            x-model="search"
                            placeholder="Search clients, email, phone..."
                            aria-label="Search clients"
                            class="h-12 w-full rounded-lg border border-[#D4D1CA] bg-white py-2.5 pl-11 pr-4 text-sm text-[#11110F] placeholder-[#9B9992] outline-none transition duration-200 focus:border-[#C9A96E] focus:ring-4 focus:ring-[#C9A96E]/15"
                        >

                    </div>


                    {{-- Status --}}
                    <div class="flex flex-wrap gap-2">

                        <button
                            type="button"
                            @click="status = 'all'"
                            :class="status === 'all'
                                ? 'border-[#C9A96E] bg-[#C9A96E]/10 text-[#795A18]'
                                : 'border-[#E5E2DB] bg-white text-[#77756F] hover:border-[#D4D1CA] hover:bg-[#FAF9F6]'"
                            class="rounded-lg border px-4 py-2.5 text-sm font-semibold transition duration-200"
                        >
                            All
                        </button>


                        <button
                            type="button"
                            @click="status = 'active'"
                            :class="status === 'active'
                                ? 'border-[#C9A96E] bg-[#C9A96E]/10 text-[#795A18]'
                                : 'border-[#E5E2DB] bg-white text-[#77756F] hover:border-[#D4D1CA] hover:bg-[#FAF9F6]'"
                            class="rounded-lg border px-4 py-2.5 text-sm font-semibold transition duration-200"
                        >
                            Active
                        </button>


                        <button
                            type="button"
                            @click="status = 'inactive'"
                            :class="status === 'inactive'
                                ? 'border-[#C9A96E] bg-[#C9A96E]/10 text-[#795A18]'
                                : 'border-[#E5E2DB] bg-white text-[#77756F] hover:border-[#D4D1CA] hover:bg-[#FAF9F6]'"
                            class="rounded-lg border px-4 py-2.5 text-sm font-semibold transition duration-200"
                        >
                            Inactive
                        </button>


                        <button
                            type="button"
                            @click="search = ''; status = 'all'"
                            class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2.5 text-sm font-medium text-[#9B9992] transition hover:bg-[#F7F4ED] hover:text-[#41403C]"
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
                                    d="M6 6l12 12M18 6 6 18"
                                />

                            </svg>

                            Clear

                        </button>

                    </div>

                </div>

            </div>


            {{-- Clients Table --}}
            <div
                class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white"
            >

                {{-- Desktop --}}
                <div class="hidden overflow-x-auto md:block">

                    <table class="min-w-full">

                        <thead class="bg-[#F7F4ED]">

                            <tr>

                                <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                    Client
                                </th>

                                <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                    Contact
                                </th>

                                <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                    Cases
                                </th>

                                <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                    Joined
                                </th>

                                <th class="px-6 py-4 text-right text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-[#E5E2DB]">

                            @forelse($clients as $client)

                                @php
                                    $clientStatus = strtolower(
                                        $client->status
                                            ?? (($client->is_active ?? true) ? 'active' : 'inactive')
                                    );

                                    if (!in_array($clientStatus, ['active', 'inactive'])) {
                                        $clientStatus = 'active';
                                    }

                                    $caseCount = (int) (
                                        $client->cases_as_client_count
                                        ?? $client->cases_count
                                        ?? 0
                                    );
                                @endphp


                                <tr
                                    x-show="matches($el)"
                                    data-status="{{ $clientStatus }}"
                                    class="transition duration-150 hover:bg-[#FAF9F6]"
                                >

                                    {{-- Client --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        <div class="flex items-center gap-3">

                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#11110F] text-sm font-semibold text-[#C9A96E]"
                                            >
                                                {{ strtoupper(substr($client->name ?? 'C', 0, 1)) }}
                                            </div>


                                            <div>

                                                <p class="font-semibold text-[#11110F]">
                                                    {{ $client->name ?? 'Unnamed Client' }}
                                                </p>

                                                <p class="mt-0.5 text-xs text-[#9B9992]">
                                                    Client #{{ $client->id }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Contact --}}
                                    <td class="px-6 py-4">

                                        <p class="text-sm font-medium text-[#41403C]">
                                            {{ $client->email ?? '—' }}
                                        </p>

                                        <p class="mt-1 text-xs text-[#9B9992]">
                                            {{ $client->phone ?? 'No phone number' }}
                                        </p>

                                    </td>


                                    {{-- Cases --}}
                                    <td class="px-6 py-4">

                                        <div class="inline-flex items-center gap-1.5">

                                            {{-- Small document icon --}}
                                            <svg
                                                class="h-4 w-4 shrink-0 text-[#C9A96E]"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M9 12h6m-6 4h4m-2-13H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-5z"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M14 3v5h5"
                                                />

                                            </svg>


                                            {{-- Compact number --}}
                                            <span
                                                class="min-w-[28px] rounded-md border border-[#D4D1CA] bg-[#F7F4ED] px-2 py-1 text-center text-xs font-semibold text-[#41403C]"
                                            >
                                                {{ $caseCount }}
                                            </span>

                                        </div>

                                    </td>


                                    {{-- Status --}}
                                    <td class="px-6 py-4">

                                        @if ($clientStatus === 'active')

                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full border border-[#3D8B5A]/30 bg-[#EFF8F2] px-3 py-1.5 text-xs font-semibold text-[#27633D]"
                                            >

                                                <span class="h-1.5 w-1.5 rounded-full bg-[#3D8B5A]"></span>

                                                Active

                                            </span>

                                        @else

                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full border border-[#D4D1CA] bg-[#F7F4ED] px-3 py-1.5 text-xs font-semibold text-[#77756F]"
                                            >

                                                <span class="h-1.5 w-1.5 rounded-full bg-[#9B9992]"></span>

                                                Inactive

                                            </span>

                                        @endif

                                    </td>


                                    {{-- Joined --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-[#77756F]">

                                        {{ optional($client->created_at)->format('M d, Y') ?? '—' }}

                                    </td>


                                    {{-- Action --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-right">

                                        <a
                                            href="{{ route('admin.clients.show', $client) }}"
                                            class="inline-flex items-center gap-2 rounded-lg border border-[#C9A96E] px-3.5 py-2 text-sm font-semibold text-[#795A18] transition duration-200 hover:bg-[#C9A96E]/10"
                                        >

                                            View Client

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
                                                    d="m9 18 6-6-6-6"
                                                />

                                            </svg>

                                        </a>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td colspan="6" class="px-6 py-16 text-center">

                                        <div
                                            class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-[#E5E2DB] bg-[#F7F4ED] text-[#C9A96E]"
                                        >

                                            <svg
                                                class="h-7 w-7"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"
                                                />

                                                <circle
                                                    cx="9"
                                                    cy="7"
                                                    r="4"
                                                    stroke-width="1.8"
                                                />

                                            </svg>

                                        </div>


                                        <h3 class="mt-4 text-sm font-semibold text-[#11110F]">
                                            No Clients Yet
                                        </h3>

                                        <p class="mt-1 text-sm text-[#77756F]">
                                            There are currently no clients to display.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- Mobile --}}
                <div class="divide-y divide-[#E5E2DB] md:hidden">

                    @forelse($clients as $client)

                        @php
                            $clientStatus = strtolower(
                                $client->status
                                    ?? (($client->is_active ?? true) ? 'active' : 'inactive')
                            );

                            if (!in_array($clientStatus, ['active', 'inactive'])) {
                                $clientStatus = 'active';
                            }

                            $caseCount = (int) (
                                $client->cases_as_client_count
                                ?? $client->cases_count
                                ?? 0
                            );
                        @endphp


                        <div
                            x-show="matches($el)"
                            data-status="{{ $clientStatus }}"
                            class="p-5 transition hover:bg-[#FAF9F6]"
                        >

                            <div class="flex items-start justify-between gap-3">

                                <div class="flex min-w-0 items-center gap-3">

                                    <div
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#11110F] text-sm font-semibold text-[#C9A96E]"
                                    >
                                        {{ strtoupper(substr($client->name ?? 'C', 0, 1)) }}
                                    </div>


                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-semibold text-[#11110F]">
                                            {{ $client->name ?? 'Unnamed Client' }}
                                        </p>

                                        <p class="mt-0.5 text-xs text-[#9B9992]">
                                            Client #{{ $client->id }}
                                        </p>

                                    </div>

                                </div>


                                @if ($clientStatus === 'active')

                                    <span
                                        class="shrink-0 rounded-full border border-[#3D8B5A]/30 bg-[#EFF8F2] px-2.5 py-1 text-xs font-semibold text-[#27633D]"
                                    >
                                        Active
                                    </span>

                                @else

                                    <span
                                        class="shrink-0 rounded-full border border-[#D4D1CA] bg-[#F7F4ED] px-2.5 py-1 text-xs font-semibold text-[#77756F]"
                                    >
                                        Inactive
                                    </span>

                                @endif

                            </div>


                            <div class="mt-5 grid grid-cols-2 gap-x-5 gap-y-5">

                                <div class="min-w-0">

                                    <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                        Email
                                    </p>

                                    <p class="mt-1 truncate text-sm font-medium text-[#41403C]">
                                        {{ $client->email ?? '—' }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
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
                                                stroke-width="1.8"
                                                d="M9 12h6m-6 4h4m-2-13H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-5z"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="M14 3v5h5"
                                            />

                                        </svg>


                                        <span class="text-sm font-semibold text-[#41403C]">
                                            {{ $caseCount }}
                                        </span>

                                    </div>

                                </div>


                                <div>

                                    <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                        Phone
                                    </p>

                                    <p class="mt-1 truncate text-sm font-medium text-[#41403C]">
                                        {{ $client->phone ?? '—' }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#9B9992]">
                                        Joined
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-[#41403C]">
                                        {{ optional($client->created_at)->format('M d, Y') ?? '—' }}
                                    </p>

                                </div>

                            </div>


                            <div class="mt-5 border-t border-[#E5E2DB] pt-4">

                                <a
                                    href="{{ route('admin.clients.show', $client) }}"
                                    class="flex h-11 w-full items-center justify-center gap-2 rounded-lg bg-[#C9A96E] px-4 text-sm font-semibold text-[#0B0B0A] transition duration-200 hover:bg-[#D8BE8A]"
                                >

                                    View Client

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
                                            d="m9 18 6-6-6-6"
                                        />

                                    </svg>

                                </a>

                            </div>

                        </div>

                    @empty

                        <div class="px-5 py-16 text-center">

                            <div
                                class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-[#E5E2DB] bg-[#F7F4ED] text-[#C9A96E]"
                            >

                                <svg
                                    class="h-7 w-7"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"
                                    />

                                    <circle
                                        cx="9"
                                        cy="7"
                                        r="4"
                                        stroke-width="1.8"
                                    />

                                </svg>

                            </div>


                            <h3 class="mt-4 text-sm font-semibold text-[#11110F]">
                                No Clients Yet
                            </h3>

                            <p class="mt-1 text-sm text-[#77756F]">
                                There are currently no clients to display.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>


            {{-- Pagination --}}
            @if (method_exists($clients, 'links'))

                <div class="mt-6">
                    {{ $clients->links() }}
                </div>

            @endif

        </div>

    </div>

@endsection