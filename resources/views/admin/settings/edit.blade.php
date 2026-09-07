@extends('layouts.app')

@section('title', 'Settings')

@section('content')
    <div class="min-h-screen bg-slate-50">

        <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-900 text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M12 15.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M19.4 15a1.7 1.7 0 00.34 1.88l.06.06-1.9 1.9-.06-.06a1.7 1.7 0 00-1.88-.34 1.7 1.7 0 00-1.03 1.56V20h-2.7v-.09a1.7 1.7 0 00-1.03-1.56 1.7 1.7 0 00-1.88.34l-.06.06-1.9-1.9.06-.06A1.7 1.7 0 007.8 15a1.7 1.7 0 00-1.56-1.03H6v-2.7h.24A1.7 1.7 0 007.8 10a1.7 1.7 0 00-.34-1.88L7.4 8.06l1.9-1.9.06.06a1.7 1.7 0 001.88.34 1.7 1.7 0 001.03-1.56V4h2.7v.09A1.7 1.7 0 0016 5.65a1.7 1.7 0 001.88-.34l.06-.06 1.9 1.9-.06.06A1.7 1.7 0 0019.4 9c.22.6.8 1 1.44 1H21v2.7h-.16A1.7 1.7 0 0019.4 15z" />
                        </svg>
                    </div>

                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                            Settings
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            Manage your administrator account and profile information.
                        </p>
                    </div>

                </div>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                    <div class="flex items-center gap-3">
                        <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 13l4 4L19 7" />
                        </svg>

                        <p class="text-sm font-medium text-emerald-700">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

                    <div class="flex gap-3">

                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9" stroke-width="1.8" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4m0 4h.01" />
                        </svg>

                        <div>
                            <p class="text-sm font-semibold text-red-800">
                                Please correct the following errors:
                            </p>

                            <ul class="mt-2 list-disc pl-5 text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                {{-- Sidebar --}}
                <div class="lg:col-span-1">

                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-200 p-5">
                            <h2 class="text-sm font-semibold text-slate-900">
                                Account Settings
                            </h2>
                        </div>

                        <div class="p-2">

                            <a href="{{ route('admin.settings.edit') }}"
                                class="flex items-center gap-3 rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M12 15.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M19.4 15a1.7 1.7 0 00.34 1.88l.06.06-1.9 1.9-.06-.06a1.7 1.7 0 00-1.88-.34 1.7 1.7 0 00-1.03 1.56V20h-2.7v-.09a1.7 1.7 0 00-1.03-1.56 1.7 1.7 0 00-1.88.34l-.06.06-1.9-1.9.06-.06A1.7 1.7 0 007.8 15a1.7 1.7 0 00-1.56-1.03H6v-2.7h.24A1.7 1.7 0 007.8 10a1.7 1.7 0 00-.34-1.88L7.4 8.06l1.9-1.9.06.06a1.7 1.7 0 001.88.34 1.7 1.7 0 001.03-1.56V4h2.7v.09A1.7 1.7 0 0016 5.65a1.7 1.7 0 001.88-.34l.06-.06 1.9 1.9-.06.06A1.7 1.7 0 0019.4 9c.22.6.8 1 1.44 1H21v2.7h-.16A1.7 1.7 0 0019.4 15z" />
                                </svg>

                                Profile Settings
                            </a>

                            <a href="{{ route('admin.password.edit') }}"
                                class="mt-1 flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="4" y="10" width="16" height="10" rx="2" stroke-width="1.8" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M8 10V7a4 4 0 018 0v3" />
                                </svg>

                                Change Password
                            </a>

                        </div>
                    </div>

                </div>

                {{-- Main Form --}}
                <div class="lg:col-span-2">

                    <form method="POST" action="{{ route('admin.settings.update') }}"
                        class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                        @csrf
                        @method('PUT')

                        <div class="border-b border-slate-200 px-6 py-5">
                            <h2 class="text-base font-semibold text-slate-900">
                                Profile Information
                            </h2>

                            <p class="mt-1 text-sm text-slate-500">
                                Update your administrator account information.
                            </p>
                        </div>

                        <div class="space-y-5 p-6">

                            {{-- Avatar --}}
                            <div class="flex items-center gap-4 rounded-xl bg-slate-50 p-4">

                                <div
                                    class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-900 text-xl font-bold text-white">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                </div>

                                <div>
                                    <p class="text-sm font-semibold text-slate-900">
                                        {{ Auth::user()->name }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        Administrator Account
                                    </p>
                                </div>

                            </div>

                            {{-- Name --}}
                            <div>
                                <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
                                    Full Name
                                </label>

                                <input id="name" type="text" name="name"
                                    value="{{ old('name', Auth::user()->name) }}" required autocomplete="name"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">
                                    Email Address
                                </label>

                                <input id="email" type="email" name="email"
                                    value="{{ old('email', Auth::user()->email) }}" required autocomplete="email"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label for="phone" class="mb-2 block text-sm font-semibold text-slate-700">
                                    Phone Number
                                </label>

                                <input id="phone" type="text" name="phone"
                                    value="{{ old('phone', Auth::user()->phone) }}" placeholder="+962..."
                                    autocomplete="tel"
                                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                            </div>

                            {{-- Role --}}
                            <div>
                                <label for="role" class="mb-2 block text-sm font-semibold text-slate-700">
                                    Role
                                </label>

                                <input id="role" type="text"
                                    value="{{ ucfirst(Auth::user()->role ?? 'Admin') }}" readonly
                                    class="w-full cursor-not-allowed rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm font-medium capitalize text-slate-500">

                                <p class="mt-2 text-xs text-slate-400">
                                    Your administrator role cannot be changed from this page.
                                </p>
                            </div>

                        </div>

                        {{-- Footer --}}
                        <div
                            class="flex flex-col-reverse gap-3 border-t border-slate-200 px-6 py-5 sm:flex-row sm:justify-end">

                            <a href="{{ route('admin.dashboard') }}"
                                class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                Cancel
                            </a>

                            <button type="submit"
                                class="rounded-xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                                Save Changes
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>
@endsection
