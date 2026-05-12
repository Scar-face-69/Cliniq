@extends('layouts.auth')

@section('title', 'Sign In — ClinIQ')

@section('content')

<div class="auth-wrapper">

    {{-- ===== LEFT PANEL ===== --}}
    <div class="auth-left">
        <div class="auth-left-grid"></div>
        <div class="auth-left-glow"></div>
        <div class="auth-left-glow2"></div>

        <a href="/" class="auth-logo">
            <div class="auth-logo-mark">+</div>
            <span class="auth-logo-text">Clin<em>IQ</em></span>
        </a>

        <div class="auth-left-content">
            <div class="auth-left-eyebrow">
                <span class="auth-pulse"></span>
                AI-Powered Health Guidance
            </div>

            <h1 class="auth-left-title">
                Welcome back to<br>
                <span>smarter healthcare</span>
            </h1>

            <p class="auth-left-sub">
                Sign in to access your family health dashboard, consultations, and lab reports — all in one place.
            </p>

            <div class="auth-features">
                <div class="auth-feat">
                    <div class="auth-feat-icon auth-feat-icon--muted"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"/><rect x="9" y="9" width="6" height="6"/><line x1="9" y1="1" x2="9" y2="4"/><line x1="15" y1="1" x2="15" y2="4"/><line x1="9" y1="20" x2="9" y2="23"/><line x1="15" y1="20" x2="15" y2="23"/><line x1="20" y1="9" x2="23" y2="9"/><line x1="20" y1="14" x2="23" y2="14"/><line x1="1" y1="9" x2="4" y2="9"/><line x1="1" y1="14" x2="4" y2="14"/></svg></div>
                    <div class="auth-feat-text">
                        <strong>AI symptom analysis</strong>
                        Ranked conditions with probability scores
                    </div>
                </div>
                <div class="auth-feat">
                    <div class="auth-feat-icon auth-feat-icon--muted"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></div>
                    <div class="auth-feat-text">
                        <strong>Family profiles</strong>
                        Manage health for your entire family
                    </div>
                </div>
                <div class="auth-feat">
                    <div class="auth-feat-icon auth-feat-icon--accent"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
                    <div class="auth-feat-text">
                        <strong>Emergency detection</strong>
                        Instant alerts for critical symptoms
                    </div>
                </div>
                <div class="auth-feat">
                    <div class="auth-feat-icon auth-feat-icon--muted"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg></div>
                    <div class="auth-feat-text">
                        <strong>Bilingual support</strong>
                        Full English and Urdu language support
                    </div>
                </div>
            </div>

            <div class="auth-testi">
                <div class="auth-stars" aria-hidden="true">@foreach(range(1, 5) as $_)<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>@endforeach</div>
                <p class="auth-testi-quote">"ClinIQ detected my mother's dengue risk before we even visited a doctor. Absolutely incredible."</p>
                <div class="auth-testi-author">
                    <div class="auth-testi-avatar">AK</div>
                    <div>
                        <div class="auth-testi-name">Ahmed Khan</div>
                        <div class="auth-testi-role">Karachi, Pakistan</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="auth-left-footer">
            © {{ date('Y') }} ClinIQ. Not a substitute for professional medical advice.<br>
            Always consult a licensed doctor for diagnosis and treatment.
        </div>
    </div>

    {{-- ===== RIGHT PANEL ===== --}}
    <div class="auth-right">
        <div class="auth-form-wrap">

            <div class="auth-form-header">
                <h2 class="auth-form-title">Sign in to ClinIQ</h2>
                <p class="auth-form-sub">Enter your credentials to access your dashboard</p>
            </div>

            {{-- Session errors --}}
            @if ($errors->any())
                <div class="auth-error">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Session status --}}
            @if (session('status'))
                <div class="auth-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="/login">
                @csrf

                {{-- Email --}}
                <div class="auth-form-group">
                    <label class="auth-label" for="email">Email address</label>
                    <div class="auth-input-wrap">
                        <input
                            class="auth-input"
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="ahmed@example.com"
                            required
                            autofocus
                        />
                        <span class="auth-input-icon auth-input-icon--static"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22 6 12 13 2 6"/></svg></span>
                    </div>
                </div>

                {{-- Password --}}
                <div class="auth-form-group">
                    <label class="auth-label" for="password">Password</label>
                    <div class="auth-input-wrap">
                        <input
                            class="auth-input"
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                        />
                        <span class="auth-input-icon" onclick="togglePassword('password')" role="button" tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></span>
                    </div>
                </div>

                {{-- Remember & Forgot --}}
                <div class="auth-extras">
                    <label class="auth-remember">
                        <input type="checkbox" name="remember" />
                        <span>Remember me</span>
                    </label>
                    <a href="/forgot-password" class="auth-forgot">Forgot password?</a>
                </div>

                {{-- Submit --}}
                <button type="submit" class="auth-btn">
                    Sign in to ClinIQ
                </button>

            </form>

            <div class="auth-divider">
                <div class="auth-divider-line"></div>
                <span class="auth-divider-text">don't have an account?</span>
                <div class="auth-divider-line"></div>
            </div>

            <div class="auth-switch">
                New to ClinIQ? <a href="/register">Create free account</a>
            </div>

            <div class="auth-terms">
                By signing in, you agree to our
                <a href="#">Terms of Service</a> and
                <a href="#">Privacy Policy</a>
            </div>

        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
@endpush
