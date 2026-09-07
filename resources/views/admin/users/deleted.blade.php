@extends('layouts.app')

@section('title', 'Deleted Users')

@section('content')

<div class="min-h-screen bg-[#F7F4ED]">

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>
                <a
                    href="{{ route('admin.users.index') }}"
                    class="mb-4 inline-flex items-center gap-2 text-sm font-medium text-[#77756F] transition hover:text-[#11110F]"
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
                            stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"
                        />
                    </svg>

                    Back to Users
                </a>

                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#C9A96E]">
                    Administration
                </p>

                <h1 class="mt-2 font-serif text-3xl font-bold text-[#11110F]">
                    Deleted Users
                </h1>

                <p class="mt-2 max-w-2xl text-sm text-[#77756F]">
                    Manage accounts that have been removed from the active users list.
                </p>
            </div>

        </div>


        {{-- Success --}}
        @if(session('success'))

            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">
                <div class="flex items-center gap-3">

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                    {{ session('success') }}

                </div>
            </div>

        @endif


        {{-- Error --}}
        @if(session('error'))

            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">
                <div class="flex items-center gap-3">

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"
                        />
                    </svg>

                    {{ session('error') }}

                </div>
            </div>

        @endif


        {{-- Deleted Users Card --}}
        <div class="overflow-hidden rounded-2xl border border-[#E5E2DB] bg-white shadow-sm">

            {{-- Card Header --}}
            <div class="border-b border-[#E5E2DB] bg-[#11110F] px-6 py-5">

                <div class="flex items-center justify-between gap-4">

                    <div>
                        <h2 class="font-serif text-lg font-bold text-white">
                            Deleted Accounts
                        </h2>

                        <p class="mt-1 text-sm text-[#B8B5AC]">
                            These accounts are currently soft deleted.
                        </p>
                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl border border-[#C9A96E]/30 bg-[#181815]">

                        <svg
                            class="h-5 w-5 text-[#D8BE8A]"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h14"
                            />
                        </svg>

                    </div>

                </div>

            </div>


            {{-- Table --}}
            @if($users->count())

                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <thead class="border-b border-[#E5E2DB] bg-[#FAF9F6]">

                            <tr>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#77756F]">
                                    User
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#77756F]">
                                    Role
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#77756F]">
                                    Deleted
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-[#77756F]">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-[#E5E2DB]">

                            @foreach($users as $user)

                                @php
                                    $initial = strtoupper(substr($user->name ?? 'U', 0, 1));

                                    $role = strtolower($user->role ?? 'user');
                                @endphp

                                <tr class="transition hover:bg-[#FAF9F6]">

                                    {{-- User --}}
                                    <td class="px-6 py-5">

                                        <div class="flex items-center gap-4">

                                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-[#C9A96E]/40 bg-[#11110F] font-serif text-lg font-bold text-[#D8BE8A]">
                                                {{ $initial }}
                                            </div>

                                            <div class="min-w-0">

                                                <p class="truncate text-sm font-bold text-[#11110F]">
                                                    {{ $user->name }}
                                                </p>

                                                <p class="mt-1 truncate text-sm text-[#77756F]">
                                                    {{ $user->email }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Role --}}
                                    <td class="px-6 py-5">

                                        @switch($role)

                                            @case('admin')
                                                <span class="inline-flex rounded-full border border-[#C9A96E]/30 bg-[#FBF6EA] px-3 py-1 text-xs font-bold text-[#8A6D35]">
                                                    Administrator
                                                </span>
                                                @break

                                            @case('lawyer')
                                                <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-700">
                                                    Lawyer
                                                </span>
                                                @break

                                            @case('client')
                                                <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">
                                                    Client
                                                </span>
                                                @break

                                            @case('accountant')
                                                <span class="inline-flex rounded-full bg-purple-50 px-3 py-1 text-xs font-bold text-purple-700">
                                                    Accountant
                                                </span>
                                                @break

                                            @default
                                                <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-bold capitalize text-gray-600">
                                                    {{ $role }}
                                                </span>

                                        @endswitch

                                    </td>


                                    {{-- Deleted At --}}
                                    <td class="px-6 py-5">

                                        <p class="text-sm font-semibold text-[#11110F]">
                                            {{ $user->deleted_at?->format('M d, Y') ?? '—' }}
                                        </p>

                                        <p class="mt-1 text-xs text-[#9B9992]">
                                            {{ $user->deleted_at?->format('h:i A') ?? '' }}
                                        </p>

                                    </td>


                                    {{-- Actions --}}
                                    <td class="px-6 py-5">

                                        <div class="flex justify-end gap-2">

                                            {{-- Restore --}}
                                            <form
                                                method="POST"
                                                action="{{ route('admin.users.restore', $user->id) }}"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs font-bold text-emerald-700 transition hover:bg-emerald-100"
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
                                                            stroke-width="2"
                                                            d="M3 10h10a4 4 0 014 4v1m0 0l-3-3m3 3l3-3M21 14H11a4 4 0 01-4-4V9m0 0l3 3m-3-3L4 12"
                                                        />
                                                    </svg>

                                                    Restore

                                                </button>

                                            </form>


                                            {{-- Permanent Delete --}}
                                            <form
                                                method="POST"
                                                action="{{ route('admin.users.forceDelete', $user->id) }}"
                                                onsubmit="return confirm('Are you sure you want to permanently delete this user? This action cannot be undone.');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-2 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-bold text-red-600 transition hover:bg-red-100"
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
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h14"
                                                        />
                                                    </svg>

                                                    Delete Forever

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}
                @if($users->hasPages())

                    <div class="border-t border-[#E5E2DB] px-6 py-5">
                        {{ $users->links() }}
                    </div>

                @endif

            @else

                {{-- Empty State --}}
                <div class="px-6 py-16 text-center">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#F7F4ED]">

                        <svg
                            class="h-7 w-7 text-[#9B9992]"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4"
                            />
                        </svg>

                    </div>

                    <h3 class="mt-5 font-serif text-lg font-bold text-[#11110F]">
                        No deleted users
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm text-[#77756F]">
                        There are currently no soft-deleted user accounts.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection