@extends('layouts.dashboard')

@section('title', 'Dashboard — ClinIQ')

@section('content')

{{-- ===== TOP BAR ===== --}}
<div class="db-topbar">
    <div class="db-greeting">
        <h1>Good {{ now()->format('H') < 12 ? 'morning' : (now()->format('H') < 17 ? 'afternoon' : 'evening') }}, {{ explode(' ', auth()->user()->name)[0] }}</h1>
        <p>Here's your family health overview for today</p>
    </div>
    <div class="db-topbar-right">
        <a href="/consultation/new" class="db-new-btn">+ New Consultation</a>
    </div>
</div>

{{-- ===== ALERT BANNER ===== --}}
<div class="db-alert-banner">
    <div class="db-alert-icon">
        <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
    </div>
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
            <span class="db-stat-icon">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            </span>
            Family members
        </div>
        <div class="db-stat-value">{{ $memberCount ?? 1 }}</div>
        <span class="db-stat-badge">All monitored</span>
    </div>

    <div class="db-stat-card">
        <div class="db-stat-label">
            <span class="db-stat-icon">
                <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
            </span>
            Consultations
        </div>
        <div class="db-stat-value">{{ $consultationCount ?? 0 }}</div>
        <span class="db-stat-badge">This month</span>
    </div>

    <div class="db-stat-card">
        <div class="db-stat-label">
            <span class="db-stat-icon">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            </span>
            Lab reports
        </div>
        <div class="db-stat-value">{{ $reportCount ?? 0 }}</div>
        <span class="db-stat-badge">All analyzed</span>
    </div>

    <div class="db-stat-card">
        <div class="db-stat-label">
            <span class="db-stat-icon">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </span>
            Risk alerts
        </div>
        <div class="db-stat-value">{{ $alertCount ?? 0 }}</div>
        <span class="db-stat-badge {{ ($alertCount ?? 0) > 0 ? 'red' : '' }}">
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
                    <div class="db-member-avatar">
                        {{ strtoupper(substr($member->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="db-member-name">{{ $member->name }}</div>
                        <div class="db-member-meta">{{ $member->age }} yrs &middot; {{ $member->relation }}</div>
                    </div>
                </div>
                <span class="db-status">Stable</span>
            </div>
            @endforeach
        @else
            {{-- Default: show logged in user --}}
            <div class="db-member-item">
                <div class="db-member-left">
                    <div class="db-member-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="db-member-name">{{ auth()->user()->name }}</div>
                        <div class="db-member-meta">Primary account</div>
                    </div>
                </div>
                <span class="db-status">Stable</span>
            </div>

            <div class="db-add-member-cta">
                <div class="db-add-member-cta-title">Add family members</div>
                <div class="db-add-member-cta-sub">Track health for your whole family</div>
                <a href="/family" class="db-add-member-cta-btn">+ Add Member</a>
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
        <a href="/consultations/{{ $c->id }}" class="db-recent-item">
            <div class="db-recent-icon">
                {{ strtoupper(substr($c->title, 0, 2)) }}
            </div>
            <div>
                <div class="db-recent-title">{{ $c->title }}</div>
                <div class="db-recent-sub">{{ $c->summary }}</div>
            </div>
            <span class="db-recent-time">{{ $c->created_at->diffForHumans() }}</span>
        </a>
        @endforeach
    @else
        <div class="db-empty">
            <div class="db-empty-icon">
                <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
            </div>
            <div class="db-empty-title">No consultations yet</div>
            <div class="db-empty-sub" style="margin-bottom:16px;">Start your first consultation to get AI-powered health guidance</div>
            <a href="/consultation/new" class="db-new-btn" style="font-size:13px;padding:9px 20px;">Start First Consultation</a>
        </div>
    @endif
</div>

@endsection