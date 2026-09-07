@extends('layouts.app')

@section('title', 'My Cases')

@section('breadcrumb')
    <span>My Cases</span>
@endsection

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

        <div>
            <p class="text-[10px] font-medium uppercase tracking-[0.18em] text-[#b99a63]">
                Legal Matters
            </p>

            <h1
                class="mt-1 text-3xl font-semibold text-[#151515]"
                style="font-family: 'Cormorant Garamond', serif;"
            >
                My Cases
            </h1>

            <p class="mt-1 max-w-xl text-sm leading-6 text-[#77736b]">
                View and manage your legal matters, assigned lawyers,
                documents, and case communication.
            </p>
        </div>


        <a
            href="{{ route('client.cases.create') }}"
            class="inline-flex w-fit items-center gap-2 rounded-md bg-[#151515] px-3.5 py-2 text-[11px] font-medium text-[#f5f1e8] transition hover:bg-[#b99a63] hover:text-[#151515]"
        >

            <svg
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.7"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 5v14M5 12h14"
                />
            </svg>

            New Legal Matter

        </a>

    </div>


    {{-- Status message --}}
    @if(session('status'))

        <div class="rounded-lg border border-[#cddbcf] bg-[#eef5ef] px-4 py-3 text-xs text-[#52745a]">
            {{ session('status') }}
        </div>

    @endif


    {{-- Validation errors --}}
    @if($errors->any())

        <div class="rounded-lg border border-[#e0c7c3] bg-[#faf0ee] px-4 py-3">

            <p class="text-xs font-medium text-[#914f49]">
                Please correct the following:
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5 text-xs text-[#914f49]">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- Cases --}}
    <div class="overflow-hidden rounded-xl border border-[#ddd7ca] bg-[#fffdf8]">

        <div class="border-b border-[#ddd7ca] px-5 py-4">

            <h2
                class="text-xl font-semibold text-[#151515]"
                style="font-family: 'Cormorant Garamond', serif;"
            >
                Your Legal Cases
            </h2>

            <p class="mt-1 text-xs text-[#77736b]">
                {{ $cases->total() }} case{{ $cases->total() === 1 ? '' : 's' }} in your account
            </p>

        </div>


        @if($cases->count())

            <div class="overflow-x-auto">

                <table class="min-w-full text-left">

                    <thead class="border-b border-[#eeeae0] bg-[#f7f4ed]">

                        <tr>

                            <th class="px-5 py-3 text-[10px] font-medium uppercase tracking-wider text-[#77736b]">
                                Case
                            </th>

                            <th class="px-5 py-3 text-[10px] font-medium uppercase tracking-wider text-[#77736b]">
                                Lawyer
                            </th>

                            <th class="px-5 py-3 text-[10px] font-medium uppercase tracking-wider text-[#77736b]">
                                Status
                            </th>

                            <th class="px-5 py-3 text-[10px] font-medium uppercase tracking-wider text-[#77736b]">
                                Opened
                            </th>

                            <th class="px-5 py-3 text-right text-[10px] font-medium uppercase tracking-wider text-[#77736b]">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-[#eeeae0]">

                        @foreach($cases as $case)

                            <tr class="transition hover:bg-[#fcfaf5]">

                                {{-- Case --}}
                                <td class="px-5 py-4">

                                    <div class="min-w-0">

                                        <p class="break-words text-xs font-semibold text-[#151515]">
                                            {{ $case->case_type ?? 'Legal Matter' }}
                                        </p>

                                        <p class="mt-1 break-all font-mono text-[10px] text-[#99958d]">
                                            {{ $case->case_number }}
                                        </p>

                                    </div>

                                </td>


                                {{-- Lawyer --}}
                                <td class="px-5 py-4">

                                    @if($case->lawyer)

                                        <p class="text-xs font-medium text-[#555149]">
                                            {{ $case->lawyer->name }}
                                        </p>

                                        @if($case->lawyer->specialization)

                                            <p class="mt-1 text-[10px] text-[#99958d]">
                                                {{ $case->lawyer->specialization }}
                                            </p>

                                        @endif

                                    @else

                                        <span class="text-xs text-[#99958d]">
                                            Not assigned
                                        </span>

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td class="px-5 py-4">

                                    @php
                                        $status = strtolower($case->status ?? 'opened');

                                        $statusClasses = match($status) {
                                            'closed' => 'bg-[#f3e9e7] text-[#914f49]',
                                            'pending' => 'bg-[#f7f0df] text-[#9a763d]',
                                            'active', 'open', 'opened' => 'bg-[#eef5ef] text-[#52745a]',
                                            default => 'bg-[#eeeae0] text-[#77736b]',
                                        };
                                    @endphp

                                    <span
                                        class="inline-flex rounded-full px-2.5 py-1 text-[10px] font-medium {{ $statusClasses }}"
                                    >
                                        {{ ucfirst($status) }}
                                    </span>

                                </td>


                                {{-- Date --}}
                                <td class="px-5 py-4">

                                    <span class="text-xs text-[#77736b]">
                                        {{ $case->start_date?->format('M d, Y') ?? '—' }}
                                    </span>

                                </td>


                                {{-- Action --}}
                                <td class="px-5 py-4 text-right">

                                    <a
                                        href="{{ route('client.cases.show', $case) }}"
                                        class="inline-flex items-center gap-1.5 rounded-md border border-[#ddd7ca] bg-white px-3 py-1.5 text-[10px] font-medium text-[#555149] transition hover:border-[#b99a63] hover:bg-[#f4eddf] hover:text-[#9a763d]"
                                    >

                                        View Case

                                        <svg
                                            class="h-3 w-3"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.7"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="m9 5 7 7-7 7"
                                            />
                                        </svg>

                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if($cases->hasPages())

                <div class="border-t border-[#eeeae0] px-5 py-4">

                    {{ $cases->links() }}

                </div>

            @endif

        @else

            {{-- Empty state --}}
            <div class="px-5 py-14 text-center">

                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#f4eddf] text-[#9a763d]">

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M7 4.5h10A2.5 2.5 0 0 1 19.5 7v10a2.5 2.5 0 0 1-2.5 2.5H7A2.5 2.5 0 0 1 4.5 17V7A2.5 2.5 0 0 1 7 4.5Z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8 9h8M8 13h5"
                        />
                    </svg>

                </div>


                <h3 class="mt-4 text-sm font-semibold text-[#151515]">
                    No legal cases yet
                </h3>

                <p class="mx-auto mt-1 max-w-md text-xs leading-5 text-[#99958d]">
                    Start by filing a new legal matter and selecting
                    the lawyer you would like to work with.
                </p>


                <a
                    href="{{ route('client.cases.create') }}"
                    class="mt-5 inline-flex items-center gap-2 rounded-md bg-[#151515] px-3.5 py-2 text-[11px] font-medium text-[#f5f1e8] transition hover:bg-[#b99a63] hover:text-[#151515]"
                >

                    <svg
                        class="h-3.5 w-3.5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.7"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 5v14M5 12h14"
                        />
                    </svg>

                    File a Legal Matter

                </a>

            </div>

        @endif

    </div>

</div>

@endsection