<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use App\Traits\SecureQueryTrait;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SecureQueryTrait;

    /**
     * Instance cache for visible leader IDs to prevent duplicate queries in same request
     */
    private $visibleLeaderIdsCache = null;

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

    /**
     * Get visible leader IDs for data filtering based on user role
     * - Admin: See all leaders (returns empty array, no filtering)
     * - Equipping: See only assigned leader's hierarchy (including descendants)
     * - Leader: See their own hierarchy (including descendants)
     * - User: No access (returns empty array)
     * 
     * @return array Array of G12Leader IDs that the user can access
     */
    public function getVisibleLeaderIdsForFiltering(): array
    {
        // Admin sees everything - no filtering needed
        if ($this->isAdmin()) {
            return [];
        }

        // Equipping users see only their assigned leader's hierarchy
        if ($this->isEquipping() && $this->assignedLeader) {
            return Cache::remember(
                "equipping_user_{$this->id}_visible_leaders",
                1800, // 30 minutes
                fn() => $this->assignedLeader->getAllDescendantIds()
            );
        }

        // Leaders see their own hierarchy
        if ($this->isLeader() && $this->leaderRecord) {
            return $this->getVisibleLeaderIds();
        }

        // Regular users have no access
        return [];
    }

    /**
     * Check if equipping user can access data for a specific member
     * 
     * @param Member $member The member to check access for
     * @return bool True if user can access the member's data
     */
    public function canAccessMemberData(Member $member): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if ($this->isEquipping() && $this->assignedLeader) {
            $visibleLeaderIds = $this->getVisibleLeaderIdsForFiltering();
            return in_array($member->g12_leader_id, $visibleLeaderIds);
        }

        if ($this->isLeader() && $this->leaderRecord) {
            $visibleLeaderIds = $this->getVisibleLeaderIds();
            return in_array($member->g12_leader_id, $visibleLeaderIds);
        }

        return false;
    }

    /**
     * Get cached visible leader IDs to prevent duplicate hierarchy traversal in same request
     */
    private function getVisibleLeaderIds(): array
    {
        if ($this->visibleLeaderIdsCache === null) {
            $this->visibleLeaderIdsCache = $this->leaderRecord->getAllDescendantIds();
        }
        return $this->visibleLeaderIdsCache;
    }

    /**
     * Get available G12 leaders for form selection based on user role
     * Leaders can only select from their hierarchy, admins can select any
     * Results are cached for 30 minutes to improve form load performance
     */
    public function getAvailableG12Leaders(): array
    {
        if ($this->isAdmin()) {
            return $this->getAllG12Leaders();
        }
        
        if ($this->leaderRecord) {
            return $this->getHierarchyG12Leaders();
        }

        return [];
    }

    /**
     * Get all G12 leaders for admin users (cached)
     */
    private function getAllG12Leaders(): array
    {
        return Cache::remember('all_g12_leaders', 1800, function () {
            return G12Leader::orderBy('name')
                ->pluck('name', 'id')
                ->toArray();
        });
    }

    /**
     * Get G12 leaders from user's hierarchy (cached)
     */
    private function getHierarchyG12Leaders(): array
    {
        $cacheKey = "user_{$this->id}_available_leaders";
        
        return Cache::remember($cacheKey, 1800, function () {
            $visibleLeaderIds = $this->getVisibleLeaderIds();
            
            return G12Leader::whereIn('id', $visibleLeaderIds)
                ->orderBy('name')
                ->pluck('name', 'id')
                ->toArray();
        });
    }

    /**
     * Get available consolidators for form selection based on user role
     * Leaders see consolidators in their entire hierarchy (themselves + all descendants)
     * Results are cached for 30 minutes to improve form load performance
     */
    public function getAvailableConsolidators(): array
    {
        if ($this->isAdmin()) {
            return $this->getAllConsolidators();
        }
        
        if ($this->leaderRecord) {
            return $this->getHierarchyConsolidators();
        }

        return [];
    }

    /**
     * Get all consolidators for admin users (cached)
     */
    private function getAllConsolidators(): array
    {
        return Cache::remember('all_consolidators', 1800, function () {
            return Member::consolidators()
                ->select('id', 'first_name', 'last_name') // Only needed columns
                ->orderBy('first_name')
                ->get()
                ->mapWithKeys(function ($member) {
                    return [$member->id => $this->formatMemberName($member)];
                })
                ->toArray();
        });
    }

    /**
     * Get consolidators from user's hierarchy (cached & optimized)
     * Excludes the logged-in user from appearing in their own consolidator search options
     */
    private function getHierarchyConsolidators(): array
    {
        $cacheKey = "user_{$this->id}_available_consolidators";
        
        return Cache::remember($cacheKey, 1800, function () {
            $visibleLeaderIds = $this->getVisibleLeaderIds();
            
            // Eager load only necessary columns to reduce memory usage
            $consolidators = Member::consolidators()
                ->whereIn('g12_leader_id', $visibleLeaderIds)
                ->select('id', 'first_name', 'last_name', 'email') // Only needed columns
                ->orderBy('first_name')
                ->get();
            
            // Pre-compute comparison values for better performance
            $userEmail = strtolower(trim($this->email ?? ''));
            $userName = strtolower(trim($this->name ?? ''));

            return $consolidators
                ->reject(function ($member) use ($userEmail, $userName) {
                    // Exclude self from search options - fast email comparison first
                    if (!empty($member->email) && !empty($userEmail)) {
                        if (strtolower(trim($member->email)) === $userEmail) {
                            return true;
                        }
                    }
                    
                    // Fallback: name comparison
                    if (!empty($userName)) {
                        $memberFullName = strtolower(trim("{$member->first_name} {$member->last_name}"));
                        if ($memberFullName === $userName) {
                            return true;
                        }
                    }
                    
                    return false;
                })
                ->mapWithKeys(function ($member) {
                    return [$member->id => $this->formatMemberName($member)];
                })
                ->toArray();
        });
    }

    /**
     * Check if a member represents the same person as the logged-in user
     * Used to exclude the user from seeing themselves in consolidator search options
     */
    private function isSamePerson(Member $member): bool
    {
        // Primary check: exact email match
        if (!empty($member->email) && !empty($this->email) && $member->email === $this->email) {
            return true;
        }
        
        // Fallback check: name matching (useful when emails differ but it's the same person)
        $userFirstName = strtolower(trim($this->first_name ?? ''));
        $userLastName = strtolower(trim($this->last_name ?? ''));
        $memberFirstName = strtolower(trim($member->first_name ?? ''));
        $memberLastName = strtolower(trim($member->last_name ?? ''));
        
        // If we have both first and last names, check if they match
        if (!empty($userFirstName) && !empty($userLastName) && 
            !empty($memberFirstName) && !empty($memberLastName)) {
            return $userFirstName === $memberFirstName && $userLastName === $memberLastName;
        }
        
        return false;
    }

    /**
     * Format member name for display
     */
    private function formatMemberName(Member $member): string
    {
        return $member->first_name . ' ' . $member->last_name;
    }

    /**
     * Get all members visible to this user based on hierarchy
     */
    public function getVisibleMembers()
    {
        if ($this->isAdmin()) {
            return Member::query();
        }
        
        if ($this->leaderRecord) {
            return $this->getHierarchyMembers();
        }

        return $this->getEmptyMemberQuery();
    }

    /**
     * Get members from user's hierarchy (uses instance cache)
     */
    private function getHierarchyMembers()
    {
        $visibleLeaderIds = $this->getVisibleLeaderIds();
        return Member::whereIn('g12_leader_id', $visibleLeaderIds);
    }

    /**
     * Get empty member query safely
     */
    private function getEmptyMemberQuery()
    {
        return Member::where('id', '=', 0);
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
            return $this->isMemberInHierarchy($member);
        }

        return false;
    }

    /**
     * Check if member is in user's hierarchy (uses instance cache)
     */
    private function isMemberInHierarchy(Member $member): bool
    {
        $visibleLeaderIds = $this->getVisibleLeaderIds();
        return in_array($member->g12_leader_id, $visibleLeaderIds);
    }

    /**
     * Clear all caches for this user
     * Call this when user's G12 leader assignment changes
     */
    public static function clearUserCache($userId)
    {
        Cache::forget("user_{$userId}_available_leaders");
        Cache::forget("user_{$userId}_available_consolidators");
        
        // Also clear global caches that might be affected
        Cache::forget('all_g12_leaders');
        Cache::forget('all_consolidators');
    }

    /**
     * Boot method to handle cache invalidation
     */
    protected static function booted()
    {
        // Clear cache when user's G12 leader assignment changes
        static::saved(function ($user) {
            if ($user->isDirty('g12_leader_id') || $user->isDirty('role')) {
                static::clearUserCache($user->id);
            }
        });

        // Clear cache when user is deleted
        static::deleted(function ($user) {
            static::clearUserCache($user->id);
        });
    }

    /**
     * Check if user can edit a specific member
     */
    public function canEditMember(Member $member): bool
    {
        return $this->canViewMember($member);
    }
}
