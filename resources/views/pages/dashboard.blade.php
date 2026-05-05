@extends('layouts.dashboard')

@section('title', 'Dashboard — ClinIQ')

@section('content')

{{-- ===== TOP BAR ===== --}}
<div class="db-topbar">
    <div class="db-greeting">
        <h1>Good {{ now()->format('H') < 12 ? 'morning' : (now()->format('H') < 17 ? 'afternoon' : 'evening') }}, {{ explode(' ', auth()->user()->name)[0] }} 👋</h1>
        <p>Here's your family health overview for today</p>
    </div>
    <div class="db-topbar-right">
        <a href="/consultation/new" class="db-new-btn">+ New Consultation</a>
    </div>
</div>

{{-- ===== ALERT BANNER ===== --}}
<div class="db-alert-banner">
    <div class="db-alert-icon">⚠️</div>
    <div>
        <div class="db-alert-title">Follow-up recommended</div>
        <div class="db-alert-sub">A family member has a pending follow-up — symptoms should be re-evaluated today.</div>
    </div>
    <a href="/consultation/new" class="db-alert-action">Start Consultation</a>
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="db-stats">
    <div class="db-stat-card">
        <div class="db-stat-label">
            <span class="db-stat-icon">👨‍👩‍👧</span> Family members
        </div>
        <div class="db-stat-value">{{ $memberCount ?? 1 }}</div>
        <span class="db-stat-badge blue">All monitored</span>
    </div>
    <div class="db-stat-card">
        <div class="db-stat-label">
            <span class="db-stat-icon">💬</span> Consultations
        </div>
        <div class="db-stat-value">{{ $consultationCount ?? 0 }}</div>
        <span class="db-stat-badge green">This month</span>
    </div>
    <div class="db-stat-card">
        <div class="db-stat-label">
            <span class="db-stat-icon">📄</span> Lab reports
        </div>
        <div class="db-stat-value">{{ $reportCount ?? 0 }}</div>
        <span class="db-stat-badge green">All analyzed</span>
    </div>
    <div class="db-stat-card">
        <div class="db-stat-label">
            <span class="db-stat-icon">🚨</span> Risk alerts
        </div>
        <div class="db-stat-value">{{ $alertCount ?? 0 }}</div>
        <span class="db-stat-badge {{ ($alertCount ?? 0) > 0 ? 'amber' : 'green' }}">
            {{ ($alertCount ?? 0) > 0 ? 'Needs review' : 'All clear' }}
        </span>
    </div>
</div>

{{-- ===== GRID ROW 1 ===== --}}
<div class="db-grid-2">

    {{-- Chart --}}
    <div class="db-card">
        <div class="db-card-header">
            <span class="db-card-title">Consultations this week</span>
            <a href="/consultations" class="db-card-action">View all</a>
        </div>
        <div class="db-chart-bars">
            <div class="db-bar" style="height:35%;"></div>
            <div class="db-bar" style="height:60%;"></div>
            <div class="db-bar" style="height:25%;"></div>
            <div class="db-bar" style="height:80%;"></div>
            <div class="db-bar active" style="height:95%;"></div>
            <div class="db-bar" style="height:45%;"></div>
            <div class="db-bar" style="height:65%;"></div>
        </div>
        <div class="db-chart-labels">
            <span class="db-chart-label">Mon</span>
            <span class="db-chart-label">Tue</span>
            <span class="db-chart-label">Wed</span>
            <span class="db-chart-label">Thu</span>
            <span class="db-chart-label">Fri</span>
            <span class="db-chart-label">Sat</span>
            <span class="db-chart-label">Sun</span>
        </div>
    </div>

    {{-- Family Members --}}
    <div class="db-card">
        <div class="db-card-header">
            <span class="db-card-title">Family members</span>
            <a href="/family" class="db-card-action">Manage</a>
        </div>

        @if(isset($members) && $members->count() > 0)
            @foreach($members as $member)
            <div class="db-member-item">
                <div class="db-member-left">
                    <div class="db-member-avatar" style="background:linear-gradient(135deg,#00D68F,#00B377);color:#0A1628;">
                        {{ strtoupper(substr($member->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="db-member-name">{{ $member->name }}</div>
                        <div class="db-member-meta">{{ $member->age }} yrs • {{ $member->relation }}</div>
                    </div>
                </div>
                <span class="db-status healthy">Healthy</span>
            </div>
            @endforeach
        @else
            {{-- Default: show logged in user --}}
            <div class="db-member-item">
                <div class="db-member-left">
                    <div class="db-member-avatar" style="background:linear-gradient(135deg,#00D68F,#00B377);color:#0A1628;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="db-member-name">{{ auth()->user()->name }}</div>
                        <div class="db-member-meta">Primary account</div>
                    </div>
                </div>
                <span class="db-status healthy">Healthy</span>
            </div>
            <div style="padding:24px 0;text-align:center;">
                <div style="font-size:28px;margin-bottom:8px;">👨‍👩‍👧</div>
                <div style="font-size:13px;font-weight:600;color:#64748B;margin-bottom:4px;">Add family members</div>
                <div style="font-size:12px;color:#94A3B8;margin-bottom:14px;">Track health for your whole family</div>
                <a href="/family" style="background:rgba(0,214,143,0.1);color:#00B377;border:1px solid rgba(0,214,143,0.2);border-radius:8px;padding:7px 18px;font-size:12px;font-weight:600;text-decoration:none;">+ Add Member</a>
            </div>
        @endif
    </div>

</div>

{{-- ===== RECENT CONSULTATIONS ===== --}}
<div class="db-card">
    <div class="db-card-header">
        <span class="db-card-title">Recent consultations</span>
        <a href="/consultations" class="db-card-action">View all</a>
    </div>

    @if(isset($recentConsultations) && $recentConsultations->count() > 0)
        @foreach($recentConsultations as $c)
        <div class="db-recent-item">
            <div class="db-recent-icon" style="background:#DCFCE7;">🧠</div>
            <div>
                <div class="db-recent-title">{{ $c->title }}</div>
                <div class="db-recent-sub">{{ $c->summary }}</div>
            </div>
            <span class="db-recent-time">{{ $c->created_at->diffForHumans() }}</span>
        </div>
        @endforeach
    @else
        <div class="db-empty">
            <div class="db-empty-icon">💬</div>
            <div class="db-empty-title">No consultations yet</div>
            <div class="db-empty-sub" style="margin-bottom:16px;">Start your first consultation to get AI-powered health guidance</div>
            <a href="/consultation/new" class="db-new-btn" style="font-size:13px;padding:9px 20px;">Start First Consultation</a>
        </div>
    @endif
</div>

@endsection
