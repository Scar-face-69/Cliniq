<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'user_id',
        'family_member_id',
        'symptoms',
        'ai_response',
        'risk_level',
        'conditions',
        'recommendations',
        'is_emergency',
        'language',
    ];

    protected $casts = [
        'ai_response'     => 'array',
        'conditions'      => 'array',
        'recommendations' => 'array',
        'is_emergency'    => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function messages()
    {
        return $this->hasMany(ConsultationMessage::class);
    }

    public function getRiskColorAttribute()
    {
        return match($this->risk_level) {
            'high'   => '#EF4444',
            'medium' => '#F59E0B',
            default  => '#00D68F',
        };
    }

    public function getRiskLabelAttribute()
    {
        return match($this->risk_level) {
            'high'   => 'HIGH RISK',
            'medium' => 'MEDIUM RISK',
            default  => 'LOW RISK',
        };
    }
}
