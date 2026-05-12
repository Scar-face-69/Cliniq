<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Dashboard — ClinIQ')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('css/cliniq.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />

    @stack('styles')
</head>
<body class="dashboard-body">

<div class="dashboard-wrapper">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="db-sidebar">
        <a href="/" class="db-logo">
            <div class="db-logo-mark">+</div>
            <span class="db-logo-text">Clin<em>IQ</em></span>
        </a>

        <nav class="db-nav">
            <a href="/dashboard" class="db-nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <span class="db-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></span> Dashboard
            </a>
            <a href="/consultation/new" class="db-nav-item {{ request()->is('consultation/new') ? 'active' : '' }}">
                <span class="db-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg></span> New Consultation
            </a>
            <a href="/consultations" class="db-nav-item {{ request()->is('consultations') ? 'active' : '' }}">
                <span class="db-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg></span> History
            </a>
            <a href="/lab-reports" class="db-nav-item {{ request()->is('lab-reports') ? 'active' : '' }}">
                <span class="db-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg></span> Lab Reports
            </a>

            <div class="db-nav-section">Family</div>
            <a href="/family" class="db-nav-item {{ request()->is('family') ? 'active' : '' }}">
                <span class="db-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span> Members
            </a>
            <!-- <a href="/health-records" class="db-nav-item {{ request()->is('health-records') ? 'active' : '' }}">
                <span class="db-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></span> Health Records
            </a> -->

            <div class="db-nav-section">Account</div>
            <a href="/settings" class="db-nav-item {{ request()->is('settings') ? 'active' : '' }}">
                <span class="db-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg></span> Settings
            </a>

            <form method="POST" action="/logout" class="db-nav-logout-form">
                @csrf
                <button type="submit" class="db-nav-item db-nav-item--logout">
                    <span class="db-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg></span> Sign out
                </button>
            </form>
        </nav>

        <div class="db-user">
            <div class="db-user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div>
                <div class="db-user-name">{{ auth()->user()->name }}</div>
                <div class="db-user-role">Primary account</div>
            </div>
        </div>
    </aside>

    {{-- ===== MAIN ===== --}}
    <main class="db-main">
        @yield('content')
    </main>

</div>

@stack('scripts')
</body>
</html>
