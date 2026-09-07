@extends('layouts.app')

@section('title', 'Users')

@section('content')

<div
    x-data="{
        search: '',
        status: 'all',

        matches(row) {
            const text = row.dataset.search || '';
            const rowStatus = row.dataset.status || '';

            const searchMatch = text.includes(this.search.toLowerCase());
            const statusMatch =
                this.status === 'all' || rowStatus === this.status;

            return searchMatch && statusMatch;
        }
    }"
    class="min-h-screen bg-[#F7F4ED]"
>

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

            <div>
                <p class="mb-2 text-[11px] font-semibold uppercase tracking-[0.14em] text-[#B89452]">
                    Administration
                </p>

                <h1 class="font-serif text-3xl font-semibold tracking-tight text-[#0B0B0A] sm:text-4xl">
                    Users
                </h1>

                <p class="mt-2 text-sm leading-6 text-[#77756F]">
                    Manage registered users, roles, account access, and status.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">

                {{-- Dashboard --}}
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="inline-flex h-11 items-center justify-center gap-2 rounded-lg border border-[#D4D1CA] bg-white px-5 text-sm font-semibold text-[#41403C] transition hover:border-[#C9A96E] hover:text-[#B89452]"
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
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>

                    Dashboard
                </a>

                {{-- Add User --}}
                <a
                    href="{{ route('admin.users.create') }}"
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

                    Add User
                </a>

            </div>
        </div>


        {{-- ========================================================= --}}
        {{-- STATISTICS --}}
        {{-- ========================================================= --}}

        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Total Users --}}
            <div class="rounded-xl border border-[#E5E2DB] bg-white p-5">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#9B9992]">
                            Total Users
                        </p>

                        <p class="mt-2 text-2xl font-semibold text-[#0B0B0A]">
                            {{ $users->total() }}
                        </p>

                        <p class="mt-1 text-xs text-[#77756F]">
                            Registered accounts
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

                </div>

            </div>


            {{-- Active Users --}}
            <div class="rounded-xl border border-[#E5E2DB] bg-white p-5">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#9B9992]">
                            Active Users
                        </p>

                        <p class="mt-2 text-2xl font-semibold text-[#27633D]">
                            {{ $users->where('status', 'active')->count() }}
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


            {{-- Roles --}}
            <div class="rounded-xl border border-[#E5E2DB] bg-white p-5">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-xs font-medium uppercase tracking-[0.08em] text-[#9B9992]">
                            Roles
                        </p>

                        <p class="mt-2 text-2xl font-semibold text-[#0B0B0A]">
                            {{ $users->pluck('role')->filter()->unique()->count() }}
                        </p>

                        <p class="mt-1 text-xs text-[#77756F]">
                            User access levels
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
                                d="M12 15l8-4.5L12 6l-8 4.5L12 15z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.7"
                                d="M5 13.5V17c0 1.5 3.13 3 7 3s7-1.5 7-3v-3.5"
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
                            {{ $users->filter(function ($user) {
                                return $user->created_at?->isCurrentMonth();
                            })->count() }}
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


        {{-- ========================================================= --}}
        {{-- SEARCH / FILTERS --}}
        {{-- ========================================================= --}}

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
                        placeholder="Search users..."
                        class="h-11 w-full rounded-lg border border-[#D4D1CA] bg-white py-2.5 pl-10 pr-4 text-sm text-[#41403C] outline-none transition placeholder:text-[#9B9992] focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/15"
                    >

                </div>


                {{-- Filters --}}
                <div class="flex flex-wrap gap-2">

                    {{-- All --}}
                    <button
                        @click="status = 'all'"
                        :class="status === 'all'
                            ? 'border-[#C9A96E] bg-[#11110F] text-white'
                            : 'border-[#E5E2DB] bg-white text-[#77756F] hover:border-[#C9A96E] hover:text-[#B89452]'"
                        class="rounded-lg border px-4 py-2 text-sm font-medium transition"
                    >
                        All
                    </button>


                    {{-- Active --}}
                    <button
                        @click="status = 'active'"
                        :class="status === 'active'
                            ? 'border-[#C9A96E] bg-[#11110F] text-white'
                            : 'border-[#E5E2DB] bg-white text-[#77756F] hover:border-[#C9A96E] hover:text-[#B89452]'"
                        class="rounded-lg border px-4 py-2 text-sm font-medium transition"
                    >
                        Active
                    </button>


                    {{-- Inactive --}}
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


        {{-- ========================================================= --}}
        {{-- USERS TABLE --}}
        {{-- ========================================================= --}}

        <div class="overflow-hidden rounded-xl border border-[#E5E2DB] bg-white">

            {{-- ===================================================== --}}
            {{-- DESKTOP --}}
            {{-- ===================================================== --}}

            <div class="hidden overflow-x-auto md:block">

                <table class="min-w-full">

                    <thead class="border-b border-[#E5E2DB] bg-[#F7F4ED]">

                        <tr>

                            {{-- User --}}
                            <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                User
                            </th>

                            {{-- Email --}}
                            <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                Email
                            </th>

                            {{-- Role --}}
                            <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                Role
                            </th>

                            {{-- Status --}}
                            <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                Status
                            </th>

                            {{-- Registered --}}
                            <th class="px-6 py-4 text-left text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                Registered
                            </th>

                            {{-- Actions --}}
                            <th class="px-6 py-4 text-right text-[11px] font-semibold uppercase tracking-[0.08em] text-[#77756F]">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-[#E5E2DB]">

                        @forelse ($users as $user)

                            @php

                                $status = $user->status ?? 'active';

                                $role = $user->role ?? 'user';

                                $searchText = strtolower(
                                    ($user->name ?? '') . ' ' .
                                    ($user->email ?? '') . ' ' .
                                    ($role ?? '')
                                );

                            @endphp


                            <tr
                                x-show="matches($el)"
                                data-search="{{ $searchText }}"
                                data-status="{{ $status }}"
                                class="transition hover:bg-[#FAF9F6]"
                            >

                                {{-- ================================================= --}}
                                {{-- USER --}}
                                {{-- ================================================= --}}

                                <td class="whitespace-nowrap px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        {{-- Avatar --}}
                                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg border border-[#D8BE8A] bg-[#11110F] font-serif text-sm font-semibold text-[#D8BE8A]">

                                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}

                                        </div>


                                        {{-- Name --}}
                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-semibold text-[#0B0B0A]">
                                                {{ $user->name }}
                                            </p>

                                            <p class="mt-1 text-xs text-[#9B9992]">
                                                User #{{ $user->id }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- ================================================= --}}
                                {{-- EMAIL --}}
                                {{-- ================================================= --}}

                                <td class="px-6 py-4">

                                    <p class="max-w-[260px] truncate text-sm text-[#41403C]">
                                        {{ $user->email }}
                                    </p>

                                </td>


                                {{-- ================================================= --}}
                                {{-- ROLE --}}
                                {{-- ================================================= --}}

                                <td class="px-6 py-4">

                                    @php

                                        $roleClasses = match (strtolower($role)) {

                                            'admin' =>
                                                'border-[#D8BE8A] bg-[#F7F0E1] text-[#8F713C]',

                                            'lawyer' =>
                                                'border-[#D4D1CA] bg-[#F7F4ED] text-[#41403C]',

                                            'client' =>
                                                'border-[#C8DDE8] bg-[#F0F7FA] text-[#386276]',

                                            default =>
                                                'border-[#E5E2DB] bg-white text-[#77756F]',

                                        };

                                    @endphp


                                    <span
                                        class="inline-flex items-center rounded-md border px-2.5 py-1 text-xs font-semibold capitalize {{ $roleClasses }}"
                                    >
                                        {{ $role }}
                                    </span>

                                </td>


                                {{-- ================================================= --}}
                                {{-- STATUS --}}
                                {{-- ================================================= --}}

                                <td class="whitespace-nowrap px-6 py-4">

                                    @if ($status === 'active')

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


                                {{-- ================================================= --}}
                                {{-- REGISTERED --}}
                                {{-- ================================================= --}}

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
                                                d="M7 3v4M17 3v4M4 9h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z"
                                            />
                                        </svg>

                                        <span class="text-sm text-[#41403C]">
                                            {{ $user->created_at?->format('M d, Y') ?? '—' }}
                                        </span>

                                    </div>

                                </td>


                                {{-- ================================================= --}}
                                {{-- ACTIONS --}}
                                {{-- ================================================= --}}

                                <td class="whitespace-nowrap px-6 py-4">

                                    <div class="flex justify-end gap-2">

                                        {{-- VIEW --}}
                                        <a
                                            href="{{ route('admin.users.show', $user) }}"
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


                                        {{-- EDIT --}}
                                        <a
                                            href="{{ route('admin.users.edit', $user) }}"
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

                                <td
                                    colspan="6"
                                    class="px-6 py-16 text-center"
                                >

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
                                        No users found
                                    </h3>

                                    <p class="mt-1 text-sm text-[#9B9992]">
                                        Add your first user to the system.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- ========================================================= --}}
            {{-- MOBILE --}}
            {{-- ========================================================= --}}

            <div class="divide-y divide-[#E5E2DB] md:hidden">

                @forelse ($users as $user)

                    @php

                        $status = $user->status ?? 'active';

                        $role = $user->role ?? 'user';

                    @endphp


                    <div class="p-5">

                        {{-- User Header --}}
                        <div class="flex items-start justify-between gap-4">

                            <div class="flex min-w-0 items-center gap-3">

                                {{-- Avatar --}}
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg border border-[#D8BE8A] bg-[#11110F] font-serif text-sm font-semibold text-[#D8BE8A]">

                                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}

                                </div>


                                <div class="min-w-0">

                                    <p class="truncate text-sm font-semibold text-[#0B0B0A]">
                                        {{ $user->name }}
                                    </p>

                                    <p class="truncate text-xs text-[#9B9992]">
                                        {{ $user->email }}
                                    </p>

                                </div>

                            </div>


                            {{-- Status --}}
                            @if ($status === 'active')

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


                        {{-- User Information --}}
                        <div class="mt-5 grid grid-cols-2 gap-3">

                            {{-- Role --}}
                            <div class="rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] p-3">

                                <p class="text-[11px] font-medium uppercase tracking-[0.06em] text-[#9B9992]">
                                    Role
                                </p>

                                <p class="mt-1 text-sm font-semibold capitalize text-[#41403C]">
                                    {{ $role }}
                                </p>

                            </div>


                            {{-- User ID --}}
                            <div class="rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] p-3">

                                <p class="text-[11px] font-medium uppercase tracking-[0.06em] text-[#9B9992]">
                                    User ID
                                </p>

                                <p class="mt-1 text-sm font-semibold text-[#41403C]">
                                    #{{ $user->id }}
                                </p>

                            </div>


                            {{-- Email --}}
                            <div class="col-span-2 rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] p-3">

                                <p class="text-[11px] font-medium uppercase tracking-[0.06em] text-[#9B9992]">
                                    Email
                                </p>

                                <p class="mt-1 truncate text-sm font-semibold text-[#41403C]">
                                    {{ $user->email }}
                                </p>

                            </div>


                            {{-- Registered --}}
                            <div class="col-span-2 rounded-lg border border-[#E5E2DB] bg-[#F7F4ED] p-3">

                                <p class="text-[11px] font-medium uppercase tracking-[0.06em] text-[#9B9992]">
                                    Registered
                                </p>

                                <p class="mt-1 text-sm font-semibold text-[#41403C]">
                                    {{ $user->created_at?->format('M d, Y') ?? '—' }}
                                </p>

                            </div>

                        </div>


                        {{-- Mobile Actions --}}
                        <div class="mt-5 flex gap-2">

                            {{-- View --}}
                            <a
                                href="{{ route('admin.users.show', $user) }}"
                                class="flex flex-1 items-center justify-center gap-2 rounded-lg border border-[#D4D1CA] bg-white px-4 py-2.5 text-sm font-semibold text-[#41403C] transition hover:border-[#C9A96E] hover:text-[#B89452]"
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


                            {{-- Edit --}}
                            <a
                                href="{{ route('admin.users.edit', $user) }}"
                                class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-[#C9A96E] px-4 py-2.5 text-sm font-semibold text-[#11110F] transition hover:bg-[#B89452]"
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

                    </div>

                @empty

                    <div class="px-6 py-16 text-center">

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
                            No users found
                        </h3>

                        <p class="mt-1 text-sm text-[#9B9992]">
                            Add your first user to the system.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- PAGINATION --}}
        {{-- ========================================================= --}}

        @if (method_exists($users, 'links'))

            <div class="mt-6">
                {{ $users->links() }}
            </div>

        @endif

    </div>

</div>

@endsection