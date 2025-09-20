<?php

namespace App\Filament\Resources\CellGroups\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class CellGroupsTable
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
                
                // Individual Cell Group Session Columns (C1-C4)
                TextColumn::make('cell_group_1_date')
                    ->label('Cell Group (1)')
                    ->formatStateUsing(fn ($state) => $state ? 'ok' : 'n/a')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->placeholder('n/a'),
                TextColumn::make('cell_group_2_date')
                    ->label('Cell Group (2)')
                    ->formatStateUsing(fn ($state) => $state ? 'ok' : 'n/a')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->placeholder('n/a'),
                TextColumn::make('cell_group_3_date')
                    ->label('Cell Group (3)')
                    ->formatStateUsing(fn ($state) => $state ? 'ok' : 'n/a')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->placeholder('n/a'),
                TextColumn::make('cell_group_4_date')
                    ->label('Cell Group (4)')
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
            ]);
    }
}
