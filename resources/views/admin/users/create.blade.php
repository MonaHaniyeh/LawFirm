@extends('layouts.app')

@section('title', 'Create User')

@section('content')

<div class="min-h-screen bg-[#F7F4ED] py-10 px-6">

    <div class="max-w-5xl mx-auto">

        {{-- Back to Users --}}
        <a
            href="{{ route('admin.users.index') }}"
            class="inline-flex items-center gap-2 mb-6 text-sm font-medium text-[#77756F] hover:text-[#11110F] transition"
        >
            <svg
                class="w-4 h-4"
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

            Back to Users
        </a>


        {{-- Page Heading --}}
        <div class="mb-8">

            <p class="text-xs uppercase tracking-[0.22em] text-[#C9A96E] font-semibold mb-2">
                User Management
            </p>

            <h1 class="text-3xl md:text-4xl font-serif text-[#11110F]">
                Create New User
            </h1>

            <p class="mt-2 text-sm text-[#77756F]">
                Create a new account for a member of the law firm.
            </p>

        </div>


        {{-- Validation Errors --}}
        @if ($errors->any())

            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5">

                <div class="flex items-start gap-4">

                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">

                        <svg
                            class="w-5 h-5 text-red-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 9v4m0 4h.01M10.29 3.86l-8.82 15A2 2 0 003.2 22h17.6a2 2 0 001.73-3.14l-8.82-15a2 2 0 00-3.42 0z"
                            />
                        </svg>

                    </div>

                    <div>

                        <h3 class="font-semibold text-red-800">
                            Please correct the following errors
                        </h3>

                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif


        {{-- Create Form --}}
        <form
            method="POST"
            action="{{ route('admin.users.store') }}"
        >

            @csrf


            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


                {{-- Main Account Information --}}
                <div class="lg:col-span-2">

                    <div class="bg-white rounded-2xl border border-[#E5E2DB] shadow-sm overflow-hidden">

                        {{-- Card Header --}}
                        <div class="px-7 py-6 border-b border-[#E5E2DB]">

                            <div class="flex items-center gap-4">

                                <div class="w-11 h-11 rounded-xl bg-[#11110F] flex items-center justify-center">

                                    <svg
                                        class="w-5 h-5 text-[#C9A96E]"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zm7-4v6m3-3h-6"
                                        />
                                    </svg>

                                </div>

                                <div>

                                    <h2 class="text-xl font-serif text-[#11110F]">
                                        Account Information
                                    </h2>

                                    <p class="text-sm text-[#77756F] mt-1">
                                        Enter the user's personal and login information.
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- Fields --}}
                        <div class="p-7 space-y-6">


                            {{-- Name --}}
                            <div>

                                <label
                                    for="name"
                                    class="block text-sm font-semibold text-[#11110F] mb-2"
                                >
                                    Full Name
                                </label>

                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name') }}"
                                    required
                                    autofocus
                                    placeholder="Enter full name"
                                    class="w-full rounded-xl border border-[#E5E2DB] bg-white px-4 py-3.5 text-sm text-[#11110F] placeholder-[#9B9992] outline-none transition focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                                >

                                @error('name')

                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- Email --}}
                            <div>

                                <label
                                    for="email"
                                    class="block text-sm font-semibold text-[#11110F] mb-2"
                                >
                                    Email Address
                                </label>

                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email') }}"
                                    required
                                    placeholder="name@example.com"
                                    class="w-full rounded-xl border border-[#E5E2DB] bg-white px-4 py-3.5 text-sm text-[#11110F] placeholder-[#9B9992] outline-none transition focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                                >

                                @error('email')

                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- Phone --}}
                            <div>

                                <label
                                    for="phone"
                                    class="block text-sm font-semibold text-[#11110F] mb-2"
                                >
                                    Phone Number
                                </label>

                                <input
                                    id="phone"
                                    name="phone"
                                    type="text"
                                    value="{{ old('phone') }}"
                                    placeholder="+962 ..."
                                    class="w-full rounded-xl border border-[#E5E2DB] bg-white px-4 py-3.5 text-sm text-[#11110F] placeholder-[#9B9992] outline-none transition focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                                >

                                @error('phone')

                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- Passwords --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                {{-- Password --}}
                                <div>

                                    <label
                                        for="password"
                                        class="block text-sm font-semibold text-[#11110F] mb-2"
                                    >
                                        Password
                                    </label>

                                    <input
                                        id="password"
                                        name="password"
                                        type="password"
                                        required
                                        placeholder="Minimum 8 characters"
                                        class="w-full rounded-xl border border-[#E5E2DB] bg-white px-4 py-3.5 text-sm text-[#11110F] placeholder-[#9B9992] outline-none transition focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                                    >

                                    @error('password')

                                        <p class="mt-2 text-sm text-red-600">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>


                                {{-- Confirm Password --}}
                                <div>

                                    <label
                                        for="password_confirmation"
                                        class="block text-sm font-semibold text-[#11110F] mb-2"
                                    >
                                        Confirm Password
                                    </label>

                                    <input
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        type="password"
                                        required
                                        placeholder="Repeat password"
                                        class="w-full rounded-xl border border-[#E5E2DB] bg-white px-4 py-3.5 text-sm text-[#11110F] placeholder-[#9B9992] outline-none transition focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                                    >

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Right Sidebar --}}
                <div class="space-y-6">


                    {{-- Role Card --}}
                    <div class="bg-white rounded-2xl border border-[#E5E2DB] shadow-sm overflow-hidden">

                        <div class="px-6 py-5 border-b border-[#E5E2DB]">

                            <h2 class="text-lg font-serif text-[#11110F]">
                                Account Role
                            </h2>

                            <p class="text-xs text-[#77756F] mt-1">
                                Choose the user's permissions.
                            </p>

                        </div>


                        <div class="p-6">

                            <label
                                for="role"
                                class="block text-sm font-semibold text-[#11110F] mb-2"
                            >
                                Role
                            </label>

                            <select
                                id="role"
                                name="role"
                                required
                                class="w-full rounded-xl border border-[#E5E2DB] bg-white px-4 py-3.5 text-sm text-[#11110F] outline-none transition focus:border-[#C9A96E] focus:ring-2 focus:ring-[#C9A96E]/20"
                            >

                                <option value="">
                                    Select a role
                                </option>

                                <option
                                    value="admin"
                                    {{ old('role') === 'admin' ? 'selected' : '' }}
                                >
                                    Administrator
                                </option>

                                <option
                                    value="lawyer"
                                    {{ old('role') === 'lawyer' ? 'selected' : '' }}
                                >
                                    Lawyer
                                </option>

                                <option
                                    value="client"
                                    {{ old('role') === 'client' ? 'selected' : '' }}
                                >
                                    Client
                                </option>

                                <option
                                    value="accountant"
                                    {{ old('role') === 'accountant' ? 'selected' : '' }}
                                >
                                    Accountant
                                </option>

                                <option
                                    value="user"
                                    {{ old('role') === 'user' ? 'selected' : '' }}
                                >
                                    User
                                </option>

                            </select>

                            @error('role')

                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                    </div>


                    {{-- Information Card --}}
                    <div class="bg-[#11110F] rounded-2xl p-6">

                        <div class="flex items-start gap-4">

                            <div class="w-10 h-10 rounded-xl bg-[#C9A96E]/15 flex items-center justify-center flex-shrink-0">

                                <svg
                                    class="w-5 h-5 text-[#C9A96E]"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z"
                                    />
                                </svg>

                            </div>

                            <div>

                                <h3 class="text-sm font-semibold text-white">
                                    Administrator Note
                                </h3>

                                <p class="mt-2 text-xs leading-5 text-gray-400">
                                    The selected role determines which areas of
                                    the law firm system this user can access.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Actions --}}
                    <div class="flex flex-col gap-3">

                        <button
                            type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-[#11110F] px-5 py-3.5 text-sm font-semibold text-white hover:bg-[#252520] transition"
                        >

                            <svg
                                class="w-5 h-5 text-[#C9A96E]"
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

                            Create User

                        </button>


                        <a
                            href="{{ route('admin.users.index') }}"
                            class="w-full inline-flex items-center justify-center rounded-xl border border-[#E5E2DB] bg-white px-5 py-3.5 text-sm font-medium text-[#11110F] hover:bg-[#F7F4ED] transition"
                        >
                            Cancel
                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection