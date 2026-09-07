@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#f3f0e9] px-6 py-10">

    <div class="mx-auto max-w-7xl">

        <div class="mb-8 flex items-center justify-between">

            <div>

                <p class="text-sm font-medium uppercase tracking-[0.2em] text-[#c9a45c]">
                    Administration
                </p>

                <h1 class="mt-2 text-3xl font-semibold text-[#111111]">
                    Appointments
                </h1>

                <p class="mt-2 text-sm text-gray-600">
                    All scheduled appointments.
                </p>

            </div>

            <a
                href="{{ route('admin.dashboard') }}"
                class="rounded-lg border border-[#111111] px-5 py-2.5 text-sm font-medium text-[#111111] transition hover:bg-[#111111] hover:text-white"
            >
                ← Dashboard
            </a>

        </div>


        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-[#111111]">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#c9a45c]">
                                ID
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#c9a45c]">
                                Client
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#c9a45c]">
                                Lawyer
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#c9a45c]">
                                Case
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#c9a45c]">
                                Status
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#c9a45c]">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @forelse ($appointments as $appointment)

                            <tr class="transition hover:bg-[#faf9f6]">

                                <td class="px-6 py-4 text-sm text-gray-500">
                                    #{{ $appointment->id }}
                                </td>

                                <td class="px-6 py-4">

                                    <div class="text-sm font-medium text-[#111111]">
                                        {{ $appointment->client?->name ?? '—' }}
                                    </div>

                                    <div class="text-xs text-gray-500">
                                        {{ $appointment->client?->email ?? '' }}
                                    </div>

                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $appointment->lawyer?->name ?? '—' }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $appointment->case?->case_number ?? '—' }}
                                </td>

                                <td class="px-6 py-4">

                                    <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium capitalize text-gray-700">
                                        {{ $appointment->status ?? 'Pending' }}
                                    </span>

                                </td>

                                <td class="px-6 py-4">

                                    <a
                                        href="{{ route('admin.appointments.show', $appointment) }}"
                                        class="text-sm font-medium text-[#9a783b] hover:underline"
                                    >
                                        View
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="px-6 py-12 text-center text-sm text-gray-500"
                                >
                                    No appointments found.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($appointments->hasPages())

                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $appointments->links() }}
                </div>

            @endif

        </div>

    </div>

</div>

@endsection