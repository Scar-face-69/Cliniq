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
                    <div class="auth-feat-icon" style="background:rgba(0,214,143,0.1);">🧠</div>
                    <div class="auth-feat-text">
                        <strong>AI symptom analysis</strong>
                        Ranked conditions with probability scores
                    </div>
                </div>
                <div class="auth-feat">
                    <div class="auth-feat-icon" style="background:rgba(96,165,250,0.1);">👨‍👩‍👧</div>
                    <div class="auth-feat-text">
                        <strong>Family profiles</strong>
                        Manage health for your entire family
                    </div>
                </div>
                <div class="auth-feat">
                    <div class="auth-feat-icon" style="background:rgba(239,68,68,0.1);">🚨</div>
                    <div class="auth-feat-text">
                        <strong>Emergency detection</strong>
                        Instant alerts for critical symptoms
                    </div>
                </div>
                <div class="auth-feat">
                    <div class="auth-feat-icon" style="background:rgba(167,139,250,0.1);">🌐</div>
                    <div class="auth-feat-text">
                        <strong>Bilingual support</strong>
                        Full English and Urdu language support
                    </div>
                </div>
            </div>

            <div class="auth-testi">
                <div class="auth-stars">★★★★★</div>
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
                        <span class="auth-input-icon">✉</span>
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
                        <span class="auth-input-icon" onclick="togglePassword('password')" style="cursor:pointer;">👁</span>
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
