<?php

namespace App\Filament\Resources\LifeclassCandidates\Tables;

use App\Filament\Traits\HasSol1Promotion;
use App\Filament\Traits\HasLessonTableColumns;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class LifeclassCandidatesTable
{
    use HasSol1Promotion;
    use HasLessonTableColumns;
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->label('First Name')
                    ->formatStateUsing(fn ($record) => 
                        $record->solProfile 
                            ? $record->solProfile->first_name 
                            : $record->member?->first_name ?? 'N/A'
                    )
                    ->sortable()
                    ->searchable(['solProfile.first_name', 'member.first_name']),
                TextColumn::make('last_name')
                    ->label('Last Name')
                    ->formatStateUsing(fn ($record) => 
                        $record->solProfile 
                            ? $record->solProfile->last_name 
                            : $record->member?->last_name ?? 'N/A'
                    )
                    ->sortable()
                    ->searchable(['solProfile.last_name', 'member.last_name']),
                TextColumn::make('g12_leader')
                    ->label('G12 Leader')
                    ->formatStateUsing(function ($record) {
                        if ($record->solProfile && $record->solProfile->g12Leader) {
                            return $record->solProfile->g12Leader->first_name . ' ' . $record->solProfile->g12Leader->last_name;
                        }
                        if ($record->member && $record->member->consolidator) {
                            return $record->member->consolidator->first_name . ' ' . $record->member->consolidator->last_name;
                        }
                        return 'N/A';
                    })
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
                EditAction::make(),
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
