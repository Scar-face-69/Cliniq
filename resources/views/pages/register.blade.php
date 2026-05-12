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
                    <div class="auth-feat-icon auth-feat-icon--muted"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
                    <div class="auth-feat-text">
                        <strong>Completely free</strong>
                        No credit card or subscription required
                    </div>
                </div>
                <div class="auth-feat">
                    <div class="auth-feat-icon auth-feat-icon--muted"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg></div>
                    <div class="auth-feat-text">
                        <strong>Private & secure</strong>
                        End-to-end encrypted health data
                    </div>
                </div>
                <div class="auth-feat">
                    <div class="auth-feat-icon auth-feat-icon--muted"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg></div>
                    <div class="auth-feat-text">
                        <strong>Bilingual support</strong>
                        Full English and Urdu language support
                    </div>
                </div>
                <div class="auth-feat">
                    <div class="auth-feat-icon auth-feat-icon--muted"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></div>
                    <div class="auth-feat-text">
                        <strong>Family profiles</strong>
                        Add unlimited family members
                    </div>
                </div>
            </div>

            <div class="auth-testi">
                <div class="auth-stars" aria-hidden="true">@foreach(range(1, 5) as $_)<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>@endforeach</div>
                <p class="auth-testi-quote">"The Urdu support is seamless. My parents can use it in their own language and get the same quality guidance."</p>
                <div class="auth-testi-author">
                    <div class="auth-testi-avatar">SR</div>
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
                            placeholder="Min. 8 characters"
                            required
                            oninput="checkStrength(this.value)"
                        />
                        <span class="auth-input-icon" onclick="togglePassword('password')" role="button" tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></span>
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
                        <span class="auth-input-icon" onclick="togglePassword('password_confirmation')" role="button" tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></span>
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
