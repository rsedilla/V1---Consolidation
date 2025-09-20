<?php

namespace App\Filament\Resources\SundayServices\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
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
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
