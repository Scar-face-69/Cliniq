@extends('layouts.dashboard')

@section('title', 'Settings — ClinIQ')

@push('styles')
<style>
.st-breadcrumb{font-size:12px;color:#475569;margin-bottom:6px;}
.st-breadcrumb a{color:#475569;text-decoration:none;}
.st-breadcrumb em{color:#00D68F;font-style:normal;}
.st-title{font-size:24px;font-weight:700;color:white;letter-spacing:-0.5px;margin-bottom:4px;}
.st-sub{font-size:13px;color:#475569;margin-bottom:24px;}

/* Tabs */
.st-tabs{display:flex;gap:6px;margin-bottom:24px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:14px;padding:6px;}
.st-tab{flex:1;padding:9px 12px;border-radius:10px;border:none;background:transparent;color:#475569;font-size:13px;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;transition:all 0.2s;text-align:center;}
.st-tab.active{background:rgba(0,214,143,0.1);color:#00D68F;border:1px solid rgba(0,214,143,0.2);}
.st-tab:hover:not(.active){color:#94A3B8;background:rgba(255,255,255,0.03);}

/* Panels */
.st-panel{display:none;}
.st-panel.active{display:block;}

/* Cards */
.st-card{background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:18px;overflow:hidden;margin-bottom:20px;}
.st-card-header{padding:18px 24px;border-bottom:1px solid rgba(255,255,255,0.05);display:flex;align-items:center;gap:12px;}
.st-card-icon{width:38px;height:38px;border-radius:10px;background:rgba(0,214,143,0.08);border:1px solid rgba(0,214,143,0.15);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;}
.st-card-title{font-size:15px;font-weight:700;color:white;}
.st-card-sub{font-size:12px;color:#475569;margin-top:2px;}
.st-card-body{padding:24px;}

/* Form */
.st-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
.st-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;}
.st-field{display:flex;flex-direction:column;gap:6px;margin-bottom:16px;}
.st-field:last-child{margin-bottom:0;}
.st-label{font-size:11px;font-weight:700;color:#64748B;letter-spacing:0.5px;text-transform:uppercase;}
.st-input{background:rgba(255,255,255,0.04);border:1.5px solid rgba(255,255,255,0.08);border-radius:10px;padding:10px 14px;font-size:13px;color:white;outline:none;font-family:'Inter',sans-serif;transition:border-color 0.2s;width:100%;box-sizing:border-box;}
.st-input:focus{border-color:#00D68F;}
.st-input::placeholder{color:#334155;}
.st-select{background:rgba(255,255,255,0.04);border:1.5px solid rgba(255,255,255,0.08);border-radius:10px;padding:10px 14px;font-size:13px;color:#94A3B8;outline:none;font-family:'Inter',sans-serif;width:100%;box-sizing:border-box;}
.st-select:focus{border-color:#00D68F;}
.st-textarea{background:rgba(255,255,255,0.04);border:1.5px solid rgba(255,255,255,0.08);border-radius:10px;padding:10px 14px;font-size:13px;color:white;outline:none;font-family:'Inter',sans-serif;width:100%;box-sizing:border-box;resize:vertical;min-height:80px;}
.st-textarea:focus{border-color:#00D68F;}
.st-textarea::placeholder{color:#334155;}

/* Flash */
.st-flash{padding:12px 16px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:20px;display:flex;align-items:center;gap:10px;}
.st-flash.success{background:rgba(0,214,143,0.08);border:1px solid rgba(0,214,143,0.2);color:#00D68F;}
.st-flash.error{background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);color:#EF4444;}

/* Save button */
.st-save-row{display:flex;justify-content:flex-end;margin-top:20px;padding-top:20px;border-top:1px solid rgba(255,255,255,0.05);}
.st-save-btn{background:linear-gradient(135deg,#00D68F,#00B377);color:#0A1628;border:none;border-radius:10px;padding:11px 28px;font-size:13px;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;}
.st-save-btn:hover{opacity:0.9;}

/* Avatar */
.st-avatar-row{display:flex;align-items:center;gap:20px;margin-bottom:24px;padding-bottom:24px;border-bottom:1px solid rgba(255,255,255,0.05);}
.st-avatar{width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,#00D68F,#00B377);color:#0A1628;font-size:24px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.st-avatar-info{flex:1;}
.st-avatar-name{font-size:18px;font-weight:700;color:white;margin-bottom:4px;}
.st-avatar-email{font-size:13px;color:#475569;}

/* Toggle */
.st-toggle-row{display:flex;align-items:center;justify-content:space-between;padding:14px 0;border-bottom:1px solid rgba(255,255,255,0.04);}
.st-toggle-row:last-child{border-bottom:none;}
.st-toggle-info{}
.st-toggle-title{font-size:13px;font-weight:600;color:white;margin-bottom:2px;}
.st-toggle-sub{font-size:12px;color:#475569;}
.st-toggle{position:relative;width:44px;height:24px;flex-shrink:0;}
.st-toggle input{opacity:0;width:0;height:0;}
.st-toggle-slider{position:absolute;inset:0;background:rgba(255,255,255,0.08);border-radius:100px;cursor:pointer;transition:0.2s;}
.st-toggle-slider:before{content:'';position:absolute;width:18px;height:18px;left:3px;top:3px;background:white;border-radius:50%;transition:0.2s;}
.st-toggle input:checked + .st-toggle-slider{background:#00D68F;}
.st-toggle input:checked + .st-toggle-slider:before{transform:translateX(20px);}

/* Danger zone */
.st-danger-card{background:rgba(239,68,68,0.03);border:1px solid rgba(239,68,68,0.12);border-radius:18px;overflow:hidden;margin-bottom:20px;}
.st-danger-header{padding:18px 24px;border-bottom:1px solid rgba(239,68,68,0.08);display:flex;align-items:center;gap:12px;}
.st-danger-icon{width:38px;height:38px;border-radius:10px;background:rgba(239,68,68,0.08);display:flex;align-items:center;justify-content:center;font-size:18px;}
.st-danger-title{font-size:15px;font-weight:700;color:#EF4444;}
.st-danger-sub{font-size:12px;color:#475569;margin-top:2px;}
.st-danger-body{padding:24px;}
.st-danger-text{font-size:13px;color:#64748B;margin-bottom:16px;line-height:1.6;}
.st-danger-btn{background:rgba(239,68,68,0.1);color:#EF4444;border:1px solid rgba(239,68,68,0.2);border-radius:10px;padding:11px 24px;font-size:13px;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;transition:all 0.2s;}
.st-danger-btn:hover{background:rgba(239,68,68,0.2);}

/* Delete modal */
.st-modal-overlay{display:none;position:fixed;inset:0;background:rgba(6,14,28,0.85);backdrop-filter:blur(6px);z-index:1000;align-items:center;justify-content:center;}
.st-modal-overlay.active{display:flex;}
.st-modal{background:#111E35;border:1px solid rgba(239,68,68,0.2);border-radius:24px;width:100%;max-width:440px;overflow:hidden;animation:stIn 0.2s ease;}
@keyframes stIn{from{transform:scale(0.95);opacity:0;}to{transform:scale(1);opacity:1;}}
.st-modal-header{padding:22px 28px;border-bottom:1px solid rgba(255,255,255,0.06);}
.st-modal-title{font-size:16px;font-weight:700;color:#EF4444;}
.st-modal-sub{font-size:12px;color:#475569;margin-top:4px;}
.st-modal-body{padding:24px 28px;}
.st-modal-warning{background:rgba(239,68,68,0.06);border:1px solid rgba(239,68,68,0.15);border-radius:10px;padding:14px;font-size:13px;color:#94A3B8;line-height:1.6;margin-bottom:16px;}
.st-modal-footer{padding:16px 28px 24px;display:flex;gap:10px;}
.st-modal-cancel{flex:1;background:rgba(255,255,255,0.04);color:#64748B;border:1px solid rgba(255,255,255,0.08);border-radius:10px;padding:12px;font-size:13px;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;}
.st-modal-delete{flex:2;background:linear-gradient(135deg,#DC2626,#EF4444);color:white;border:none;border-radius:10px;padding:12px;font-size:13px;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;}

/* Error */
.st-field-error{font-size:11px;color:#EF4444;margin-top:4px;}

@media(max-width:768px){
    .st-tabs{flex-wrap:wrap;}
    .st-grid-2,.st-grid-3{grid-template-columns:1fr;}
}
</style>
@endpush

@section('content')

<div class="st-breadcrumb"><a href="/dashboard">Dashboard</a> › <em>Settings</em></div>
<div class="st-title">Settings</div>
<div class="st-sub">Manage your account, health profile, and preferences</div>

{{-- Flash messages --}}
@if(session('success_profile'))
    <div class="st-flash success" id="flashMsg">✓ {{ session('success_profile') }}</div>
@endif
@if(session('success_health'))
    <div class="st-flash success" id="flashMsg">✓ {{ session('success_health') }}</div>
@endif
@if(session('success_password'))
    <div class="st-flash success" id="flashMsg">✓ {{ session('success_password') }}</div>
@endif
@if(session('success_notif'))
    <div class="st-flash success" id="flashMsg">✓ {{ session('success_notif') }}</div>
@endif
@if($errors->any())
    <div class="st-flash error">✕ {{ $errors->first() }}</div>
@endif

{{-- TABS --}}
<div class="st-tabs">
    <button class="st-tab active" onclick="switchTab('profile', this)">👤 Profile</button>
    <button class="st-tab" onclick="switchTab('health', this)">🩺 Health</button>
    <button class="st-tab" onclick="switchTab('password', this)">🔒 Password</button>
    <button class="st-tab" onclick="switchTab('notifications', this)">🔔 Notifications</button>
    <button class="st-tab" onclick="switchTab('danger', this)">⚠️ Account</button>
</div>

{{-- ===== PROFILE TAB ===== --}}
<div class="st-panel active" id="panel-profile">
    <div class="st-card">
        <div class="st-card-header">
            <div class="st-card-icon">👤</div>
            <div>
                <div class="st-card-title">Personal Information</div>
                <div class="st-card-sub">Update your name, email and contact details</div>
            </div>
        </div>
        <div class="st-card-body">
            <div class="st-avatar-row">
                <div class="st-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                <div class="st-avatar-info">
                    <div class="st-avatar-name">{{ $user->name }}</div>
                    <div class="st-avatar-email">{{ $user->email }}</div>
                </div>
            </div>
            <form method="POST" action="/settings/profile">
                @csrf
                <div class="st-grid-2">
                    <div class="st-field">
                        <label class="st-label">Full Name</label>
                        <input class="st-input" type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Your full name" required />
                    </div>
                    <div class="st-field">
                        <label class="st-label">Email Address</label>
                        <input class="st-input" type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="your@email.com" required />
                    </div>
                </div>
                <div class="st-field">
                    <label class="st-label">Phone Number</label>
                    <input class="st-input" type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" placeholder="+92 300 0000000" />
                </div>
                <div class="st-save-row">
                    <button type="submit" class="st-save-btn">Save Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== HEALTH TAB ===== --}}
<div class="st-panel" id="panel-health">
    <div class="st-card">
        <div class="st-card-header">
            <div class="st-card-icon">🩺</div>
            <div>
                <div class="st-card-title">Health Profile</div>
                <div class="st-card-sub">This information helps ClinIQ give you more accurate health guidance</div>
            </div>
        </div>
        <div class="st-card-body">
            <form method="POST" action="/settings/health">
                @csrf
                <div class="st-grid-3">
                    <div class="st-field">
                        <label class="st-label">Blood Group</label>
                        <select class="st-select" name="blood_group">
                            <option value="">Select</option>
                            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                                <option value="{{ $bg }}" {{ old('blood_group', $user->blood_group ?? '') === $bg ? 'selected' : '' }}>{{ $bg }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="st-field">
                        <label class="st-label">Date of Birth</label>
                        <input class="st-input" type="date" name="date_of_birth" value="{{ old('date_of_birth', isset($user->date_of_birth) ? \Carbon\Carbon::parse($user->date_of_birth)->format('Y-m-d') : '') }}" />
                    </div>
                    <div class="st-field">
                        <label class="st-label">Gender</label>
                        <select class="st-select" name="gender">
                            <option value="">Select</option>
                            <option value="male"   {{ old('gender', $user->gender ?? '') === 'male'   ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $user->gender ?? '') === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other"  {{ old('gender', $user->gender ?? '') === 'other'  ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>
                <div class="st-grid-2">
                    <div class="st-field">
                        <label class="st-label">Height (cm)</label>
                        <input class="st-input" type="number" name="height" value="{{ old('height', $user->height ?? '') }}" placeholder="e.g. 175" min="50" max="250" />
                    </div>
                    <div class="st-field">
                        <label class="st-label">Weight (kg)</label>
                        <input class="st-input" type="number" name="weight" value="{{ old('weight', $user->weight ?? '') }}" placeholder="e.g. 70" min="10" max="300" />
                    </div>
                </div>
                <div class="st-field">
                    <label class="st-label">Known Allergies</label>
                    <textarea class="st-textarea" name="allergies" placeholder="e.g. Penicillin, Peanuts, Dust...">{{ old('allergies', $user->allergies ?? '') }}</textarea>
                </div>
                <div class="st-field">
                    <label class="st-label">Chronic Conditions</label>
                    <textarea class="st-textarea" name="conditions" placeholder="e.g. Diabetes Type 2, Hypertension...">{{ old('conditions', $user->conditions ?? '') }}</textarea>
                </div>
                <div class="st-field">
                    <label class="st-label">Current Medications</label>
                    <textarea class="st-textarea" name="medications" placeholder="e.g. Metformin 500mg, Aspirin 75mg...">{{ old('medications', $user->medications ?? '') }}</textarea>
                </div>
                <div class="st-save-row">
                    <button type="submit" class="st-save-btn">Save Health Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== PASSWORD TAB ===== --}}
<div class="st-panel" id="panel-password">
    <div class="st-card">
        <div class="st-card-header">
            <div class="st-card-icon">🔒</div>
            <div>
                <div class="st-card-title">Change Password</div>
                <div class="st-card-sub">Make sure to use a strong, unique password</div>
            </div>
        </div>
        <div class="st-card-body">
            <form method="POST" action="/settings/password">
                @csrf
                <div class="st-field">
                    <label class="st-label">Current Password</label>
                    <input class="st-input" type="password" name="current_password" placeholder="Enter current password" />
                    @error('current_password')<div class="st-field-error">{{ $message }}</div>@enderror
                </div>
                <div class="st-field">
                    <label class="st-label">New Password</label>
                    <input class="st-input" type="password" name="password" placeholder="Minimum 8 characters" />
                </div>
                <div class="st-field">
                    <label class="st-label">Confirm New Password</label>
                    <input class="st-input" type="password" name="password_confirmation" placeholder="Repeat new password" />
                </div>
                <div class="st-save-row">
                    <button type="submit" class="st-save-btn">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== NOTIFICATIONS TAB ===== --}}
<div class="st-panel" id="panel-notifications">
    <div class="st-card">
        <div class="st-card-header">
            <div class="st-card-icon">🔔</div>
            <div>
                <div class="st-card-title">Notification Preferences</div>
                <div class="st-card-sub">Choose what updates you want to receive</div>
            </div>
        </div>
        <div class="st-card-body">
            <form method="POST" action="/settings/notifications">
                @csrf
                <div class="st-toggle-row">
                    <div class="st-toggle-info">
                        <div class="st-toggle-title">Consultation Reminders</div>
                        <div class="st-toggle-sub">Get reminded about follow-up consultations</div>
                    </div>
                    <label class="st-toggle">
                        <input type="checkbox" name="notif_consultations" {{ ($user->notif_consultations ?? true) ? 'checked' : '' }} />
                        <span class="st-toggle-slider"></span>
                    </label>
                </div>
                <div class="st-toggle-row">
                    <div class="st-toggle-info">
                        <div class="st-toggle-title">Lab Report Analysis</div>
                        <div class="st-toggle-sub">Notify when a lab report analysis is complete</div>
                    </div>
                    <label class="st-toggle">
                        <input type="checkbox" name="notif_lab_reports" {{ ($user->notif_lab_reports ?? true) ? 'checked' : '' }} />
                        <span class="st-toggle-slider"></span>
                    </label>
                </div>
                <div class="st-toggle-row">
                    <div class="st-toggle-info">
                        <div class="st-toggle-title">Family Health Alerts</div>
                        <div class="st-toggle-sub">Get alerted when a family member has high risk symptoms</div>
                    </div>
                    <label class="st-toggle">
                        <input type="checkbox" name="notif_family_alerts" {{ ($user->notif_family_alerts ?? true) ? 'checked' : '' }} />
                        <span class="st-toggle-slider"></span>
                    </label>
                </div>
                <div class="st-toggle-row">
                    <div class="st-toggle-info">
                        <div class="st-toggle-title">Health Tips & Updates</div>
                        <div class="st-toggle-sub">Receive weekly health tips and ClinIQ updates</div>
                    </div>
                    <label class="st-toggle">
                        <input type="checkbox" name="notif_tips" {{ ($user->notif_tips ?? false) ? 'checked' : '' }} />
                        <span class="st-toggle-slider"></span>
                    </label>
                </div>
                <div class="st-save-row">
                    <button type="submit" class="st-save-btn">Save Preferences</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== DANGER ZONE TAB ===== --}}
<div class="st-panel" id="panel-danger">
    <div class="st-card" style="margin-bottom:20px;">
        <div class="st-card-header">
            <div class="st-card-icon">📤</div>
            <div>
                <div class="st-card-title">Sign Out</div>
                <div class="st-card-sub">Sign out from your ClinIQ account</div>
            </div>
        </div>
        <div class="st-card-body">
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="st-save-btn" style="background:rgba(255,255,255,0.06);color:#94A3B8;border:1px solid rgba(255,255,255,0.08);">Sign Out</button>
            </form>
        </div>
    </div>

    <div class="st-danger-card">
        <div class="st-danger-header">
            <div class="st-danger-icon">🗑</div>
            <div>
                <div class="st-danger-title">Delete Account</div>
                <div class="st-danger-sub">This action is permanent and cannot be undone</div>
            </div>
        </div>
        <div class="st-danger-body">
            <div class="st-danger-text">
                Deleting your account will permanently remove all your data including consultations, lab reports, and family member profiles. This cannot be recovered.
            </div>
            <button type="button" class="st-danger-btn" onclick="openDeleteModal()">🗑 Delete My Account</button>
        </div>
    </div>
</div>

{{-- DELETE MODAL --}}
<div class="st-modal-overlay" id="deleteModal">
    <div class="st-modal">
        <div class="st-modal-header">
            <div class="st-modal-title">🗑 Delete Account</div>
            <div class="st-modal-sub">This cannot be undone</div>
        </div>
        <form method="POST" action="/settings/delete-account">
            @csrf
            <div class="st-modal-body">
                <div class="st-modal-warning">
                    ⚠️ All your data will be permanently deleted — consultations, lab reports, family members, and your account. There is no way to recover this data.
                </div>
                <div class="st-field">
                    <label class="st-label">Type DELETE to confirm</label>
                    <input class="st-input" type="text" name="confirm_delete" placeholder="DELETE" autocomplete="off" />
                </div>
            </div>
            <div class="st-modal-footer">
                <button type="button" class="st-modal-cancel" onclick="closeDeleteModal()">Cancel</button>
                <button type="submit" class="st-modal-delete">Delete My Account</button>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-switch tab if redirected back with error on password tab
@if(session('tab') === 'password' || $errors->has('current_password'))
    document.addEventListener('DOMContentLoaded', () => switchTab('password', document.querySelectorAll('.st-tab')[2]));
@endif

function switchTab(name, el) {
    document.querySelectorAll('.st-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.st-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('panel-' + name).classList.add('active');
    el.classList.add('active');
}

function openDeleteModal() {
    document.getElementById('deleteModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
    document.body.style.overflow = '';
}

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});

// Auto hide flash after 4 seconds
const flash = document.getElementById('flashMsg');
if (flash) setTimeout(() => flash.style.display = 'none', 4000);
</script>

@endsection