<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class G12Leader extends Model
{
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

    /**
     * Get all descendant G12 leader IDs (recursive)
     */
    public function getAllDescendantIds()
    {
        $descendants = collect([$this->id]);
        
        // Eager load children to prevent lazy loading violations
        $this->loadMissing('children');
        
        foreach ($this->children as $child) {
            $descendants = $descendants->merge($child->getAllDescendantIds());
        }
        
        return $descendants->unique()->values()->toArray();
    }

    /**
     * Get all ancestor G12 leader IDs (recursive)
     */
    public function getAllAncestorIds()
    {
        $ancestors = collect();
        
        // Eager load parent to prevent lazy loading violations
        $this->loadMissing('parent');
        
        if ($this->parent) {
            $ancestors->push($this->parent->id);
            $ancestors = $ancestors->merge($this->parent->getAllAncestorIds());
        }
        
        return $ancestors->unique()->values()->toArray();
    }

    /**
     * Check if this leader is a descendant of another leader
     */
    public function isDescendantOf(G12Leader $leader)
    {
        return in_array($leader->id, $this->getAllAncestorIds());
    }

    /**
     * Check if this leader is an ancestor of another leader
     */
    public function isAncestorOf(G12Leader $leader)
    {
        return in_array($this->id, $leader->getAllAncestorIds());
    }

    /**
     * Get all members visible to this G12 leader (including descendants)
     */
    public function getAllVisibleMembers()
    {
        $visibleLeaderIds = $this->getAllDescendantIds();
        return Member::whereIn('g12_leader_id', $visibleLeaderIds)->get();
    }
}
