@extends('layouts.app')

@section('title', 'Schedule Appointment')

@section('content')

<div class="min-h-screen bg-[#F7F4ED]">

    <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <div class="mb-5 flex items-center gap-2 text-[11px] text-[#9B9992]">

            <a
                href="{{ route('lawyer.dashboard') }}"
                class="transition hover:text-[#B89452]"
            >
                Dashboard
            </a>

            <span>/</span>

            <a
                href="{{ route('lawyer.appointments.index') }}"
                class="transition hover:text-[#B89452]"
            >
                Appointments
            </a>

            <span>/</span>

            <span class="text-[#41403C]">
                Schedule
            </span>

        </div>


        {{-- Header --}}
        <div class="mb-7">

            <p class="mb-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-[#B89452]">
                Appointment Management
            </p>

            <h1 class="font-serif text-3xl font-semibold tracking-tight text-[#181815] sm:text-4xl">
                Schedule Appointment
            </h1>

            <p class="mt-1.5 max-w-xl text-[12px] leading-5 text-[#77756F]">
                Schedule an appointment for one of your assigned cases.
            </p>

        </div>


        {{-- Errors --}}
        @if($errors->any())

            <div class="mb-5 rounded-lg border border-[#E8C9C8] bg-[#FDF0EF] px-4 py-3">

                <p class="text-[11px] font-semibold text-[#7D302F]">
                    Please correct the following:
                </p>

                <ul class="mt-1 list-inside list-disc space-y-0.5 text-[10px] text-[#7D302F]">

                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        {{-- Main Card --}}
        <div class="overflow-hidden rounded-xl border border-[#E5E2DB] bg-white shadow-sm">

            {{-- Card Header --}}
            <div class="border-b border-[#E5E2DB] px-5 py-4 sm:px-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#F0E8D8] text-[#B89452]">

                        <svg
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                        >
                            <rect x="3" y="4" width="18" height="17" rx="2"/>
                            <path d="M16 2v4M8 2v4M3 10h18"/>
                            <path d="M8 14h2M14 14h2M8 18h2"/>
                        </svg>

                    </div>

                    <div>

                        <h2 class="text-sm font-semibold text-[#181815]">
                            Appointment Details
                        </h2>

                        <p class="mt-0.5 text-[10px] text-[#9B9992]">
                            Select the case and appointment information.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Form --}}
            <form
                method="POST"
                action="{{ route('lawyer.appointments.store') }}"
                class="px-5 py-6 sm:px-6"
            >

                @csrf

                <div class="space-y-6">


                    {{-- Case --}}
                    <div>

                        <label
                            for="case_id"
                            class="mb-1.5 block text-[10px] font-semibold uppercase tracking-wider text-[#41403C]"
                        >
                            Case
                        </label>

                        <select
                            id="case_id"
                            name="case_id"
                            required
                            class="block h-11 w-full rounded-lg border border-[#D4D1CA] bg-white px-3 text-[12px] text-[#41403C] outline-none transition focus:border-[#B89452] focus:ring-1 focus:ring-[#B89452]"
                        >

                            <option value="">
                                Select a case
                            </option>

                            @forelse($cases as $case)

                                <option
                                    value="{{ $case->id }}"
                                    {{ old('case_id') == $case->id ? 'selected' : '' }}
                                >
                                    {{ $case->title }}

                                    @if($case->client)
                                        — {{ $case->client->name }}
                                    @endif
                                </option>

                            @empty

                                <option value="" disabled>
                                    No cases assigned to you
                                </option>

                            @endforelse

                        </select>

                        @error('case_id')
                            <p class="mt-1 text-[10px] text-[#B94A48]">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Date + Time --}}
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                        {{-- Date --}}
                        <div>

                            <label
                                for="appointment_date"
                                class="mb-1.5 block text-[10px] font-semibold uppercase tracking-wider text-[#41403C]"
                            >
                                Appointment Date
                            </label>

                            <input
                                type="date"
                                id="appointment_date"
                                name="appointment_date"
                                value="{{ old('appointment_date') }}"
                                min="{{ date('Y-m-d') }}"
                                required
                                class="block h-11 w-full rounded-lg border border-[#D4D1CA] bg-white px-3 text-[12px] text-[#41403C] outline-none transition focus:border-[#B89452] focus:ring-1 focus:ring-[#B89452]"
                            >

                            @error('appointment_date')
                                <p class="mt-1 text-[10px] text-[#B94A48]">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Time --}}
                        <div>

                            <label
                                for="appointment_time"
                                class="mb-1.5 block text-[10px] font-semibold uppercase tracking-wider text-[#41403C]"
                            >
                                Appointment Time
                            </label>

                            <input
                                type="time"
                                id="appointment_time"
                                name="appointment_time"
                                value="{{ old('appointment_time') }}"
                                required
                                class="block h-11 w-full rounded-lg border border-[#D4D1CA] bg-white px-3 text-[12px] text-[#41403C] outline-none transition focus:border-[#B89452] focus:ring-1 focus:ring-[#B89452]"
                            >

                            @error('appointment_time')
                                <p class="mt-1 text-[10px] text-[#B94A48]">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>


                    {{-- Reason --}}
                    <div>

                        <label
                            for="reason"
                            class="mb-1.5 block text-[10px] font-semibold uppercase tracking-wider text-[#41403C]"
                        >
                            Reason for Appointment
                        </label>

                        <textarea
                            id="reason"
                            name="reason"
                            rows="4"
                            maxlength="1000"
                            placeholder="Enter the reason for the appointment..."
                            class="block w-full resize-none rounded-lg border border-[#D4D1CA] bg-white px-3 py-2.5 text-[12px] leading-5 text-[#41403C] outline-none transition placeholder:text-[#B5B2AA] focus:border-[#B89452] focus:ring-1 focus:ring-[#B89452]"
                        >{{ old('reason') }}</textarea>

                        <p class="mt-1 text-[9px] text-[#9B9992]">
                            Maximum 1000 characters.
                        </p>

                        @error('reason')
                            <p class="mt-1 text-[10px] text-[#B94A48]">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Notes --}}
                    <div>

                        <label
                            for="notes"
                            class="mb-1.5 block text-[10px] font-semibold uppercase tracking-wider text-[#41403C]"
                        >
                            Additional Notes
                            <span class="font-normal normal-case tracking-normal text-[#9B9992]">
                                (Optional)
                            </span>
                        </label>

                        <textarea
                            id="notes"
                            name="notes"
                            rows="3"
                            maxlength="2000"
                            placeholder="Add any additional notes..."
                            class="block w-full resize-none rounded-lg border border-[#D4D1CA] bg-white px-3 py-2.5 text-[12px] leading-5 text-[#41403C] outline-none transition placeholder:text-[#B5B2AA] focus:border-[#B89452] focus:ring-1 focus:ring-[#B89452]"
                        >{{ old('notes') }}</textarea>

                        @error('notes')
                            <p class="mt-1 text-[10px] text-[#B94A48]">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Information --}}
                    <div class="rounded-lg border border-[#E5E2DB] bg-[#FAF9F6] px-4 py-3">

                        <div class="flex items-start gap-2.5">

                            <svg
                                class="mt-0.5 h-4 w-4 shrink-0 text-[#B89452]"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.7"
                            >
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 10v6"/>
                                <path d="M12 7h.01"/>
                            </svg>

                            <div>

                                <p class="text-[10px] font-semibold text-[#41403C]">
                                    Appointment status
                                </p>

                                <p class="mt-0.5 text-[10px] leading-4 text-[#77756F]">
                                    New appointments will be created with
                                    <span class="font-semibold text-[#795A18]">
                                        pending
                                    </span>
                                    status.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Buttons --}}
                    <div class="flex flex-col-reverse gap-2.5 border-t border-[#E5E2DB] pt-5 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('lawyer.appointments.index') }}"
                            class="inline-flex h-9 items-center justify-center rounded-md border border-[#D4D1CA] px-4 text-[10px] font-semibold text-[#41403C] transition hover:border-[#B89452] hover:text-[#B89452]"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="inline-flex h-9 items-center justify-center gap-1.5 rounded-md bg-[#B89452] px-4 text-[10px] font-semibold text-white transition hover:bg-[#9F7D43] focus:outline-none focus:ring-2 focus:ring-[#B89452] focus:ring-offset-1"
                        >

                            <svg
                                class="h-3.5 w-3.5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path d="M12 5v14"/>
                                <path d="M5 12h14"/>
                            </svg>

                            Schedule Appointment

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection