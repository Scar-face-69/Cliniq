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

    public function getFileIconAttribute()
    {
        return match(true) {
            str_contains($this->file_type, 'pdf')  => '📄',
            str_contains($this->file_type, 'image') => '🖼',
            default => '📋',
        };
    }

    public function getFileIconBgAttribute()
    {
        return match(true) {
            str_contains(strtolower($this->report_type ?? ''), 'blood') ||
            str_contains(strtolower($this->report_type ?? ''), 'cbc')   => 'rgba(239,68,68,0.08)',
            str_contains(strtolower($this->report_type ?? ''), 'thyroid') => 'rgba(96,165,250,0.08)',
            str_contains(strtolower($this->report_type ?? ''), 'urine')   => 'rgba(245,158,11,0.08)',
            default => 'rgba(0,214,143,0.08)',
        };
    }
}
