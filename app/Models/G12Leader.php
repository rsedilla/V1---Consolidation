<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHierarchyTraversal;
use App\Traits\ManagesHierarchyCache;

class G12Leader extends Model
{
    use HasHierarchyTraversal, ManagesHierarchyCache;

    protected $fillable = [
        'name',
        'user_id',
        'parent_id',
    ];

    /**
     * Get the user account for this G12 leader (if they have login access)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all members under this G12 leader
     */
    public function members()
    {
        return $this->hasMany(Member::class);
    }

    /**
     * Get the parent G12 leader (if any)
     */
    public function parent()
    {
        return $this->belongsTo(G12Leader::class, 'parent_id');
    }

    /**
     * Get direct child G12 leaders
     */
    public function children()
    {
        return $this->hasMany(G12Leader::class, 'parent_id');
    }

    // Hierarchy traversal methods are in HasHierarchyTraversal trait
    // Cache management methods are in ManagesHierarchyCache trait

    /**
     * Get all members visible to this G12 leader (including descendants)
     */
    public function getAllVisibleMembers()
    {
        $visibleLeaderIds = $this->getAllDescendantIds();
        return Member::whereIn('g12_leader_id', $visibleLeaderIds)->get();
    }
}
