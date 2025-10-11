<?php

namespace App\Filament\Resources\Sol1\Tables;

use App\Models\Sol1Candidate;
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
                TextColumn::make('sol1.full_name')
                    ->label('Student Name')
                    ->searchable(['sol1.first_name', 'sol1.last_name'])
                    ->sortable(),
                
                TextColumn::make('sol1.g12Leader.name')
                    ->label('G12 Leader')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('enrollment_date')
                    ->label('Enrolled')
                    ->date('Y-m-d')
                    ->sortable(),
                
                TextColumn::make('completion_progress')
                    ->label('Progress')
                    ->getStateUsing(fn (?Sol1Candidate $record) => 
                        $record ? $record->getCompletionCount() . '/10 lessons' : '0/10 lessons'
                    )
                    ->badge()
                    ->color(function (?Sol1Candidate $record) {
                        if (!$record) return 'secondary';
                        $count = $record->getCompletionCount();
                        if ($count >= 10) return 'success';
                        if ($count >= 7) return 'warning';
                        if ($count >= 4) return 'info';
                        return 'secondary';
                    }),
                
                TextColumn::make('completion_percentage')
                    ->label('Completion %')
                    ->getStateUsing(fn (?Sol1Candidate $record) => 
                        $record ? $record->getCompletionPercentage() . '%' : '0%'
                    )
                    ->sortable(query: function (Builder $query, string $direction) {
                        // Custom sort by counting completed lessons
                        return $query->orderByRaw('
                            (CASE WHEN lesson_1_completion_date IS NOT NULL THEN 1 ELSE 0 END +
                             CASE WHEN lesson_2_completion_date IS NOT NULL THEN 1 ELSE 0 END +
                             CASE WHEN lesson_3_completion_date IS NOT NULL THEN 1 ELSE 0 END +
                             CASE WHEN lesson_4_completion_date IS NOT NULL THEN 1 ELSE 0 END +
                             CASE WHEN lesson_5_completion_date IS NOT NULL THEN 1 ELSE 0 END +
                             CASE WHEN lesson_6_completion_date IS NOT NULL THEN 1 ELSE 0 END +
                             CASE WHEN lesson_7_completion_date IS NOT NULL THEN 1 ELSE 0 END +
                             CASE WHEN lesson_8_completion_date IS NOT NULL THEN 1 ELSE 0 END +
                             CASE WHEN lesson_9_completion_date IS NOT NULL THEN 1 ELSE 0 END +
                             CASE WHEN lesson_10_completion_date IS NOT NULL THEN 1 ELSE 0 END
                            ) ' . $direction
                        );
                    }),
                
                BadgeColumn::make('qualified_for_sol2')
                    ->label('SOL 2 Ready')
                    ->getStateUsing(function (?Sol1Candidate $record) {
                        return $record?->isQualifiedForSol2() ? 'Qualified' : '';
                    })
                    ->colors([
                        'success' => 'Qualified',
                    ])
                    ->visible(fn (?Sol1Candidate $record) => $record?->isQualifiedForSol2() ?? false),
                
                TextColumn::make('graduation_date')
                    ->label('Graduated')
                    ->date('Y-m-d')
                    ->sortable()
                    ->placeholder('In Progress'),
            ])
            ->filters([
                SelectFilter::make('g12_leader_id')
                    ->label('G12 Leader')
                    ->relationship('sol1.g12Leader', 'name'),
                
                TernaryFilter::make('completed')
                    ->label('Completion Status')
                    ->placeholder('All Students')
                    ->trueLabel('Completed (10/10)')
                    ->falseLabel('In Progress')
                    ->queries(
                        true: fn (Builder $query) => $query->completed(),
                        false: fn (Builder $query) => $query->whereNull('graduation_date'),
                    ),
                
                TernaryFilter::make('qualified_for_sol2')
                    ->label('SOL 2 Ready')
                    ->placeholder('All Students')
                    ->trueLabel('Qualified for SOL 2')
                    ->falseLabel('Not Yet Qualified')
                    ->queries(
                        true: fn (Builder $query) => $query->qualifiedForSol2(),
                        false: fn (Builder $query) => $query->whereNotIn('id', 
                            Sol1Candidate::qualifiedForSol2()->pluck('id')
                        ),
                    ),
            ])
            ->actions([
                // Actions defined in ListSol1Candidates page
            ])
            ->bulkActions([
                // Bulk actions defined in ListSol1Candidates page
            ])
            ->defaultSort('enrollment_date', 'desc');
    }
}
