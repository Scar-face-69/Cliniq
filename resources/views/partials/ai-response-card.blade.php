@php
    $risk       = $response['risk_level'] ?? 'low';
    $riskIcon   = $risk === 'high' ? '🚨' : ($risk === 'medium' ? '⚠️' : '✅');
    $riskLabel  = strtoupper($risk) . ' RISK';
    $conditions = $response['conditions'] ?? [];
    $recs       = $response['recommendations'] ?? [];
    $otc        = $response['otc_medications'] ?? [];
@endphp

<div class="msg-row ai">
    <div class="msg-avatar ai">+</div>
    <div class="msg-content">
        <div class="ai-card">
            <div class="ai-card-header">
                <span class="ai-card-icon">🧠</span>
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
                                ? 'linear-gradient(90deg,#00B377,#00D68F)'
                                : ($pct >= 35 ? 'linear-gradient(90deg,#D97706,#F59E0B)' : 'linear-gradient(90deg,#DC2626,#EF4444)');
                            $clr   = $pct >= 60 ? '#00D68F' : ($pct >= 35 ? '#F59E0B' : '#EF4444');
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
                        <span class="ai-risk-icon">{{ $riskIcon }}</span>
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
                            <span class="ai-otc-safe">OTC Safe ✓</span>
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
                    ⚕ {{ $response['disclaimer'] ?? 'This information is for guidance only.' }}
                </div>
            </div>
            <div class="ai-card-footer">
                <button class="ai-footer-btn primary" onclick="window.open('https://www.google.com/maps/search/doctor+near+me')">🏥 Find Doctor</button>
                <button class="ai-footer-btn secondary" onclick="window.print()">📄 Save Report</button>
            </div>
        </div>
    </div>
</div>