<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page-title', 'Admin') — Cliniq</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    <aside class="fixed left-0 top-0 z-40 flex h-screen w-64 flex-col border-r border-slate-200 bg-white">
        <div class="border-b border-slate-100 px-4 py-5">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-bold text-xl text-blue-600">
                <span class="text-2xl leading-none">+</span>
                <span>Cliniq</span>
            </a>
        </div>
        <nav class="flex flex-1 flex-col gap-1 px-3 py-4">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 font-medium text-blue-600' : 'text-slate-700 hover:bg-slate-100' }}">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.users') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition duration-150 {{ request()->routeIs('admin.users') ? 'bg-blue-50 font-medium text-blue-600' : 'text-slate-700 hover:bg-slate-100' }}">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
                Users
            </a>
            <a href="{{ route('admin.consultations') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition duration-150 {{ request()->routeIs('admin.consultations') ? 'bg-blue-50 font-medium text-blue-600' : 'text-slate-700 hover:bg-slate-100' }}">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                </svg>
                Consultations
            </a>
            <a href="{{ route('admin.labReports') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition duration-150 {{ request()->routeIs('admin.labReports') ? 'bg-blue-50 font-medium text-blue-600' : 'text-slate-700 hover:bg-slate-100' }}">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                Lab Reports
            </a>
        </nav>
        <div class="mt-auto border-t border-slate-200 px-3 py-4">
            {{-- <a href="{{ route('dashboard') }}" class="mb-2 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-700 transition duration-150 hover:bg-slate-100">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                </svg>
                Back to App --}}
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm text-slate-700 transition duration-150 hover:bg-slate-100">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    Log out
                </button>
            </form>
        </div>
    </aside>

    <div class="ml-64 min-h-screen bg-slate-50">
        <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-6">
            <h1 class="font-semibold text-slate-900">@yield('page-title')</h1>
            <div class="flex items-center gap-3">
                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">Admin</span>
                <span class="text-sm text-slate-600">{{ auth()->user()->name }}</span>
            </div>
        </header>
        <div class="p-6">
            @yield('content')
        </div>
    </div>
</body>
</html>
