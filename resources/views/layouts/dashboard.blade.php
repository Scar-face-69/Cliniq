<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Dashboard — ClinIQ')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

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
                <span class="db-nav-icon">🏠</span> Dashboard
            </a>
            <a href="/consultation/new" class="db-nav-item {{ request()->is('consultation/new') ? 'active' : '' }}">
                <span class="db-nav-icon">💬</span> New Consultation
            </a>
            <a href="/consultations" class="db-nav-item {{ request()->is('consultations') ? 'active' : '' }}">
                <span class="db-nav-icon">📋</span> History
            </a>
            <a href="/lab-reports" class="db-nav-item {{ request()->is('lab-reports') ? 'active' : '' }}">
                <span class="db-nav-icon">📄</span> Lab Reports
            </a>

            <div class="db-nav-section">Family</div>
            <a href="/family" class="db-nav-item {{ request()->is('family') ? 'active' : '' }}">
                <span class="db-nav-icon">👨‍👩‍👧</span> Members
            </a>
            <a href="/health-records" class="db-nav-item {{ request()->is('health-records') ? 'active' : '' }}">
                <span class="db-nav-icon">📊</span> Health Records
            </a>

            <div class="db-nav-section">Account</div>
            <a href="/settings" class="db-nav-item {{ request()->is('settings') ? 'active' : '' }}">
                <span class="db-nav-icon">⚙️</span> Settings
            </a>

            <form method="POST" action="/logout" style="margin:0;">
                @csrf
                <button type="submit" class="db-nav-item" style="width:100%;border:none;background:none;text-align:left;cursor:pointer;color:#64748B;font-family:inherit;font-size:13px;">
                    <span class="db-nav-icon">🚪</span> Sign out
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
