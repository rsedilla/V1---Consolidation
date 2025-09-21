<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'g12_leader_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a leader
     */
    public function isLeader(): bool
    {
        return $this->role === 'leader';
    }

    /**
     * Check if user has admin or leader privileges
     */
    public function hasLeadershipRole(): bool
    {
        return in_array($this->role, ['admin', 'leader']);
    }

    /**
     * Get role display name
     */
    public function getRoleDisplayAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Administrator',
            'leader' => 'Leader',
            'user' => 'User',
            default => 'User',
        };
    }

    /**
     * Get the G12 leader this user is assigned to
     */
    public function g12Leader()
    {
        return $this->belongsTo(G12Leader::class);
    }

    /**
     * Check if user can access G12 leader specific data
     */
    public function canAccessLeaderData(): bool
    {
        return $this->isLeader() && $this->g12_leader_id !== null;
    }

    /**
     * Get the G12 leader ID for filtering
     */
    public function getG12LeaderId(): ?int
    {
        return $this->g12_leader_id;
    }

    /**
     * Get available G12 leaders for form selection based on user role
     * Leaders can only select themselves, admins can select any
     */
    public function getAvailableG12Leaders(): array
    {
        if ($this->isAdmin()) {
            // Admins can assign any G12 leader
            return G12Leader::orderBy('name')->pluck('name', 'id')->toArray();
        }
        
        if ($this->canAccessLeaderData()) {
            // Leaders can only assign their own G12 leader
            $g12Leader = $this->g12Leader;
            return $g12Leader ? [$g12Leader->id => $g12Leader->name] : [];
        }

        // Other users cannot assign G12 leaders
        return [];
    }

    /**
     * Get available consolidators for form selection based on user role
     * Leaders see only consolidators under their care, admins see all
     */
    public function getAvailableConsolidators(): array
    {
        if ($this->isAdmin()) {
            // Admins can see all consolidators
            return Member::consolidators()
                ->orderBy('first_name')
                ->get()
                ->mapWithKeys(function ($member) {
                    return [$member->id => $member->first_name . ' ' . $member->last_name];
                })
                ->toArray();
        }
        
        if ($this->canAccessLeaderData()) {
            // Leaders see only consolidators under their G12 leadership
            return Member::consolidators()
                ->forG12Leader($this->getG12LeaderId())
                ->orderBy('first_name')
                ->get()
                ->mapWithKeys(function ($member) {
                    return [$member->id => $member->first_name . ' ' . $member->last_name];
                })
                ->toArray();
        }

        // Other users cannot see consolidators
        return [];
    }
}
