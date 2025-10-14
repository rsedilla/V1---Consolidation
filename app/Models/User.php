<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\SecureQueryTrait;
use App\Traits\HasRolePermissions;
use App\Traits\HasHierarchyFiltering;
use App\Traits\HasSelectOptions;
use App\Traits\ManagesUserCache;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, 
        Notifiable, 
        SecureQueryTrait,
        HasRolePermissions,
        HasHierarchyFiltering,
        HasSelectOptions,
        ManagesUserCache;

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

    // Role permission methods are in HasRolePermissions trait

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
        return $this->hasManyThrough(
            Member::class,
            G12Leader::class,
            'user_id',
            'g12_leader_id'
        );
    }

    /**
     * Check if user can access G12 leader specific data
     */
    public function canAccessLeaderData(): bool
    {
        return $this->isLeader() && $this->leaderRecord;
    }

    /**
     * Get the G12 leader ID for filtering
     */
    public function getG12LeaderId(): ?int
    {
        return $this->g12_leader_id;
    }

    /**
     * Get the assigned G12 Leader record for Equipping users
     * Equipping users are assigned to a specific G12 Leader via g12_leader_id
     */
    public function assignedLeader()
    {
        return $this->belongsTo(G12Leader::class, 'g12_leader_id');
    }

    // Hierarchy filtering methods are in HasHierarchyFiltering trait
    // Select options methods are in HasSelectOptions trait
    // Cache management methods are in ManagesUserCache trait
}
