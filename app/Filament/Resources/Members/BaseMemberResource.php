<?php

namespace App\Filament\Resources\Members;

use App\Models\Member;
use App\Models\User;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Base Resource class for Member-related resources
 * Provides common functionality for VIP and Consolidator resources
 */
abstract class BaseMemberResource extends Resource
{
    protected static ?string $model = Member::class;

    /**
     * Get the base Eloquent query with common optimizations
     * Child classes can override or extend this
     */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        
        // Use optimized eager loading (if forListing scope exists)
        if (method_exists($query->getModel(), 'scopeForListing')) {
            $query->forListing();
        }
        
        // Apply member type filtering (to be implemented by child classes)
        static::applyMemberTypeFilter($query);

        // Apply G12 leader filtering if user is a leader
        static::applyLeaderFiltering($query);

        return $query;
    }

    /**
     * Apply member type filtering (VIP or Consolidator)
     * Must be implemented by child classes
     */
    abstract protected static function applyMemberTypeFilter(Builder $query): void;

    /**
     * Apply G12 leader hierarchy filtering
     * Leaders can only see members in their hierarchy
     */
    protected static function applyLeaderFiltering(Builder $query): void
    {
        $user = Auth::user();
        
        if ($user instanceof User && $user->isLeader() && $user->leaderRecord) {
            // Get all leader IDs in this user's hierarchy (including themselves and descendants)
            $visibleLeaderIds = $user->leaderRecord->getAllDescendantIds();
            $query->underLeaders($visibleLeaderIds);
        }
    }

    /**
     * Determine if a record can be viewed by the current user
     * Enforces hierarchy-based access control
     */
    public static function canView(Model $record): bool
    {
        $user = Auth::user();

        // Admins can view any member
        if ($user instanceof User && !$user->isLeader()) {
            return true;
        }

        // Leaders can only view members in their hierarchy
        if ($user instanceof User && $user->isLeader() && $user->leaderRecord) {
            $visibleLeaderIds = $user->leaderRecord->getAllDescendantIds();
            return in_array($record->g12_leader_id, $visibleLeaderIds);
        }

        return false;
    }

    /**
     * Determine if a record can be edited by the current user
     * Enforces hierarchy-based access control
     */
    public static function canEdit(Model $record): bool
    {
        return static::canView($record);
    }

    /**
     * Determine if a record can be deleted by the current user
     * Enforces hierarchy-based access control
     */
    public static function canDelete(Model $record): bool
    {
        return static::canView($record);
    }

    /**
     * Format search details for global search results
     * Provides consistent formatting across member resources
     */
    protected static function formatSearchDetails(array $details): array
    {
        return array_filter($details, fn($value) => !empty($value));
    }

    /**
     * Get navigation badge (with caching)
     * Child classes should implement this with their specific cache keys
     */
    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();
        
        // Use the same hierarchy filtering logic as the main query
        if ($user instanceof User && $user->isLeader() && $user->leaderRecord) {
            return (string) static::getEloquentQuery()->count();
        }
        
        // For admin users, show total count
        return (string) static::getEloquentQuery()->count();
    }

    /**
     * Clear navigation badge cache
     * Child classes can override to implement caching
     */
    public static function clearNavigationBadgeCache($userId = null): void
    {
        // Override in child classes to implement caching
    }
}
