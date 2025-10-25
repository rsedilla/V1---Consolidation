<?php

namespace App\Filament\Resources\LifeclassCandidates\Tables;

use App\Filament\Traits\HasSol1Promotion;
use App\Filament\Traits\HasLessonTableColumns;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;

class LifeclassCandidatesTable
{
    use HasSol1Promotion;
    use HasLessonTableColumns;
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
                
                // Individual Life Class Lesson Status Columns (L1-L4, Encounter, L6-L9) - Generated dynamically via trait
                ...self::generateLessonColumns(4, 'lesson_', 'L'), // L1-L4
                TextColumn::make('encounter_completion_date')
                    ->label('ENC')
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
                // Promote to SOL 1 Action (using HasSol1Promotion trait)
                self::makeSol1PromotionAction(),
                EditAction::make()
                    ->visible(function () {
                        $user = Auth::user();
                        return $user instanceof User && ($user->isAdmin() || $user->isEquipping());
                    }),
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
