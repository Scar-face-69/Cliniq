<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: 'DejaVu Sans', sans-serif;
        font-size: 13px;
        color: #0F172A;
        background: #ffffff;
        padding: 40px;
        line-height: 1.6;
    }

    /* Header */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 2px solid #2563EB;
        padding-bottom: 20px;
        margin-bottom: 28px;
    }
    .logo { font-size: 22px; font-weight: 700; color: #2563EB; }
    .logo span { color: #0F172A; }
    .doc-meta { text-align: right; font-size: 11px; color: #64748B; }
    .doc-meta strong { color: #0F172A; font-size: 12px; }

    /* Disclaimer */
    .disclaimer {
        background: #FEF9C3;
        border-left: 4px solid #EAB308;
        padding: 10px 14px;
        border-radius: 4px;
        font-size: 11px;
        color: #713F12;
        margin-bottom: 24px;
    }

    /* Section */
    .section { margin-bottom: 24px; }
    .section-title {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #64748B;
        margin-bottom: 10px;
        padding-bottom: 6px;
        border-bottom: 1px solid #E2E8F0;
    }

    /* Patient + Consultation Info */
    .info-grid {
        display: table;
        width: 100%;
    }
    .info-row { display: table-row; }
    .info-label {
        display: table-cell;
        width: 140px;
        font-size: 11px;
        color: #64748B;
        padding: 4px 0;
    }
    .info-value {
        display: table-cell;
        font-size: 12px;
        font-weight: 500;
        color: #0F172A;
        padding: 4px 0;
    }

    /* Symptoms box */
    .symptoms-box {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 6px;
        padding: 12px 16px;
        font-size: 13px;
        color: #0F172A;
    }

    /* Risk badge */
    .risk-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .risk-low { background: #D1FAE5; color: #065F46; }
    .risk-medium { background: #FEF3C7; color: #92400E; }
    .risk-high { background: #FEE2E2; color: #991B1B; }

    .emergency-badge {
        display: inline-block;
        background: #FEE2E2;
        color: #991B1B;
        padding: 4px 12px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 700;
        margin-left: 8px;
    }

    /* Summary */
    .summary-text {
        font-size: 13px;
        color: #334155;
        line-height: 1.7;
    }

    /* Risk explanation */
    .risk-explanation {
        background: #EFF6FF;
        border-left: 4px solid #2563EB;
        padding: 10px 14px;
        border-radius: 4px;
        font-size: 12px;
        color: #1E40AF;
        margin-top: 10px;
    }

    /* Conditions table */
    .conditions-table { width: 100%; border-collapse: collapse; }
    .conditions-table th {
        text-align: left;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        color: #64748B;
        padding: 6px 10px;
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
    }
    .conditions-table td {
        padding: 8px 10px;
        border: 1px solid #E2E8F0;
        font-size: 12px;
        vertical-align: top;
    }
    .prob-bar-bg {
        background: #E2E8F0;
        border-radius: 99px;
        height: 6px;
        width: 100%;
        margin-top: 4px;
    }
    .prob-bar-fill {
        background: #2563EB;
        border-radius: 99px;
        height: 6px;
    }

    /* Recommendations */
    .rec-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 8px 0;
        border-bottom: 1px solid #F1F5F9;
        font-size: 12px;
        color: #334155;
    }
    .rec-number {
        min-width: 22px;
        height: 22px;
        background: #EFF6FF;
        color: #2563EB;
        border-radius: 50%;
        font-size: 10px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 1px;
    }

    /* Footer */
    .footer {
        margin-top: 40px;
        padding-top: 16px;
        border-top: 1px solid #E2E8F0;
        display: flex;
        justify-content: space-between;
        font-size: 10px;
        color: #94A3B8;
    }
</style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
    <div>
        <div class="logo">+Clin<span>IQ</span></div>
        <div style="font-size:11px; color:#64748B; margin-top:4px;">AI-Powered Health Consultation</div>
    </div>
    <div class="doc-meta">
        <strong>Consultation Report</strong><br>
        Report ID: #{{ $consultation->id }}<br>
        Generated: {{ now()->format('M d, Y h:i A') }}<br>
        Language: {{ strtoupper($consultation->language ?? 'en') }}
    </div>
</div>

{{-- DISCLAIMER --}}
<div class="disclaimer">
    ⚠ This report is generated by an AI system and is intended for informational purposes only.
    It is not a substitute for professional medical advice, diagnosis, or treatment.
    Always consult a qualified healthcare provider.
</div>

{{-- PATIENT INFO --}}
<div class="section">
    <div class="section-title">Patient Information</div>
    <div class="info-grid">
        <div class="info-row">
            <div class="info-label">Full Name</div>
            <div class="info-value">{{ $user->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Email</div>
            <div class="info-value">{{ $user->email }}</div>
        </div>
        @if($user->date_of_birth)
        <div class="info-row">
            <div class="info-label">Date of Birth</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($user->date_of_birth)->format('M d, Y') }}</div>
        </div>
        @endif
        @if($user->blood_group)
        <div class="info-row">
            <div class="info-label">Blood Group</div>
            <div class="info-value">{{ $user->blood_group }}</div>
        </div>
        @endif
        <div class="info-row">
            <div class="info-label">Consultation Date</div>
            <div class="info-value">{{ $consultation->created_at->format('M d, Y h:i A') }}</div>
        </div>
    </div>
</div>

{{-- SYMPTOMS --}}
<div class="section">
    <div class="section-title">Reported Symptoms</div>
    <div class="symptoms-box">{{ $consultation->symptoms }}</div>
</div>

{{-- RISK ASSESSMENT --}}
<div class="section">
    <div class="section-title">Risk Assessment</div>
    <span class="risk-badge risk-{{ $consultation->risk_level ?? 'low' }}">
        {{ strtoupper($consultation->risk_level ?? 'low') }} Risk
    </span>
    @if($consultation->is_emergency)
        <span class="emergency-badge">⚠ Emergency</span>
    @endif
    @if(!empty($consultation->ai_response['risk_explanation']))
        <div class="risk-explanation">
            {{ $consultation->ai_response['risk_explanation'] }}
        </div>
    @endif
</div>

{{-- AI SUMMARY --}}
@if(!empty($consultation->ai_response['summary']))
<div class="section">
    <div class="section-title">AI Summary</div>
    <div class="summary-text">{{ $consultation->ai_response['summary'] }}</div>
</div>
@endif

{{-- POSSIBLE CONDITIONS --}}
@if(!empty($consultation->ai_response['conditions']))
<div class="section">
    <div class="section-title">Possible Conditions</div>
    <table class="conditions-table">
        <thead>
            <tr>
                <th style="width:30%">Condition</th>
                <th style="width:15%">Probability</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultation->ai_response['conditions'] as $condition)
            <tr>
                <td><strong>{{ $condition['name'] }}</strong></td>
                <td>
                    {{ $condition['probability'] }}%
                    <div class="prob-bar-bg">
                        <div class="prob-bar-fill" style="width:{{ $condition['probability'] }}%"></div>
                    </div>
                </td>
                <td style="color:#475569">{{ $condition['description'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- RECOMMENDATIONS --}}
@if(!empty($consultation->ai_response['recommendations']))
<div class="section">
    <div class="section-title">Recommendations</div>
    @foreach($consultation->ai_response['recommendations'] as $index => $rec)
    <div class="rec-item">
        <div class="rec-number">{{ $index + 1 }}</div>
        <div>{{ $rec }}</div>
    </div>
    @endforeach
</div>
@endif

{{-- FOOTER --}}
<div class="footer">
    <div>ClinIQ — AI Health Consultation Platform</div>
    <div>This document was auto-generated. Not a medical prescription.</div>
</div>

</body>
</html>
