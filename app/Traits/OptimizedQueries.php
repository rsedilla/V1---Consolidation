<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

trait OptimizedQueries
{
    /**
     * Scope to add common eager loading for member resources
     */
    public function scopeWithMemberRelations(Builder $query): Builder
    {
        return $query->with([
            'memberType:id,name',
            'status:id,name',
            'g12Leader:id,name',
            'vipStatus:id,name'
        ]);
    }

    /**
     * Scope to add consolidator relationship with minimal data
     */
    public function scopeWithConsolidator(Builder $query): Builder
    {
        return $query->with([
            'consolidator:id,first_name,last_name'
        ]);
    }

    /**
     * Scope to optimize queries for dashboard statistics
     */
    public function scopeForDashboardStats(Builder $query): Builder
    {
        return $query->select([
            'id',
            'member_type_id',
            'status_id',
            'g12_leader_id',
            'created_at'
        ]);
    }

    /**
     * Scope to optimize queries for listing pages
     */
    public function scopeForListing(Builder $query): Builder
    {
        return $query->select([
            'id',
            'first_name',
            'last_name',
            'email',
            'phone',
            'member_type_id',
            'status_id',
            'g12_leader_id',
            'vip_status_id',
            'created_at'
        ])->withMemberRelations();
    }

    /**
     * Scope to count records efficiently
     */
    public function scopeCountOnly(Builder $query): Builder
    {
        return $query->select('id');
    }
}