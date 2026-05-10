@extends('layouts.dashboard')

@section('title', 'Lab Reports — ClinIQ')

@push('styles')
<style>
.lr-breadcrumb{font-size:12px;color:#475569;margin-bottom:6px;}
.lr-breadcrumb a{color:#475569;text-decoration:none;}
.lr-breadcrumb em{color:#00D68F;font-style:normal;}
.lr-title{font-size:24px;font-weight:700;color:white;letter-spacing:-0.5px;margin-bottom:4px;}
.lr-sub{font-size:13px;color:#475569;margin-bottom:24px;}
.lr-flash{padding:12px 18px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:20px;display:flex;align-items:center;gap:10px;}
.lr-flash.success{background:rgba(0,214,143,0.08);border:1px solid rgba(0,214,143,0.2);color:#00D68F;}
.lr-flash.error{background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);color:#EF4444;}
.lr-upload-zone{border:2px dashed rgba(0,214,143,0.2);border-radius:20px;padding:48px 32px;text-align:center;background:rgba(0,214,143,0.02);margin-bottom:24px;transition:all 0.2s;cursor:pointer;}
.lr-upload-zone:hover,.lr-upload-zone.dragover{border-color:rgba(0,214,143,0.5);background:rgba(0,214,143,0.05);}
.lr-upload-icon{width:72px;height:72px;border-radius:50%;background:rgba(0,214,143,0.08);border:2px solid rgba(0,214,143,0.15);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;font-size:32px;}
.lr-upload-title{font-size:18px;font-weight:700;color:white;margin-bottom:8px;}
.lr-upload-sub{font-size:13px;color:#475569;margin-bottom:20px;line-height:1.6;}
.lr-upload-btn{background:linear-gradient(135deg,#00D68F,#00B377);color:#0A1628;border:none;border-radius:10px;padding:11px 28px;font-size:14px;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;}
.lr-upload-formats{display:flex;gap:8px;justify-content:center;margin-top:16px;flex-wrap:wrap;}
.lr-format-badge{background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:#475569;font-size:11px;font-weight:600;padding:4px 12px;border-radius:6px;}
.lr-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px;}
.lr-stat{background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:14px;padding:16px 18px;position:relative;overflow:hidden;}
.lr-stat::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--sc,#00D68F),transparent);}
.lr-stat-label{font-size:11px;color:#475569;margin-bottom:6px;text-transform:uppercase;letter-spacing:1px;font-weight:600;}
.lr-stat-value{font-size:24px;font-weight:700;color:white;margin-bottom:4px;}
.lr-stat-badge{display:inline-flex;font-size:10px;font-weight:600;padding:2px 8px;border-radius:100px;}
.lr-stat-badge.g{background:rgba(0,214,143,0.12);color:#00D68F;}
.lr-stat-badge.a{background:rgba(245,158,11,0.12);color:#F59E0B;}
.lr-stat-badge.b{background:rgba(96,165,250,0.12);color:#60A5FA;}
.lr-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;}
.lr-card{background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:18px;overflow:hidden;transition:border-color 0.2s;}
.lr-card:hover{border-color:rgba(0,214,143,0.2);}
.lr-card-top{padding:16px 20px;border-bottom:1px solid rgba(255,255,255,0.05);display:flex;align-items:center;gap:12px;}
.lr-file-icon{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;}
.lr-card-name{font-size:13px;font-weight:700;color:white;margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:180px;}
.lr-card-meta{font-size:11px;color:#475569;}
.lr-card-actions{margin-left:auto;display:flex;gap:6px;flex-shrink:0;}
.lr-act-btn{width:28px;height:28px;border-radius:7px;border:1px solid rgba(255,255,255,0.07);background:rgba(255,255,255,0.03);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:12px;color:#64748B;transition:all 0.2s;}
.lr-act-btn:hover{background:rgba(255,255,255,0.08);color:white;}
.lr-act-btn.del:hover{background:rgba(239,68,68,0.15);border-color:rgba(239,68,68,0.3);color:#EF4444;}
.lr-card-body{padding:16px 20px;}
.lr-analysis-header{display:flex;align-items:center;gap:8px;margin-bottom:12px;}
.lr-analysis-title{font-size:12px;font-weight:700;color:#00D68F;}
.lr-values{display:flex;flex-direction:column;gap:7px;margin-bottom:12px;}
.lr-value-row{display:flex;align-items:center;justify-content:space-between;background:rgba(255,255,255,0.03);border-radius:8px;padding:9px 12px;border:1px solid rgba(255,255,255,0.04);}
.lr-value-name{font-size:12px;color:#94A3B8;font-weight:600;}
.lr-value-range{font-size:10px;color:#334155;margin-top:1px;}
.lr-value-result{font-size:12px;font-weight:700;}
.lr-value-result.normal{color:#00D68F;}
.lr-value-result.high{color:#EF4444;}
.lr-value-result.low{color:#F59E0B;}
.lr-value-badge{font-size:10px;font-weight:700;padding:2px 7px;border-radius:100px;margin-top:2px;display:inline-block;}
.lr-value-badge.normal{background:rgba(0,214,143,0.1);color:#00D68F;}
.lr-value-badge.high{background:rgba(239,68,68,0.1);color:#EF4444;}
.lr-value-badge.low{background:rgba(245,158,11,0.1);color:#F59E0B;}
.lr-summary{font-size:12px;color:#64748B;line-height:1.6;padding:10px 12px;background:rgba(255,255,255,0.02);border-radius:8px;border:1px solid rgba(255,255,255,0.04);}
.lr-card-footer{padding:12px 20px;border-top:1px solid rgba(255,255,255,0.05);display:flex;gap:8px;}
.lr-footer-btn{flex:1;padding:8px;border-radius:8px;font-size:12px;font-weight:700;border:none;cursor:pointer;font-family:'Inter',sans-serif;transition:all 0.2s;text-align:center;text-decoration:none;display:inline-block;}
.lr-footer-btn.primary{background:linear-gradient(135deg,#00D68F,#00B377);color:#0A1628;}
.lr-footer-btn.secondary{background:rgba(255,255,255,0.04);color:#64748B;border:1px solid rgba(255,255,255,0.08);}
.lr-empty{text-align:center;padding:60px 20px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:18px;}
.lr-empty-icon{font-size:48px;margin-bottom:14px;}
.lr-empty-title{font-size:18px;font-weight:700;color:white;margin-bottom:8px;}
.lr-empty-sub{font-size:14px;color:#475569;margin-bottom:24px;}
.lr-modal-overlay{display:none;position:fixed;inset:0;background:rgba(6,14,28,0.85);backdrop-filter:blur(6px);z-index:1000;align-items:center;justify-content:center;}
.lr-modal-overlay.active{display:flex;}
.lr-modal{background:#111E35;border:1px solid rgba(255,255,255,0.08);border-radius:24px;width:100%;max-width:500px;overflow:hidden;animation:modalIn 0.2s ease;}
.lr-detail-modal{background:#111E35;border:1px solid rgba(255,255,255,0.08);border-radius:24px;width:100%;max-width:640px;max-height:90vh;overflow-y:auto;animation:modalIn 0.2s ease;}
@keyframes modalIn{from{transform:scale(0.95);opacity:0;}to{transform:scale(1);opacity:1;}}
.lr-modal-header{background:linear-gradient(135deg,#0A1628,#0D3320);padding:22px 28px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,255,255,0.06);}
.lr-modal-title{font-size:16px;font-weight:700;color:white;}
.lr-modal-sub{font-size:12px;color:#475569;margin-top:2px;}
.lr-modal-close{width:30px;height:30px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.08);border-radius:8px;cursor:pointer;color:#64748B;font-size:14px;display:flex;align-items:center;justify-content:center;}
.lr-modal-body{padding:24px 28px;}
.lr-file-preview{background:rgba(0,214,143,0.04);border:1px solid rgba(0,214,143,0.15);border-radius:12px;padding:14px 16px;display:flex;align-items:center;gap:12px;margin-bottom:16px;}
.lr-file-preview-name{font-size:13px;font-weight:600;color:white;}
.lr-file-preview-size{font-size:11px;color:#475569;}
.lr-label{font-size:11px;font-weight:700;color:#64748B;margin-bottom:6px;display:block;letter-spacing:0.5px;text-transform:uppercase;}
.lr-select{width:100%;background:rgba(255,255,255,0.04);border:1.5px solid rgba(255,255,255,0.08);border-radius:10px;padding:10px 13px;font-size:13px;color:#94A3B8;outline:none;font-family:'Inter',sans-serif;margin-bottom:14px;}
.lr-select:focus{border-color:#00D68F;}
.lr-modal-footer{padding:16px 28px 24px;display:flex;gap:10px;}
.lr-modal-cancel{flex:1;background:rgba(255,255,255,0.04);color:#64748B;border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:12px;font-size:13px;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;}
.lr-modal-save{flex:2;background:linear-gradient(135deg,#00D68F,#00B377);color:#0A1628;border:none;border-radius:10px;padding:12px;font-size:13px;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;}
.lr-detail-body{padding:24px 28px;}
.lr-detail-section{font-size:10px;font-weight:700;color:#00D68F;letter-spacing:2px;text-transform:uppercase;margin-bottom:12px;display:flex;align-items:center;gap:10px;}
.lr-detail-section::after{content:'';flex:1;height:1px;background:rgba(0,214,143,0.1);}
.lr-detail-summary{font-size:13px;color:#94A3B8;line-height:1.7;background:rgba(255,255,255,0.03);border-radius:10px;padding:14px;border:1px solid rgba(255,255,255,0.05);margin-bottom:16px;}
.lr-detail-recs{display:flex;flex-direction:column;gap:8px;margin-bottom:16px;}
.lr-detail-rec{display:flex;gap:8px;font-size:13px;color:#94A3B8;}
.lr-detail-rec-dot{width:5px;height:5px;border-radius:50%;background:#00D68F;flex-shrink:0;margin-top:6px;}
.lr-disclaimer{font-size:11px;color:#334155;padding:10px 14px;background:rgba(255,255,255,0.02);border-radius:8px;border:1px solid rgba(255,255,255,0.04);}
@media(max-width:768px){.lr-stats{grid-template-columns:repeat(2,1fr);}.lr-grid{grid-template-columns:1fr;}}
</style>
@endpush

@section('content')

<div class="lr-breadcrumb"><a href="/dashboard">Dashboard</a> › <em>Lab Reports</em></div>
<div class="lr-title">Lab Reports</div>
<div class="lr-sub">Upload your lab reports and get instant AI-powered analysis</div>

@if(session('success'))
    <div class="lr-flash success">✓ {{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="lr-flash error">✕ {{ $errors->first() }}</div>
@endif

{{-- UPLOAD ZONE --}}
<div class="lr-upload-zone" id="uploadZone"
     ondragover="handleDragOver(event)"
     ondragleave="handleDragLeave(event)"
     ondrop="handleDrop(event)">
    <div class="lr-upload-icon">📄</div>
    <div class="lr-upload-title">Upload your lab report</div>
    <div class="lr-upload-sub">Drop your file here or click to browse.<br>ClinIQ will analyze it and explain every value in plain language.</div>
    <button class="lr-upload-btn" type="button" onclick="triggerFileInput()">Browse File</button>
    <div class="lr-upload-formats">
        <span class="lr-format-badge">PDF</span>
        <span class="lr-format-badge">JPG</span>
        <span class="lr-format-badge">PNG</span>
        <span class="lr-format-badge">Max 10MB</span>
    </div>
</div>

{{-- STATS --}}
<div class="lr-stats">
    <div class="lr-stat" style="--sc:#60A5FA;">
        <div class="lr-stat-label">Total Reports</div>
        <div class="lr-stat-value">{{ $stats['total'] }}</div>
        <span class="lr-stat-badge b">All time</span>
    </div>
    <div class="lr-stat" style="--sc:#00D68F;">
        <div class="lr-stat-label">Analyzed</div>
        <div class="lr-stat-value">{{ $stats['analyzed'] }}</div>
        <span class="lr-stat-badge g">{{ $stats['total'] > 0 ? round(($stats['analyzed']/$stats['total'])*100) : 0 }}%</span>
    </div>
    <div class="lr-stat" style="--sc:#F59E0B;">
        <div class="lr-stat-label">Abnormal Values</div>
        <div class="lr-stat-value">{{ $stats['abnormal'] }}</div>
        <span class="lr-stat-badge a">Need review</span>
    </div>
    <div class="lr-stat" style="--sc:#00D68F;">
        <div class="lr-stat-label">Normal Values</div>
        <div class="lr-stat-value">{{ $stats['normal'] }}</div>
        <span class="lr-stat-badge g">All clear</span>
    </div>
</div>

{{-- REPORTS GRID --}}
@if($reports->count() > 0)
<div class="lr-grid">
    @foreach($reports as $report)
    @php $values = $report->lab_values ?? []; @endphp
    <div class="lr-card">
        <div class="lr-card-top">
            <div class="lr-file-icon" style="background:{{ $report->file_icon_bg }};">{{ $report->file_icon }}</div>
            <div style="min-width:0;">
                <div class="lr-card-name">{{ $report->file_name }}</div>
                <div class="lr-card-meta">{{ $report->report_type }} • {{ $report->familyMember?->name ?? auth()->user()->name }} • {{ $report->created_at->diffForHumans() }}</div>
            </div>
            <div class="lr-card-actions">
                <button class="lr-act-btn" onclick="openDetail({{ $report->id }})">👁</button>
                <form method="POST" action="/lab-reports/{{ $report->id }}" style="display:inline;" onsubmit="return confirm('Delete this report?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="lr-act-btn del">🗑</button>
                </form>
            </div>
        </div>
        <div class="lr-card-body">
            @if($report->status === 'analyzed')
            <div class="lr-analysis-header"><span>🧠</span><span class="lr-analysis-title">AI Analysis Complete</span></div>
            @if(!empty($values))
            <div class="lr-values">
                @foreach(array_slice($values, 0, 3) as $val)
                <div class="lr-value-row">
                    <div>
                        <div class="lr-value-name">{{ $val['name'] }}</div>
                        <div class="lr-value-range">Normal: {{ $val['range'] }}</div>
                    </div>
                    <div style="text-align:right;">
                        <div class="lr-value-result {{ $val['status'] }}">{{ $val['value'] }}</div>
                        <span class="lr-value-badge {{ $val['status'] }}">{{ $val['status'] === 'normal' ? 'Normal ✓' : ($val['status'] === 'high' ? 'High ↑' : 'Low ↓') }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            @if($report->summary)<div class="lr-summary">⚠ {{ $report->summary }}</div>@endif
            @else
            <div style="text-align:center;padding:20px;font-size:13px;color:#F59E0B;font-weight:600;">⏳ Analyzing...</div>
            @endif
        </div>
        <div class="lr-card-footer">
            <button class="lr-footer-btn primary" onclick="openDetail({{ $report->id }})">View Full Analysis</button>
            <a href="{{ Storage::url($report->file_path) }}" target="_blank" class="lr-footer-btn secondary">Download</a>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="lr-empty">
    <div class="lr-empty-icon">📄</div>
    <div class="lr-empty-title">No lab reports yet</div>
    <div class="lr-empty-sub">Upload your first lab report to get instant AI-powered analysis</div>
    <button class="lr-upload-btn" type="button" onclick="triggerFileInput()">Upload First Report</button>
</div>
@endif

{{-- UPLOAD MODAL --}}
<div class="lr-modal-overlay" id="uploadModal">
    <div class="lr-modal">
        <div class="lr-modal-header">
            <div>
                <div class="lr-modal-title">Upload Lab Report</div>
                <div class="lr-modal-sub">Select report type and member</div>
            </div>
            <button type="button" class="lr-modal-close" onclick="closeUploadModal()">✕</button>
        </div>
        {{-- form with onsubmit only changes text, never disables --}}
        <form method="POST" action="/lab-reports" enctype="multipart/form-data" id="uploadForm"
              onsubmit="document.getElementById('submitBtn').textContent='⏳ Uploading...';">
            @csrf
            <input type="file" name="file" id="realFileInput" accept=".pdf,.jpg,.jpeg,.png"
                   style="display:none;" onchange="onFileChosen(event)" />
            <div class="lr-modal-body">
                <div id="filePreview" class="lr-file-preview" style="display:none;">
                    <span style="font-size:24px;">📄</span>
                    <div>
                        <div class="lr-file-preview-name" id="previewName"></div>
                        <div class="lr-file-preview-size" id="previewSize"></div>
                    </div>
                </div>
                <label class="lr-label">Report Type</label>
                <select class="lr-select" name="report_type">
                    <option value="Complete Blood Count">Complete Blood Count (CBC)</option>
                    <option value="Thyroid Function">Thyroid Function Test</option>
                    <option value="Liver Function">Liver Function Test</option>
                    <option value="Kidney Function">Kidney Function Test</option>
                    <option value="Lipid Profile">Lipid Profile</option>
                    <option value="Blood Sugar">Blood Sugar / HbA1c</option>
                    <option value="Urine Analysis">Urine Analysis</option>
                    <option value="General">General / Other</option>
                </select>
                <label class="lr-label">For Family Member</label>
                <select class="lr-select" name="family_member_id">
                    <option value="">{{ auth()->user()->name }} (Me)</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}">{{ $member->name }} ({{ $member->relation }})</option>
                    @endforeach
                </select>
            </div>
            <div class="lr-modal-footer">
                <button type="button" class="lr-modal-cancel" onclick="closeUploadModal()">Cancel</button>
                <button type="submit" id="submitBtn" class="lr-modal-save">🧠 Analyze Report</button>
            </div>
        </form>
    </div>
</div>

{{-- DETAIL MODAL --}}
<div class="lr-modal-overlay" id="detailModal">
    <div class="lr-detail-modal">
        <div class="lr-modal-header">
            <div>
                <div class="lr-modal-title" id="detailTitle">Report Analysis</div>
                <div class="lr-modal-sub" id="detailMeta"></div>
            </div>
            <button type="button" class="lr-modal-close" onclick="closeDetailModal()">✕</button>
        </div>
        <div class="lr-detail-body" id="detailBody"></div>
    </div>
</div>

<script>
const reports = @json($reports->values());

function triggerFileInput() {
    document.getElementById('realFileInput').click();
}

function onFileChosen(event) {
    const file = event.target.files[0];
    if (!file) return;
    document.getElementById('previewName').textContent = file.name;
    document.getElementById('previewSize').textContent = (file.size / 1024).toFixed(1) + ' KB';
    document.getElementById('filePreview').style.display = 'flex';
    openUploadModal();
}

function openUploadModal() {
    document.getElementById('uploadModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeUploadModal() {
    document.getElementById('uploadModal').classList.remove('active');
    document.body.style.overflow = '';
}

function handleDragOver(e) {
    e.preventDefault();
    document.getElementById('uploadZone').classList.add('dragover');
}

function handleDragLeave() {
    document.getElementById('uploadZone').classList.remove('dragover');
}

function handleDrop(e) {
    e.preventDefault();
    document.getElementById('uploadZone').classList.remove('dragover');
    const file = e.dataTransfer.files[0];
    if (!file) return;
    const dt = new DataTransfer();
    dt.items.add(file);
    document.getElementById('realFileInput').files = dt.files;
    document.getElementById('previewName').textContent = file.name;
    document.getElementById('previewSize').textContent = (file.size / 1024).toFixed(1) + ' KB';
    document.getElementById('filePreview').style.display = 'flex';
    openUploadModal();
}

function openDetail(id) {
    const report = reports.find(r => r.id === id);
    if (!report) return;
    document.getElementById('detailTitle').textContent = report.file_name;
    document.getElementById('detailMeta').textContent = report.report_type + ' • ' + new Date(report.created_at).toLocaleDateString();
    const values = report.lab_values || [];
    const recs   = report.ai_analysis?.recommendations || [];
    let valHtml  = values.map(v => `
        <div class="lr-value-row" style="margin-bottom:8px;">
            <div>
                <div class="lr-value-name">${v.name}</div>
                <div class="lr-value-range">Normal: ${v.range}</div>
                <div style="font-size:11px;color:#475569;margin-top:2px;">${v.explanation||''}</div>
            </div>
            <div style="text-align:right;flex-shrink:0;margin-left:12px;">
                <div class="lr-value-result ${v.status}">${v.value}</div>
                <span class="lr-value-badge ${v.status}">${v.status==='normal'?'Normal ✓':v.status==='high'?'High ↑':'Low ↓'}</span>
            </div>
        </div>`).join('');
    let recHtml = recs.map(r => `<div class="lr-detail-rec"><div class="lr-detail-rec-dot"></div>${r}</div>`).join('');
    document.getElementById('detailBody').innerHTML = `
        <div class="lr-detail-section">Summary</div>
        <div class="lr-detail-summary">${report.summary || 'No summary available.'}</div>
        ${valHtml ? `<div class="lr-detail-section">Lab Values</div><div class="lr-values">${valHtml}</div>` : ''}
        ${recHtml ? `<div class="lr-detail-section" style="margin-top:16px;">Recommendations</div><div class="lr-detail-recs">${recHtml}</div>` : ''}
        <div class="lr-disclaimer">⚕ This AI analysis is for informational purposes only and is not a substitute for professional medical advice.</div>`;
    document.getElementById('detailModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.remove('active');
    document.body.style.overflow = '';
}

document.getElementById('uploadModal').addEventListener('click', function(e) { if(e.target===this) closeUploadModal(); });
document.getElementById('detailModal').addEventListener('click', function(e) { if(e.target===this) closeDetailModal(); });
</script>

@endsection