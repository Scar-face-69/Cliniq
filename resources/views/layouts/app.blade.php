<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="ClinIQ — AI-powered clinical assistant for families. Safe, structured health guidance in English and Urdu." />
    <title>@yield('title', 'ClinIQ — AI Clinical Assistant')</title>

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

    {{-- ClinIQ CSS --}}
    <link rel="stylesheet" href="{{ asset('css/cliniq.css') }}" />

    @stack('styles')
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="cq-nav">
        <a href="{{ url('/') }}" class="cq-logo">
            <div class="cq-logo-mark">+</div>
            <span class="cq-logo-text">Clin<em>IQ</em></span>
        </a>

        <div class="cq-nav-center">
            <a href="#features">Features</a>
            <a href="#how-it-works">How it works</a>
            <a href="#for-doctors">For Doctors</a>
            <a href="#pricing">Pricing</a>
            <a href="#about">About</a>
        </div>

        <div class="cq-nav-right">
            <a href="/login" class="cq-nav-login">Sign in</a>
            <a href="/register" class="cq-nav-signup">Get Started Free</a>
        </div>
    </nav>

    {{-- PAGE CONTENT --}}
    @yield('content')

    {{-- FOOTER --}}
    <footer class="cq-footer">
        <div class="cq-footer-top">
            <div>
                <div class="cq-logo">
                    <div class="cq-logo-mark">+</div>
                    <span class="cq-logo-text">Clin<em>IQ</em></span>
                </div>
                <p class="cq-footer-desc">AI-powered clinical guidance for families — responsible, safe, and always available.</p>
                <div class="cq-footer-disclaimer">
                    ⚠ ClinIQ is not a licensed medical provider. Always consult a qualified doctor for diagnosis and treatment.
                </div>
            </div>

            <div class="cq-footer-col">
                <h4>Product</h4>
                <a href="#features">Features</a>
                <a href="#how-it-works">How it works</a>
                <a href="#pricing">Pricing</a>
                <a href="#">Mobile app</a>
            </div>

            <div class="cq-footer-col">
                <h4>Support</h4>
                <a href="#">Help center</a>
                <a href="#">Contact us</a>
                <a href="#">Report issue</a>
                <a href="#">Feedback</a>
            </div>

            <div class="cq-footer-col">
                <h4>Legal</h4>
                <a href="#">Privacy policy</a>
                <a href="#">Terms of use</a>
                <a href="#">Medical disclaimer</a>
                <a href="#">Cookie policy</a>
            </div>
        </div>

        <div class="cq-footer-bottom">
            <p>© {{ date('Y') }} ClinIQ. All rights reserved.</p>
            <div class="cq-footer-badges">
                <span class="cq-fbadge">🔒 Encrypted</span>
                <span class="cq-fbadge">🌐 EN / UR</span>
                <span class="cq-fbadge">🏥 Medically responsible</span>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
