<?php

namespace App\Filament\Resources\Sol1\Tables;

use App\Filament\Traits\HasLessonTableColumns;
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
    use HasLessonTableColumns;
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
                
                // SOL 1 Lesson Status Columns (L1-L10)
                ...self::generateLessonColumns(10, 'lesson_', 'L'),
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
