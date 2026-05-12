@extends('layouts.dashboard')

@section('title', 'AI Consultation — ClinIQ')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/consultation.css') }}" />
@endpush

@section('content')

<div class="consultation-wrap">

    {{-- ===== LEFT SIDEBAR ===== --}}
    <div class="cs-sidebar">
        <div class="cs-header">
            <div class="cs-header-title">AI Consultation</div>
            <div class="cs-header-sub">Powered by Gemini AI</div>
        </div>

        {{-- Member selector --}}
        <div class="cs-member-section">
            <div class="cs-section-label">Consulting for</div>

            {{-- Primary user --}}
            <div class="cs-member-btn active" id="member-0"
                 onclick="selectMember(0, '{{ auth()->user()->name }}', this)">
                <div class="cs-member-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div>
                    <div class="cs-member-name">{{ auth()->user()->name }}</div>
                    <div class="cs-member-meta">Primary account</div>
                </div>
                <div class="cs-member-dot" style="background:#DC2626;"></div>
            </div>

            {{-- Family members --}}
            @foreach($members as $member)
            <div class="cs-member-btn" id="member-{{ $member->id }}"
                 onclick="selectMember({{ $member->id }}, '{{ addslashes($member->name) }}', this)">
                <div class="cs-member-avatar" style="background:{{ $member->avatar_color }};color:white;">
                    {{ $member->initials }}
                </div>
                <div>
                    <div class="cs-member-name">{{ $member->name }}</div>
                    <div class="cs-member-meta">{{ $member->age }} yrs • {{ $member->relation }}</div>
                </div>
                <div class="cs-member-dot" style="background:{{ $member->ring_color }};"></div>
            </div>
            @endforeach
        </div>

        {{-- History --}}
        <div class="cs-history-section">
            <div class="cs-section-label">Recent Sessions</div>
            @forelse($recentConsultations as $c)
            <a href="/consultation/new?consultation={{ $c->id }}" class="cs-history-item">
                <div class="cs-hi-title">{{ Str::limit($c->symptoms, 30) }}</div>
                <div class="cs-hi-meta">
                    {{ $c->familyMember?->name ?? auth()->user()->name }} •
                    {{ $c->created_at->diffForHumans() }}
                </div>
                <span class="cs-hi-badge {{ $c->risk_level }}">{{ strtoupper($c->risk_level) }} risk</span>
            </a>
            @empty
            <div class="cs-history-empty">No sessions yet</div>
            @endforelse
        </div>
    </div>

    {{-- ===== MAIN CHAT ===== --}}
    <div class="cs-main">

        {{-- Topbar --}}
        <div class="cs-topbar">
            <div class="cs-topbar-left">
                <div class="cs-ai-avatar">+</div>
                <div>
                    <div class="cs-ai-name">ClinIQ Assistant</div>
                    <div class="cs-ai-status">
                        <span class="cs-status-dot"></span>
                        Online — Gemini AI powered
                    </div>
                </div>
            </div>
            <div class="cs-topbar-right">
                <button type="button" class="cs-top-btn" onclick="startNewChat()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/></svg>
                    New Chat
                </button>
            </div>
        </div>

        {{-- Messages --}}
        <div class="cs-messages" id="messages">

            {{-- Welcome message --}}
            <div class="msg-row ai" id="welcomeMsg">
                <div class="msg-avatar ai">+</div>
                <div class="msg-content">
                    <div class="msg-bubble" id="welcomeText">
                        Hello, <strong id="greetName">{{ explode(' ', auth()->user()->name)[0] }}</strong>.
                        I'm your ClinIQ AI assistant, powered by Gemini.<br><br>
                        I'm here to help analyze your symptoms and provide safe, structured health guidance.
                        Please describe what you're experiencing today — be as specific as possible about your
                        symptoms, their duration, and severity.
                    </div>
                    <div class="msg-time">Just now</div>
                </div>
            </div>

            {{-- Load existing messages if consultation provided --}}
            @if($consultation)
                @foreach($consultation->messages as $msg)
                    @if($msg->role === 'user')
                        <div class="msg-row user">
                            <div class="msg-avatar user">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                            <div class="msg-content">
                                <div class="msg-bubble">{{ $msg->content }}</div>
                                <div class="msg-time">{{ $msg->created_at->format('h:i A') }}</div>
                            </div>
                        </div>
                    @else
                        @php $aiData = json_decode($msg->content, true); @endphp
                        @if($aiData)
                            @include('partials.ai-response-card', ['response' => $aiData])
                        @endif
                    @endif
                @endforeach
            @endif

        </div>

        {{-- Input area --}}
        <div class="cs-input-area">
            <div class="cs-quick-btns">
                <button type="button" class="cs-quick-btn" onclick="quickSymptom('I have a high fever')">Fever</button>
                <button type="button" class="cs-quick-btn" onclick="quickSymptom('I have a severe headache')">Headache</button>
                <button type="button" class="cs-quick-btn" onclick="quickSymptom('I feel nauseous and have stomach pain')">Nausea</button>
                <button type="button" class="cs-quick-btn" onclick="quickSymptom('I am having difficulty breathing')">Breathing</button>
                <button type="button" class="cs-quick-btn" onclick="quickSymptom('I have body aches and fatigue')">Body aches</button>
                <button type="button" class="cs-quick-btn" onclick="quickSymptom('I have chest pain')">Chest pain</button>
            </div>
            <div class="cs-input-row">
                <button type="button" class="cs-upload-btn" title="Upload lab report">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05l-9.19 9.19a6 6 0 01-8.49-8.49l9.19-9.19a4 4 0 015.66 5.66l-9.2 9.19a2 2 0 01-2.83-2.83l8.49-8.48"/></svg>
                </button>
                <textarea
                    class="cs-input-box"
                    id="messageInput"
                    placeholder="Describe your symptoms in detail — duration, severity, location..."
                    onkeydown="handleKey(event)"
                    rows="1"
                ></textarea>
                <button type="button" class="cs-send-btn" id="sendBtn" onclick="sendMessage()" aria-label="Send">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                </button>
            </div>
            <div class="cs-disclaimer">
                ClinIQ is not a substitute for professional medical advice. Always consult a licensed doctor for diagnosis and treatment.
            </div>
        </div>

    </div>
</div>

{{-- Hidden inputs --}}
<input type="hidden" id="selectedMemberId" value="" />
<input type="hidden" id="consultationId" value="{{ $consultation?->id ?? '' }}" />
<input type="hidden" id="csrfToken" value="{{ csrf_token() }}" />

@endsection

@push('scripts')
<script>
let isLoading = false;

const SVG_BRAIN = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>';
const SVG_RISK_LOW = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg>';
const SVG_RISK_MED = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>';
const SVG_RISK_HIGH = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>';
const SVG_MAP = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>';
const SVG_FILE = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>';
const SVG_ALERT = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>';

function riskIconSvg(level) {
    if (level === 'high') return SVG_RISK_HIGH;
    if (level === 'medium') return SVG_RISK_MED;
    return SVG_RISK_LOW;
}

function selectMember(id, name, el) {
    document.getElementById('selectedMemberId').value = id > 0 ? id : '';

    const firstName = name.split(' ')[0];
    document.getElementById('greetName').textContent = firstName;

    document.getElementById('consultationId').value = '';

    document.querySelectorAll('.cs-member-btn').forEach(b => b.classList.remove('active'));
    el.classList.add('active');

    const messages = document.getElementById('messages');
    messages.innerHTML = '';

    const welcome = document.createElement('div');
    welcome.className = 'msg-row ai';
    welcome.id = 'welcomeMsg';
    welcome.innerHTML = `
        <div class="msg-avatar ai">+</div>
        <div class="msg-content">
            <div class="msg-bubble">
                Hello, <strong>${firstName}</strong>.
                I'm your ClinIQ AI assistant, powered by Gemini.<br><br>
                I'm here to help analyze your symptoms and provide safe, structured health guidance.
                Please describe what <strong>${firstName}</strong> is experiencing today.
            </div>
            <div class="msg-time">Just now</div>
        </div>`;
    messages.appendChild(welcome);

    document.getElementById('messageInput').value = '';
}

function quickSymptom(text) {
    document.getElementById('messageInput').value = text;
    document.getElementById('messageInput').focus();
}

function handleKey(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
    }
}

function startNewChat() {
    document.getElementById('consultationId').value = '';
    document.getElementById('messageInput').value = '';
    const messages = document.getElementById('messages');
    messages.innerHTML = '';

    const activeBtn = document.querySelector('.cs-member-btn.active');
    const name = activeBtn ? activeBtn.querySelector('.cs-member-name').textContent.trim() : '{{ explode(" ", auth()->user()->name)[0] }}';
    const firstName = name.split(' ')[0];

    const welcome = document.createElement('div');
    welcome.className = 'msg-row ai';
    welcome.id = 'welcomeMsg';
    welcome.innerHTML = `
        <div class="msg-avatar ai">+</div>
        <div class="msg-content">
            <div class="msg-bubble">
                Hello, <strong>${firstName}</strong>.
                I'm your ClinIQ AI assistant, powered by Gemini.<br><br>
                Please describe what you're experiencing today.
            </div>
            <div class="msg-time">Just now</div>
        </div>`;
    messages.appendChild(welcome);
}

async function sendMessage() {
    if (isLoading) return;

    const input          = document.getElementById('messageInput');
    const message        = input.value.trim();
    if (!message) return;

    const memberId       = document.getElementById('selectedMemberId').value;
    const consultationId = document.getElementById('consultationId').value;
    const csrf           = document.getElementById('csrfToken').value;
    const sendBtn        = document.getElementById('sendBtn');

    appendUserMessage(message);
    input.value   = '';
    input.style.height = '46px';
    isLoading     = true;
    sendBtn.disabled = true;

    showTyping();

    try {
        const res = await fetch('/consultation/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
            },
            body: JSON.stringify({
                message,
                family_member_id: memberId > 0 ? memberId : null,
                consultation_id:  consultationId || null,
            }),
        });

        const data = await res.json();
        hideTyping();

        if (data.success) {
            document.getElementById('consultationId').value = data.consultation_id;
            appendAIResponse(data.response);
        } else {
            appendError('Something went wrong. Please try again.');
        }
    } catch (err) {
        hideTyping();
        appendError('Network error. Please check your connection.');
    } finally {
        isLoading = false;
        sendBtn.disabled = false;
    }
}

function appendUserMessage(text) {
    const initials = '{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}';
    const time     = new Date().toLocaleTimeString('en-US', {hour:'2-digit', minute:'2-digit'});
    const html     = `
        <div class="msg-row user">
            <div class="msg-avatar user">${initials}</div>
            <div class="msg-content">
                <div class="msg-bubble">${escapeHtml(text)}</div>
                <div class="msg-time">${time}</div>
            </div>
        </div>`;
    document.getElementById('messages').insertAdjacentHTML('beforeend', html);
    scrollToBottom();
}

function showTyping() {
    const html = `
        <div class="typing-indicator" id="typingIndicator">
            <div class="msg-avatar ai">+</div>
            <div class="typing-bubble">
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
            </div>
        </div>`;
    document.getElementById('messages').insertAdjacentHTML('beforeend', html);
    scrollToBottom();
}

function hideTyping() {
    const t = document.getElementById('typingIndicator');
    if (t) t.remove();
}

function appendAIResponse(response) {
    const isEmergency = response.is_emergency;

    if (isEmergency) {
        const html = `
            <div class="ai-emergency">
                <div class="ai-emergency-header">
                    <div class="ai-emergency-dot"></div>
                    <div class="ai-emergency-title">Medical emergency detected</div>
                </div>
                <div class="ai-emergency-body">
                    ${escapeHtml(response.risk_explanation || 'This may be a medical emergency.')}
                    <br><br>
                    <strong style="color:#DC2626;">Seek immediate medical attention or go to the nearest hospital.</strong>
                </div>
                <button type="button" class="ai-emergency-btn" onclick="window.open('https://www.google.com/maps/search/hospital+near+me')">
                    ${SVG_MAP}
                    Find nearest hospital
                </button>
            </div>`;
        document.getElementById('messages').insertAdjacentHTML('beforeend', html);
        scrollToBottom();
        return;
    }

    let conditionsHtml = '';
    if (response.conditions && response.conditions.length > 0) {
        response.conditions.forEach(c => {
            const pct   = c.probability || 0;
            const color = pct >= 60 ? 'linear-gradient(90deg,#6B7280,#9CA3AF)' : pct >= 35 ? 'linear-gradient(90deg,#D97706,#F59E0B)' : 'linear-gradient(90deg,#DC2626,#EF4444)';
            const clr   = pct >= 60 ? '#6B7280' : pct >= 35 ? '#F59E0B' : '#EF4444';
            conditionsHtml += `
                <div class="ai-condition">
                    <span class="ai-cond-name">${escapeHtml(c.name)}</span>
                    <div class="ai-cond-bar-wrap"><div class="ai-cond-bar" style="width:${pct}%;background:${color};"></div></div>
                    <span class="ai-cond-pct" style="color:${clr};">${pct}%</span>
                </div>`;
        });
    }

    let recsHtml = '';
    if (response.recommendations) {
        response.recommendations.forEach(r => {
            recsHtml += `<div class="ai-rec"><div class="ai-rec-dot"></div>${escapeHtml(r)}</div>`;
        });
    }

    let otcHtml = '';
    if (response.otc_medications && response.otc_medications.length > 0) {
        response.otc_medications.forEach(m => {
            otcHtml += `
                <div class="ai-otc-item">
                    <div>
                        <div class="ai-otc-name">${escapeHtml(m.name)}</div>
                        <div class="ai-otc-dose">${escapeHtml(m.dosage)} • ${escapeHtml(m.frequency)}</div>
                    </div>
                    <span class="ai-otc-safe">OTC Safe</span>
                </div>`;
        });
    }

    const risk      = response.risk_level || 'low';
    const riskIcon  = riskIconSvg(risk);
    const riskLabel = risk.toUpperCase() + ' RISK';

    const html = `
        <div class="msg-row ai">
            <div class="msg-avatar ai">+</div>
            <div class="msg-content">
        <div class="ai-card">
            <div class="ai-card-header">
                <span class="ai-card-icon">${SVG_BRAIN}</span>
                <span class="ai-card-title">AI Analysis Complete</span>
            </div>
            <div class="ai-card-body">
                ${response.summary ? `
                <div class="ai-card-section">
                    <div class="ai-section-title">Summary</div>
                    <div class="ai-summary">${escapeHtml(response.summary)}</div>
                </div>` : ''}

                ${conditionsHtml ? `
                <div class="ai-card-section">
                    <div class="ai-section-title">Possible Conditions</div>
                    <div class="ai-conditions">${conditionsHtml}</div>
                </div>` : ''}

                <div class="ai-card-section">
                    <div class="ai-section-title">Risk Level</div>
                    <div class="ai-risk ${risk}">
                        <span class="ai-risk-icon">${riskIcon}</span>
                        <div>
                            <div class="ai-risk-level">${riskLabel}</div>
                            <div class="ai-risk-exp">${escapeHtml(response.risk_explanation || '')}</div>
                        </div>
                    </div>
                </div>

                ${recsHtml ? `
                <div class="ai-card-section">
                    <div class="ai-section-title">Recommendations</div>
                    <div class="ai-recs">${recsHtml}</div>
                </div>` : ''}

                ${otcHtml ? `
                <div class="ai-card-section">
                    <div class="ai-section-title">Safe OTC Medications</div>
                    <div class="ai-otc">${otcHtml}</div>
                </div>` : ''}

                ${response.when_to_seek_help ? `
                <div class="ai-card-section">
                    <div class="ai-section-title">When to See a Doctor</div>
                    <div class="ai-summary">${escapeHtml(response.when_to_seek_help)}</div>
                </div>` : ''}

                <div class="ai-disclaimer">
                    ${escapeHtml(response.disclaimer || 'This information is for guidance only and is not a substitute for a licensed medical professional.')}
                </div>
            </div>
            <div class="ai-card-footer">
                <button type="button" class="ai-footer-btn primary" onclick="window.open('https://www.google.com/maps/search/doctor+near+me')">${SVG_MAP}Find Doctor</button>
                <button type="button" class="ai-footer-btn secondary" onclick="window.print()">${SVG_FILE}Save Report</button>
            </div>
        </div>
            </div>
        </div>`;

    document.getElementById('messages').insertAdjacentHTML('beforeend', html);
    scrollToBottom();
}

function appendError(msg) {
    const html = `
        <div class="msg-row ai">
            <div class="msg-avatar ai">+</div>
            <div class="msg-content">
                <div class="msg-bubble msg-bubble--error">
                    <span class="msg-error-icon">${SVG_ALERT}</span>
                    <span>${escapeHtml(msg)}</span>
                </div>
            </div>
        </div>`;
    document.getElementById('messages').insertAdjacentHTML('beforeend', html);
    scrollToBottom();
}

function scrollToBottom() {
    const messages = document.getElementById('messages');
    setTimeout(() => { messages.scrollTop = messages.scrollHeight; }, 100);
}

function escapeHtml(text) {
    if (!text) return '';
    return String(text)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

document.getElementById('messageInput').addEventListener('input', function() {
    this.style.height = '46px';
    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
});

scrollToBottom();
</script>
@endpush
