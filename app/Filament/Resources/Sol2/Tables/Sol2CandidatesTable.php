<?php

namespace App\Filament\Resources\Sol2\Tables;

use App\Filament\Traits\HasLessonTableColumns;
use App\Filament\Traits\HasSol3Promotion;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class Sol2CandidatesTable
{
    use HasLessonTableColumns;
    use HasSol3Promotion;
    
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
                
                // SOL 2 Lesson Status Columns (L1-L10)
                ...self::generateLessonColumns(10, 'lesson_', 'L'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // Promote to SOL 3 Action (using HasSol3Promotion trait)
                self::makeSol3PromotionAction(),
                
                EditAction::make()
                    ->visible(function () {
                        $user = Auth::user();
                        return $user instanceof User && ($user->isAdmin() || $user->isEquipping());
                    }),
                DeleteAction::make()
                    ->visible(function () {
                        $user = Auth::user();
                        return $user instanceof User && ($user->isAdmin() || $user->isEquipping());
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Delete SOL 2 Candidate')
                    ->modalDescription('Are you sure you want to permanently delete this SOL 2 candidate? This action cannot be undone and will remove all associated data.')
                    ->modalSubmitActionLabel('Yes, Delete Permanently')
                    ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected SOL 2 Candidates')
                        ->modalDescription('Are you sure you want to permanently delete the selected SOL 2 candidates? This action cannot be undone and will remove all associated data.')
                        ->modalSubmitActionLabel('Yes, Delete Permanently')
                        ->color('danger'),
                ]),
            ])
            ->defaultSort('enrollment_date', 'desc');
    }
}
