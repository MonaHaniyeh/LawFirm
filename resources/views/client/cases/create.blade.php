@extends('layouts.app')

@section('title', 'New Legal Matter')

@section('breadcrumb')
    <a
        href="{{ route('client.cases.index') }}"
        class="transition hover:text-[#9a763d]"
    >
        My Cases
    </a>

    <span class="mx-2 text-[#bbb5a9]">/</span>

    <span>New Legal Matter</span>
@endsection

@section('content')

<div
    class="mx-auto max-w-4xl"
    x-data="{
        description: @js(old('description', ''))
    }"
>

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="mb-6">

        <p class="text-[10px] font-medium uppercase tracking-[0.18em] text-[#b99a63]">
            New Request
        </p>

        <h1
            class="mt-1 text-3xl font-semibold text-[#151515]"
            style="font-family: 'Cormorant Garamond', serif;"
        >
            File a Legal Matter
        </h1>

        <p class="mt-1 max-w-2xl text-sm leading-6 text-[#77736b]">
            Provide the details of your legal matter so the firm can
            begin reviewing your request.
        </p>

    </div>


    {{-- =========================================================
        ERRORS
    ========================================================== --}}
    @if($errors->any())

        <div class="mb-6 rounded-lg border border-[#e0c7c3] bg-[#faf0ee] px-4 py-3">

            <p class="text-xs font-medium text-[#914f49]">
                Please correct the following:
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5 text-xs text-[#914f49]">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- =========================================================
        FORM
    ========================================================== --}}
    <form
        method="POST"
        action="{{ route('client.cases.store') }}"
        class="overflow-hidden rounded-xl border border-[#ddd7ca] bg-[#fffdf8]"
    >

        @csrf


        {{-- =====================================================
            FORM HEADER
        ====================================================== --}}
        <div class="border-b border-[#ddd7ca] px-5 py-5 sm:px-6">

            <h2
                class="text-xl font-semibold text-[#151515]"
                style="font-family: 'Cormorant Garamond', serif;"
            >
                Case Information
            </h2>

            <p class="mt-1 text-xs text-[#77736b]">
                Complete the information below to submit your legal matter.
            </p>

        </div>


        {{-- =====================================================
            FORM FIELDS
        ====================================================== --}}
        <div class="space-y-6 px-5 py-6 sm:px-6">


            {{-- =================================================
                CASE TITLE
            ================================================== --}}
            <div>

                <label
                    for="title"
                    class="mb-1.5 block text-xs font-medium text-[#555149]"
                >
                    Case Title
                    <span class="text-[#914f49]">*</span>
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    required
                    maxlength="255"
                    placeholder="e.g. Employment contract dispute"
                    class="block w-full rounded-md border border-[#ddd7ca] bg-white px-3 py-2.5 text-xs text-[#555149] outline-none transition placeholder:text-[#aaa59b] focus:border-[#b99a63] focus:ring-1 focus:ring-[#b99a63]"
                >

                @error('title')

                    <p class="mt-1.5 text-[10px] text-[#914f49]">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- =================================================
                LEGAL CATEGORY
            ================================================== --}}
            <div>

                <label
                    for="case_type"
                    class="mb-1.5 block text-xs font-medium text-[#555149]"
                >
                    Legal Category
                    <span class="text-[#914f49]">*</span>
                </label>

                <select
                    id="case_type"
                    name="case_type"
                    required
                    class="block w-full rounded-md border border-[#ddd7ca] bg-white px-3 py-2.5 text-xs text-[#555149] outline-none transition focus:border-[#b99a63] focus:ring-1 focus:ring-[#b99a63]"
                >

                    <option value="">
                        Select a legal category
                    </option>

                    @foreach($caseTypes as $type)

                        <option
                            value="{{ $type }}"
                            @selected(old('case_type') === $type)
                        >
                            {{ $type }}
                        </option>

                    @endforeach

                </select>

                @error('case_type')

                    <p class="mt-1.5 text-[10px] text-[#914f49]">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- =================================================
                LAWYER
            ================================================== --}}
            <div>

                <label
                    for="lawyer_id"
                    class="mb-1.5 block text-xs font-medium text-[#555149]"
                >
                    Preferred Lawyer
                    <span class="text-[#914f49]">*</span>
                </label>

                <select
                    id="lawyer_id"
                    name="lawyer_id"
                    required
                    class="block w-full rounded-md border border-[#ddd7ca] bg-white px-3 py-2.5 text-xs text-[#555149] outline-none transition focus:border-[#b99a63] focus:ring-1 focus:ring-[#b99a63]"
                >

                    <option value="">
                        Select a lawyer
                    </option>

                    @foreach($lawyers as $lawyer)

                        <option
                            value="{{ $lawyer->id }}"
                            @selected(
                                (string) old('lawyer_id') ===
                                (string) $lawyer->id
                            )
                        >
                            {{ $lawyer->name }}

                            @if($lawyer->specialization)
                                — {{ $lawyer->specialization }}
                            @endif

                        </option>

                    @endforeach

                </select>

                @error('lawyer_id')

                    <p class="mt-1.5 text-[10px] text-[#914f49]">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- =================================================
                DESCRIPTION
            ================================================== --}}
            <div>

                <div class="mb-1.5 flex items-center justify-between gap-3">

                    <label
                        for="description"
                        class="text-xs font-medium text-[#555149]"
                    >
                        Describe Your Legal Matter
                        <span class="text-[#914f49]">*</span>
                    </label>

                    <span class="shrink-0 text-[10px] text-[#99958d]">
                        <span x-text="description.length">0</span>
                        characters
                    </span>

                </div>


                <textarea
                    id="description"
                    name="description"
                    x-model="description"
                    required
                    rows="9"
                    minlength="20"
                    maxlength="5000"
                    placeholder="Please explain your legal matter, including the main issue, relevant circumstances, and any important details the lawyer should know..."
                    class="block w-full resize-y rounded-md border border-[#ddd7ca] bg-white px-3 py-3 text-xs leading-6 text-[#555149] outline-none transition placeholder:text-[#aaa59b] focus:border-[#b99a63] focus:ring-1 focus:ring-[#b99a63]"
                ></textarea>


                <div class="mt-2 flex flex-col gap-1 text-[10px] text-[#99958d] sm:flex-row sm:items-center sm:justify-between">

                    <span>
                        Please provide at least 20 characters.
                    </span>

                    <span>
                        Maximum 5,000 characters.
                    </span>

                </div>


                @error('description')

                    <p class="mt-1.5 text-[10px] text-[#914f49]">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- =================================================
                NOTICE
            ================================================== --}}
            <div class="rounded-lg border border-[#e6dcc8] bg-[#f8f3e8] px-4 py-4">

                <div class="flex gap-3">

                    <div class="mt-0.5 shrink-0 text-[#9a763d]">

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.6"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 9v3.5m0 3.5h.01M10.3 4.5h3.4L20 18.5H4L10.3 4.5Z"
                            />

                        </svg>

                    </div>


                    <div>

                        <p class="text-xs font-medium text-[#555149]">
                            Before submitting
                        </p>

                        <p class="mt-1 text-[10px] leading-5 text-[#77736b]">
                            Please make sure the information provided is accurate.
                            Your selected lawyer will be able to review the matter
                            after it has been filed.
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
            ACTIONS
        ====================================================== --}}
        <div class="flex flex-col-reverse gap-2 border-t border-[#ddd7ca] bg-[#f7f4ed] px-5 py-4 sm:flex-row sm:justify-end sm:px-6">

            {{-- Cancel --}}
            <a
                href="{{ route('client.cases.index') }}"
                class="inline-flex items-center justify-center rounded-md border border-[#ddd7ca] bg-white px-3.5 py-2 text-[11px] font-medium text-[#555149] transition hover:border-[#b99a63] hover:bg-[#f4eddf]"
            >
                Cancel
            </a>


            {{-- Submit --}}
            <button
                type="submit"
                class="inline-flex items-center justify-center gap-1.5 rounded-md bg-[#151515] px-3.5 py-2 text-[11px] font-medium text-[#f5f1e8] transition hover:bg-[#b99a63] hover:text-[#151515]"
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

                File Legal Matter

            </button>

        </div>

    </form>

</div>

@endsection