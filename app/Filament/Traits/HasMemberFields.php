<?php

namespace App\Filament\Traits;

use App\Models\Member;
use App\Models\User;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

trait HasMemberFields
{
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
     * Format member collection into options array
     * 
     * @param Collection $members
     * @return array
     */
    protected static function formatMemberOptions(Collection $members): array
    {
        return $members->mapWithKeys(function ($member) {
            return [$member->id => $member->first_name . ' ' . $member->last_name];
        })->toArray();
    }
    
    /**
     * Add current member to options if editing and not already present
     * 
     * @param array $options
     * @param mixed $record
     * @return array
     */
    protected static function includeCurrentMember(array $options, $record): array
    {
        if ($record && $record->member_id && !isset($options[$record->member_id])) {
            $currentMember = Member::find($record->member_id);
            if ($currentMember) {
                $options[$record->member_id] = $currentMember->first_name . ' ' . $currentMember->last_name;
            }
        }
        
        return $options;
    }
    
    /**
     * Build a VIP member Select field with optional scope filtering
     * 
     * @param string $label
     * @param string $helperText
     * @param callable|null $scopeCallback
     * @param bool $includeEditingMember Whether to include current member when editing
     * @return Select
     */
    protected static function buildVipMemberSelect(
        string $label = 'Member (VIP Only)',
        string $helperText = '',
        ?callable $scopeCallback = null,
        bool $includeEditingMember = false
    ): Select {
        $select = Select::make('member_id')
            ->label($label)
            ->required()
            ->searchable(fn ($record) => !$record) // Only searchable when creating
            ->disabled(fn ($record) => (bool) $record) // Disabled when editing
            ->placeholder('Select a VIP member');
        
        if ($includeEditingMember) {
            // Use dynamic options for edit mode
            $select->options(function ($record) use ($scopeCallback) {
                // When editing, just show current member (no search needed)
                if ($record && $record->member_id) {
                    $currentMember = Member::find($record->member_id);
                    if ($currentMember) {
                        return [$record->member_id => $currentMember->first_name . ' ' . $currentMember->last_name];
                    }
                }
                // When creating, load available members with search
                $vips = static::getFilteredVips($scopeCallback);
                $options = static::formatMemberOptions($vips);
                return static::includeCurrentMember($options, $record);
            });
        } else {
            // Use static options for better performance when editing is not needed
            $vips = static::getFilteredVips($scopeCallback);
            $select->options(static::formatMemberOptions($vips));
        }
        
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
     * Get all members selection field (for reference)
     */
    public static function getAllMembersField(): Select
    {
        $members = Member::orderBy('first_name')->get();
        
        return Select::make('member_id')
            ->label('Member')
            ->options(static::formatMemberOptions($members))
            ->required()
            ->searchable();
    }

    /**
     * Get consolidator members selection field
     */
    public static function getConsolidatorMemberField(): Select
    {
        $consolidators = Member::consolidators()->orderBy('first_name')->get();
        
        return Select::make('member_id')
            ->label('Member (Consolidators Only)')
            ->options(static::formatMemberOptions($consolidators))
            ->required()
            ->searchable()
            ->placeholder('Select a consolidator');
    }

    /**
     * Get qualified VIP members for Life Class selection field
     * Shows only VIPs who completed all requirements (10/10 New Life + 4/4 Sunday + 4/4 Cell Group)
     * Filtered by G12 hierarchy for leaders
     * When editing, includes the current member even if they no longer qualify
     */
    public static function getQualifiedVipMemberField(): Select
    {
        return Select::make('member_id')
            ->label('Member (Qualified VIPs Only)')
            ->options(function ($record) {
                $user = Auth::user();
                $baseQuery = \App\Services\MemberCompletionService::getQualifiedVipMembers();
                
                // Apply hierarchical filtering for leaders
                if ($user instanceof User && $user->leaderRecord && !$user->isAdmin()) {
                    $visibleLeaderIds = $user->leaderRecord->getAllDescendantIds();
                    $qualifiedVips = $baseQuery->filter(function ($member) use ($visibleLeaderIds) {
                        return in_array($member->g12_leader_id, $visibleLeaderIds);
                    });
                } else {
                    // Admins see all qualified VIPs
                    $qualifiedVips = $baseQuery;
                }
                
                // Build options array
                $options = $qualifiedVips->mapWithKeys(function ($member) {
                    return [$member->id => $member->first_name . ' ' . $member->last_name];
                })->toArray();
                
                // When editing, include current member if not already in list
                if ($record && $record->member_id && !isset($options[$record->member_id])) {
                    $currentMember = Member::find($record->member_id);
                    if ($currentMember) {
                        $options[$record->member_id] = $currentMember->first_name . ' ' . $currentMember->last_name;
                    }
                }
                
                return $options;
            })
            ->required()
            ->searchable()
            ->placeholder('Select a VIP qualified for Life Class')
            ->helperText('Shows VIPs who completed: 10/10 New Life Training + 4/4 Sunday Services + 4/4 Cell Groups');
    }

    /**
     * Get VIP member selection field for New Life Training
     * Shows only VIPs who are NOT yet enrolled in StartUpYourNewLife
     * When editing, includes the current member
     */
    public static function getVipMemberFieldForNewLife(): Select
    {
        return static::buildVipMemberSelect(
            label: 'Member (VIP Only)',
            helperText: 'Shows VIPs who are not yet enrolled in New Life Training',
            scopeCallback: fn($query) => $query->withoutNewLifeTraining(),
            includeEditingMember: true
        );
    }

    /**
     * Get VIP member selection field for Sunday Services
     * Shows only VIPs who are NOT yet enrolled in Sunday Services
     * When editing, includes the current member
     */
    public static function getVipMemberFieldForSundayService(): Select
    {
        return static::buildVipMemberSelect(
            label: 'Member (VIP Only)',
            helperText: 'Shows VIPs who are not yet enrolled in Sunday Services',
            scopeCallback: fn($query) => $query->withoutSundayService(),
            includeEditingMember: true
        );
    }

    /**
     * Get VIP member selection field for Cell Groups
     * Shows only VIPs who are NOT yet enrolled in Cell Groups
     * When editing, includes the current member
     */
    public static function getVipMemberFieldForCellGroup(): Select
    {
        return static::buildVipMemberSelect(
            label: 'Member (VIP Only)',
            helperText: 'Shows VIPs who are not yet enrolled in Cell Groups',
            scopeCallback: fn($query) => $query->withoutCellGroup(),
            includeEditingMember: true
        );
    }
}