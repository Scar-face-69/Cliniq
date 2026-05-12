@php
    $risk       = $response['risk_level'] ?? 'low';
    $riskLabel  = strtoupper($risk) . ' RISK';
    $conditions = $response['conditions'] ?? [];
    $recs       = $response['recommendations'] ?? [];
    $otc        = $response['otc_medications'] ?? [];
@endphp

@php
    $riskSvgLow = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg>';
    $riskSvgMed = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>';
    $riskSvgHigh = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>';
    $riskIconSvg = $risk === 'high' ? $riskSvgHigh : ($risk === 'medium' ? $riskSvgMed : $riskSvgLow);
@endphp

<div class="msg-row ai">
    <div class="msg-avatar ai">+</div>
    <div class="msg-content">
        <div class="ai-card">
            <div class="ai-card-header">
                <span class="ai-card-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></span>
                <span class="ai-card-title">AI Analysis Complete</span>
            </div>
            <div class="ai-card-body">

                @if(!empty($response['summary']))
                <div class="ai-card-section">
                    <div class="ai-section-title">Summary</div>
                    <div class="ai-summary">{{ $response['summary'] }}</div>
                </div>
                @endif

                @if(!empty($conditions))
                <div class="ai-card-section">
                    <div class="ai-section-title">Possible Conditions</div>
                    <div class="ai-conditions">
                        @foreach($conditions as $c)
                        @php
                            $pct   = $c['probability'] ?? 0;
                            $color = $pct >= 60
                                ? 'linear-gradient(90deg,#6B7280,#9CA3AF)'
                                : ($pct >= 35 ? 'linear-gradient(90deg,#D97706,#F59E0B)' : 'linear-gradient(90deg,#DC2626,#EF4444)');
                            $clr   = $pct >= 60 ? '#6B7280' : ($pct >= 35 ? '#F59E0B' : '#EF4444');
                        @endphp
                        <div class="ai-condition">
                            <span class="ai-cond-name">{{ $c['name'] }}</span>
                            <div class="ai-cond-bar-wrap">
                                <div class="ai-cond-bar" style="width:{{ $pct }}%;background:{{ $color }};"></div>
                            </div>
                            <span class="ai-cond-pct" style="color:{{ $clr }};">{{ $pct }}%</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="ai-card-section">
                    <div class="ai-section-title">Risk Level</div>
                    <div class="ai-risk {{ $risk }}">
                        <span class="ai-risk-icon">{!! $riskIconSvg !!}</span>
                        <div>
                            <div class="ai-risk-level">{{ $riskLabel }}</div>
                            <div class="ai-risk-exp">{{ $response['risk_explanation'] ?? '' }}</div>
                        </div>
                    </div>
                </div>

                @if(!empty($recs))
                <div class="ai-card-section">
                    <div class="ai-section-title">Recommendations</div>
                    <div class="ai-recs">
                        @foreach($recs as $r)
                        <div class="ai-rec"><div class="ai-rec-dot"></div>{{ $r }}</div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(!empty($otc))
                <div class="ai-card-section">
                    <div class="ai-section-title">Safe OTC Medications</div>
                    <div class="ai-otc">
                        @foreach($otc as $m)
                        <div class="ai-otc-item">
                            <div>
                                <div class="ai-otc-name">{{ $m['name'] }}</div>
                                <div class="ai-otc-dose">{{ $m['dosage'] }} • {{ $m['frequency'] }}</div>
                            </div>
                            <span class="ai-otc-safe">OTC Safe</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(!empty($response['when_to_seek_help']))
                <div class="ai-card-section">
                    <div class="ai-section-title">When to See a Doctor</div>
                    <div class="ai-summary">{{ $response['when_to_seek_help'] }}</div>
                </div>
                @endif

                <div class="ai-disclaimer">
                    {{ $response['disclaimer'] ?? 'This information is for guidance only.' }}
                </div>
            </div>
            <div class="ai-card-footer">
                <button type="button" class="ai-footer-btn primary" onclick="window.open('https://www.google.com/maps/search/doctor+near+me')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Find Doctor
                </button>
                <button type="button" class="ai-footer-btn secondary" onclick="window.print()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Save Report
                </button>
            </div>
        </div>
    </div>
</div>
