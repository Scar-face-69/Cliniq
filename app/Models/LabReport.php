<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabReport extends Model
{
    protected $fillable = [
        'user_id',
        'family_member_id',
        'file_name',
        'file_path',
        'file_type',
        'report_type',
        'status',
        'ai_analysis',
        'lab_values',
        'summary',
        'abnormal_count',
        'normal_count',
    ];

    protected $casts = [
        'ai_analysis' => 'array',
        'lab_values'  => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function getFileIconAttribute(): string
    {
        return match (true) {
            str_contains($this->file_type, 'pdf') => 'pdf',
            str_contains($this->file_type, 'image') => 'image',
            default => 'file',
        };
    }

    public function getFileIconBgAttribute(): string
    {
        return match (true) {
            str_contains(strtolower($this->report_type ?? ''), 'blood') ||
            str_contains(strtolower($this->report_type ?? ''), 'cbc') => 'rgba(220,38,38,0.1)',
            str_contains(strtolower($this->report_type ?? ''), 'thyroid') => 'rgba(243,244,246,0.08)',
            str_contains(strtolower($this->report_type ?? ''), 'urine') => 'rgba(245,158,11,0.1)',
            default => 'rgba(243,244,246,0.06)',
        };
    }
}
