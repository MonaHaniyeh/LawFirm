@php
    $user = auth()->user();
    $role = $user?->role;
@endphp

<aside class="sidebar" id="sidebar">

    {{-- BRAND --}}
    <div class="brand">
        <div class="brand-title">Law Firm</div>
        <div class="brand-subtitle">Legal Workspace</div>
    </div>


    {{-- NAVIGATION --}}
    <nav class="sidebar-nav">

        {{-- =====================================================
             ADMIN
        ====================================================== --}}
        @if ($role === 'admin')

            <div class="nav-section">

                <div class="nav-label">Management</div>

                {{-- Dashboard --}}
                @if (Route::has('admin.dashboard'))
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7" rx="1" />
                                <rect x="14" y="3" width="7" height="7" rx="1" />
                                <rect x="3" y="14" width="7" height="7" rx="1" />
                                <rect x="14" y="14" width="7" height="7" rx="1" />
                            </svg>
                        </span>

                        <span>Dashboard</span>
                    </a>
                @endif


                {{-- Users --}}
                @if (Route::has('admin.users.index'))
                    <a href="{{ route('admin.users.index') }}"
                        class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="3.5" />
                                <path d="M4.5 21c1-4.5 3.7-6.5 7.5-6.5s6.5 2 7.5 6.5" />
                            </svg>
                        </span>

                        <span>Users</span>
                    </a>
                @endif


                {{-- Lawyers --}}
                @if (Route::has('admin.lawyers.index'))
                    <a href="{{ route('admin.lawyers.index') }}"
                        class="nav-link {{ request()->routeIs('admin.lawyers.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="7" r="3" />
                                <path d="M5 21c.8-4 3.1-6 7-6s6.2 2 7 6" />
                                <path d="M8 11h8" />
                            </svg>
                        </span>

                        <span>Lawyers</span>
                    </a>
                @endif


                {{-- Clients --}}
                @if (Route::has('admin.clients.index'))
                    <a href="{{ route('admin.clients.index') }}"
                        class="nav-link {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="8" r="3" />
                                <path d="M3 21c.6-3.7 2.6-5.5 6-5.5s5.4 1.8 6 5.5" />
                                <circle cx="17" cy="9" r="2.5" />
                                <path d="M16 15.5c2.7.4 4.2 2.1 4.8 5" />
                            </svg>
                        </span>

                        <span>Clients</span>
                    </a>
                @endif


                {{-- Cases --}}
                @if (Route::has('admin.cases.index'))
                    <a href="{{ route('admin.cases.index') }}"
                        class="nav-link {{ request()->routeIs('admin.cases.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="6" width="18" height="14" rx="2" />
                                <path d="M8 6V4.5A1.5 1.5 0 0 1 9.5 3h5A1.5 1.5 0 0 1 16 4.5V6" />
                                <path d="M3 11h18" />
                                <path d="M10 11v2h4v-2" />
                            </svg>
                        </span>

                        <span>Cases</span>
                    </a>
                @endif


                {{-- Appointments --}}
                @if (Route::has('admin.appointments.index'))
                    <a href="{{ route('admin.appointments.index') }}"
                        class="nav-link {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4.5" width="18" height="17" rx="2" />
                                <path d="M8 2.5v4" />
                                <path d="M16 2.5v4" />
                                <path d="M3 9h18" />
                                <path d="M8 13h3" />
                                <path d="M8 17h5" />
                            </svg>
                        </span>

                        <span>Appointments</span>
                    </a>
                @endif


                {{-- Documents --}}
                @if (Route::has('admin.documents.index'))
                    <a href="{{ route('admin.documents.index') }}"
                        class="nav-link {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 3h8l4 4v14H6z" />
                                <path d="M14 3v4h4" />
                                <path d="M9 12h6" />
                                <path d="M9 16h6" />
                                <path d="M9 8h2" />
                            </svg>
                        </span>

                        <span>Documents</span>
                    </a>
                @endif


                {{-- Billing --}}
                @if (Route::has('admin.billing.index'))
                    <a href="{{ route('admin.billing.index') }}"
                        class="nav-link {{ request()->routeIs('admin.billing.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="5" width="18" height="14" rx="2" />
                                <path d="M3 10h18" />
                                <path d="M7 15h4" />
                            </svg>
                        </span>

                        <span>Billing</span>
                    </a>
                @endif


                {{-- Communication --}}
                @if (Route::has('admin.communication.index'))
                    <a href="{{ route('admin.communication.index') }}"
                        class="nav-link {{ request()->routeIs('admin.communication.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M4 5.5A2.5 2.5 0 0 1 6.5 3h11A2.5 2.5 0 0 1 20 5.5v8a2.5 2.5 0 0 1-2.5 2.5H10l-5 4v-4.5a2.5 2.5 0 0 1-1-2z" />
                                <path d="M8 8h8" />
                                <path d="M8 12h5" />
                            </svg>
                        </span>

                        <span>Communication</span>
                    </a>
                @endif


                {{-- Activity Log --}}
                @if (Route::has('admin.activity.index'))
                    <a href="{{ route('admin.activity.index') }}"
                        class="nav-link {{ request()->routeIs('admin.activity.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 12h4l2.5-7 4 14 2.5-7H21" />
                            </svg>
                        </span>

                        <span>Activity Log</span>
                    </a>
                @endif

            </div>


            {{-- ADMIN ACCOUNT --}}
            <div class="nav-section">

                <div class="nav-label">Account</div>

                {{-- Settings --}}
                @if (Route::has('admin.settings.edit'))
                    <a href="{{ route('admin.settings.edit') }}"
                        class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 262.394 262.394" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M245.63,103.39h-9.91c-2.486-9.371-6.197-18.242-10.955-26.432l7.015-7.015c6.546-6.546,6.546-17.159,0-23.705
                                    l-15.621-15.621c-6.546-6.546-17.159-6.546-23.705,0l-7.015,7.015c-8.19-4.758-17.061-8.468-26.432-10.955v-9.914
                                    C159.007,7.505,151.502,0,142.244,0h-22.091c-9.258,0-16.763,7.505-16.763,16.763v9.914c-9.37,2.486-18.242,6.197-26.431,10.954
                                    l-7.016-7.015c-6.546-6.546-17.159-6.546-23.705,0.001L30.618,46.238c-6.546,6.546-6.546,17.159,0,23.705l7.014,7.014
                                    c-4.758,8.19-8.469,17.062-10.955,26.433h-9.914c-9.257,0-16.762,7.505-16.762,16.763v22.09c0,9.258,7.505,16.763,16.762,16.763
                                    h9.914c2.487,9.371,6.198,18.243,10.956,26.433l-7.015,7.015c-6.546,6.546-6.546,17.159,0,23.705l15.621,15.621
                                    c6.546,6.546,17.159,6.546,23.705,0l7.016-7.016c8.189,4.758,17.061,8.469,26.431,10.955v9.913c0,9.258,7.505,16.763,16.763,16.763
                                    h22.091c9.258,0,16.763-7.505,16.763-16.763v-9.913c9.371-2.487,18.242-6.198,26.432-10.956l7.016,7.017
                                    c6.546,6.546,17.159,6.546,23.705,0l15.621-15.621c3.145-3.144,4.91-7.407,4.91-11.853s-1.766-8.709-4.91-11.853l-7.016-7.016
                                    c4.758-8.189,8.468-17.062,10.955-26.432h9.91c9.258,0,16.763-7.505,16.763-16.763v-22.09
                                    C262.393,110.895,254.888,103.39,245.63,103.39z M131.198,191.194c-33.083,0-59.998-26.915-59.998-59.997
                                    c0-33.083,26.915-59.998,59.998-59.998s59.998,26.915,59.998,59.998C191.196,164.279,164.281,191.194,131.198,191.194z" />
                                <path d="M131.198,101.199c-16.541,0-29.998,13.457-29.998,29.998c0,16.54,13.457,29.997,29.998,29.997s29.998-13.457,29.998-29.997
                                    C161.196,114.656,147.739,101.199,131.198,101.199z" />
                            </svg>
                        </span>

                        <span>Settings</span>
                    </a>
                @endif


                {{-- Password --}}
                @if (Route::has('admin.password.edit'))
                    <a href="{{ route('admin.password.edit') }}"
                        class="nav-link {{ request()->routeIs('admin.password.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="4" y="10" width="16" height="11" rx="2" />
                                <path d="M8 10V7a4 4 0 0 1 8 0v3" />
                                <circle cx="12" cy="15.5" r="1" />
                                <path d="M12 16.5v2" />
                            </svg>
                        </span>

                        <span>Change Password</span>
                    </a>
                @endif

            </div>


            {{-- =====================================================
             LAWYER
        ====================================================== --}}
        @elseif ($role === 'lawyer')
            <div class="nav-section">

                <div class="nav-label">Workspace</div>

                {{-- Dashboard --}}
                @if (Route::has('lawyer.dashboard'))
                    <a href="{{ route('lawyer.dashboard') }}"
                        class="nav-link {{ request()->routeIs('lawyer.dashboard') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7" rx="1" />
                                <rect x="14" y="3" width="7" height="7" rx="1" />
                                <rect x="3" y="14" width="7" height="7" rx="1" />
                                <rect x="14" y="14" width="7" height="7" rx="1" />
                            </svg>
                        </span>

                        <span>Dashboard</span>
                    </a>
                @endif


                {{-- My Cases --}}
                @if (Route::has('lawyer.cases.index'))
                    <a href="{{ route('lawyer.cases.index') }}"
                        class="nav-link {{ request()->routeIs('lawyer.cases.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 3h10l4 4v14H5z" />
                                <path d="M15 3v5h4" />
                                <path d="M8 12h8" />
                                <path d="M8 16h6" />
                            </svg>
                        </span>

                        <span>My Cases</span>
                    </a>
                @endif


                {{-- Appointments --}}
                @if (Route::has('lawyer.appointments.index'))
                    <a href="{{ route('lawyer.appointments.index') }}"
                        class="nav-link {{ request()->routeIs('lawyer.appointments.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4.5" width="18" height="17" rx="2" />
                                <path d="M8 2.5v4" />
                                <path d="M16 2.5v4" />
                                <path d="M3 9h18" />
                                <path d="M8 13h3" />
                                <path d="M8 17h5" />
                            </svg>
                        </span>

                        <span>Appointments</span>
                    </a>
                @endif


                {{-- Messages --}}
                @if (Route::has('lawyer.messages.index'))
                    <a href="{{ route('lawyer.messages.index') }}"
                        class="nav-link {{ request()->routeIs('lawyer.messages.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M4 5.5A2.5 2.5 0 0 1 6.5 3h11A2.5 2.5 0 0 1 20 5.5v8a2.5 2.5 0 0 1-2.5 2.5H10l-5 4v-4.5a2.5 2.5 0 0 1-1-2z" />
                                <path d="M8 8h8" />
                                <path d="M8 12h5" />
                            </svg>
                        </span>

                        <span>Messages</span>
                    </a>
                @endif

            </div>


            {{-- LAWYER ACCOUNT --}}
            <div class="nav-section">

                <div class="nav-label">Account</div>

                {{-- Settings --}}
                @if (Route::has('lawyer.settings.edit'))
                    <a href="{{ route('lawyer.settings.edit') }}"
                        class="nav-link {{ request()->routeIs('lawyer.settings.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 262.394 262.394" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M245.63,103.39h-9.91c-2.486-9.371-6.197-18.242-10.955-26.432l7.015-7.015c6.546-6.546,6.546-17.159,0-23.705
                                    l-15.621-15.621c-6.546-6.546-17.159-6.546-23.705,0l-7.015,7.015c-8.19-4.758-17.061-8.468-26.432-10.955v-9.914
                                    C159.007,7.505,151.502,0,142.244,0h-22.091c-9.258,0-16.763,7.505-16.763,16.763v9.914c-9.37,2.486-18.242,6.197-26.431,10.954
                                    l-7.016-7.015c-6.546-6.546-17.159-6.546-23.705,0.001L30.618,46.238c-6.546,6.546-6.546,17.159,0,23.705l7.014,7.014
                                    c-4.758,8.19-8.469,17.062-10.955,26.433h-9.914c-9.257,0-16.762,7.505-16.762,16.763v22.09c0,9.258,7.505,16.763,16.762,16.763
                                    h9.914c2.487,9.371,6.198,18.243,10.956,26.433l-7.015,7.015c-6.546,6.546-6.546,17.159,0,23.705l15.621,15.621
                                    c6.546,6.546,17.159,6.546,23.705,0l7.016-7.016c8.189,4.758,17.061,8.469,26.431,10.955v9.913c0,9.258,7.505,16.763,16.763,16.763
                                    h22.091c9.258,0,16.763-7.505,16.763-16.763v-9.913c9.371-2.487,18.242-6.198,26.432-10.956l7.016,7.017
                                    c6.546,6.546,17.159,6.546,23.705,0l15.621-15.621c3.145-3.144,4.91-7.407,4.91-11.853s-1.766-8.709-4.91-11.853l-7.016-7.016
                                    c4.758-8.189,8.468-17.062,10.955-26.432h9.91c9.258,0,16.763-7.505,16.763-16.763v-22.09
                                    C262.393,110.895,254.888,103.39,245.63,103.39z M131.198,191.194c-33.083,0-59.998-26.915-59.998-59.997
                                    c0-33.083,26.915-59.998,59.998-59.998s59.998,26.915,59.998,59.998C191.196,164.279,164.281,191.194,131.198,191.194z" />
                                <path d="M131.198,101.199c-16.541,0-29.998,13.457-29.998,29.998c0,16.54,13.457,29.997,29.998,29.997s29.998-13.457,29.998-29.997
                                    C161.196,114.656,147.739,101.199,131.198,101.199z" />
                            </svg>
                        </span>

                        <span>Settings</span>
                    </a>
                @endif


                {{-- Password --}}
                @if (Route::has('lawyer.password.edit'))
                    <a href="{{ route('lawyer.password.edit') }}"
                        class="nav-link {{ request()->routeIs('lawyer.password.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="4" y="10" width="16" height="11" rx="2" />
                                <path d="M8 10V7a4 4 0 0 1 8 0v3" />
                                <circle cx="12" cy="15.5" r="1" />
                                <path d="M12 16.5v2" />
                            </svg>
                        </span>

                        <span>Change Password</span>
                    </a>
                @endif

            </div>


            {{-- =====================================================
             CLIENT
        ====================================================== --}}
        @elseif ($role === 'client')
            <div class="nav-section">

                <div class="nav-label">Workspace</div>

                {{-- Dashboard --}}
                @if (Route::has('client.dashboard'))
                    <a href="{{ route('client.dashboard') }}"
                        class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7" rx="1" />
                                <rect x="14" y="3" width="7" height="7" rx="1" />
                                <rect x="3" y="14" width="7" height="7" rx="1" />
                                <rect x="14" y="14" width="7" height="7" rx="1" />
                            </svg>
                        </span>

                        <span>Dashboard</span>
                    </a>
                @endif


                {{-- My Cases --}}
                @if (Route::has('client.cases.index'))
                    <a href="{{ route('client.cases.index') }}"
                        class="nav-link {{ request()->routeIs('client.cases.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M3 6.5A2.5 2.5 0 0 1 5.5 4H10l2 2h6.5A2.5 2.5 0 0 1 21 8.5v9A2.5 2.5 0 0 1 18.5 20h-13A2.5 2.5 0 0 1 3 17.5z" />
                                <path d="M3 9h18" />
                            </svg>
                        </span>

                        <span>My Cases</span>
                    </a>
                @endif


                {{-- Appointments --}}
                @if (Route::has('client.appointments'))
                    <a href="{{ route('client.appointments') }}"
                        class="nav-link {{ request()->routeIs('client.appointments') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4.5" width="18" height="17" rx="2" />
                                <path d="M8 2.5v4" />
                                <path d="M16 2.5v4" />
                                <path d="M3 9h18" />
                                <path d="M8 13h3" />
                                <path d="M8 17h5" />
                            </svg>
                        </span>

                        <span>Appointments</span>
                    </a>
                @endif


                {{-- Messages --}}
                @if (Route::has('client.messages'))
                    <a href="{{ route('client.messages') }}"
                        class="nav-link {{ request()->routeIs('client.messages') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M4 5.5A2.5 2.5 0 0 1 6.5 3h11A2.5 2.5 0 0 1 20 5.5v8a2.5 2.5 0 0 1-2.5 2.5H10l-5 4v-4.5a2.5 2.5 0 0 1-1-2z" />
                                <path d="M8 8h8" />
                                <path d="M8 12h5" />
                            </svg>
                        </span>

                        <span>Messages</span>
                    </a>
                @endif

            </div>


            {{-- CLIENT ACCOUNT --}}
            <div class="nav-section">

                <div class="nav-label">Account</div>

                {{-- Settings --}}
                @if (Route::has('client.settings.edit'))
                    <a href="{{ route('client.settings.edit') }}"
                        class="nav-link {{ request()->routeIs('client.settings.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 262.394 262.394" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M245.63,103.39h-9.91c-2.486-9.371-6.197-18.242-10.955-26.432l7.015-7.015c6.546-6.546,6.546-17.159,0-23.705
                                    l-15.621-15.621c-6.546-6.546-17.159-6.546-23.705,0l-7.015,7.015c-8.19-4.758-17.061-8.468-26.432-10.955v-9.914
                                    C159.007,7.505,151.502,0,142.244,0h-22.091c-9.258,0-16.763,7.505-16.763,16.763v9.914c-9.37,2.486-18.242,6.197-26.431,10.954
                                    l-7.016-7.015c-6.546-6.546-17.159-6.546-23.705,0.001L30.618,46.238c-6.546,6.546-6.546,17.159,0,23.705l7.014,7.014
                                    c-4.758,8.19-8.469,17.062-10.955,26.433h-9.914c-9.257,0-16.762,7.505-16.762,16.763v22.09c0,9.258,7.505,16.763,16.762,16.763
                                    h9.914c2.487,9.371,6.198,18.243,10.956,26.433l-7.015,7.015c-6.546,6.546-6.546,17.159,0,23.705l15.621,15.621
                                    c6.546,6.546,17.159,6.546,23.705,0l7.016-7.016c8.189,4.758,17.061,8.469,26.431,10.955v9.913c0,9.258,7.505,16.763,16.763,16.763
                                    h22.091c9.258,0,16.763-7.505,16.763-16.763v-9.913c9.371-2.487,18.242-6.198,26.432-10.956l7.016,7.017
                                    c6.546,6.546,17.159,6.546,23.705,0l15.621-15.621c3.145-3.144,4.91-7.407,4.91-11.853s-1.766-8.709-4.91-11.853l-7.016-7.016
                                    c4.758-8.189,8.468-17.062,10.955-26.432h9.91c9.258,0,16.763-7.505,16.763-16.763v-22.09
                                    C262.393,110.895,254.888,103.39,245.63,103.39z M131.198,191.194c-33.083,0-59.998-26.915-59.998-59.997
                                    c0-33.083,26.915-59.998,59.998-59.998s59.998,26.915,59.998,59.998C191.196,164.279,164.281,191.194,131.198,191.194z" />
                                <path d="M131.198,101.199c-16.541,0-29.998,13.457-29.998,29.998c0,16.54,13.457,29.997,29.998,29.997s29.998-13.457,29.998-29.997
                                    C161.196,114.656,147.739,101.199,131.198,101.199z" />
                            </svg>
                        </span>

                        <span>Settings</span>
                    </a>
                @endif


                {{-- Password --}}
                @if (Route::has('client.password.edit'))
                    <a href="{{ route('client.password.edit') }}"
                        class="nav-link {{ request()->routeIs('client.password.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="4" y="10" width="16" height="11" rx="2" />
                                <path d="M8 10V7a4 4 0 0 1 8 0v3" />
                                <circle cx="12" cy="15.5" r="1" />
                                <path d="M12 16.5v2" />
                            </svg>
                        </span>

                        <span>Change Password</span>
                    </a>
                @endif

            </div>


            {{-- =====================================================
             ACCOUNTANT
        ====================================================== --}}
        @elseif ($role === 'accountant')
            <div class="nav-section">

                <div class="nav-label">Workspace</div>

                {{-- Dashboard --}}
                @if (Route::has('accountant.dashboard'))
                    <a href="{{ route('accountant.dashboard') }}"
                        class="nav-link {{ request()->routeIs('accountant.dashboard') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7" rx="1" />
                                <rect x="14" y="3" width="7" height="7" rx="1" />
                                <rect x="3" y="14" width="7" height="7" rx="1" />
                                <rect x="14" y="14" width="7" height="7" rx="1" />
                            </svg>
                        </span>

                        <span>Dashboard</span>
                    </a>
                @endif


                {{-- Invoices --}}
                @if (Route::has('accountant.invoices.index'))
                    <a href="{{ route('accountant.invoices.index') }}"
                        class="nav-link {{ request()->routeIs('accountant.invoices.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 3h12v18l-3-2-3 2-3-2-3 2z" />
                                <path d="M9 8h6" />
                                <path d="M9 12h6" />
                                <path d="M9 16h3" />
                            </svg>
                        </span>

                        <span>Invoices</span>
                    </a>
                @endif


                {{-- ACCOUNTANT ACCOUNT --}}
                <div class="nav-section">

                    <div class="nav-label">Account</div>

                    {{-- Settings --}}
                    @if (Route::has('accountant.settings.edit'))
                        <a href="{{ route('accountant.settings.edit') }}"
                            class="nav-link {{ request()->routeIs('accountant.settings.*') ? 'active' : '' }}">
                            <span class="nav-icon">
                                <svg viewBox="0 0 262.394 262.394" fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M245.63,103.39h-9.91c-2.486-9.371-6.197-18.242-10.955-26.432l7.015-7.015c6.546-6.546,6.546-17.159,0-23.705
                                    l-15.621-15.621c-6.546-6.546-17.159-6.546-23.705,0l-7.015,7.015c-8.19-4.758-17.061-8.468-26.432-10.955v-9.914
                                    C159.007,7.505,151.502,0,142.244,0h-22.091c-9.258,0-16.763,7.505-16.763,16.763v9.914c-9.37,2.486-18.242,6.197-26.431,10.954
                                    l-7.016-7.015c-6.546-6.546-17.159-6.546-23.705,0.001L30.618,46.238c-6.546,6.546-6.546,17.159,0,23.705l7.014,7.014
                                    c-4.758,8.19-8.469,17.062-10.955,26.433h-9.914c-9.257,0-16.762,7.505-16.762,16.763v22.09c0,9.258,7.505,16.763,16.762,16.763
                                    h9.914c2.487,9.371,6.198,18.243,10.956,26.433l-7.015,7.015c-6.546,6.546-6.546,17.159,0,23.705l15.621,15.621
                                    c6.546,6.546,17.159,6.546,23.705,0l7.016-7.016c8.189,4.758,17.061,8.469,26.431,10.955v9.913c0,9.258,7.505,16.763,16.763,16.763
                                    h22.091c9.258,0,16.763-7.505,16.763-16.763v-9.913c9.371-2.487,18.242-6.198,26.432-10.956l7.016,7.017
                                    c6.546,6.546,17.159,6.546,23.705,0l15.621-15.621c3.145-3.144,4.91-7.407,4.91-11.853s-1.766-8.709-4.91-11.853l-7.016-7.016
                                    c4.758-8.189,8.468-17.062,10.955-26.432h9.91c9.258,0,16.763-7.505,16.763-16.763v-22.09
                                    C262.393,110.895,254.888,103.39,245.63,103.39z M131.198,191.194c-33.083,0-59.998-26.915-59.998-59.997
                                    c0-33.083,26.915-59.998,59.998-59.998s59.998,26.915,59.998,59.998C191.196,164.279,164.281,191.194,131.198,191.194z" />
                                    <path d="M131.198,101.199c-16.541,0-29.998,13.457-29.998,29.998c0,16.54,13.457,29.997,29.998,29.997s29.998-13.457,29.998-29.997
                                    C161.196,114.656,147.739,101.199,131.198,101.199z" />
                                </svg>
                            </span>

                            <span>Settings</span>
                        </a>
                    @endif


                    {{-- Password --}}
                    @if (Route::has('accountant.password.edit'))
                        <a href="{{ route('accountant.password.edit') }}"
                            class="nav-link {{ request()->routeIs('accountant.password.*') ? 'active' : '' }}">
                            <span class="nav-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="4" y="10" width="16" height="11" rx="2" />
                                    <path d="M8 10V7a4 4 0 0 1 8 0v3" />
                                    <circle cx="12" cy="15.5" r="1" />
                                    <path d="M12 16.5v2" />
                                </svg>
                            </span>

                            <span>Change Password</span>
                        </a>
                    @endif

                </div>

        @endif

    </nav>


    {{-- =====================================================
         PROFILE + LOGOUT
    ====================================================== --}}

    <div class="sidebar-bottom">

        {{-- Profile --}}
        <div class="profile-mini">

            <div class="avatar">
                {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
            </div>

            <div class="profile-details">

                <div class="profile-name">
                    {{ $user?->name ?? 'User' }}
                </div>

                <div class="profile-role">
                    {{ ucfirst($role ?? 'User') }}
                </div>

            </div>

        </div>


        {{-- Logout --}}
        @if (Route::has('logout'))
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf

                <button type="submit" class="logout-button">

                    <span class="logout-icon">

                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 17l5-5-5-5" />
                            <path d="M15 12H3" />
                            <path d="M21 3v18" />
                        </svg>

                    </span>

                    <span>Logout</span>

                </button>

            </form>
        @endif

    </div>

</aside>
