<?php

namespace App\Filament\Resources\SolProfiles\Tables;

use App\Models\SolProfile;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SolProfilesTable
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
                
                TextColumn::make('currentSolLevel.level_name')
                    ->label('Current Level')
                    ->badge()
                    ->color(function (?SolProfile $record) {
                        if (!$record || !$record->currentSolLevel) return 'secondary';
                        return match($record->currentSolLevel->level_number) {
                            1 => 'info',
                            2 => 'warning',
                            3 => 'success',
                            default => 'secondary',
                        };
                    })
                    ->sortable(),
                
                TextColumn::make('g12Leader.name')
                    ->label('G12 Leader')
                    ->searchable()
                    ->sortable(),
                
                BadgeColumn::make('is_cell_leader')
                    ->label('Cell Leader')
                    ->getStateUsing(fn (?SolProfile $record) => $record?->is_cell_leader ? 'Yes' : 'No')
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
                    ->getStateUsing(function (?SolProfile $record) {
                        if (!$record) return '0/10';
                        $progress = $record->getCompletionProgress();
                        return $progress['completed'] . '/' . $progress['total'];
                    })
                    ->badge()
                    ->color(function (?SolProfile $record) {
                        if (!$record) return 'secondary';
                        $progress = $record->getCompletionProgress();
                        
                        if ($progress['percentage'] >= 100) return 'success';
                        if ($progress['percentage'] >= 70) return 'warning';
                        return 'secondary';
                    }),
                
                BadgeColumn::make('qualified_for_sol2')
                    ->label('SOL 2 Ready')
                    ->getStateUsing(function (?SolProfile $record) {
                        return $record?->isQualifiedForSol2() ? 'Qualified' : '';
                    })
                    ->colors([
                        'success' => 'Qualified',
                    ])
                    ->visible(fn (?SolProfile $record) => $record?->isQualifiedForSol2() ?? false),
                
                TextColumn::make('created_at')
                    ->label('Enrolled')
                    ->date('Y-m-d')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('current_sol_level_id')
                    ->label('SOL Level')
                    ->relationship('currentSolLevel', 'level_name'),
                
                SelectFilter::make('status')
                    ->relationship('status', 'name'),
                
                SelectFilter::make('g12_leader_id')
                    ->label('G12 Leader')
                    ->relationship('g12Leader', 'name')
                    ->searchable()
                    ->preload(),
                
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
                // Actions defined in ListSolProfiles page
            ])
            ->bulkActions([
                // Bulk actions defined in ListSolProfiles page
            ])
            ->defaultSort('created_at', 'desc');
    }
}
