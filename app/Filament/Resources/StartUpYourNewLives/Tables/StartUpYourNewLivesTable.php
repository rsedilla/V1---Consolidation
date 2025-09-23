<?php

namespace App\Filament\Resources\StartUpYourNewLives\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class StartUpYourNewLivesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('member.first_name')
                    ->label('Member')
                    ->formatStateUsing(fn ($record) => $record->member->first_name . ' ' . $record->member->last_name)
                    ->searchable(['member.first_name', 'member.last_name'])
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
                
                // Individual Lesson Status Columns (L1-L10)
                TextColumn::make('lesson_1_completion_date')
                    ->label('L1')
                    ->formatStateUsing(fn ($state) => $state ? 'ok' : 'n/a')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->placeholder('n/a'),
                TextColumn::make('lesson_2_completion_date')
                    ->label('L2')
                    ->formatStateUsing(fn ($state) => $state ? 'ok' : 'n/a')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->placeholder('n/a'),
                TextColumn::make('lesson_3_completion_date')
                    ->label('L3')
                    ->formatStateUsing(fn ($state) => $state ? 'ok' : 'n/a')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->placeholder('n/a'),
                TextColumn::make('lesson_4_completion_date')
                    ->label('L4')
                    ->formatStateUsing(fn ($state) => $state ? 'ok' : 'n/a')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->placeholder('n/a'),
                TextColumn::make('lesson_5_completion_date')
                    ->label('L5')
                    ->formatStateUsing(fn ($state) => $state ? 'ok' : 'n/a')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->placeholder('n/a'),
                TextColumn::make('lesson_6_completion_date')
                    ->label('L6')
                    ->formatStateUsing(fn ($state) => $state ? 'ok' : 'n/a')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->placeholder('n/a'),
                TextColumn::make('lesson_7_completion_date')
                    ->label('L7')
                    ->formatStateUsing(fn ($state) => $state ? 'ok' : 'n/a')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->placeholder('n/a'),
                TextColumn::make('lesson_8_completion_date')
                    ->label('L8')
                    ->formatStateUsing(fn ($state) => $state ? 'ok' : 'n/a')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->placeholder('n/a'),
                TextColumn::make('lesson_9_completion_date')
                    ->label('L9')
                    ->formatStateUsing(fn ($state) => $state ? 'ok' : 'n/a')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->placeholder('n/a'),
                TextColumn::make('lesson_10_completion_date')
                    ->label('L10')
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
                    ->modalHeading('Delete Start Up Your New Life Record')
                    ->modalDescription('Are you sure you want to permanently delete this Start Up Your New Life record? This action cannot be undone and will remove all lesson progress data.')
                    ->modalSubmitActionLabel('Yes, Delete Permanently')
                    ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Start Up Your New Life Records')
                        ->modalDescription('Are you sure you want to permanently delete the selected Start Up Your New Life records? This action cannot be undone and will remove all lesson progress data.')
                        ->modalSubmitActionLabel('Yes, Delete Permanently')
                        ->color('danger'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
