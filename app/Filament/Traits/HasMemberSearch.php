<?php

namespace App\Filament\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait for optimized member search functionality
 * 
 * This trait provides consistent and efficient search capabilities
 * across VIP and Consolidator member resources.
 */
trait HasMemberSearch
{
    /**
     * Configure the base search query with optimized eager loading
     */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return static::getEloquentQuery()
            ->select([
                'members.id',
                'members.first_name',
                'members.last_name',
                'members.email',
                'members.phone',
                'members.address',
                'members.member_type_id',
                'members.status_id',
                'members.g12_leader_id',
                'members.consolidator_id',
                'members.vip_status_id',
            ])
            ->with([
                'memberType:id,name',
                'status:id,name',
                'g12Leader:id,name',
                'consolidator:id,first_name,last_name',
                'vipStatus:id,name',
            ]);
    }

    /**
     * Define base searchable attributes common to all members
     */
    public static function getBaseSearchableAttributes(): array
    {
        return [
            'first_name',
            'last_name', 
            'email',
            'phone',
            'address',
        ];
    }

    /**
     * Define searchable relationship attributes
     */
    public static function getRelationshipSearchableAttributes(): array
    {
        return [
            'memberType.name',
            'status.name',
            'g12Leader.name',
        ];
    }

    /**
     * Get all searchable attributes (combines base and relationship)
     */
    public static function getGloballySearchableAttributes(): array
    {
        $baseAttributes = static::getBaseSearchableAttributes();
        $relationshipAttributes = static::getRelationshipSearchableAttributes();
        
        return array_merge($baseAttributes, $relationshipAttributes);
    }

    /**
     * Configure global search result title
     */
    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return trim("{$record->first_name} {$record->last_name}");
    }

    /**
     * Get base search result details
     */
    public static function getBaseSearchResultDetails(Model $record): array
    {
        $details = [];
        
        if ($record->email) {
            $details['Email'] = $record->email;
        }
        
        if ($record->phone) {
            $details['Phone'] = $record->phone;
        }
        
        if ($record->g12Leader) {
            $details['G12 Leader'] = $record->g12Leader->name;
        }

        return $details;
    }

    /**
     * Format search result details array to string array
     */
    protected static function formatSearchDetails(array $details): array
    {
        return array_map(
            fn($key, $value) => is_numeric($key) ? $value : "{$key}: {$value}",
            array_keys($details),
            $details
        );
    }

    /**
     * Optimize table search queries with proper indexing hints
     */
    public static function getTableSearchQuery(): Builder
    {
        return static::getEloquentQuery()
            ->select([
                'members.*'
            ]);
    }
}
