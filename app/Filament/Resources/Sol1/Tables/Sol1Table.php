<?php

namespace App\Filament\Resources\Sol1\Tables;

use App\Models\Sol1;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class Sol1Table
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Name')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(['first_name', 'last_name']),
                
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('g12Leader.name')
                    ->label('G12 Leader')
                    ->searchable()
                    ->sortable(),
                
                BadgeColumn::make('is_cell_leader')
                    ->label('Cell Leader')
                    ->getStateUsing(fn (?Sol1 $record) => $record?->is_cell_leader ? 'Yes' : 'No')
                    ->colors([
                        'success' => 'Yes',
                        'secondary' => 'No',
                    ]),
                
                BadgeColumn::make('status.name')
                    ->label('Status')
                    ->colors([
                        'success' => 'Active',
                        'warning' => 'Inactive',
                        'danger' => 'Archived',
                    ]),
                
                TextColumn::make('completion_progress')
                    ->label('Progress')
                    ->getStateUsing(function (?Sol1 $record) {
                        if (!$record) return '0/10';
                        $candidate = $record->sol1Candidate;
                        if (!$candidate) {
                            return '0/10';
                        }
                        return $candidate->getCompletionCount() . '/10';
                    })
                    ->badge()
                    ->color(function (?Sol1 $record) {
                        if (!$record) return 'secondary';
                        $candidate = $record->sol1Candidate;
                        if (!$candidate) return 'secondary';
                        
                        $count = $candidate->getCompletionCount();
                        if ($count >= 10) return 'success';
                        if ($count >= 7) return 'warning';
                        return 'secondary';
                    }),
                
                BadgeColumn::make('qualified_for_sol2')
                    ->label('SOL 2 Ready')
                    ->getStateUsing(function (?Sol1 $record) {
                        return $record?->isQualifiedForSol2() ? 'Qualified' : '';
                    })
                    ->colors([
                        'success' => 'Qualified',
                    ])
                    ->visible(fn (?Sol1 $record) => $record?->isQualifiedForSol2() ?? false),
                
                TextColumn::make('created_at')
                    ->label('Enrolled')
                    ->date('Y-m-d')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->relationship('status', 'name'),
                
                SelectFilter::make('g12_leader_id')
                    ->label('G12 Leader')
                    ->relationship('g12Leader', 'name'),
                
                SelectFilter::make('is_cell_leader')
                    ->label('Cell Leaders')
                    ->options([
                        '1' => 'Cell Leaders Only',
                    ])
                    ->query(fn (Builder $query, $state) => 
                        $state['value'] ? $query->where('is_cell_leader', true) : $query
                    ),
            ])
            ->actions([
                // Actions defined in ListSol1 page
            ])
            ->bulkActions([
                // Bulk actions defined in ListSol1 page
            ])
            ->defaultSort('created_at', 'desc');
    }
}
