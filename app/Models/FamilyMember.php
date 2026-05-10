<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'relation',
        'age',
        'gender',
        'blood_group',
        'allergies',
        'conditions',
        'medications',
        'status',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    // Relationship to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Get allergies as array
    public function getAllergiesArrayAttribute()
    {
        if (!$this->allergies) return [];
        return array_map('trim', explode(',', $this->allergies));
    }

    // Get conditions as array
    public function getConditionsArrayAttribute()
    {
        if (!$this->conditions) return [];
        return array_map('trim', explode(',', $this->conditions));
    }

    // Get medications as array
    public function getMedicationsArrayAttribute()
    {
        if (!$this->medications) return [];
        return array_map('trim', explode(',', $this->medications));
    }

    // Get initials for avatar
    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($this->name, 0, 2));
    }

    // Avatar color based on relation
    public function getAvatarColorAttribute()
    {
        $colors = [
            'Mother'  => 'linear-gradient(135deg,#60A5FA,#3B82F6)',
            'Father'  => 'linear-gradient(135deg,#FBBF24,#F59E0B)',
            'Sister'  => 'linear-gradient(135deg,#F472B6,#EC4899)',
            'Brother' => 'linear-gradient(135deg,#818CF8,#6366F1)',
            'Spouse'  => 'linear-gradient(135deg,#F87171,#EF4444)',
            'Child'   => 'linear-gradient(135deg,#34D399,#10B981)',
            'Other'   => 'linear-gradient(135deg,#94A3B8,#64748B)',
        ];
        return $colors[$this->relation] ?? 'linear-gradient(135deg,#00D68F,#00B377)';
    }

    // Ring color based on status
    public function getRingColorAttribute()
    {
        return match($this->status) {
            'healthy'  => '#00D68F',
            'followup' => '#F59E0B',
            'alert'    => '#EF4444',
            default    => '#00D68F',
        };
    }
}
