<?php

namespace App\Filament\Traits;

use App\Models\Member;
use Filament\Forms\Components\Select;

trait HasMemberFields
{
    /**
     * Get VIP member selection field
     * Shows only members with VIP member type
     */
    public static function getVipMemberField(): Select
    {
        return Select::make('member_id')
            ->label('Member (VIP Only)')
            ->options(Member::vips()->orderBy('first_name')->get()->mapWithKeys(function ($member) {
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
     */
    public static function getQualifiedVipMemberField(): Select
    {
        return Select::make('member_id')
            ->label('Member (Qualified VIPs Only)')
            ->options(\App\Services\MemberCompletionService::getQualifiedVipMembers()->mapWithKeys(function ($member) {
                return [$member->id => $member->first_name . ' ' . $member->last_name];
            }))
            ->required()
            ->searchable()
            ->placeholder('Select a VIP qualified for Life Class')
            ->helperText('Shows VIPs who completed: 10/10 New Life Training + 4/4 Sunday Services + 4/4 Cell Groups');
    }
}