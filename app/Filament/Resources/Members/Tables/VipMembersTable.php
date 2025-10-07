<?php

namespace App\Filament\Resources\Members\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use App\Services\MemberDeletionService;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class VipMembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->label('First Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('last_name')
                    ->label('Last Name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                // Member Type column removed as requested
                TextColumn::make('consolidation_date')
                    ->label('Consolidation Date')
                    ->date('d/m/Y')
                    ->sortable()
                    ->placeholder('Not set')
                    ->toggleable(isToggledHiddenByDefault: false)
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
                    }),
                TextColumn::make('g12Leader.name')
                    ->label('G12 Leader')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('consolidator_name')
                    ->label('Consolidator')
                    ->getStateUsing(function ($record) {
                        if ($record->consolidator) {
                            return $record->consolidator->first_name . ' ' . $record->consolidator->last_name;
                        }
                        return 'N/A';
                    })
                    ->placeholder('N/A')
                    ->toggleable(isToggledHiddenByDefault: false)
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
                    }),
                TextColumn::make('vipStatus.name')
                    ->label('VIP Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'New Believer' => 'success',
                        'Recommitment' => 'warning', 
                        'Other Church' => 'info',
                        default => 'secondary',
                    })
                    ->placeholder('Not Set')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Joined')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Delete VIP Member')
                    ->modalDescription('Are you sure you want to permanently delete this VIP member? This action cannot be undone and will permanently remove all member data from the system.')
                    ->modalSubmitActionLabel('Yes, Delete Permanently')
                    ->modalIcon('heroicon-o-exclamation-triangle')
                    ->color('danger')
                    ->before(function ($record) {
                        // Use MemberDeletionService for safe deletion with dependency handling
                        $deletionService = app(MemberDeletionService::class);
                        $result = $deletionService->safeDelete($record);
                        
                        if (!$result['success']) {
                            throw new \Exception($result['message']);
                        }
                        
                        // Prevent the default delete action since we already handled it
                        return false;
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected VIP Members')
                        ->modalDescription('Are you sure you want to permanently delete the selected VIP members? This action cannot be undone and will permanently remove all member data from the system.')
                        ->modalSubmitActionLabel('Yes, Delete Permanently')
                        ->modalIcon('heroicon-o-exclamation-triangle')
                        ->color('danger')
                        ->action(function ($records) {
                            // Use MemberDeletionService for batch safe deletion
                            $deletionService = app(MemberDeletionService::class);
                            $memberIds = collect($records)->pluck('id')->toArray();
                            
                            $result = $deletionService->batchDelete($memberIds);
                            
                            if (!$result['success']) {
                                throw new \Exception($result['message']);
                            }
                        }),
                ]),
            ])
            ->defaultSort('last_name', 'asc');
    }
}
