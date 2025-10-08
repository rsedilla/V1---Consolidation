<?php

namespace App\Filament\Traits;

use App\Models\Member;
use App\Models\User;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;

trait HasMemberFields
{
    /**
     * Get VIP member selection field
     * Shows only members with VIP member type based on user role and G12 hierarchy
     */
    public static function getVipMemberField(): Select
    {
        $user = Auth::user();
        
        if ($user instanceof User && $user->isAdmin()) {
            // Admins see all VIPs
            $vips = Member::vips()->orderBy('first_name')->get();
        } elseif ($user instanceof User && $user->leaderRecord) {
            // Leaders see VIPs in their G12 hierarchy (themselves + all descendants)
            $visibleLeaderIds = $user->leaderRecord->getAllDescendantIds();
            $vips = Member::vips()
                ->whereIn('g12_leader_id', $visibleLeaderIds)
                ->orderBy('first_name')
                ->get();
        } else {
            $vips = collect();
        }
        
        return Select::make('member_id')
            ->label('Member (VIP Only)')
            ->options($vips->mapWithKeys(function ($member) {
                return [$member->id => $member->first_name . ' ' . $member->last_name];
            }))
            ->required()
            ->searchable()
            ->placeholder('Select a VIP member');
    }

    /**
     * Get all members selection field (for reference)
     */
    public static function getAllMembersField(): Select
    {
        return Select::make('member_id')
            ->label('Member')
            ->options(Member::orderBy('first_name')->get()->mapWithKeys(function ($member) {
                return [$member->id => $member->first_name . ' ' . $member->last_name];
            }))
            ->required()
            ->searchable();
    }

    /**
     * Get consolidator members selection field
     */
    public static function getConsolidatorMemberField(): Select
    {
        return Select::make('member_id')
            ->label('Member (Consolidators Only)')
            ->options(Member::consolidators()->orderBy('first_name')->get()->mapWithKeys(function ($member) {
                return [$member->id => $member->first_name . ' ' . $member->last_name];
            }))
            ->required()
            ->searchable()
            ->placeholder('Select a consolidator');
    }

    /**
     * Get qualified VIP members for Life Class selection field
     * Shows only VIPs who completed all requirements (10/10 New Life + 4/4 Sunday + 4/4 Cell Group)
     * Filtered by G12 hierarchy for leaders
     */
    public static function getQualifiedVipMemberField(): Select
    {
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
        
        return Select::make('member_id')
            ->label('Member (Qualified VIPs Only)')
            ->options($qualifiedVips->mapWithKeys(function ($member) {
                return [$member->id => $member->first_name . ' ' . $member->last_name];
            }))
            ->required()
            ->searchable()
            ->placeholder('Select a VIP qualified for Life Class')
            ->helperText('Shows VIPs who completed: 10/10 New Life Training + 4/4 Sunday Services + 4/4 Cell Groups');
    }
}