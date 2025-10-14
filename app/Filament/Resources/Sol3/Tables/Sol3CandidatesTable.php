<?php

namespace App\Filament\Resources\Sol3\Tables;

use App\Filament\Traits\HasLessonTableColumns;
use App\Models\Sol3Candidate;
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

class Sol3CandidatesTable
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
                
                // SOL 3 Lesson Status Columns (L1-L10)
                ...self::generateLessonColumns(10, 'lesson_', 'L'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Delete SOL 3 Candidate')
                    ->modalDescription('Are you sure you want to permanently delete this SOL 3 candidate? This action cannot be undone and will remove all associated data.')
                    ->modalSubmitActionLabel('Yes, Delete Permanently')
                    ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected SOL 3 Candidates')
                        ->modalDescription('Are you sure you want to permanently delete the selected SOL 3 candidates? This action cannot be undone and will remove all associated data.')
                        ->modalSubmitActionLabel('Yes, Delete Permanently')
                        ->color('danger'),
                ]),
            ])
            ->defaultSort('enrollment_date', 'desc');
    }
}
