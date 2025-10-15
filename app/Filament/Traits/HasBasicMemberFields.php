<?php

namespace App\Filament\Traits;

use App\Models\Member;
use Filament\Forms\Components\Select;
use Illuminate\Support\Collection;

trait HasBasicMemberFields
{
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
     * Get current member details for edit mode
     * 
     * @param mixed $record
     * @return array|null
     */
    protected static function getCurrentMemberOption($record): ?array
    {
        if ($record && $record->member_id) {
            $currentMember = Member::find($record->member_id);
            if ($currentMember) {
                return [$record->member_id => $currentMember->first_name . ' ' . $currentMember->last_name];
            }
        }
        return null;
    }

    /**
     * Get all members selection field
     * Optimized for edit mode - only loads current member when editing
     */
    public static function getAllMembersField(): Select
    {
        return Select::make('member_id')
            ->label('Member')
            ->options(function ($record) {
                // When editing, just show current member (no search needed)
                if ($record) {
                    $currentOption = static::getCurrentMemberOption($record);
                    if ($currentOption) {
                        return $currentOption;
                    }
                }
                // When creating, load all members
                $members = Member::orderBy('first_name')->get();
                return static::formatMemberOptions($members);
            })
            ->required()
            ->searchable(fn ($record) => !$record) // Only searchable when creating
            ->disabled(fn ($record) => (bool) $record); // Disabled when editing
    }

    /**
     * Get consolidator members selection field
     * Optimized for edit mode - only loads current member when editing
     */
    public static function getConsolidatorMemberField(): Select
    {
        return Select::make('member_id')
            ->label('Member (Consolidators Only)')
            ->options(function ($record) {
                // When editing, just show current member (no search needed)
                if ($record) {
                    $currentOption = static::getCurrentMemberOption($record);
                    if ($currentOption) {
                        return $currentOption;
                    }
                }
                // When creating, load all consolidators
                $consolidators = Member::consolidators()->orderBy('first_name')->get();
                return static::formatMemberOptions($consolidators);
            })
            ->required()
            ->searchable(fn ($record) => !$record) // Only searchable when creating
            ->disabled(fn ($record) => (bool) $record) // Disabled when editing
            ->placeholder('Select a consolidator');
    }
}
