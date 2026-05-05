@extends('layouts.auth')

@section('title', 'Create Account — ClinIQ')

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
                Free forever — no credit card needed
            </div>

            <h1 class="auth-left-title">
                Join thousands of<br>
                <span>healthier families</span>
            </h1>

            <p class="auth-left-sub">
                Create your free account and get AI-powered health guidance for your entire family — in English or Urdu, available 24/7.
            </p>

            <div class="auth-features">
                <div class="auth-feat">
                    <div class="auth-feat-icon" style="background:rgba(0,214,143,0.1);">✓</div>
                    <div class="auth-feat-text">
                        <strong>Completely free</strong>
                        No credit card or subscription required
                    </div>
                </div>
                <div class="auth-feat">
                    <div class="auth-feat-icon" style="background:rgba(167,139,250,0.1);">🔒</div>
                    <div class="auth-feat-text">
                        <strong>Private & secure</strong>
                        End-to-end encrypted health data
                    </div>
                </div>
                <div class="auth-feat">
                    <div class="auth-feat-icon" style="background:rgba(251,191,36,0.1);">🌐</div>
                    <div class="auth-feat-text">
                        <strong>Bilingual support</strong>
                        Full English and Urdu language support
                    </div>
                </div>
                <div class="auth-feat">
                    <div class="auth-feat-icon" style="background:rgba(96,165,250,0.1);">👨‍👩‍👧</div>
                    <div class="auth-feat-text">
                        <strong>Family profiles</strong>
                        Add unlimited family members
                    </div>
                </div>
            </div>

            <div class="auth-testi">
                <div class="auth-stars">★★★★★</div>
                <p class="auth-testi-quote">"The Urdu support is seamless. My parents can use it in their own language and get the same quality guidance."</p>
                <div class="auth-testi-author">
                    <div class="auth-testi-avatar" style="background:linear-gradient(135deg,#A78BFA,#7C3AED);">SR</div>
                    <div>
                        <div class="auth-testi-name">Sana Rizvi</div>
                        <div class="auth-testi-role">Lahore, Pakistan</div>
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
                <h2 class="auth-form-title">Create your account</h2>
                <p class="auth-form-sub">Start your free health journey today</p>
            </div>

            {{-- Errors --}}
            @if ($errors->any())
                <div class="auth-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="/register">
                @csrf

                {{-- Name Row --}}
                <div class="auth-form-row">
                    <div class="auth-form-group">
                        <label class="auth-label" for="first_name">First name</label>
                        <input
                            class="auth-input"
                            type="text"
                            id="first_name"
                            name="first_name"
                            value="{{ old('first_name') }}"
                            placeholder="Ahmed"
                            required
                            autofocus
                        />
                    </div>
                    <div class="auth-form-group">
                        <label class="auth-label" for="last_name">Last name</label>
                        <input
                            class="auth-input"
                            type="text"
                            id="last_name"
                            name="last_name"
                            value="{{ old('last_name') }}"
                            placeholder="Khan"
                            required
                        />
                    </div>
                </div>

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
                            placeholder="Min. 8 characters"
                            required
                            oninput="checkStrength(this.value)"
                        />
                        <span class="auth-input-icon" onclick="togglePassword('password')" style="cursor:pointer;">👁</span>
                    </div>
                    <div class="auth-strength" id="strength-bars">
                        <div class="auth-str-bar" id="bar1"></div>
                        <div class="auth-str-bar" id="bar2"></div>
                        <div class="auth-str-bar" id="bar3"></div>
                        <div class="auth-str-bar" id="bar4"></div>
                    </div>
                    <div class="auth-str-label" id="str-label"></div>
                </div>

                {{-- Confirm Password --}}
                <div class="auth-form-group">
                    <label class="auth-label" for="password_confirmation">Confirm password</label>
                    <div class="auth-input-wrap">
                        <input
                            class="auth-input"
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Re-enter your password"
                            required
                        />
                        <span class="auth-input-icon" onclick="togglePassword('password_confirmation')" style="cursor:pointer;">👁</span>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="auth-btn">
                    Create Free Account
                </button>

            </form>

            <div class="auth-terms">
                By creating an account, you agree to our
                <a href="#">Terms of Service</a> and
                <a href="#">Privacy Policy</a>.
                ClinIQ is not a substitute for professional medical advice.
            </div>

            <div class="auth-divider" style="margin-top:20px;">
                <div class="auth-divider-line"></div>
                <span class="auth-divider-text">already have an account?</span>
                <div class="auth-divider-line"></div>
            </div>

            <div class="auth-switch">
                <a href="/login">Sign in instead</a>
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

function checkStrength(val) {
    const bars = [document.getElementById('bar1'), document.getElementById('bar2'), document.getElementById('bar3'), document.getElementById('bar4')];
    const label = document.getElementById('str-label');
    bars.forEach(b => { b.className = 'auth-str-bar'; });

    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    if (score === 1) {
        bars[0].classList.add('weak');
        label.textContent = 'Weak'; label.className = 'auth-str-label weak';
    } else if (score === 2) {
        bars[0].classList.add('medium'); bars[1].classList.add('medium');
        label.textContent = 'Fair'; label.className = 'auth-str-label medium';
    } else if (score === 3) {
        bars[0].classList.add('strong'); bars[1].classList.add('strong'); bars[2].classList.add('strong');
        label.textContent = 'Good'; label.className = 'auth-str-label strong';
    } else if (score === 4) {
        bars.forEach(b => b.classList.add('strong'));
        label.textContent = 'Strong'; label.className = 'auth-str-label strong';
    } else {
        label.textContent = '';
    }
}
</script>
@endpush
