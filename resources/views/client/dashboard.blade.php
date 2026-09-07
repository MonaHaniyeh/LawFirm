@extends('layouts.app')

@section('title', 'Client Dashboard')

@section('breadcrumb', 'Client Dashboard')

@section('content')

<div class="w-full">

    {{-- Page Header --}}
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-10">

        <div>
            <div class="text-xs font-semibold uppercase tracking-[0.25em] text-[#b99a63] mb-3">
                Client Portal
            </div>

            <h1
                class="text-4xl md:text-5xl font-medium text-[#151515]"
                style="font-family: 'Cormorant Garamond', serif;"
            >
                Good afternoon,
                <span class="text-[#b99a63]">
                    {{ auth()->user()->name }}
                </span>
            </h1>

            <p class="text-sm text-[#77736b] mt-3 leading-relaxed">
                Here's a quick overview of your cases, appointments,
                messages, and documents.
            </p>
        </div>

        {{-- File New Case --}}
        <a
            href="{{ route('client.cases.create') }}"
            class="inline-flex items-center justify-center gap-2
                   px-5 py-3 rounded-lg
                   bg-[#151515] text-[#f5f1e8]
                   text-xs font-semibold
                   hover:bg-[#b99a63] hover:text-[#151515]
                   transition-all duration-200"
        >
            <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                class="w-4 h-4"
            >
                <path d="M12 5v14"/>
                <path d="M5 12h14"/>
            </svg>

            File a new case
        </a>

    </div>


    {{-- Statistics --}}
    <section
        class="grid grid-cols-2 xl:grid-cols-4
               border-t border-b border-[#ddd7ca] mb-12"
    >

        {{-- Open Cases --}}
        <div class="p-6 border-r border-[#ddd7ca]">

            <div class="text-[10px] uppercase tracking-[0.15em]
                        font-semibold text-[#77736b]">
                Open Cases
            </div>

            <div
                class="text-4xl mt-3 text-[#151515]"
                style="font-family: 'Cormorant Garamond', serif;"
            >
                {{ $stats['open_cases'] ?? 0 }}
            </div>

            <div class="w-6 h-px bg-[#b99a63] mt-4"></div>

        </div>


        {{-- Upcoming Appointments --}}
        <div class="p-6 xl:border-r border-[#ddd7ca]">

            <div class="text-[10px] uppercase tracking-[0.15em]
                        font-semibold text-[#77736b]">
                Upcoming Appointments
            </div>

            <div
                class="text-4xl mt-3 text-[#151515]"
                style="font-family: 'Cormorant Garamond', serif;"
            >
                {{ $stats['upcoming_appointments'] ?? 0 }}
            </div>

            <div class="w-6 h-px bg-[#b99a63] mt-4"></div>

        </div>


        {{-- Unread Messages --}}
        <div
            class="p-6 border-t xl:border-t-0
                   xl:border-r border-[#ddd7ca]"
        >

            <div class="text-[10px] uppercase tracking-[0.15em]
                        font-semibold text-[#77736b]">
                Unread Messages
            </div>

            <div
                class="text-4xl mt-3 text-[#151515]"
                style="font-family: 'Cormorant Garamond', serif;"
            >
                {{ $stats['unread_messages'] ?? 0 }}
            </div>

            <div class="w-6 h-px bg-[#b99a63] mt-4"></div>

        </div>


        {{-- Documents --}}
        <div
            class="p-6 border-t xl:border-t-0
                   border-[#ddd7ca]"
        >

            <div class="text-[10px] uppercase tracking-[0.15em]
                        font-semibold text-[#77736b]">
                Documents on File
            </div>

            <div
                class="text-4xl mt-3 text-[#151515]"
                style="font-family: 'Cormorant Garamond', serif;"
            >
                {{ $stats['documents'] ?? 0 }}
            </div>

            <div class="w-6 h-px bg-[#b99a63] mt-4"></div>

        </div>

    </section>


    {{-- My Cases --}}
    <section class="mb-12">

        <div class="flex items-center justify-between mb-5">

            <h2
                class="text-3xl font-semibold text-[#151515]"
                style="font-family: 'Cormorant Garamond', serif;"
            >
                My Cases
            </h2>

            {{-- View All --}}
            <a
                href="{{ route('client.cases.index') }}"
                class="inline-flex items-center gap-2
                       px-4 py-2 rounded-lg
                       text-xs font-semibold
                       text-[#b99a63]
                       border border-[#ddd7ca]
                       hover:bg-[#151515]
                       hover:text-[#f5f1e8]
                       hover:border-[#151515]
                       transition-all duration-200"
            >
                View all

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                    class="w-4 h-4"
                >
                    <path d="M5 12h14"/>
                    <path d="m13 6 6 6-6 6"/>
                </svg>
            </a>

        </div>


        @if($cases->isNotEmpty())

            <div class="overflow-x-auto border-t border-[#ddd7ca]">

                <table class="w-full min-w-[750px] border-collapse">

                    <thead>

                        <tr>

                            <th
                                class="text-left px-4 py-4
                                       text-[10px] uppercase tracking-wider
                                       font-semibold text-[#77736b]
                                       border-b border-[#ddd7ca]"
                            >
                                Case Number
                            </th>

                            <th
                                class="text-left px-4 py-4
                                       text-[10px] uppercase tracking-wider
                                       font-semibold text-[#77736b]
                                       border-b border-[#ddd7ca]"
                            >
                                Type
                            </th>

                            <th
                                class="text-left px-4 py-4
                                       text-[10px] uppercase tracking-wider
                                       font-semibold text-[#77736b]
                                       border-b border-[#ddd7ca]"
                            >
                                Start Date
                            </th>

                            <th
                                class="text-left px-4 py-4
                                       text-[10px] uppercase tracking-wider
                                       font-semibold text-[#77736b]
                                       border-b border-[#ddd7ca]"
                            >
                                Status
                            </th>

                            <th
                                class="text-left px-4 py-4
                                       text-[10px] uppercase tracking-wider
                                       font-semibold text-[#77736b]
                                       border-b border-[#ddd7ca]"
                            >
                                Lawyer
                            </th>

                            <th
                                class="text-left px-4 py-4
                                       text-[10px] uppercase tracking-wider
                                       font-semibold text-[#77736b]
                                       border-b border-[#ddd7ca]"
                            >
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($cases as $case)

                            @php

                                $caseStatus = strtolower(
                                    $case->status ?? 'pending'
                                );

                                $caseStatusClass = match ($caseStatus) {

                                    'open',
                                    'opened',
                                    'active' =>
                                        'bg-[#e9f0ea] text-[#52745a]',

                                    'pending' =>
                                        'bg-[#f4eddf] text-[#9a763d]',

                                    'closed',
                                    'completed' =>
                                        'bg-[#e9e6df] text-[#77736b]',

                                    'cancelled',
                                    'rejected' =>
                                        'bg-[#f4e8e6] text-[#914f49]',

                                    default =>
                                        'bg-[#eeeae0] text-[#756b52]',
                                };

                            @endphp


                            <tr class="hover:bg-white/40 transition">

                                {{-- Case Number --}}
                                <td
                                    class="px-4 py-5
                                           border-b border-[#ddd7ca]
                                           text-sm font-semibold"
                                >
                                    {{ $case->case_number }}
                                </td>


                                {{-- Case Type --}}
                                <td
                                    class="px-4 py-5
                                           border-b border-[#ddd7ca]
                                           text-sm text-[#77736b]"
                                >
                                    {{ $case->case_type }}
                                </td>


                                {{-- Start Date --}}
                                <td
                                    class="px-4 py-5
                                           border-b border-[#ddd7ca]
                                           text-sm"
                                >
                                    {{ $case->start_date?->format('M d, Y') ?? '—' }}
                                </td>


                                {{-- Status --}}
                                <td
                                    class="px-4 py-5
                                           border-b border-[#ddd7ca]"
                                >

                                    <span
                                        class="inline-flex items-center gap-2
                                               px-3 py-1.5
                                               rounded-full
                                               text-[10px] uppercase
                                               tracking-wider
                                               font-semibold
                                               {{ $caseStatusClass }}"
                                    >

                                        <span
                                            class="w-1.5 h-1.5
                                                   rounded-full
                                                   bg-current"
                                        ></span>

                                        {{ ucfirst($case->status ?? 'Pending') }}

                                    </span>

                                </td>


                                {{-- Lawyer --}}
                                <td
                                    class="px-4 py-5
                                           border-b border-[#ddd7ca]
                                           text-sm font-medium"
                                >

                                    @if($case->lawyer)

                                        {{ $case->lawyer->name }}

                                    @else

                                        <span class="text-[#77736b]">
                                            Not assigned
                                        </span>

                                    @endif

                                </td>


                                {{-- Action --}}
                                <td
                                    class="px-4 py-5
                                           border-b border-[#ddd7ca]"
                                >

                                    <a
                                        href="{{ route('client.cases.show', $case) }}"
                                        class="inline-flex items-center
                                               px-3 py-2 rounded-lg
                                               bg-[#f4eddf]
                                               text-[#9a763d]
                                               text-xs font-semibold
                                               hover:bg-[#b99a63]
                                               hover:text-[#151515]
                                               transition-all duration-200"
                                    >
                                        Case details →
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            {{-- Empty Cases --}}
            <div
                class="border-t border-b border-[#ddd7ca]
                       py-12 text-center"
            >

                <div
                    class="w-10 h-10 mx-auto mb-4
                           rounded-full
                           border border-[#ddd7ca]
                           flex items-center justify-center
                           text-[#b99a63]"
                >

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        class="w-5 h-5"
                    >
                        <path
                            d="M4 5.5A2.5 2.5 0 0 1 6.5 3H10l2 2h7.5A2.5 2.5 0 0 1 20 7.5v10a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 17.5v-12Z"
                        />
                    </svg>

                </div>


                <h3
                    class="text-2xl text-[#151515]"
                    style="font-family: 'Cormorant Garamond', serif;"
                >
                    No cases yet
                </h3>


                <p class="text-xs text-[#77736b] mt-1">
                    Cases you file will appear here.
                </p>


                <a
                    href="{{ route('client.cases.create') }}"
                    class="inline-flex items-center
                           mt-4 px-4 py-2 rounded-lg
                           bg-[#151515]
                           text-[#f5f1e8]
                           text-xs font-semibold
                           hover:bg-[#b99a63]
                           hover:text-[#151515]
                           transition-all duration-200"
                >
                    File your first case →
                </a>

            </div>

        @endif

    </section>


    {{-- Upcoming Appointments --}}
    <section class="mb-12">

        <div class="flex items-center justify-between mb-5">

            <h2
                class="text-3xl font-semibold text-[#151515]"
                style="font-family: 'Cormorant Garamond', serif;"
            >
                Upcoming Appointments
            </h2>


            @if(Route::has('client.appointments.index'))

                <a
                    href="{{ route('client.appointments.index') }}"
                    class="inline-flex items-center gap-2
                           px-4 py-2 rounded-lg
                           text-xs font-semibold
                           text-[#b99a63]
                           border border-[#ddd7ca]
                           hover:bg-[#151515]
                           hover:text-[#f5f1e8]
                           hover:border-[#151515]
                           transition-all duration-200"
                >
                    View all

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.7"
                        class="w-4 h-4"
                    >
                        <path d="M5 12h14"/>
                        <path d="m13 6 6 6-6 6"/>
                    </svg>

                </a>

            @endif

        </div>


        @if($appointments->isNotEmpty())

            <div class="border-t border-[#ddd7ca]">

                @foreach($appointments as $appointment)

                    @php

                        $appointmentStatus = strtolower(
                            $appointment->status ?? 'pending'
                        );

                        $appointmentStatusClass = match ($appointmentStatus) {

                            'scheduled' =>
                                'bg-[#e9f0ea] text-[#52745a]',

                            'completed' =>
                                'bg-[#e9e6df] text-[#77736b]',

                            'pending' =>
                                'bg-[#f4eddf] text-[#9a763d]',

                            'cancelled',
                            'rejected' =>
                                'bg-[#f4e8e6] text-[#914f49]',

                            default =>
                                'bg-[#eeeae0] text-[#756b52]',
                        };

                    @endphp


                    <div
                        class="grid grid-cols-[18px_1fr_auto]
                               gap-4 py-5
                               border-b border-[#ddd7ca]"
                    >

                        {{-- Marker --}}
                        <div class="flex justify-center">

                            <span
                                class="w-2.5 h-2.5 mt-1
                                       rounded-full
                                       border-2 border-[#b99a63]
                                       bg-[#f5f1e8]"
                            ></span>

                        </div>


                        {{-- Information --}}
                        <div>

                            <div
                                class="text-sm font-semibold
                                       text-[#151515]"
                            >
                                {{ $appointment->lawyer->name ?? 'Lawyer not assigned' }}
                            </div>


                            <div
                                class="flex flex-wrap gap-4 mt-2
                                       text-[11px] text-[#77736b]"
                            >

                                {{-- Date --}}
                                <span
                                    class="inline-flex items-center gap-1.5"
                                >

                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                        class="w-3.5 h-3.5"
                                    >
                                        <rect
                                            x="3"
                                            y="5"
                                            width="18"
                                            height="16"
                                            rx="2"
                                        />
                                        <path d="M16 3v4"/>
                                        <path d="M8 3v4"/>
                                        <path d="M3 10h18"/>
                                    </svg>

                                    {{ $appointment->appointment_date
                                        ? \Carbon\Carbon::parse(
                                            $appointment->appointment_date
                                          )->format('M d, Y')
                                        : 'Date not set'
                                    }}

                                </span>


                                {{-- Time --}}
                                @if(!empty($appointment->appointment_time))

                                    <span
                                        class="inline-flex items-center gap-1.5"
                                    >

                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.7"
                                            class="w-3.5 h-3.5"
                                        >
                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="9"
                                            />
                                            <path d="M12 7v5l3 2"/>
                                        </svg>

                                        {{
                                            \Carbon\Carbon::parse(
                                                $appointment->appointment_time
                                            )->format('h:i A')
                                        }}

                                    </span>

                                @endif


                                {{-- Case --}}
                                @if($appointment->case)

                                    <span
                                        class="inline-flex items-center gap-1.5"
                                    >

                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.7"
                                            class="w-3.5 h-3.5"
                                        >
                                            <path
                                                d="M4 5.5A2.5 2.5 0 0 1 6.5 3H10l2 2h5.5A2.5 2.5 0 0 1 20 7.5v10a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 17.5v-12Z"
                                            />
                                        </svg>

                                        {{ $appointment->case->case_number ?? 'No case reference' }}

                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- Status --}}
                        <div class="self-center">

                            <span
                                class="inline-flex items-center gap-2
                                       px-3 py-1.5
                                       rounded-full
                                       text-[10px] uppercase
                                       tracking-wider
                                       font-semibold
                                       {{ $appointmentStatusClass }}"
                            >

                                <span
                                    class="w-1.5 h-1.5
                                           rounded-full
                                           bg-current"
                                ></span>

                                {{ ucfirst($appointment->status ?? 'Pending') }}

                            </span>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            {{-- Empty Appointments --}}
            <div
                class="border-t border-b border-[#ddd7ca]
                       py-12 text-center"
            >

                <div
                    class="w-10 h-10 mx-auto mb-4
                           rounded-full
                           border border-[#ddd7ca]
                           flex items-center justify-center
                           text-[#b99a63]"
                >

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        class="w-5 h-5"
                    >
                        <rect
                            x="3"
                            y="5"
                            width="18"
                            height="16"
                            rx="2"
                        />
                        <path d="M16 3v4"/>
                        <path d="M8 3v4"/>
                        <path d="M3 10h18"/>
                    </svg>

                </div>


                <h3
                    class="text-2xl text-[#151515]"
                    style="font-family: 'Cormorant Garamond', serif;"
                >
                    No upcoming appointments
                </h3>


                <p class="text-xs text-[#77736b] mt-1">
                    Your upcoming consultations and meetings will appear here.
                </p>


                @if(Route::has('client.appointments.index'))

                    <a
                        href="{{ route('client.appointments.index') }}"
                        class="inline-flex items-center
                               mt-4 px-4 py-2 rounded-lg
                               bg-[#151515]
                               text-[#f5f1e8]
                               text-xs font-semibold
                               hover:bg-[#b99a63]
                               hover:text-[#151515]
                               transition-all duration-200"
                    >
                        Book an appointment →
                    </a>

                @endif

            </div>

        @endif

    </section>

</div>

@endsection
