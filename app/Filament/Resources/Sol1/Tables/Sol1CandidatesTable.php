<?php

namespace App\Filament\Resources\Sol1\Tables;

use App\Models\Sol1Candidate;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class Sol1CandidatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('solProfile.first_name')
                    ->label('First Name')
                    ->sortable()
                    ->searchable(),
                
                TextColumn::make('solProfile.last_name')
                    ->label('Last Name')
                    ->sortable()
                    ->searchable(),
                
                TextColumn::make('solProfile.g12Leader.name')
                    ->label('G12 Leader')
                    ->searchable()
                    ->sortable(),
                
                // Individual SOL 1 Lesson Status Columns (L1-L10)
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
                
                TextColumn::make('lesson_5_completion_date')
                    ->label('L5')
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
                
                TextColumn::make('lesson_10_completion_date')
                    ->label('L10')
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
                    ->modalHeading('Delete SOL 1 Candidate')
                    ->modalDescription('Are you sure you want to permanently delete this SOL 1 candidate? This action cannot be undone and will remove all associated data.')
                    ->modalSubmitActionLabel('Yes, Delete Permanently')
                    ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected SOL 1 Candidates')
                        ->modalDescription('Are you sure you want to permanently delete the selected SOL 1 candidates? This action cannot be undone and will remove all associated data.')
                        ->modalSubmitActionLabel('Yes, Delete Permanently')
                        ->color('danger'),
                ]),
            ])
            ->defaultSort('enrollment_date', 'desc');
    }
}
