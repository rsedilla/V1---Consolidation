<?php

namespace App\Filament\Traits;

use Filament\Tables\Columns\TextColumn;

/**
 * Trait for reusable member table columns
 * 
 * Provides common column definitions used across member tables
 * to eliminate code duplication and ensure consistency.
 */
trait HasMemberTableColumns
{
    /**
     * Generate first name column
     */
    protected static function makeFirstNameColumn(): TextColumn
    {
        return TextColumn::make('first_name')
            ->label('First Name')
            ->searchable()
            ->sortable();
    }

    /**
     * Generate last name column
     */
    protected static function makeLastNameColumn(bool $toggleable = false): TextColumn
    {
        return TextColumn::make('last_name')
            ->label('Last Name')
            ->searchable()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: $toggleable);
    }

    /**
     * Generate G12 Leader column
     */
    protected static function makeG12LeaderColumn(bool $toggleable = false): TextColumn
    {
        return TextColumn::make('g12Leader.name')
            ->label('G12 Leader')
            ->searchable()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: $toggleable);
    }

    /**
     * Generate Consolidator name column with custom formatting
     */
    protected static function makeConsolidatorColumn(bool $toggleable = false): TextColumn
    {
        return TextColumn::make('consolidator_name')
            ->label('Consolidator')
            ->getStateUsing(function ($record) {
                if ($record->consolidator) {
                    return $record->consolidator->first_name . ' ' . $record->consolidator->last_name;
                }
                return 'N/A';
            })
            ->placeholder('N/A')
            ->toggleable(isToggledHiddenByDefault: $toggleable)
            ->searchable(query: function ($query, string $search) {
                return $query->whereHas('consolidator', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%");
                });
            })
            ->sortable(query: function ($query, $direction) {
                return $query->leftJoin('members as consolidators', 'members.consolidator_id', '=', 'consolidators.id')
                    ->orderBy('consolidators.first_name', $direction)
                    ->orderBy('consolidators.last_name', $direction);
            });
    }

    /**
     * Generate Member Type column
     */
    protected static function makeMemberTypeColumn(): TextColumn
    {
        return TextColumn::make('memberType.name')
            ->label('Member Type')
            ->searchable()
            ->sortable();
    }

    /**
     * Generate Status column
     */
    protected static function makeStatusColumn(): TextColumn
    {
        return TextColumn::make('status.name')
            ->label('Status')
            ->sortable();
    }

    /**
     * Generate VIP Status column with badge
     */
    protected static function makeVipStatusColumn(): TextColumn
    {
        return TextColumn::make('vipStatus.name')
            ->label('VIP Status')
            ->badge()
            ->color(fn (string $state): string => match ($state) {
                'New Believer' => 'success',
                'Recommitment' => 'warning', 
                'Other Church' => 'info',
                default => 'secondary',
            })
            ->placeholder('Not Set')
            ->sortable();
    }

    /**
     * Generate Consolidation Date column with month search
     */
    protected static function makeConsolidationDateColumn(bool $toggleable = false): TextColumn
    {
        return TextColumn::make('consolidation_date')
            ->label('Consolidation Date')
            ->date('d/m/Y')
            ->sortable()
            ->placeholder('Not set')
            ->toggleable(isToggledHiddenByDefault: $toggleable)
            ->searchable(query: function ($query, string $search) {
                // Map month names to numbers
                $months = [
                    'january' => 1, 'jan' => 1,
                    'february' => 2, 'feb' => 2,
                    'march' => 3, 'mar' => 3,
                    'april' => 4, 'apr' => 4,
                    'may' => 5,
                    'june' => 6, 'jun' => 6,
                    'july' => 7, 'jul' => 7,
                    'august' => 8, 'aug' => 8,
                    'september' => 9, 'sep' => 9, 'sept' => 9,
                    'october' => 10, 'oct' => 10,
                    'november' => 11, 'nov' => 11,
                    'december' => 12, 'dec' => 12,
                ];
                
                $searchLower = strtolower(trim($search));
                
                // Check if search term is a month name
                if (isset($months[$searchLower])) {
                    return $query->whereMonth('consolidation_date', $months[$searchLower]);
                }
                
                // Otherwise search as regular date
                return $query->where('consolidation_date', 'like', "%{$search}%");
            });
    }

    /**
     * Generate Created At column
     */
    protected static function makeCreatedAtColumn(): TextColumn
    {
        return TextColumn::make('created_at')
            ->label('Joined')
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }
}
