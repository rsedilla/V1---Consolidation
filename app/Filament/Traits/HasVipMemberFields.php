<?php

namespace App\Filament\Traits;

use App\Models\Member;
use App\Models\User;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

trait HasVipMemberFields
{
    use HasBasicMemberFields;

    /**
     * Get filtered VIP members based on user role and hierarchy
     * 
     * @param callable|null $scopeCallback Additional scope to apply (e.g., withoutNewLifeTraining)
     * @return Collection
     */
    protected static function getFilteredVips(?callable $scopeCallback = null): Collection
    {
        $user = Auth::user();
        
        if (!$user instanceof User) {
            return collect();
        }
        
        $query = Member::vips();
        
        // Apply additional scope if provided
        if ($scopeCallback) {
            $scopeCallback($query);
        }
        
        // Apply hierarchy filtering for leaders
        if (!$user->isAdmin() && $user->leaderRecord) {
            $visibleLeaderIds = $user->leaderRecord->getAllDescendantIds();
            $query->whereIn('g12_leader_id', $visibleLeaderIds);
        }
        
        return $query->orderBy('first_name')->get();
    }
    
    /**
     * Build a VIP member Select field with optional scope filtering
     * Optimized for edit mode - only loads current member when editing
     * 
     * @param string $label
     * @param string $helperText
     * @param callable|null $scopeCallback
     * @return Select
     */
    protected static function buildVipMemberSelect(
        string $label = 'Member (VIP Only)',
        string $helperText = '',
        ?callable $scopeCallback = null
    ): Select {
        $select = Select::make('member_id')
            ->label($label)
            ->required()
            ->searchable(fn ($record) => !$record) // Only searchable when creating
            ->disabled(fn ($record) => (bool) $record) // Disabled when editing
            ->placeholder('Select a VIP member');
        
        // Use dynamic options for both create and edit mode
        $select->options(function ($record) use ($scopeCallback) {
            // When editing, just show current member (no search needed)
            if ($record) {
                $currentOption = static::getCurrentMemberOption($record);
                if ($currentOption) {
                    return $currentOption;
                }
            }
            // When creating, load available VIPs with search
            $vips = static::getFilteredVips($scopeCallback);
            return static::formatMemberOptions($vips);
        });
        
        if ($helperText) {
            $select->helperText($helperText);
        }
        
        return $select;
    }
    
    /**
     * Get VIP member selection field
     * Shows only members with VIP member type based on user role and G12 hierarchy
     */
    public static function getVipMemberField(): Select
    {
        return static::buildVipMemberSelect();
    }

    /**
     * Get VIP member selection field for New Life Training
     * Shows only VIPs who are NOT yet enrolled in StartUpYourNewLife
     * When editing, shows only current member (disabled and non-searchable)
     */
    public static function getVipMemberFieldForNewLife(): Select
    {
        return static::buildVipMemberSelect(
            label: 'Member (VIP Only)',
            helperText: 'Shows VIPs who are not yet enrolled in New Life Training',
            scopeCallback: fn($query) => $query->withoutNewLifeTraining()
        );
    }

    /**
     * Get VIP member selection field for Sunday Services
     * Shows only VIPs who are NOT yet enrolled in Sunday Services
     * When editing, shows only current member (disabled and non-searchable)
     */
    public static function getVipMemberFieldForSundayService(): Select
    {
        return static::buildVipMemberSelect(
            label: 'Member (VIP Only)',
            helperText: 'Shows VIPs who are not yet enrolled in Sunday Services',
            scopeCallback: fn($query) => $query->withoutSundayService()
        );
    }

    /**
     * Get VIP member selection field for Cell Groups
     * Shows only VIPs who are NOT yet enrolled in Cell Groups
     * When editing, shows only current member (disabled and non-searchable)
     */
    public static function getVipMemberFieldForCellGroup(): Select
    {
        return static::buildVipMemberSelect(
            label: 'Member (VIP Only)',
            helperText: 'Shows VIPs who are not yet enrolled in Cell Groups',
            scopeCallback: fn($query) => $query->withoutCellGroup()
        );
    }
}
