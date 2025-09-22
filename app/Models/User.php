<?php

namespace App\Models;

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
     * Get the G12 leader record this user represents (if they are a G12 leader)
     */
    public function leaderRecord()
    {
        return $this->hasOne(G12Leader::class);
    }

    /**
     * Get all members under this user's G12 leadership (if they are a G12 leader)
     */
    public function leaderMembers()
    {
        return $this->hasManyThrough(Member::class, G12Leader::class, 'user_id', 'g12_leader_id');
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
     * Leaders can only select from their hierarchy, admins can select any
     */
    public function getAvailableG12Leaders(): array
    {
        if ($this->isAdmin()) {
            // Admins can assign any G12 leader
            return G12Leader::orderBy('name')->pluck('name', 'id')->toArray();
        }
        
        if ($this->leaderRecord) {
            // Leaders can only assign from their hierarchy (themselves + descendants)
            $visibleLeaderIds = $this->leaderRecord->getAllDescendantIds();
            return G12Leader::whereIn('id', $visibleLeaderIds)
                ->orderBy('name')
                ->pluck('name', 'id')
                ->toArray();
        }

        // Other users cannot assign G12 leaders
        return [];
    }

    /**
     * Get available consolidators for form selection based on user role
     * Leaders see consolidators in their entire hierarchy (themselves + all descendants)
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
        
        if ($this->leaderRecord) {
            // Leaders see consolidators in their entire hierarchy (including descendants)
            $visibleLeaderIds = $this->leaderRecord->getAllDescendantIds();
            
            $consolidatorsInHierarchy = Member::consolidators()
                ->whereIn('g12_leader_id', $visibleLeaderIds)
                ->orderBy('first_name')
                ->get();
            
            return $consolidatorsInHierarchy->mapWithKeys(function ($member) {
                return [$member->id => $member->first_name . ' ' . $member->last_name];
            })->toArray();
        }

        // Other users cannot see consolidators
        return [];
    }

    /**
     * Get all members visible to this user based on hierarchy
     */
    public function getVisibleMembers()
    {
        if ($this->isAdmin()) {
            // Admins can see all members
            return Member::query();
        }
        
        if ($this->leaderRecord) {
            // Leaders can see members in their entire hierarchy
            $visibleLeaderIds = $this->leaderRecord->getAllDescendantIds();
            return Member::whereIn('g12_leader_id', $visibleLeaderIds);
        }

        // Other users cannot see any members
        return Member::whereRaw('1 = 0'); // Empty query
    }

    /**
     * Check if user can view a specific member
     */
    public function canViewMember(Member $member): bool
    {
        if ($this->isAdmin()) {
            return true;
        }
        
        if ($this->leaderRecord) {
            $visibleLeaderIds = $this->leaderRecord->getAllDescendantIds();
            return in_array($member->g12_leader_id, $visibleLeaderIds);
        }

        return false;
    }

    /**
     * Check if user can edit a specific member
     */
    public function canEditMember(Member $member): bool
    {
        return $this->canViewMember($member);
    }
}
