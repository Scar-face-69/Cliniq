@extends('layouts.app')

@section('title', 'ClinIQ — AI Clinical Assistant for Families')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap');
.cq-marketing,.cq-marketing button,.cq-marketing .cq-btn-primary{font-family:'DM Sans',system-ui,sans-serif;}
.cq-marketing .cq-dc-badge.green{background:#F3F4F6!important;color:#6B7280!important;}
.cq-marketing .cq-r-status.ok{color:#6B7280!important;}
.cq-marketing .cq-sidebar-item.active{background:rgba(220,38,38,0.08)!important;color:#FCA5A5!important;border-right-color:#DC2626!important;}
.cq-marketing .cq-bar{background:linear-gradient(to top,#9CA3AF,#D1D5DB)!important;opacity:0.85!important;}
.cq-marketing .cq-bar.active{background:linear-gradient(to top,#DC2626,#F87171)!important;opacity:1!important;}
.cq-marketing .cq-mc.user{background:#374151!important;color:#fff!important;}
.cq-marketing .cq-mc-badge{background:#FEF3C7!important;color:#92400E!important;}
.cq-marketing .cq-rm-fill{background:linear-gradient(90deg,#9CA3AF,#D1D5DB)!important;}
.cq-marketing .cq-otc-badge{background:#F3F4F6!important;color:#6B7280!important;}
.cq-marketing .cq-check-tick{background:#F3F4F6!important;border:1px solid rgba(229,231,235,0.8)!important;color:#6B7280!important;font-size:0!important;display:inline-flex!important;align-items:center!important;justify-content:center!important;}
.cq-marketing .cq-check-tick svg{width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;}
.cq-marketing .cq-section-label{color:#DC2626!important;}
.cq-marketing .cq-split-label{color:#DC2626!important;}
.cq-marketing .cq-hs-step{color:#DC2626!important;}
.cq-marketing .cq-upload-btn{background:rgba(220,38,38,0.1)!important;color:#FCA5A5!important;border-color:rgba(220,38,38,0.25)!important;}
.cq-marketing .cq-feat-icon{display:flex!important;align-items:center;justify-content:center;}
.cq-marketing .cq-feat-icon svg{width:26px;height:26px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;}
.cq-marketing .cq-trust-item .cq-trust-ico{display:inline-flex;margin-right:8px;vertical-align:middle;}
.cq-marketing .cq-trust-item svg{width:16px;height:16px;stroke:#64748B;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;}
.cq-marketing .cq-hs-num{display:flex!important;align-items:center;justify-content:center;font-size:0!important;}
.cq-marketing .cq-hs-num svg{width:28px;height:28px;stroke:#64748B;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;}
.cq-marketing .cq-stars{display:flex;gap:3px;justify-content:center;margin-bottom:12px;}
.cq-marketing .cq-stars svg{width:14px;height:14px;stroke:#F59E0B;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;}
.cq-marketing .cq-url-lock{display:inline-flex;align-items:center;gap:6px;}
.cq-marketing .cq-url-lock svg{width:13px;height:13px;stroke:#64748B;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;}
.cq-marketing .cq-play{display:inline-flex;align-items:center;gap:6px;}
.cq-marketing .cq-play svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;}
.cq-marketing .cq-upload-ico{display:flex;justify-content:center;margin-bottom:8px;color:#94A3B8;}
.cq-marketing .cq-upload-ico svg{width:28px;height:28px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;}
.cq-marketing .cq-ec-dot{background:#EF4444!important;}
</style>
@endpush

@section('content')
<div class="cq-marketing">

{{-- ===== HERO ===== --}}
<section class="cq-hero">
    <div class="cq-hero-grid"></div>
    <div class="cq-hero-glow1"></div>
    <div class="cq-hero-glow2"></div>

    <div class="cq-eyebrow">
        <span class="cq-pulse"></span>
        Trusted AI health guidance — not a replacement for doctors
    </div>

    <h1 class="cq-hero-title">
        <div>Your health, understood</div>
        <div class="shimmer">intelligently &amp; safely</div>
        <div class="muted">by AI that knows its limits</div>
    </h1>

    <p class="cq-hero-sub">
        ClinIQ analyzes your symptoms, checks your history, detects emergencies, and guides
        your family — in English or Urdu, 24/7.
    </p>

    <div class="cq-hero-actions">
        <a href="/register" class="cq-btn-primary">Start Free Consultation</a>
        <a href="#how-it-works" class="cq-btn-ghost">
            <span class="cq-play"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"/></svg></span> Watch 2-min demo
        </a>
    </div>

    {{-- Dashboard Mockup --}}
    <div class="cq-dashboard">
        <div class="cq-dash-frame">
            <div class="cq-dash-topbar">
                <div class="cq-dots">
                    <div class="cq-dot r"></div>
                    <div class="cq-dot y"></div>
                    <div class="cq-dot g"></div>
                </div>
                <div class="cq-url-bar"><span class="cq-url-lock"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg></span>app.cliniq.health/dashboard</div>
            </div>
            <div class="cq-dash-body">
                <div class="cq-sidebar">
                    <div class="cq-sidebar-logo">Clin<em>IQ</em></div>
                    <div class="cq-sidebar-item active">
                        <div class="cq-sidebar-dot" style="background:rgba(220,38,38,0.35);"></div> Dashboard
                    </div>
                    <div class="cq-sidebar-item">
                        <div class="cq-sidebar-dot" style="background:rgba(100,116,139,0.2);"></div> Consultations
                    </div>
                    <div class="cq-sidebar-item">
                        <div class="cq-sidebar-dot" style="background:rgba(100,116,139,0.2);"></div> Lab Reports
                    </div>
                    <div class="cq-sidebar-item">
                        <div class="cq-sidebar-dot" style="background:rgba(100,116,139,0.2);"></div> Family
                    </div>
                    <div class="cq-sidebar-item">
                        <div class="cq-sidebar-dot" style="background:rgba(100,116,139,0.2);"></div> History
                    </div>
                    <div class="cq-sidebar-item">
                        <div class="cq-sidebar-dot" style="background:rgba(100,116,139,0.2);"></div> Settings
                    </div>
                </div>
                <div class="cq-dash-main">
                    <div class="cq-dash-greeting">Good morning, Ahmed</div>
                    <div class="cq-dash-headline">Family Health Overview</div>
                    <div class="cq-dash-cards">
                        <div class="cq-dash-card">
                            <div class="cq-dc-label">Active members</div>
                            <div class="cq-dc-value">4</div>
                            <div class="cq-dc-badge green">All monitored</div>
                        </div>
                        <div class="cq-dash-card">
                            <div class="cq-dc-label">Last consultation</div>
                            <div class="cq-dc-value">2h ago</div>
                            <div class="cq-dc-badge amber">Follow-up due</div>
                        </div>
                        <div class="cq-dash-card">
                            <div class="cq-dc-label">Risk alerts</div>
                            <div class="cq-dc-value">1</div>
                            <div class="cq-dc-badge red">Review needed</div>
                        </div>
                    </div>
                    <div class="cq-dash-row">
                        <div class="cq-chart-area">
                            <div class="cq-chart-label">Consultations this week</div>
                            <div class="cq-chart-bars">
                                <div class="cq-bar" style="height:40%;"></div>
                                <div class="cq-bar" style="height:65%;"></div>
                                <div class="cq-bar" style="height:30%;"></div>
                                <div class="cq-bar" style="height:80%;"></div>
                                <div class="cq-bar active" style="height:95%;"></div>
                                <div class="cq-bar" style="height:50%;"></div>
                                <div class="cq-bar" style="height:70%;"></div>
                            </div>
                        </div>
                        <div class="cq-recent">
                            <div class="cq-recent-title">Family members</div>
                            <div class="cq-recent-item">
                                <div class="cq-r-avatar" style="background:#2D2D2D;color:#FFFFFF;">A</div>
                                <div><div class="cq-r-name">Ahmed</div><div class="cq-r-status ok">Stable</div></div>
                            </div>
                            <div class="cq-recent-item">
                                <div class="cq-r-avatar" style="background:#2D2D2D;color:#FFFFFF;">M</div>
                                <div><div class="cq-r-name">Mother</div><div class="cq-r-status warn">Follow up</div></div>
                            </div>
                            <div class="cq-recent-item">
                                <div class="cq-r-avatar" style="background:#2D2D2D;color:#FFFFFF;">S</div>
                                <div><div class="cq-r-name">Sister</div><div class="cq-r-status ok">Stable</div></div>
                            </div>
                            <div class="cq-recent-item">
                                <div class="cq-r-avatar" style="background:#2D2D2D;color:#FFFFFF;">F</div>
                                <div><div class="cq-r-name">Father</div><div class="cq-r-status ok">Stable</div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== TRUST STRIP ===== --}}
<div class="cq-trust">
    <div class="cq-trust-item"><span class="cq-trust-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg></span>End-to-end encrypted</div>
    <div class="cq-trust-item"><span class="cq-trust-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></span>Medically responsible AI</div>
    <div class="cq-trust-item"><span class="cq-trust-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg></span>English &amp; Urdu support</div>
    <div class="cq-trust-item"><span class="cq-trust-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></span>Built for families</div>
    <div class="cq-trust-item"><span class="cq-trust-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></span>Emergency detection</div>
</div>

{{-- ===== BENTO FEATURES ===== --}}
<section class="cq-bento" id="features">
    <div class="cq-section-label">Features</div>
    <h2 class="cq-section-title">Everything your family needs,<br>in one intelligent platform</h2>
    <p class="cq-section-sub">ClinIQ combines AI intelligence with medical responsibility — giving you clarity without crossing limits.</p>

    <div class="cq-bento-grid">

        {{-- Card 1: AI Chat (large) --}}
        <div class="cq-bento-card cq-bc1" style="--card-accent:#DC2626;">
            <div class="cq-feat-icon" style="background:rgba(220,38,38,0.1);color:#FCA5A5;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"/><rect x="9" y="9" width="6" height="6"/><line x1="9" y1="1" x2="9" y2="4"/><line x1="15" y1="1" x2="15" y2="4"/><line x1="9" y1="20" x2="9" y2="23"/><line x1="15" y1="20" x2="15" y2="23"/><line x1="20" y1="9" x2="23" y2="9"/><line x1="20" y1="14" x2="23" y2="14"/><line x1="1" y1="9" x2="4" y2="9"/><line x1="1" y1="14" x2="4" y2="14"/></svg></div>
            <h3>AI symptom analysis</h3>
            <p>Describe symptoms naturally. ClinIQ collects structured data conversationally, checks your profile, and returns ranked possible conditions with probability scores.</p>
            <div class="cq-mini-chat">
                <div class="cq-mc ai">Hello! What symptoms are you experiencing today?</div>
                <div class="cq-mc user">Fever, headache and body aches since 2 days</div>
                <div class="cq-mc ai">
                    Based on your profile and regional risks:<br>
                    <strong>1. Viral flu</strong> — High<br>
                    <strong>2. Dengue</strong> — Medium<br>
                    <span class="cq-mc-badge">Medium risk — monitor 48hrs</span>
                </div>
            </div>
        </div>

        {{-- Card 2: Risk --}}
        <div class="cq-bento-card cq-bc2" style="--card-accent:#F59E0B;">
            <div class="cq-feat-icon" style="background:rgba(245,158,11,0.1);color:#F59E0B;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
            <h3>Risk classification</h3>
            <p>Every consultation returns a clear risk level — Low, Medium, or High — with actionable next steps.</p>
            <div style="margin-top:16px;">
                <div class="cq-rm-row">
                    <span class="cq-rm-label">Viral flu</span>
                    <div class="cq-rm-track"><div class="cq-rm-fill" style="width:78%;"></div></div>
                    <span class="cq-rm-pct">78%</span>
                </div>
                <div class="cq-rm-row">
                    <span class="cq-rm-label">Dengue</span>
                    <div class="cq-rm-track"><div class="cq-rm-fill" style="width:45%;background:linear-gradient(90deg,#F59E0B,#D97706)!important;"></div></div>
                    <span class="cq-rm-pct">45%</span>
                </div>
                <div class="cq-rm-row">
                    <span class="cq-rm-label">Typhoid</span>
                    <div class="cq-rm-track"><div class="cq-rm-fill" style="width:18%;background:linear-gradient(90deg,#EF4444,#DC2626)!important;"></div></div>
                    <span class="cq-rm-pct">18%</span>
                </div>
            </div>
        </div>

        {{-- Card 3: Emergency --}}
        <div class="cq-bento-card cq-bc3" style="--card-accent:#EF4444;">
            <div class="cq-feat-icon" style="background:rgba(239,68,68,0.1);color:#EF4444;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
            <h3>Emergency detection</h3>
            <p>Red flag symptoms trigger instant emergency mode with hospital guidance.</p>
            <div class="cq-emergency">
                <div class="cq-ec-header">
                    <div class="cq-ec-dot"></div>
                    <span class="cq-ec-title">Emergency detected</span>
                </div>
                <div class="cq-ec-body">Chest pain + difficulty breathing detected. Seek immediate medical attention.</div>
                <button class="cq-ec-btn">Find Nearest Hospital →</button>
            </div>
        </div>

        {{-- Card 4: Lab Upload --}}
        <div class="cq-bento-card cq-bc4" style="--card-accent:#DC2626;">
            <div class="cq-feat-icon" style="background:rgba(243,244,246,0.08);color:#94A3B8;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><line x1="10" y1="9" x2="8" y2="9"/></svg></div>
            <h3>Lab report analysis</h3>
            <p>Upload PDF or image. Get plain-language explanations of every value.</p>
            <div class="cq-upload">
                <div class="cq-upload-ico"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg></div>
                <div style="font-size:13px;color:#64748B;">Drag your report here<br>PDF, JPG, PNG supported</div>
                <button class="cq-upload-btn">Browse file</button>
            </div>
        </div>

        {{-- Card 5: Family --}}
        <div class="cq-bento-card cq-bc5" style="--card-accent:#DC2626;">
            <div class="cq-feat-icon" style="background:rgba(243,244,246,0.08);color:#94A3B8;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></div>
            <h3>Family profiles</h3>
            <p>Each member gets a personalized profile with their own history, allergies, and medications.</p>
            <div class="cq-family-row">
                <div class="cq-fam-card">
                    <div class="cq-fam-avatar" style="background:#2D2D2D;color:#FFFFFF;">A</div>
                    <div><div class="cq-fam-name">Ahmed</div><div class="cq-fam-age">Primary</div></div>
                </div>
                <div class="cq-fam-card">
                    <div class="cq-fam-avatar" style="background:#2D2D2D;color:#FFFFFF;">M</div>
                    <div><div class="cq-fam-name">Mother</div><div class="cq-fam-age">52 yrs</div></div>
                </div>
            </div>
        </div>

        {{-- Card 6: Bilingual --}}
        <div class="cq-bento-card cq-bc6" style="--card-accent:#DC2626;">
            <div class="cq-feat-icon" style="background:rgba(243,244,246,0.08);color:#94A3B8;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg></div>
            <h3>Bilingual — English &amp; Urdu</h3>
            <p>Write in whichever language you prefer. ClinIQ detects and responds accordingly — no switching needed.</p>
            <div class="cq-lang-toggle">
                <button class="cq-lt-btn active">English</button>
                <button class="cq-lt-btn">اردو</button>
            </div>
            <div class="cq-lang-preview">
                آپ کو بخار اور سر درد ہے؟ میں آپ کی مدد کر سکتا ہوں — براہ کرم اپنی علامات بیان کریں۔
            </div>
        </div>

        {{-- Card 7: OTC --}}
        <div class="cq-bento-card cq-bc7" style="--card-accent:#FBBF24;">
            <div class="cq-feat-icon" style="background:rgba(251,191,36,0.1);color:#F59E0B;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10.5 20.5l10-10a2.83 2.83 0 00-4-4l-10 10"/><path d="M13.5 7.5l4 4"/><path d="M7 17l4-4"/></svg></div>
            <h3>Safe OTC medication guidance</h3>
            <p>ClinIQ suggests over-the-counter medications with safe dosage ranges — never crossing into prescription territory.</p>
            <div class="cq-otc-row">
                <span class="cq-otc-name">Paracetamol 500mg</span>
                <span class="cq-otc-badge">Safe</span>
            </div>
            <div class="cq-otc-row">
                <span class="cq-otc-name">Max 4g/day — every 6hrs</span>
                <span style="font-size:12px;color:#64748B;">OTC only</span>
            </div>
        </div>

    </div>
</section>

{{-- ===== SPLIT: Regional ===== --}}
<section class="cq-split">
    <div class="cq-split-left">
        <div class="cq-split-label">Built for Pakistan &amp; beyond</div>
        <h2 class="cq-split-title">Regional health risks,<br>built right in</h2>
        <p class="cq-split-body">
            ClinIQ is aware of common regional diseases — dengue, malaria, typhoid, seasonal infections —
            and factors them into every analysis based on your location and season.
        </p>
        <ul class="cq-checks">
            <li class="cq-check-item"><span class="cq-check-tick"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></span> Dengue &amp; malaria risk awareness</li>
            <li class="cq-check-item"><span class="cq-check-tick"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></span> Seasonal infection patterns</li>
            <li class="cq-check-item"><span class="cq-check-tick"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></span> Localized OTC medication availability</li>
            <li class="cq-check-item"><span class="cq-check-tick"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></span> Full Urdu language support</li>
        </ul>
        <a href="/register" class="cq-btn-primary">See Regional Features</a>
    </div>
    <div class="cq-split-img-wrap">
        <div class="cq-split-img-frame">
            <img src="https://openmedscience.com/wp-content/uploads/2024/08/Generative-AI-Healthcare.jpg"
                 alt="AI Healthcare technology"
                 onerror="this.style.background='linear-gradient(135deg,#1E3A5F,#0B3D2E)';this.style.minHeight='380px';" />
            <div class="cq-img-overlay"></div>
        </div>
        <div class="cq-float-stat top">
            <div class="cq-fs-num">98%</div>
            <div class="cq-fs-label">Safe guidance rate</div>
        </div>
        <div class="cq-float-stat bottom">
            <div class="cq-fs-num">24/7</div>
            <div class="cq-fs-label">Always available</div>
        </div>
    </div>
</section>

{{-- ===== HOW IT WORKS ===== --}}
<section class="cq-how" id="how-it-works">
    <div class="cq-section-label">Process</div>
    <h2 class="cq-section-title" style="text-align:center;">How ClinIQ works</h2>
    <p class="cq-section-sub">From first symptom to final recommendation in four intelligent steps.</p>

    <div class="cq-how-steps">
        <div class="cq-how-step">
            <div class="cq-hs-num"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2v4"/><path d="M12 18v4"/><path d="M4.93 4.93l2.83 2.83"/><path d="M16.24 16.24l2.83 2.83"/><path d="M2 12h4"/><path d="M18 12h4"/><path d="M4.93 19.07l2.83-2.83"/><path d="M16.24 7.76l2.83-2.83"/><circle cx="12" cy="12" r="4"/></svg></div>
            <div class="cq-hs-step">Step 01</div>
            <div class="cq-hs-title">Build your profile</div>
            <div class="cq-hs-body">Add your medical history, allergies, medications, and family members for personalized analysis.</div>
        </div>
        <div class="cq-how-step">
            <div class="cq-hs-num"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg></div>
            <div class="cq-hs-step">Step 02</div>
            <div class="cq-hs-title">Describe or upload</div>
            <div class="cq-hs-body">Chat naturally about symptoms in English or Urdu, or upload lab reports as PDF or image.</div>
        </div>
        <div class="cq-how-step">
            <div class="cq-hs-num"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><line x1="10" y1="9" x2="8" y2="9"/></svg></div>
            <div class="cq-hs-step">Step 03</div>
            <div class="cq-hs-title">Get your report</div>
            <div class="cq-hs-body">Receive a structured report: conditions, risk level, OTC guidance, and when to see a doctor.</div>
        </div>
        <div class="cq-how-step">
            <div class="cq-hs-num"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 11-2.12-9.36L23 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 012.13 9.36L1 14"/></svg></div>
            <div class="cq-hs-step">Step 04</div>
            <div class="cq-hs-title">Follow up &amp; track</div>
            <div class="cq-hs-body">ClinIQ sends reminders, tracks your history, and refines guidance as it learns your patterns.</div>
        </div>
    </div>
</section>

{{-- ===== TESTIMONIALS ===== --}}
<section class="cq-testi">
    <div class="cq-section-label">Testimonials</div>
    <h2 class="cq-section-title">Trusted by families across Pakistan</h2>
    <p class="cq-section-sub">Real feedback from real users who rely on ClinIQ daily.</p>

    <div class="cq-testi-grid">
        <div class="cq-testi-card">
            <div class="cq-stars" aria-hidden="true">@foreach(range(1, 5) as $_)<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>@endforeach</div>
            <p class="cq-testi-text">ClinIQ detected my mother's dengue risk before we even visited a doctor. The regional awareness feature is incredible — it knew exactly what to look for.</p>
            <div class="cq-testi-author">
                <div class="cq-testi-avatar" style="background:#2D2D2D;color:#FFFFFF;">AK</div>
                <div><div class="cq-testi-name">Ahmed Khan</div><div class="cq-testi-role">Karachi, Pakistan</div></div>
            </div>
        </div>
        <div class="cq-testi-card">
            <div class="cq-stars" aria-hidden="true">@foreach(range(1, 5) as $_)<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>@endforeach</div>
            <p class="cq-testi-text">The Urdu support is seamless. My parents can use it in their own language and get the same quality guidance. This is built for us.</p>
            <div class="cq-testi-author">
                <div class="cq-testi-avatar" style="background:#2D2D2D;color:#FFFFFF;">SR</div>
                <div><div class="cq-testi-name">Sana Rizvi</div><div class="cq-testi-role">Lahore, Pakistan</div></div>
            </div>
        </div>
        <div class="cq-testi-card">
            <div class="cq-stars" aria-hidden="true">@foreach(range(1, 5) as $_)<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>@endforeach</div>
            <p class="cq-testi-text">I uploaded my CBC report and within seconds ClinIQ explained every abnormal value in plain language. Saved me hours of anxiety.</p>
            <div class="cq-testi-author">
                <div class="cq-testi-avatar" style="background:#2D2D2D;color:#FFFFFF;">FM</div>
                <div><div class="cq-testi-name">Farhan Mirza</div><div class="cq-testi-role">Islamabad, Pakistan</div></div>
            </div>
        </div>
    </div>
</section>

{{-- ===== CTA ===== --}}
<section class="cq-cta">
    <div class="cq-cta-glow"></div>
    <div class="cq-cta-grid"></div>

    <div class="cq-cta-eyebrow">Start for free — no credit card required</div>
    <h2 class="cq-cta-title">Your family deserves<br><span>smarter healthcare</span></h2>
    <p class="cq-cta-sub">Join thousands of families using ClinIQ to navigate health with confidence, clarity, and safety.</p>

    <div class="cq-cta-actions">
        <a href="/register" class="cq-btn-primary" style="font-size:16px;padding:16px 40px;">Create Free Account</a>
        <a href="#how-it-works" class="cq-btn-ghost" style="font-size:16px;padding:16px 40px;">See how it works</a>
    </div>

    <div class="cq-cta-pill">
        <div class="cq-cp-item"><div class="cq-cp-num">10K+</div><div class="cq-cp-label">Families served</div></div>
        <div class="cq-cp-div"></div>
        <div class="cq-cp-item"><div class="cq-cp-num">50K+</div><div class="cq-cp-label">Consultations done</div></div>
        <div class="cq-cp-div"></div>
        <div class="cq-cp-item"><div class="cq-cp-num">98%</div><div class="cq-cp-label">Safe guidance rate</div></div>
        <div class="cq-cp-div"></div>
        <div class="cq-cp-item"><div class="cq-cp-num">24/7</div><div class="cq-cp-label">Always online</div></div>
    </div>
</section>

</div>{{-- .cq-marketing --}}

@endsection

@push('scripts')
<script>
    // Lang toggle interaction
    document.querySelectorAll('.cq-lt-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.cq-lang-toggle').querySelectorAll('.cq-lt-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
</script>
@endpush
