@extends('layouts.dashboard')

@section('title', 'Settings — ClinIQ')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
<style>
.st-page { font-family: 'DM Sans', sans-serif; }

.st-breadcrumb { font-size: 12px; color: #9CA3AF; margin-bottom: 6px; display: flex; align-items: center; gap: 5px; }
.st-breadcrumb a { color: #9CA3AF; text-decoration: none; transition: color 0.15s; }
.st-breadcrumb a:hover { color: #111111; }
.st-breadcrumb em { color: #DC2626; font-style: normal; }

.st-title { font-size: 20px; font-weight: 700; color: #111111; letter-spacing: -0.3px; margin-bottom: 3px; }
.st-sub { font-size: 13px; color: #6B7280; margin-bottom: 28px; }

/* ── Tabs ── */
.st-tabs {
    display: flex;
    gap: 3px;
    margin-bottom: 24px;
    background: #F3F4F6;
    border: 1px solid #E5E5E5;
    border-radius: 12px;
    padding: 4px;
}
.st-tab {
    display: flex;
    flex: 1;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 8px 10px;
    border-radius: 9px;
    border: none;
    background: transparent;
    color: #6B7280;
    font-size: 12.5px;
    font-weight: 500;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: all 0.15s;
    white-space: nowrap;
}
.st-tab svg {
    width: 14px;
    height: 14px;
    stroke: currentColor;
    fill: none;
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
    flex-shrink: 0;
}
.st-tab.active {
    background: #FFFFFF;
    color: #111111;
    font-weight: 600;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04);
}
.st-tab:hover:not(.active) {
    color: #374151;
    background: rgba(0,0,0,0.03);
}

/* ── Panels ── */
.st-panel { display: none; }
.st-panel.active { display: block; }

/* ── Cards ── */
.st-card {
    background: #FFFFFF;
    border: 1px solid #E5E5E5;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.st-card-header {
    padding: 16px 22px;
    border-bottom: 1px solid #F3F4F6;
    display: flex;
    align-items: center;
    gap: 12px;
}
.st-card-icon {
    width: 36px;
    height: 36px;
    border-radius: 9px;
    background: #F3F4F6;
    border: 1px solid #E5E5E5;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #6B7280;
}
.st-card-icon svg {
    width: 16px;
    height: 16px;
    stroke: currentColor;
    fill: none;
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
}
.st-card-title { font-size: 14px; font-weight: 600; color: #111111; }
.st-card-sub { font-size: 12px; color: #9CA3AF; margin-top: 2px; }
.st-card-body { padding: 22px; }

/* ── Form Layout ── */
.st-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.st-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; }
.st-field { display: flex; flex-direction: column; gap: 5px; margin-bottom: 14px; }
.st-field:last-child { margin-bottom: 0; }

.st-label {
    font-size: 11px;
    font-weight: 600;
    color: #6B7280;
    letter-spacing: 0.4px;
    text-transform: uppercase;
}
.st-input {
    background: #FFFFFF;
    border: 1.5px solid #E5E5E5;
    border-radius: 9px;
    padding: 9px 12px;
    font-size: 13px;
    color: #111111;
    outline: none;
    font-family: 'DM Sans', sans-serif;
    transition: border-color 0.15s, box-shadow 0.15s;
    width: 100%;
    box-sizing: border-box;
}
.st-input:focus {
    border-color: #DC2626;
    box-shadow: 0 0 0 3px rgba(220,38,38,0.08);
}
.st-input::placeholder { color: #D1D5DB; }

.st-select {
    background: #FFFFFF;
    border: 1.5px solid #E5E5E5;
    border-radius: 9px;
    padding: 9px 12px;
    font-size: 13px;
    color: #374151;
    outline: none;
    font-family: 'DM Sans', sans-serif;
    width: 100%;
    box-sizing: border-box;
    cursor: pointer;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.st-select:focus {
    border-color: #DC2626;
    box-shadow: 0 0 0 3px rgba(220,38,38,0.08);
}

.st-textarea {
    background: #FFFFFF;
    border: 1.5px solid #E5E5E5;
    border-radius: 9px;
    padding: 9px 12px;
    font-size: 13px;
    color: #111111;
    outline: none;
    font-family: 'DM Sans', sans-serif;
    width: 100%;
    box-sizing: border-box;
    resize: vertical;
    min-height: 80px;
    line-height: 1.6;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.st-textarea:focus {
    border-color: #DC2626;
    box-shadow: 0 0 0 3px rgba(220,38,38,0.08);
}
.st-textarea::placeholder { color: #D1D5DB; }

/* ── Flash ── */
.st-flash {
    padding: 11px 15px;
    border-radius: 9px;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 9px;
}
.st-flash.success {
    background: #F0FDF4;
    border: 1px solid rgba(22,163,74,0.2);
    color: #15803D;
}
.st-flash.error {
    background: #FEF2F2;
    border: 1px solid rgba(220,38,38,0.2);
    color: #DC2626;
}

/* ── Save Row ── */
.st-save-row {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
    padding-top: 18px;
    border-top: 1px solid #F3F4F6;
}
.st-save-btn {
    background: #DC2626;
    color: #FFFFFF;
    border: none;
    border-radius: 9px;
    padding: 10px 24px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: background 0.15s;
}
.st-save-btn:hover { background: #B91C1C; }

/* ── Avatar Row ── */
.st-avatar-row {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 22px;
    padding-bottom: 22px;
    border-bottom: 1px solid #F3F4F6;
}
.st-avatar {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: #111111;
    color: #FFFFFF;
    font-size: 20px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    letter-spacing: 0.5px;
}
.st-avatar-name { font-size: 16px; font-weight: 700; color: #111111; margin-bottom: 3px; }
.st-avatar-email { font-size: 13px; color: #6B7280; }

/* ── Toggle ── */
.st-toggle-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 0;
    border-bottom: 1px solid #F3F4F6;
}
.st-toggle-row:last-of-type { border-bottom: none; }
.st-toggle-title { font-size: 13px; font-weight: 600; color: #111111; margin-bottom: 2px; }
.st-toggle-sub { font-size: 12px; color: #9CA3AF; }

.st-toggle { position: relative; width: 42px; height: 23px; flex-shrink: 0; }
.st-toggle input { opacity: 0; width: 0; height: 0; }
.st-toggle-slider {
    position: absolute;
    inset: 0;
    background: #D1D5DB;
    border-radius: 100px;
    cursor: pointer;
    transition: 0.2s;
}
.st-toggle-slider:before {
    content: '';
    position: absolute;
    width: 17px;
    height: 17px;
    left: 3px;
    top: 3px;
    background: white;
    border-radius: 50%;
    transition: 0.2s;
    box-shadow: 0 1px 3px rgba(0,0,0,0.15);
}
.st-toggle input:checked + .st-toggle-slider { background: #DC2626; }
.st-toggle input:checked + .st-toggle-slider:before { transform: translateX(19px); }

/* ── Danger Zone ── */
.st-danger-card {
    background: #FFFFFF;
    border: 1px solid #FEE2E2;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 20px;
}
.st-danger-header {
    padding: 16px 22px;
    border-bottom: 1px solid #FEE2E2;
    display: flex;
    align-items: center;
    gap: 12px;
}
.st-danger-icon {
    width: 36px;
    height: 36px;
    border-radius: 9px;
    background: #FEF2F2;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #DC2626;
    flex-shrink: 0;
}
.st-danger-icon svg {
    width: 16px;
    height: 16px;
    stroke: currentColor;
    fill: none;
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
}
.st-danger-title { font-size: 14px; font-weight: 600; color: #DC2626; }
.st-danger-sub { font-size: 12px; color: #9CA3AF; margin-top: 2px; }
.st-danger-body { padding: 22px; }
.st-danger-text { font-size: 13px; color: #6B7280; margin-bottom: 16px; line-height: 1.65; }
.st-danger-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #FEF2F2;
    color: #DC2626;
    border: 1px solid #FECACA;
    border-radius: 9px;
    padding: 9px 18px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: all 0.15s;
}
.st-danger-btn svg {
    width: 14px;
    height: 14px;
    stroke: currentColor;
    fill: none;
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
}
.st-danger-btn:hover { background: #FEE2E2; border-color: #FCA5A5; }

/* ── Delete Modal ── */
.st-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    backdrop-filter: blur(4px);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}
.st-modal-overlay.active { display: flex; }
.st-modal {
    background: #FFFFFF;
    border: 1px solid #E5E5E5;
    border-radius: 18px;
    width: 100%;
    max-width: 420px;
    overflow: hidden;
    animation: stIn 0.18s ease;
    box-shadow: 0 20px 60px rgba(0,0,0,0.12);
}
@keyframes stIn {
    from { transform: scale(0.96); opacity: 0; }
    to   { transform: scale(1);    opacity: 1; }
}
.st-modal-header { padding: 20px 24px; border-bottom: 1px solid #F3F4F6; }
.st-modal-title {
    font-size: 15px;
    font-weight: 700;
    color: #DC2626;
    display: flex;
    align-items: center;
    gap: 8px;
}
.st-modal-title svg {
    width: 16px;
    height: 16px;
    stroke: currentColor;
    fill: none;
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
}
.st-modal-sub { font-size: 12px; color: #9CA3AF; margin-top: 3px; }
.st-modal-body { padding: 20px 24px; }
.st-modal-warning {
    display: flex;
    gap: 10px;
    align-items: flex-start;
    background: #FEF2F2;
    border: 1px solid #FECACA;
    border-radius: 9px;
    padding: 13px;
    font-size: 13px;
    color: #6B7280;
    line-height: 1.6;
    margin-bottom: 16px;
}
.st-modal-warning svg {
    width: 16px;
    height: 16px;
    stroke: #DC2626;
    fill: none;
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
    flex-shrink: 0;
    margin-top: 2px;
}
.st-modal-footer { padding: 12px 24px 20px; display: flex; gap: 10px; }
.st-modal-cancel {
    flex: 1;
    background: #F3F4F6;
    color: #6B7280;
    border: 1px solid #E5E5E5;
    border-radius: 9px;
    padding: 11px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: background 0.15s;
}
.st-modal-cancel:hover { background: #E5E5E5; }
.st-modal-delete {
    flex: 2;
    background: #DC2626;
    color: white;
    border: none;
    border-radius: 9px;
    padding: 11px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: background 0.15s;
}
.st-modal-delete:hover { background: #B91C1C; }

/* ── Field Error ── */
.st-field-error { font-size: 11px; color: #DC2626; margin-top: 4px; }

/* ── Signout button override ── */
.st-signout-btn {
    background: #F3F4F6;
    color: #374151;
    border: 1px solid #E5E5E5;
    border-radius: 9px;
    padding: 10px 22px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: all 0.15s;
}
.st-signout-btn:hover { background: #E5E5E5; color: #111111; }

@media (max-width: 768px) {
    .st-tabs { flex-wrap: wrap; }
    .st-grid-2, .st-grid-3 { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="st-page">

<div class="st-breadcrumb"><a href="/dashboard">Dashboard</a> › <em>Settings</em></div>
<div class="st-title">Settings</div>
<div class="st-sub">Manage your account, health profile, and preferences</div>

{{-- Flash messages --}}
@if(session('success_profile'))
    <div class="st-flash success" id="flashMsg">{{ session('success_profile') }}</div>
@endif
@if(session('success_health'))
    <div class="st-flash success" id="flashMsg">{{ session('success_health') }}</div>
@endif
@if(session('success_password'))
    <div class="st-flash success" id="flashMsg">{{ session('success_password') }}</div>
@endif
@if(session('success_notif'))
    <div class="st-flash success" id="flashMsg">{{ session('success_notif') }}</div>
@endif
@if($errors->any())
    <div class="st-flash error">{{ $errors->first() }}</div>
@endif

{{-- TABS --}}
<div class="st-tabs">
    <button type="button" class="st-tab active" onclick="switchTab('profile', this)">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Profile
    </button>
    <button type="button" class="st-tab" onclick="switchTab('health', this)">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
        Health
    </button>
    <button type="button" class="st-tab" onclick="switchTab('password', this)">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
        Password
    </button>
    <button type="button" class="st-tab" onclick="switchTab('notifications', this)">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
        Notifications
    </button>
    <button type="button" class="st-tab" onclick="switchTab('danger', this)">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        Account
    </button>
</div>

{{-- ===== PROFILE TAB ===== --}}
<div class="st-panel active" id="panel-profile">
    <div class="st-card">
        <div class="st-card-header">
            <div class="st-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
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
            <div class="st-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            </div>
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
            <div class="st-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
            </div>
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
            <div class="st-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
            </div>
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

{{-- ===== ACCOUNT TAB ===== --}}
<div class="st-panel" id="panel-danger">

    <div class="st-card" style="margin-bottom:20px;">
        <div class="st-card-header">
            <div class="st-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </div>
            <div>
                <div class="st-card-title">Sign Out</div>
                <div class="st-card-sub">Sign out from your ClinIQ account on this device</div>
            </div>
        </div>
        <div class="st-card-body">
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="st-signout-btn">Sign Out</button>
            </form>
        </div>
    </div>

    <div class="st-danger-card">
        <div class="st-danger-header">
            <div class="st-danger-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
            </div>
            <div>
                <div class="st-danger-title">Delete Account</div>
                <div class="st-danger-sub">This action is permanent and cannot be undone</div>
            </div>
        </div>
        <div class="st-danger-body">
            <div class="st-danger-text">
                Deleting your account will permanently remove all your data including consultations, lab reports, and family member profiles. This cannot be recovered.
            </div>
            <button type="button" class="st-danger-btn" onclick="openDeleteModal()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                Delete My Account
            </button>
        </div>
    </div>

</div>

</div>{{-- .st-page --}}

{{-- DELETE MODAL --}}
<div class="st-modal-overlay" id="deleteModal">
    <div class="st-modal">
        <div class="st-modal-header">
            <div class="st-modal-title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                Delete Account
            </div>
            <div class="st-modal-sub">This cannot be undone</div>
        </div>
        <form method="POST" action="/settings/delete-account">
            @csrf
            <div class="st-modal-body">
                <div class="st-modal-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <span>All your data will be permanently deleted — consultations, lab reports, family members, and your account. There is no way to recover this data.</span>
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

const flash = document.getElementById('flashMsg');
if (flash) setTimeout(() => flash.style.display = 'none', 4000);
</script>

@endsection