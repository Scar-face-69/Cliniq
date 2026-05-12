@extends('layouts.dashboard')

@section('title', 'Consultation History — ClinIQ')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap');
.ch-page{font-family:'DM Sans',sans-serif;}
.ch-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px;}
.ch-breadcrumb{font-size:12px;color:#475569;margin-bottom:6px;}
.ch-breadcrumb a{color:#475569;text-decoration:none;}
.ch-breadcrumb em{color:#DC2626;font-style:normal;}
.ch-title{font-size:24px;font-weight:700;color:white;letter-spacing:-0.5px;margin-bottom:4px;}
.ch-sub{font-size:13px;color:#475569;}
.ch-new-btn{background:#DC2626;color:#fff;border:none;border-radius:9px;padding:10px 20px;font-size:13px;font-weight:700;cursor:pointer;text-decoration:none;display:inline-block;transition:transform 0.2s,box-shadow 0.2s;font-family:'DM Sans',sans-serif;}
.ch-new-btn:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(220,38,38,0.3);}

.ch-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px;}
.ch-stat{background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:14px;padding:18px 20px;position:relative;overflow:hidden;}
.ch-stat::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--sc,#DC2626),transparent);}
.ch-stat-label{font-size:11px;color:#475569;margin-bottom:8px;text-transform:uppercase;letter-spacing:1px;font-weight:600;}
.ch-stat-value{font-size:26px;font-weight:700;color:white;margin-bottom:4px;}
.ch-stat-badge{display:inline-flex;font-size:10px;font-weight:600;padding:2px 8px;border-radius:100px;}
.ch-stat-badge.g{background:#F3F4F6;color:#6B7280;}
.ch-stat-badge.a{background:#FEF3C7;color:#92400E;}
.ch-stat-badge.r{background:#FEE2E2;color:#991B1B;}
.ch-stat-badge.b{background:#F3F4F6;color:#6B7280;}

.ch-filters{display:flex;gap:10px;margin-bottom:20px;align-items:center;flex-wrap:wrap;}
.ch-filter-btn{display:inline-flex;align-items:center;gap:7px;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);color:#64748B;border-radius:8px;padding:7px 16px;font-size:12px;cursor:pointer;font-weight:600;font-family:'DM Sans',sans-serif;transition:all 0.2s;}
.ch-filter-btn svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0;}
.ch-filter-btn:hover,.ch-filter-btn.active{background:rgba(220,38,38,0.08);border-color:rgba(220,38,38,0.25);color:#F87171;}
.ch-search{flex:1;max-width:280px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:8px;padding:7px 14px;font-size:12px;color:white;outline:none;font-family:'DM Sans',sans-serif;}
.ch-search::placeholder{color:#334155;}

.ch-table-wrap{background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:18px;overflow:hidden;margin-bottom:20px;}
.ch-table-header{display:grid;grid-template-columns:2fr 1.2fr 1fr 1fr 1fr minmax(220px,1fr);gap:12px;padding:12px 20px;border-bottom:1px solid rgba(255,255,255,0.05);background:rgba(255,255,255,0.02);}
.ch-th{font-size:10px;font-weight:700;color:#334155;letter-spacing:1px;text-transform:uppercase;}
.ch-row{display:grid;grid-template-columns:2fr 1.2fr 1fr 1fr 1fr minmax(220px,1fr);gap:12px;padding:16px 20px;border-bottom:1px solid rgba(255,255,255,0.04);align-items:center;transition:background 0.2s;cursor:pointer;}
.ch-row:hover{background:rgba(255,255,255,0.03);}
.ch-row:last-child{border-bottom:none;}
.ch-symptom{display:flex;align-items:center;gap:10px;}
.ch-symptom-icon{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:rgba(243,244,246,0.08);color:#94A3B8;}
.ch-symptom-icon svg{width:18px;height:18px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;}
.ch-symptom-text{font-size:13px;font-weight:600;color:white;margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:180px;}
.ch-symptom-sub{font-size:11px;color:#475569;}
.ch-member{display:flex;align-items:center;gap:8px;}
.ch-member-avatar{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;flex-shrink:0;background:#2D2D2D;color:#fff;}
.ch-member-name{font-size:12px;color:#94A3B8;font-weight:600;}
.ch-risk{display:inline-flex;align-items:center;gap:6px;font-size:11px;font-weight:700;padding:4px 10px;border-radius:100px;}
.ch-risk svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0;}
.ch-risk.low   {background:rgba(243,244,246,0.12);color:#D1D5DB;border:1px solid rgba(229,231,235,0.2);}
.ch-risk.medium{background:rgba(245,158,11,0.1);color:#F59E0B;border:1px solid rgba(245,158,11,0.15);}
.ch-risk.high  {background:rgba(239,68,68,0.1);color:#EF4444;border:1px solid rgba(239,68,68,0.15);}
.ch-date{font-size:12px;color:#64748B;}
.ch-conditions{font-size:11px;color:#64748B;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.ch-actions{display:flex;flex-wrap:wrap;gap:8px;align-items:center;justify-content:flex-end;}
.ch-act-btn{width:28px;height:28px;border-radius:7px;border:1px solid rgba(255,255,255,0.07);background:rgba(255,255,255,0.03);cursor:pointer;display:flex;align-items:center;justify-content:center;color:#64748B;transition:all 0.2s;text-decoration:none;}
.ch-act-btn svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;}
.ch-act-btn:hover{background:rgba(255,255,255,0.08);color:white;}
.ch-act-btn.del:hover{background:rgba(239,68,68,0.15);border-color:rgba(239,68,68,0.3);color:#EF4444;}

/* DETAIL MODAL */
.ch-modal-overlay{display:none;position:fixed;inset:0;background:rgba(6,14,28,0.85);backdrop-filter:blur(6px);z-index:1000;align-items:center;justify-content:center;}
.ch-modal-overlay.active{display:flex;}
.ch-modal{background:#111E35;border:1px solid rgba(255,255,255,0.08);border-radius:24px;width:100%;max-width:700px;max-height:90vh;overflow-y:auto;animation:modalIn 0.2s ease;}
@keyframes modalIn{from{transform:scale(0.95);opacity:0;}to{transform:scale(1);opacity:1;}}
.ch-modal-header{background:linear-gradient(135deg,#0A1628,#111827);padding:22px 28px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,255,255,0.06);position:sticky;top:0;}
.ch-modal-title{font-size:16px;font-weight:700;color:white;}
.ch-modal-meta{font-size:12px;color:#475569;margin-top:2px;}
.ch-modal-close{width:30px;height:30px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.08);border-radius:8px;cursor:pointer;color:#64748B;display:flex;align-items:center;justify-content:center;}
.ch-modal-close svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;}
.ch-modal-body{padding:24px 28px;}
.ch-modal-section{font-size:10px;font-weight:700;color:#F87171;letter-spacing:2px;text-transform:uppercase;margin-bottom:12px;margin-top:4px;display:flex;align-items:center;gap:10px;}
.ch-modal-section::after{content:'';flex:1;height:1px;background:rgba(220,38,38,0.2);}
.ch-modal-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;}
.ch-modal-card{background:rgba(255,255,255,0.03);border-radius:12px;padding:16px;border:1px solid rgba(255,255,255,0.05);}
.ch-modal-card-title{font-size:10px;color:#475569;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:12px;}
.ch-cond-row{display:flex;align-items:center;gap:8px;margin-bottom:8px;}
.ch-cond-name{font-size:12px;color:#94A3B8;width:90px;flex-shrink:0;}
.ch-cond-bar-wrap{flex:1;height:5px;background:rgba(255,255,255,0.06);border-radius:100px;overflow:hidden;}
.ch-cond-bar{height:100%;border-radius:100px;}
.ch-cond-pct{font-size:11px;font-weight:700;width:30px;text-align:right;}
.ch-rec-item{display:flex;gap:8px;font-size:12px;color:#94A3B8;margin-bottom:8px;line-height:1.5;}
.ch-rec-dot{width:5px;height:5px;border-radius:50%;background:#6B7280;flex-shrink:0;margin-top:5px;}
.ch-risk-banner{display:flex;align-items:center;gap:12px;padding:14px 16px;border-radius:12px;margin-bottom:16px;}
.ch-risk-banner.low   {background:rgba(243,244,246,0.08);border:1px solid rgba(229,231,235,0.15);}
.ch-risk-banner.medium{background:rgba(245,158,11,0.06);border:1px solid rgba(245,158,11,0.15);}
.ch-risk-banner.high  {background:rgba(239,68,68,0.06);border:1px solid rgba(239,68,68,0.15);}
.ch-risk-banner-label{font-size:14px;font-weight:700;}
.ch-risk-banner.low    .ch-risk-banner-label{color:#D1D5DB;}
.ch-risk-banner.medium .ch-risk-banner-label{color:#F59E0B;}
.ch-risk-banner.high   .ch-risk-banner-label{color:#EF4444;}
.ch-risk-banner-icon{display:flex;align-items:center;color:inherit;}
.ch-risk-banner-icon svg{width:22px;height:22px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;}
.ch-risk-banner-exp{font-size:12px;color:#64748B;margin-top:2px;}
.ch-symptoms-text{font-size:13px;color:#94A3B8;line-height:1.7;background:rgba(255,255,255,0.03);border-radius:10px;padding:14px;border:1px solid rgba(255,255,255,0.05);}
.ch-disclaimer{display:flex;gap:10px;align-items:flex-start;font-size:11px;color:#334155;padding:12px 14px;background:rgba(255,255,255,0.02);border-radius:8px;border:1px solid rgba(255,255,255,0.04);margin-top:16px;}
.ch-disclaimer svg{width:16px;height:16px;stroke:#64748B;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0;margin-top:1px;}
.ch-modal-footer{padding:16px 28px 24px;display:flex;gap:10px;border-top:1px solid rgba(255,255,255,0.05);}
.ch-modal-btn{flex:1;padding:11px;border-radius:10px;font-size:13px;font-weight:700;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;display:inline-flex;align-items:center;justify-content:center;gap:8px;}
.ch-modal-btn.primary{background:#DC2626;color:#fff;}
.ch-modal-btn.primary svg{width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;}
.ch-modal-btn.secondary{background:rgba(255,255,255,0.04);color:#64748B;border:1px solid rgba(255,255,255,0.08);}

/* EMPTY STATE */
.ch-empty{text-align:center;padding:60px 20px;}
.ch-empty-icon{width:48px;height:48px;margin:0 auto 14px;display:flex;align-items:center;justify-content:center;color:#94A3B8;}
.ch-empty-icon svg{width:28px;height:28px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;}
.ch-empty-title{font-size:18px;font-weight:700;color:white;margin-bottom:8px;}
.ch-empty-sub{font-size:14px;color:#475569;margin-bottom:24px;}

/* PAGINATION */
.ch-pagination{display:flex;justify-content:center;gap:8px;margin-top:20px;}
.ch-page-btn{width:36px;height:36px;border-radius:8px;border:1px solid rgba(255,255,255,0.08);background:rgba(255,255,255,0.03);color:#64748B;font-size:13px;cursor:pointer;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:all 0.2s;}
.ch-page-btn.active,.ch-page-btn:hover{background:rgba(220,38,38,0.12);border-color:rgba(220,38,38,0.25);color:#FCA5A5;}

@media(max-width:768px){
    .ch-stats{grid-template-columns:repeat(2,1fr);}
    .ch-table-header{display:none;}
    .ch-row{grid-template-columns:1fr;gap:8px;}
}
</style>
@endpush

@push('styles')
<script src="https://cdn.tailwindcss.com"></script>
@endpush

@section('content')
<div class="ch-page">

{{-- HEADER --}}
<div class="ch-header">
    <div>
        <div class="ch-breadcrumb">
            <a href="/dashboard">Dashboard</a> › <em>Consultation History</em>
        </div>
        <div class="ch-title">Consultation History</div>
        <div class="ch-sub">All your past AI health consultations in one place</div>
    </div>
    <a href="/consultation/new" class="ch-new-btn">+ New Consultation</a>
</div>

{{-- STATS --}}
<div class="ch-stats">
    <div class="ch-stat" style="--sc:#DC2626;">
        <div class="ch-stat-label">Total Sessions</div>
        <div class="ch-stat-value">{{ $stats['total'] }}</div>
        <span class="ch-stat-badge b">All time</span>
    </div>
    <div class="ch-stat" style="--sc:#9CA3AF;">
        <div class="ch-stat-label">Low Risk</div>
        <div class="ch-stat-value">{{ $stats['low'] }}</div>
        <span class="ch-stat-badge g">{{ $stats['total'] > 0 ? round(($stats['low'] / $stats['total']) * 100) : 0 }}%</span>
    </div>
    <div class="ch-stat" style="--sc:#F59E0B;">
        <div class="ch-stat-label">Medium Risk</div>
        <div class="ch-stat-value">{{ $stats['medium'] }}</div>
        <span class="ch-stat-badge a">{{ $stats['total'] > 0 ? round(($stats['medium'] / $stats['total']) * 100) : 0 }}%</span>
    </div>
    <div class="ch-stat" style="--sc:#EF4444;">
        <div class="ch-stat-label">High Risk</div>
        <div class="ch-stat-value">{{ $stats['high'] }}</div>
        <span class="ch-stat-badge r">{{ $stats['total'] > 0 ? round(($stats['high'] / $stats['total']) * 100) : 0 }}%</span>
    </div>
</div>

{{-- FILTERS --}}
<div class="ch-filters">
    <button type="button" class="ch-filter-btn active" onclick="filterRisk('all', this)">All</button>
    <button type="button" class="ch-filter-btn" onclick="filterRisk('low', this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>Low Risk</button>
    <button type="button" class="ch-filter-btn" onclick="filterRisk('medium', this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>Medium Risk</button>
    <button type="button" class="ch-filter-btn" onclick="filterRisk('high', this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>High Risk</button>
    <input class="ch-search" type="text" placeholder="Search symptoms..." onkeyup="searchConsultations(this.value)" />
</div>

{{-- TABLE --}}
@if($consultations->count() > 0)
<div class="ch-table-wrap">
    <div class="ch-table-header">
        <div class="ch-th">Symptoms</div>
        <div class="ch-th">Member</div>
        <div class="ch-th">Risk Level</div>
        <div class="ch-th">Top Condition</div>
        <div class="ch-th">Date</div>
        <div class="ch-th">Actions</div>
    </div>

    @foreach($consultations as $c)
    @php
        $conditions  = $c->conditions ?? [];
        $topCondition = !empty($conditions) ? $conditions[0] : null;
        $sLower = strtolower($c->symptoms);
        $symptomSvg = match(true) {
            str_contains($sLower, 'fever') => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 14.76V3.5a2.5 2.5 0 00-5 0v11.26a4.5 4.5 0 105 0z"/></svg>',
            str_contains($sLower, 'chest') => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>',
            str_contains($sLower, 'stomach') => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/></svg>',
            str_contains($sLower, 'head') => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>',
            str_contains($sLower, 'breath') => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9.59 4.59A2 2 0 1112 10H2m11.59 5.41A2 2 0 1014 14H2m15.59-7.41A2 2 0 1118 10H2"/></svg>',
            default => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>',
        };
        $riskSvg = match($c->risk_level) {
            'high' => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>',
            'medium' => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>',
            default => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
        };
    @endphp
    <div class="ch-row" data-risk="{{ $c->risk_level }}" data-symptoms="{{ strtolower($c->symptoms) }}"
         onclick="openDetail({{ $c->id }})">
        <div class="ch-symptom">
            <div class="ch-symptom-icon">{!! $symptomSvg !!}</div>
            <div>
                <div class="ch-symptom-text">{{ Str::limit($c->symptoms, 40) }}</div>
                <div class="ch-symptom-sub">{{ now()->parse($c->created_at)->format('h:i A') }}</div>
            </div>
        </div>
        <div class="ch-member">
            @if($c->familyMember)
                <div class="ch-member-avatar" style="background:{{ $c->familyMember->avatar_color }};color:white;">
                    {{ $c->familyMember->initials }}
                </div>
                <span class="ch-member-name">{{ $c->familyMember->name }}</span>
            @else
                <div class="ch-member-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <span class="ch-member-name">{{ explode(' ', auth()->user()->name)[0] }}</span>
            @endif
        </div>
        <div><span class="ch-risk {{ $c->risk_level }}">{!! $riskSvg !!}<span>{{ ucfirst($c->risk_level) }}</span></span></div>
        <div class="ch-conditions">
            {{ $topCondition ? $topCondition['name'] . ' (' . $topCondition['probability'] . '%)' : 'N/A' }}
        </div>
        <div class="ch-date">{{ $c->created_at->diffForHumans() }}</div>
        <div class="ch-actions" onclick="event.stopPropagation()">
            <a href="{{ route('consultations.pdf', $c->id) }}"
               target="_blank"
               class="inline-flex items-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium px-4 py-2 rounded-xl transition duration-200 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h4a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                Download PDF
            </a>
            <a href="#" class="ch-act-btn" title="View" onclick="openDetail({{ $c->id }}); return false;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></a>
            <form method="POST" action="/consultations/{{ $c->id }}" style="display:inline;"
                  onsubmit="return confirm('Delete this consultation?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="ch-act-btn del" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg></button>
            </form>
        </div>
    </div>
    @endforeach
</div>

{{-- PAGINATION --}}
@if($consultations->hasPages())
<div class="ch-pagination">
    {{$consultations->links()}}
</div>
@endif

@else
<div class="ch-table-wrap">
    <div class="ch-empty">
        <div class="ch-empty-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg></div>
        <div class="ch-empty-title">No consultations yet</div>
        <div class="ch-empty-sub">Start your first AI consultation to see your history here</div>
        <a href="/consultation/new" class="ch-new-btn">Start First Consultation</a>
    </div>
</div>
@endif

{{-- DETAIL MODAL --}}
<div class="ch-modal-overlay" id="detailModal">
    <div class="ch-modal">
        <div class="ch-modal-header">
            <div>
                <div class="ch-modal-title" id="modalTitle">Consultation Detail</div>
                <div class="ch-modal-meta" id="modalMeta"></div>
            </div>
            <button type="button" class="ch-modal-close" onclick="closeDetail()" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
        </div>
        <div class="ch-modal-body" id="modalBody">
            <div style="text-align:center;padding:40px;color:#475569;">Loading...</div>
        </div>
        <div class="ch-modal-footer">
            <button type="button" class="ch-modal-btn primary" onclick="window.location.href='/consultation/new'"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 11-2.12-9.36L23 10"/></svg>New Consultation</button>
            <button type="button" class="ch-modal-btn secondary" onclick="closeDetail()">Close</button>
        </div>
    </div>
</div>

</div>{{-- .ch-page --}}

{{-- Store consultation data for JS --}}
<script>
const consultations = @json($consultations->items());
</script>

@endsection

@push('scripts')
<script>
function filterRisk(risk, btn) {
    document.querySelectorAll('.ch-filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.ch-row').forEach(row => {
        row.style.display = (risk === 'all' || row.dataset.risk === risk) ? '' : 'none';
    });
}

function searchConsultations(query) {
    document.querySelectorAll('.ch-row').forEach(row => {
        row.style.display = row.dataset.symptoms.includes(query.toLowerCase()) ? '' : 'none';
    });
}

function openDetail(id) {
    const c = consultations.find(c => c.id === id);
    if (!c) return;

    const risk      = c.risk_level || 'low';
    const riskBannerSvg = risk === 'high'
        ? '<span class="ch-risk-banner-icon"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></span>'
        : risk === 'medium'
        ? '<span class="ch-risk-banner-icon"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></span>'
        : '<span class="ch-risk-banner-icon"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></span>';
    const riskLabel = risk.toUpperCase() + ' RISK';
    const conditions = c.conditions || [];
    const recs       = c.recommendations || [];

    document.getElementById('modalTitle').textContent = 'Consultation — ' + c.symptoms.substring(0, 40);
    document.getElementById('modalMeta').textContent  = new Date(c.created_at).toLocaleString();

    let condsHtml = '';
    conditions.forEach(cond => {
        const pct   = cond.probability || 0;
        const color = pct >= 60 ? 'linear-gradient(90deg,#9CA3AF,#D1D5DB)' : pct >= 35 ? 'linear-gradient(90deg,#D97706,#F59E0B)' : 'linear-gradient(90deg,#DC2626,#EF4444)';
        const clr   = pct >= 60 ? '#6B7280' : pct >= 35 ? '#F59E0B' : '#EF4444';
        condsHtml  += `<div class="ch-cond-row">
            <span class="ch-cond-name">${cond.name}</span>
            <div class="ch-cond-bar-wrap"><div class="ch-cond-bar" style="width:${pct}%;background:${color};"></div></div>
            <span class="ch-cond-pct" style="color:${clr};">${pct}%</span>
        </div>`;
    });

    let recsHtml = '';
    recs.forEach(r => { recsHtml += `<div class="ch-rec-item"><div class="ch-rec-dot"></div>${r}</div>`; });

    document.getElementById('modalBody').innerHTML = `
        <div class="ch-modal-section">Reported Symptoms</div>
        <div class="ch-symptoms-text">${c.symptoms}</div>

        <div class="ch-modal-section" style="margin-top:16px;">Risk Assessment</div>
        <div class="ch-risk-banner ${risk}">
            ${riskBannerSvg}
            <div>
                <div class="ch-risk-banner-label">${riskLabel}</div>
                <div class="ch-risk-banner-exp">${c.ai_response?.risk_explanation || 'See recommendations below.'}</div>
            </div>
        </div>

        <div class="ch-modal-grid">
            <div class="ch-modal-card">
                <div class="ch-modal-card-title">Possible Conditions</div>
                ${condsHtml || '<div style="font-size:12px;color:#475569;">No conditions data</div>'}
            </div>
            <div class="ch-modal-card">
                <div class="ch-modal-card-title">Recommendations</div>
                ${recsHtml || '<div style="font-size:12px;color:#475569;">No recommendations data</div>'}
            </div>
        </div>

        <div class="ch-disclaimer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            <span>This information is for guidance only and is not a substitute for a licensed medical professional.</span>
        </div>`;

    document.getElementById('detailModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeDetail() {
    document.getElementById('detailModal').classList.remove('active');
    document.body.style.overflow = '';
}

document.getElementById('detailModal').addEventListener('click', function(e) {
    if (e.target === this) closeDetail();
});
</script>
@endpush
