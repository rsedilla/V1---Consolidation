<?php

namespace App\Filament\Traits;

use App\Models\Member;
use App\Models\User;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;

trait HasQualifiedMemberFields
{
    use HasBasicMemberFields;

    /**
     * Get qualified VIP members for Life Class selection field
     * Shows only VIPs who completed all requirements (10/10 New Life + 4/4 Sunday + 4/4 Cell Group)
     * Filtered by G12 hierarchy for leaders
     * Optimized for edit mode - only loads current member when editing
     */
    public static function getQualifiedVipMemberField(): Select
    {
        return Select::make('member_id')
            ->label('Member (Qualified VIPs Only)')
            ->options(function ($record) {
                // When editing, just show current member (no search needed)
                if ($record) {
                    $currentOption = static::getCurrentMemberOption($record);
                    if ($currentOption) {
                        return $currentOption;
                    }
                }
                
                // When creating, load qualified VIPs
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
                
                return $options;
            })
            ->required()
            ->searchable(fn ($record) => !$record) // Only searchable when creating
            ->disabled(fn ($record) => (bool) $record) // Disabled when editing
            ->placeholder('Select a VIP qualified for Life Class')
            ->helperText('Shows VIPs who completed: 10/10 New Life Training + 4/4 Sunday Services + 4/4 Cell Groups');
    }
}
