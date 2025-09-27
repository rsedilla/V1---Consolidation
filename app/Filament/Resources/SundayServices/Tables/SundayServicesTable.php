<?php

namespace App\Filament\Resources\SundayServices\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class SundayServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('member.first_name')
                    ->label('Member')
                    ->formatStateUsing(function ($record) {
                        if ($record->member) {
                            return $record->member->first_name . ' ' . $record->member->last_name;
                        }
                        return 'N/A';
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('consolidator_name')
                    ->label('Consolidator')
                    ->getStateUsing(function ($record) {
                        if ($record->member && $record->member->consolidator) {
                            return $record->member->consolidator->first_name . ' ' . $record->member->consolidator->last_name;
                        }
                        return 'N/A';
                    })
                    ->placeholder('N/A')
                    ->searchable(false)
                    ->sortable(false),
                
                // Individual Sunday Service Session Columns (S1-S4)
                TextColumn::make('sunday_service_1_date')
                    ->label('Sunday Service (1)')
                    ->formatStateUsing(fn ($state) => $state ? 'ok' : 'n/a')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->placeholder('n/a'),
                TextColumn::make('sunday_service_2_date')
                    ->label('Sunday Service (2)')
                    ->formatStateUsing(fn ($state) => $state ? 'ok' : 'n/a')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->placeholder('n/a'),
                TextColumn::make('sunday_service_3_date')
                    ->label('Sunday Service (3)')
                    ->formatStateUsing(fn ($state) => $state ? 'ok' : 'n/a')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->placeholder('n/a'),
                TextColumn::make('sunday_service_4_date')
                    ->label('Sunday Service (4)')
                    ->formatStateUsing(fn ($state) => $state ? 'ok' : 'n/a')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->placeholder('n/a'),
                
                TextColumn::make('notes')
                    ->label('Notes')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Created')
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
                    ->modalHeading('Delete Sunday Service Record')
                    ->modalDescription('Are you sure you want to permanently delete this Sunday service record? This action cannot be undone and will remove all session data.')
                    ->modalSubmitActionLabel('Yes, Delete Permanently')
                    ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Sunday Service Records')
                        ->modalDescription('Are you sure you want to permanently delete the selected Sunday service records? This action cannot be undone and will remove all session data.')
                        ->modalSubmitActionLabel('Yes, Delete Permanently')
                        ->color('danger'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
