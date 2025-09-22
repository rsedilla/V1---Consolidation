<?php

namespace App\Filament\Resources\Members\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class ConsolidatorMembersTable
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
                // Member Type column removed (they're all Consolidators)
                TextColumn::make('status.name')
                    ->label('Status')
                    ->sortable(),
                TextColumn::make('g12Leader.name')
                    ->label('G12 Leader')
                    ->sortable(),
                // Consolidator column removed (doesn't apply to consolidators)
                // VIP Status column removed (doesn't apply to consolidators)
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
                    ->modalHeading('Delete Consolidator Member')
                    ->modalDescription('Are you sure you want to permanently delete this consolidator member? This action cannot be undone and will permanently remove all member data from the system.')
                    ->modalSubmitActionLabel('Yes, Delete Permanently')
                    ->modalIcon('heroicon-o-exclamation-triangle')
                    ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Consolidator Members')
                        ->modalDescription('Are you sure you want to permanently delete the selected consolidator members? This action cannot be undone and will permanently remove all member data from the system.')
                        ->modalSubmitActionLabel('Yes, Delete Permanently')
                        ->modalIcon('heroicon-o-exclamation-triangle')
                        ->color('danger'),
                ]),
            ])
            ->defaultSort('last_name', 'asc');
    }
}