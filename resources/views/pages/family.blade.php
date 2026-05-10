@extends('layouts.dashboard')

@section('title', 'Family Members — ClinIQ')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/family.css') }}" />
@endpush

@section('content')

{{-- HEADER --}}
<div class="fp-header">
    <div>
        <div class="fp-breadcrumb">
            <a href="/dashboard">Dashboard</a> › <em>Family Members</em>
        </div>
        <div class="fp-page-title">Family Profiles</div>
        <div class="fp-page-sub">Manage health records for every member of your family</div>
    </div>
    <div class="fp-header-right">
        <button class="fp-filter-btn" onclick="openModal()">+ Add Member</button>
    </div>
</div>

{{-- FLASH MESSAGES --}}
@if(session('success'))
    <div class="fp-flash success">✓ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="fp-flash error">✕ {{ session('error') }}</div>
@endif

{{-- STATS --}}
<div class="fp-stats">
    <div class="fp-stat-card" style="--sc:#60A5FA;">
        <div class="fp-stat-label">Total Members</div>
        <div class="fp-stat-value">{{ $stats['total'] }}</div>
        <span class="fp-stat-badge b">All active</span>
    </div>
    <div class="fp-stat-card" style="--sc:#00D68F;">
        <div class="fp-stat-label">Healthy</div>
        <div class="fp-stat-value">{{ $stats['healthy'] }}</div>
        <span class="fp-stat-badge g">No issues</span>
    </div>
    <div class="fp-stat-card" style="--sc:#F59E0B;">
        <div class="fp-stat-label">Follow-up Needed</div>
        <div class="fp-stat-value">{{ $stats['followup'] }}</div>
        <span class="fp-stat-badge a">Review today</span>
    </div>
    <div class="fp-stat-card" style="--sc:#EF4444;">
        <div class="fp-stat-label">Risk Alerts</div>
        <div class="fp-stat-value">{{ $stats['alert'] }}</div>
        <span class="fp-stat-badge {{ $stats['alert'] > 0 ? 'r' : 'g' }}">
            {{ $stats['alert'] > 0 ? 'Urgent' : 'All clear' }}
        </span>
    </div>
</div>

{{-- MEMBERS GRID --}}
<div class="fp-grid">

    {{-- EXISTING MEMBERS --}}
    @foreach($members as $member)
    <div class="fp-card" style="--ct:rgba({{ $member->status === 'followup' ? '245,158,11' : ($member->status === 'alert' ? '239,68,68' : '0,214,143') }},0.06);">

        <div class="fp-card-top">
            {{-- Actions --}}
            <div class="fp-card-actions">
                <button class="fp-act-btn" onclick="openEditModal({{ $member->id }}, '{{ addslashes($member->name) }}', '{{ $member->relation }}', '{{ $member->age }}', '{{ $member->gender }}', '{{ $member->blood_group }}', '{{ addslashes($member->allergies) }}', '{{ addslashes($member->conditions) }}', '{{ addslashes($member->medications) }}')">✏</button>
                <form method="POST" action="/family/{{ $member->id }}" style="display:inline;" onsubmit="return confirm('Remove {{ $member->name }} from your family?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="fp-act-btn del">🗑</button>
                </form>
            </div>

            {{-- Avatar --}}
            <div class="fp-avatar-wrap">
                <div style="position:relative;display:inline-block;">
                    <div class="fp-avatar" style="background:{{ $member->avatar_color }};color:{{ in_array($member->relation, ['Mother','Sister','Child']) ? 'white' : ($member->relation === 'Father' ? '#0A1628' : 'white') }};">
                        {{ $member->initials }}
                    </div>
                    <div class="fp-avatar-ring" style="border-color:{{ $member->ring_color }};"></div>
                </div>
            </div>

            <div class="fp-card-name">{{ $member->name }}</div>
            <div class="fp-card-meta">{{ $member->age ? $member->age . ' yrs' : '' }}{{ $member->age && $member->gender ? ' • ' : '' }}{{ $member->gender ?? '' }}</div>

            <div class="fp-status-wrap">
                <span class="fp-status {{ $member->status }}">
                    {{ $member->status === 'healthy' ? '● Healthy' : ($member->status === 'followup' ? '⚠ Follow-up' : '🚨 Alert') }}
                </span>
                <span class="fp-relation-badge">{{ $member->relation }}</span>
            </div>
        </div>

        <div class="fp-card-body">
            <div class="fp-divider"></div>

            {{-- Info grid --}}
            <div class="fp-info-grid">
                <div class="fp-info-item">
                    <div class="fp-info-label">Blood Group</div>
                    <div class="fp-info-value accent">{{ $member->blood_group ?? 'Unknown' }}</div>
                </div>
                <div class="fp-info-item">
                    <div class="fp-info-label">Consultations</div>
                    <div class="fp-info-value accent">0</div>
                </div>
            </div>

            {{-- Tags --}}
            <div class="fp-tags">
                @if($member->allergies)
                    @foreach($member->allergies_array as $allergy)
                        <span class="fp-tag allergy">{{ $allergy }}</span>
                    @endforeach
                @endif
                @if($member->conditions)
                    @foreach($member->conditions_array as $condition)
                        <span class="fp-tag condition">{{ $condition }}</span>
                    @endforeach
                @endif
                @if($member->medications)
                    @foreach($member->medications_array as $med)
                        <span class="fp-tag med">{{ $med }}</span>
                    @endforeach
                @endif
                @if(!$member->allergies && !$member->conditions && !$member->medications)
                    <span class="fp-tag none">No history added</span>
                @endif
            </div>

            {{-- Buttons --}}
            <div class="fp-card-btns">
                <a href="/consultation/new?member={{ $member->id }}" class="fp-card-btn consult">New Consult</a>
                <a href="#" class="fp-card-btn records">Records</a>
            </div>
        </div>
    </div>
    @endforeach

    {{-- ADD CARD --}}
    <div class="fp-add-card" onclick="openModal()">
        <div class="fp-add-icon-wrap">+</div>
        <div class="fp-add-card-title">Add Family Member</div>
        <div class="fp-add-card-sub">Add parents, siblings, children<br>or spouse with their full health profile</div>
    </div>

</div>

{{-- ===== ADD MODAL ===== --}}
<div class="fp-modal-overlay" id="addModal">
    <div class="fp-modal">
        <div class="fp-modal-header">
            <div>
                <div class="fp-modal-title">Add Family Member</div>
                <div class="fp-modal-subtitle">Fill in details to create a health profile</div>
            </div>
            <button class="fp-modal-close" onclick="closeModal()">✕</button>
        </div>

        <form method="POST" action="/family">
            @csrf
            <div class="fp-modal-body">

                <div class="fp-modal-section">Basic Information</div>

                <div class="fp-form-row">
                    <div class="fp-form-group">
                        <label class="fp-label">Full Name *</label>
                        <input class="fp-input" type="text" name="name" placeholder="e.g. Sara Khan" required />
                    </div>
                    <div class="fp-form-group">
                        <label class="fp-label">Relation *</label>
                        <select class="fp-select" name="relation" required>
                            <option value="">Select relation</option>
                            <option>Mother</option>
                            <option>Father</option>
                            <option>Sister</option>
                            <option>Brother</option>
                            <option>Spouse</option>
                            <option>Child</option>
                            <option>Other</option>
                        </select>
                    </div>
                </div>

                <div class="fp-form-row">
                    <div class="fp-form-group">
                        <label class="fp-label">Age</label>
                        <input class="fp-input" type="number" name="age" placeholder="e.g. 45" min="0" max="120" />
                    </div>
                    <div class="fp-form-group">
                        <label class="fp-label">Gender</label>
                        <select class="fp-select" name="gender">
                            <option value="">Select</option>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="fp-form-group">
                        <label class="fp-label">Blood Group</label>
                        <select class="fp-select" name="blood_group">
                            <option value="">Unknown</option>
                            <option>A+</option><option>A-</option>
                            <option>B+</option><option>B-</option>
                            <option>O+</option><option>O-</option>
                            <option>AB+</option><option>AB-</option>
                        </select>
                    </div>
                </div>

                <div class="fp-modal-section">Medical History</div>

                <div class="fp-form-full">
                    <label class="fp-label">Known Allergies</label>
                    <input class="fp-input" type="text" name="allergies" placeholder="e.g. Penicillin, Peanuts (comma separated)" />
                </div>

                <div class="fp-form-full">
                    <label class="fp-label">Medical Conditions</label>
                    <input class="fp-input" type="text" name="conditions" placeholder="e.g. Diabetes, Hypertension (comma separated)" />
                </div>

                <div class="fp-form-full">
                    <label class="fp-label">Current Medications</label>
                    <textarea class="fp-textarea" name="medications" placeholder="e.g. Metformin 500mg daily, Aspirin 75mg..."></textarea>
                </div>

            </div>
            <div class="fp-modal-footer">
                <button type="button" class="fp-modal-cancel" onclick="closeModal()">Cancel</button>
                <button type="submit" class="fp-modal-save">Save Member Profile</button>
            </div>
        </form>
    </div>
</div>

{{-- ===== EDIT MODAL ===== --}}
<div class="fp-modal-overlay" id="editModal">
    <div class="fp-modal">
        <div class="fp-modal-header">
            <div>
                <div class="fp-modal-title">Edit Family Member</div>
                <div class="fp-modal-subtitle">Update health profile details</div>
            </div>
            <button class="fp-modal-close" onclick="closeEditModal()">✕</button>
        </div>

        <form method="POST" id="editForm" action="">
            @csrf
            @method('PUT')
            <div class="fp-modal-body">

                <div class="fp-modal-section">Basic Information</div>

                <div class="fp-form-row">
                    <div class="fp-form-group">
                        <label class="fp-label">Full Name *</label>
                        <input class="fp-input" type="text" name="name" id="edit_name" required />
                    </div>
                    <div class="fp-form-group">
                        <label class="fp-label">Relation *</label>
                        <select class="fp-select" name="relation" id="edit_relation" required>
                            <option>Mother</option><option>Father</option>
                            <option>Sister</option><option>Brother</option>
                            <option>Spouse</option><option>Child</option><option>Other</option>
                        </select>
                    </div>
                </div>

                <div class="fp-form-row">
                    <div class="fp-form-group">
                        <label class="fp-label">Age</label>
                        <input class="fp-input" type="number" name="age" id="edit_age" min="0" max="120" />
                    </div>
                    <div class="fp-form-group">
                        <label class="fp-label">Gender</label>
                        <select class="fp-select" name="gender" id="edit_gender">
                            <option value="">Select</option>
                            <option>Male</option><option>Female</option><option>Other</option>
                        </select>
                    </div>
                    <div class="fp-form-group">
                        <label class="fp-label">Blood Group</label>
                        <select class="fp-select" name="blood_group" id="edit_blood">
                            <option value="">Unknown</option>
                            <option>A+</option><option>A-</option><option>B+</option><option>B-</option>
                            <option>O+</option><option>O-</option><option>AB+</option><option>AB-</option>
                        </select>
                    </div>
                </div>

                <div class="fp-modal-section">Medical History</div>

                <div class="fp-form-full">
                    <label class="fp-label">Known Allergies</label>
                    <input class="fp-input" type="text" name="allergies" id="edit_allergies" />
                </div>
                <div class="fp-form-full">
                    <label class="fp-label">Medical Conditions</label>
                    <input class="fp-input" type="text" name="conditions" id="edit_conditions" />
                </div>
                <div class="fp-form-full">
                    <label class="fp-label">Current Medications</label>
                    <textarea class="fp-textarea" name="medications" id="edit_medications"></textarea>
                </div>

            </div>
            <div class="fp-modal-footer">
                <button type="button" class="fp-modal-cancel" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="fp-modal-save">Update Member</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openModal() {
    document.getElementById('addModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeModal() {
    document.getElementById('addModal').classList.remove('active');
    document.body.style.overflow = '';
}
function openEditModal(id, name, relation, age, gender, blood, allergies, conditions, medications) {
    document.getElementById('editForm').action = '/family/' + id;
    document.getElementById('edit_name').value       = name;
    document.getElementById('edit_age').value        = age;
    document.getElementById('edit_allergies').value  = allergies;
    document.getElementById('edit_conditions').value = conditions;
    document.getElementById('edit_medications').value= medications;
    setSelect('edit_relation', relation);
    setSelect('edit_gender',   gender);
    setSelect('edit_blood',    blood);
    document.getElementById('editModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeEditModal() {
    document.getElementById('editModal').classList.remove('active');
    document.body.style.overflow = '';
}
function setSelect(id, val) {
    const sel = document.getElementById(id);
    for (let opt of sel.options) {
        if (opt.value === val) { sel.value = val; break; }
    }
}
// Close on backdrop click
document.getElementById('addModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});
</script>
@endpush
