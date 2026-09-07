@extends('layouts.app') @section('title', 'Delete User') @section('content') <div class="min-h-screen bg-[#F7F4ED] py-10 px-6">
    <div class="max-w-3xl mx-auto"> {{-- Back --}} <a href="{{ route('admin.users.show', $user) }}"
            class="inline-flex items-center gap-2 mb-6 text-sm font-medium text-[#77756F] hover:text-[#11110F] transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19l-7-7 7-7" />
            </svg> Back to User Profile </a> {{-- Card --}} <div
            class="bg-white rounded-2xl border border-[#E5E2DB] shadow-sm overflow-hidden"> {{-- Header --}} <div
                class="bg-[#11110F] px-8 py-8">
                <div class="flex items-center gap-5"> {{-- Avatar --}} <div
                        class="w-16 h-16 rounded-full bg-[#C9A96E] flex items-center justify-center text-[#11110F] text-2xl font-semibold">
                        {{ strtoupper(substr($user->name, 0, 1)) }} </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-[#C9A96E] mb-1"> Delete User </p>
                        <h1 class="text-2xl font-serif text-white"> {{ $user->name }} </h1>
                        <p class="text-sm text-gray-400 mt-1"> {{ $user->email }} </p>
                    </div>
                </div>
            </div> {{-- Content --}} <div class="p-8"> {{-- Warning --}} <div
                    class="flex gap-4 p-5 rounded-xl border border-red-200 bg-red-50">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center"> <svg
                                class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v4m0 4h.01M10.29 3.86l-8.82 15A2 2 0 003.2 22h17.6a2 2 0 001.73-3.14l-8.82-15a2 2 0 00-3.42 0z" />
                            </svg> </div>
                    </div>
                    <div>
                        <h2 class="font-semibold text-red-800"> Are you sure you want to delete this user? </h2>
                        <p class="text-sm text-red-700 mt-1 leading-6"> This user will be removed from the active users
                            list. The account will be moved to the Deleted Users section and can be restored later. </p>
                    </div>
                </div> {{-- User information --}} <div class="mt-8">
                    <h2 class="text-lg font-serif text-[#11110F] mb-5"> User Information </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4"> {{-- Name --}} <div
                            class="rounded-xl border border-[#E5E2DB] p-5">
                            <p class="text-xs uppercase tracking-wider text-[#9B9992]"> Full Name </p>
                            <p class="mt-2 font-medium text-[#11110F]"> {{ $user->name }} </p>
                        </div> {{-- Email --}} <div class="rounded-xl border border-[#E5E2DB] p-5">
                            <p class="text-xs uppercase tracking-wider text-[#9B9992]"> Email </p>
                            <p class="mt-2 font-medium text-[#11110F] break-all"> {{ $user->email }} </p>
                        </div> {{-- Role --}} <div class="rounded-xl border border-[#E5E2DB] p-5">
                            <p class="text-xs uppercase tracking-wider text-[#9B9992]"> Role </p>
                            <p class="mt-2 font-medium text-[#11110F] capitalize"> {{ $user->role ?? 'User' }} </p>
                        </div> {{-- Created --}} <div class="rounded-xl border border-[#E5E2DB] p-5">
                            <p class="text-xs uppercase tracking-wider text-[#9B9992]"> Account Created </p>
                            <p class="mt-2 font-medium text-[#11110F]"> {{ $user->created_at?->format('d M Y') }} </p>
                        </div>
                    </div>
                </div> {{-- Actions --}} <div class="mt-8 pt-6 border-t border-[#E5E2DB]">
                    <div class="flex flex-col sm:flex-row gap-3 sm:justify-end"> {{-- Cancel --}} <a
                            href="{{ route('admin.users.show', $user) }}"
                            class="inline-flex justify-center items-center px-6 py-3 rounded-xl border border-[#E5E2DB] bg-white text-[#11110F] font-medium hover:bg-[#F7F4ED] transition">
                            Cancel </a> {{-- Delete --}} <form method="POST"
                            action="{{ route('admin.users.destroy', $user) }}"> @csrf @method('DELETE') <button
                                type="submit"
                                class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-6 py-3 rounded-xl bg-[#B94A48] text-white font-medium hover:bg-red-700 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h14" />
                                </svg> Yes, Delete User </button> </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> @endsection
