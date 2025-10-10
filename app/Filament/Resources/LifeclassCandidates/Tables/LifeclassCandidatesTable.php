<?php

namespace App\Filament\Resources\LifeclassCandidates\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class LifeclassCandidatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('member.first_name')
                    ->label('First Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('member.last_name')
                    ->label('Last Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('member.consolidator.first_name')
                    ->label('Consolidator')
                    ->formatStateUsing(fn ($record) => 
                        $record->member?->consolidator 
                            ? $record->member->consolidator->first_name . ' ' . $record->member->consolidator->last_name 
                            : 'N/A'
                    )
                    ->searchable(['consolidator.first_name', 'consolidator.last_name'])
                    ->sortable(),
                
                // Individual Life Class Lesson Status Columns (L1-L9)
                TextColumn::make('lesson_1_completion_date')
                    ->label('L1')
                    ->formatStateUsing(fn ($state) => $state ? '✓' : '-')
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('lesson_2_completion_date')
                    ->label('L2')
                    ->formatStateUsing(fn ($state) => $state ? '✓' : '-')
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('lesson_3_completion_date')
                    ->label('L3')
                    ->formatStateUsing(fn ($state) => $state ? '✓' : '-')
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('lesson_4_completion_date')
                    ->label('L4')
                    ->formatStateUsing(fn ($state) => $state ? '✓' : '-')
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('encounter_completion_date')
                    ->label('Encounter')
                    ->formatStateUsing(fn ($state) => $state ? '✓' : '-')
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('lesson_6_completion_date')
                    ->label('L6')
                    ->formatStateUsing(fn ($state) => $state ? '✓' : '-')
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('lesson_7_completion_date')
                    ->label('L7')
                    ->formatStateUsing(fn ($state) => $state ? '✓' : '-')
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('lesson_8_completion_date')
                    ->label('L8')
                    ->formatStateUsing(fn ($state) => $state ? '✓' : '-')
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('lesson_9_completion_date')
                    ->label('L9')
                    ->formatStateUsing(fn ($state) => $state ? '✓' : '-')
                    ->color(fn ($state) => $state ? 'success' : 'gray')
                    ->sortable()
                    ->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Delete Lifeclass Candidate')
                    ->modalDescription('Are you sure you want to permanently delete this lifeclass candidate? This action cannot be undone and will remove all associated data.')
                    ->modalSubmitActionLabel('Yes, Delete Permanently')
                    ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Lifeclass Candidates')
                        ->modalDescription('Are you sure you want to permanently delete the selected lifeclass candidates? This action cannot be undone and will remove all associated data.')
                        ->modalSubmitActionLabel('Yes, Delete Permanently')
                        ->color('danger'),
                ]),
            ]);
    }
}
