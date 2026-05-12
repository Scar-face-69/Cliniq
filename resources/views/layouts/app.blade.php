<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="ClinIQ — AI-powered clinical assistant for families. Safe, structured health guidance in English and Urdu." />
    <title>@yield('title', 'ClinIQ — AI Clinical Assistant')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet" />

    {{-- ClinIQ CSS --}}
    <link rel="stylesheet" href="{{ asset('css/cliniq.css') }}" />

    @stack('styles')
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="cq-nav" id="cqNav">
        <a href="{{ url('/') }}" class="cq-logo">
            <div class="cq-logo-mark">+</div>
            <span class="cq-logo-text">Clin<em>IQ</em></span>
        </a>

        <div class="cq-nav-center">
            <a href="#features">Features</a>
            <a href="#how-it-works">How it works</a>
            <a href="#for-doctors">For Doctors</a>
            <a href="#about">Testimonials</a>
        </div>

        <div class="cq-nav-right">
            <a href="/login" class="cq-nav-login">Sign in</a>
            <a href="/register" class="cq-nav-signup">Get Started Free</a>
        </div>
    </nav>

    {{-- HERO --}}
    <section class="cq-hero">
        <div class="cq-hero-inner">
            <div class="cq-hero-left">
                <div class="cq-eyebrow">
                    <span class="cq-pulse"></span>
                    Trusted AI health guidance — not a replacement for doctors
                </div>
                <h1 class="cq-hero-title">
                    Your health,<br>
                    <span class="accent">understood</span><br>
                    <span class="muted">intelligently & safely</span><br>
                    by AI that knows<br>
                    its limits
                </h1>
                <p class="cq-hero-sub">
                    ClinIQ analyzes your symptoms, checks your history, detects emergencies, and guides your family — in English or Urdu, 24/7.
                </p>
                <div class="cq-hero-actions">
                    <a href="/register" class="cq-btn-primary">Start Free Consultation</a>
                    <a href="#how-it-works" class="cq-btn-text">
                        Watch a 2-min demo
                        <svg viewBox="0 0 24 24"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
            <div class="cq-hero-right">
                <div class="cq-geo-stack">
                    <div class="cq-geo-rect cq-geo-rect-1"></div>
                    <div class="cq-geo-rect cq-geo-rect-2"></div>
                    <div class="cq-geo-rect cq-geo-rect-3"></div>
                    <div class="cq-geo-line cq-geo-line-1"></div>
                    <div class="cq-geo-line cq-geo-line-2"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- TRUST STRIP --}}
    <section class="cq-trust">
        <span class="cq-trust-item">End-to-end encrypted</span>
        <span class="cq-trust-item">Medically responsible AI</span>
        <span class="cq-trust-item">English & Urdu support</span>
        <span class="cq-trust-item">Built for families</span>
        <span class="cq-trust-item">Emergency detection</span>
    </section>

    {{-- FEATURES (BENTO) --}}
    <section class="cq-bento" id="features">
        <div class="cq-section-label">Features</div>
        <h2 class="cq-section-title">Everything your family needs,<br>in one intelligent platform</h2>
        <p class="cq-section-sub">ClinIQ combines AI intelligence with medical responsibility — giving you clarity without crossing limits.</p>

        <div class="cq-bento-grid">
            <div class="cq-bento-card cq-bc1">
                <div class="cq-feat-icon">
                    <svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                </div>
                <h3>AI symptom analysis</h3>
                <p>Describe symptoms naturally. ClinIQ collects structured data conversationally, checks your profile, and returns ranked possible conditions with probability scores.</p>
            </div>

            <div class="cq-bento-card cq-bc2">
                <div class="cq-feat-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                </div>
                <h3>Risk classification</h3>
                <p>Every consultation returns a clear risk level — Low, Medium, or High — with actionable next steps.</p>
            </div>

            <div class="cq-bento-card cq-bc3">
                <div class="cq-feat-icon">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </div>
                <h3>Emergency detection</h3>
                <p>Red flag symptoms trigger instant emergency mode with hospital guidance.</p>
            </div>

            <div class="cq-bento-card cq-bc4">
                <div class="cq-feat-icon">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <h3>Lab report analysis</h3>
                <p>Upload PDF or image. Get plain-language explanations of every value.</p>
            </div>

            <div class="cq-bento-card cq-bc5">
                <div class="cq-feat-icon">
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                </div>
                <h3>Family profiles</h3>
                <p>Each member gets a personalized profile with their own history, allergies, and medications.</p>
            </div>

            <div class="cq-bento-card cq-bc6">
                <div class="cq-feat-icon">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
                </div>
                <h3>Bilingual — English & Urdu</h3>
                <p>Write in whichever language you prefer. ClinIQ detects and responds accordingly — no switching needed.</p>
            </div>

            <div class="cq-bento-card cq-bc7">
                <div class="cq-feat-icon">
                    <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
                <h3>Safe OTC medication guidance</h3>
                <p>ClinIQ suggests over-the-counter medications with safe dosage ranges — never crossing into prescription territory.</p>
            </div>
        </div>
    </section>

    {{-- SPLIT: Regional Health Risks --}}
    <section class="cq-split" id="for-doctors">
        <div class="cq-split-left">
            <div class="cq-split-label">Built for Pakistan & Beyond</div>
            <h2 class="cq-split-title">Regional health risks,<br>built right in</h2>
            <p class="cq-split-body">ClinIQ is aware of common regional diseases — dengue, malaria, typhoid, seasonal infections — and factors them into every analysis based on your location and season.</p>
            <ul class="cq-checks">
                <li class="cq-check-item">
                    <span class="cq-check-tick">✓</span>
                    Dengue & malaria risk awareness
                </li>
                <li class="cq-check-item">
                    <span class="cq-check-tick">✓</span>
                    Seasonal infection patterns
                </li>
                <li class="cq-check-item">
                    <span class="cq-check-tick">✓</span>
                    Localized OTC medication availability
                </li>
                <li class="cq-check-item">
                    <span class="cq-check-tick">✓</span>
                    Full Urdu language support
                </li>
            </ul>
            <a href="/register" class="cq-btn-primary">See Regional Features</a>
        </div>
        <div class="cq-split-img-wrap">
            <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=800&q=80" alt="Clinical precision" />
        </div>
    </section>

    {{-- HOW IT WORKS --}}
    <section class="cq-how" id="how-it-works">
        <div class="cq-section-label">Process</div>
        <h2 class="cq-section-title">How ClinIQ works</h2>
        <p class="cq-section-sub">From first symptom to final recommendation in four intelligent steps.</p>

        <div class="cq-how-steps">
            <div class="cq-how-step">
                <div class="cq-hs-num">01</div>
                <h3 class="cq-hs-title">Build your profile</h3>
                <p class="cq-hs-body">Add your medical history, allergies, medications, and family members for personalized analysis.</p>
            </div>
            <div class="cq-how-step">
                <div class="cq-hs-num">02</div>
                <h3 class="cq-hs-title">Describe or upload</h3>
                <p class="cq-hs-body">Chat naturally about symptoms in English or Urdu, or upload lab reports as PDF or image.</p>
            </div>
            <div class="cq-how-step">
                <div class="cq-hs-num">03</div>
                <h3 class="cq-hs-title">Get your report</h3>
                <p class="cq-hs-body">Receive a structured report: conditions, risk level, OTC guidance, and when to see a doctor.</p>
            </div>
            <div class="cq-how-step">
                <div class="cq-hs-num">04</div>
                <h3 class="cq-hs-title">Follow up & track</h3>
                <p class="cq-hs-body">ClinIQ sends reminders, tracks your history, and refines guidance as it learns your patterns.</p>
            </div>
        </div>
    </section>

    {{-- TESTIMONIALS --}}
    <section class="cq-testi" id="about">
        <div class="cq-section-label">Testimonials</div>
        <h2 class="cq-section-title">Trusted by families across Pakistan</h2>
        <p class="cq-section-sub">Real feedback from real users who rely on ClinIQ daily.</p>

        <div class="cq-testi-grid">
            <div class="cq-testi-card">
                <p class="cq-testi-text">ClinIQ detected my mother's dengue risk before we even visited a doctor. The regional awareness feature is incredible — it knew exactly what to look for.</p>
                <div class="cq-testi-author">
                    <div class="cq-testi-avatar">AK</div>
                    <div>
                        <div class="cq-testi-name">Ahmed Khan</div>
                        <div class="cq-testi-role">Karachi, Pakistan</div>
                    </div>
                </div>
            </div>
            <div class="cq-testi-card">
                <p class="cq-testi-text">The Urdu support is seamless. My parents can use it in their own language and get the same quality guidance. This is built for us.</p>
                <div class="cq-testi-author">
                    <div class="cq-testi-avatar">SR</div>
                    <div>
                        <div class="cq-testi-name">Sana Rizvi</div>
                        <div class="cq-testi-role">Lahore, Pakistan</div>
                    </div>
                </div>
            </div>
            <div class="cq-testi-card">
                <p class="cq-testi-text">I uploaded my CBC report and within seconds ClinIQ explained every abnormal value in plain language. Saved me hours of anxiety.</p>
                <div class="cq-testi-author">
                    <div class="cq-testi-avatar">FM</div>
                    <div>
                        <div class="cq-testi-name">Farhan Mirza</div>
                        <div class="cq-testi-role">Islamabad, Pakistan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="cq-cta" id="cta">
        <div class="cq-cta-eyebrow">Start for free — no credit card required</div>
        <h2 class="cq-cta-title">Your family deserves<br><span>clinical clarity</span></h2>
        <p class="cq-cta-sub">Join thousands of families using ClinIQ to navigate health with confidence, clarity, and safety.</p>
        <div class="cq-cta-actions">
            <a href="/register" class="cq-btn-primary">Create Free Account</a>
            <a href="#how-it-works" class="cq-btn-text">
                See how it works
                <svg viewBox="0 0 24 24"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="cq-cta-pill">
            <div class="cq-cp-item">
                <div class="cq-cp-num">10K+</div>
                <div class="cq-cp-label">Families served</div>
            </div>
            <div class="cq-cp-div"></div>
            <div class="cq-cp-item">
                <div class="cq-cp-num">50K+</div>
                <div class="cq-cp-label">Consultations done</div>
            </div>
            <div class="cq-cp-div"></div>
            <div class="cq-cp-item">
                <div class="cq-cp-num">98%</div>
                <div class="cq-cp-label">Safe guidance rate</div>
            </div>
            <div class="cq-cp-div"></div>
            <div class="cq-cp-item">
                <div class="cq-cp-num">24/7</div>
                <div class="cq-cp-label">Always online</div>
            </div>
        </div>
    </section>

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
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <span>ClinIQ is not a licensed medical provider. Always consult a qualified doctor for diagnosis and treatment.</span>
                </div>
            </div>

            <div class="cq-footer-col">
                <h4>Product</h4>
                <a href="#features">Features</a>
                <a href="#how-it-works">How it works</a>
                <a href="#for-doctors">Regional features</a>
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
            <div class="cq-footer-trust">
                <span>Encrypted</span>
                <span class="cq-trust-dot">·</span>
                <span>EN / UR</span>
                <span class="cq-trust-dot">·</span>
                <span>Medically responsible</span>
            </div>
        </div>
    </footer>

    @stack('scripts')
    <script>
        const nav = document.getElementById('cqNav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 40) {
                nav.classList.add('cq-nav-scrolled');
            } else {
                nav.classList.remove('cq-nav-scrolled');
            }
        });
    </script>
</body>
</html>