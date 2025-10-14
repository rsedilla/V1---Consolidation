<?php

namespace App\Traits;

trait HasRolePermissions
{
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
     * Check if user is an equipping staff
     */
    public function isEquipping(): bool
    {
        return $this->role === 'equipping';
    }

    /**
     * Check if user has admin, leader, or equipping privileges
     */
    public function hasLeadershipRole(): bool
    {
        return in_array($this->role, ['admin', 'leader', 'equipping']);
    }

    /**
     * Get role display name
     */
    public function getRoleDisplayAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Administrator',
            'leader' => 'Leader',
            'equipping' => 'Equipping',
            'user' => 'User',
            default => 'User',
        };
    }
}
