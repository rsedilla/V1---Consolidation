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
                    ->sortable(),
                // Member Type column removed as requested
                TextColumn::make('consolidation_date')
                    ->label('Consolidation Date')
                    ->date('d/m/Y')
                    ->sortable()
                    ->placeholder('Not set'),
                TextColumn::make('g12Leader.name')
                    ->label('G12 Leader')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('consolidator_name')
                    ->label('Consolidator')
                    ->getStateUsing(function ($record) {
                        if ($record->consolidator) {
                            return $record->consolidator->first_name . ' ' . $record->consolidator->last_name;
                        }
                        return 'N/A';
                    })
                    ->placeholder('N/A')
                    ->searchable(false)
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
