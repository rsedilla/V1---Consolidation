<?php

namespace App\Filament\Resources\Members\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class MembersTable
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
                TextColumn::make('memberType.name')
                    ->label('Member Type')
                    ->sortable(),
                TextColumn::make('status.name')
                    ->label('Status')
                    ->sortable(),
                TextColumn::make('g12Leader.name')
                    ->label('G12 Leader')
                    ->sortable(),
                TextColumn::make('consolidator.first_name')
                    ->label('Consolidator')
                    ->formatStateUsing(function ($record) {
                        if ($record->consolidator) {
                            return $record->consolidator->first_name . ' ' . $record->consolidator->last_name;
                        }
                        return 'N/A';
                    })
                    ->placeholder('N/A')
                    ->searchable()
                    ->sortable(),
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
                    ->modalHeading('Delete Member')
                    ->modalDescription('Are you sure you want to permanently delete this member? This action cannot be undone and will permanently remove all member data from the system.')
                    ->modalSubmitActionLabel('Yes, Delete Permanently')
                    ->modalIcon('heroicon-o-exclamation-triangle')
                    ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Members')
                        ->modalDescription('Are you sure you want to permanently delete the selected members? This action cannot be undone and will permanently remove all member data from the system.')
                        ->modalSubmitActionLabel('Yes, Delete Permanently')
                        ->modalIcon('heroicon-o-exclamation-triangle')
                        ->color('danger'),
                ]),
            ])
            ->defaultSort('last_name', 'asc');
    }
}
