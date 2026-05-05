<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'ClinIQ — AI Clinical Assistant')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('css/cliniq.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}" />

    @stack('styles')
</head>
<body class="auth-body">

    @yield('content')

    @stack('scripts')
</body>
</html>
