<?php

namespace App\Filament\Resources\SolGraduate\Tables;

use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SolGraduatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Name (Full Name)
                TextColumn::make('full_name')
                    ->label('Name')
                    ->sortable(['first_name', 'last_name'])
                    ->searchable(['first_name', 'middle_name', 'last_name'])
                    ->getStateUsing(fn($record) => $record->full_name),
                
                // G12 Leader
                TextColumn::make('g12Leader.name')
                    ->label('G12 Leader')
                    ->searchable()
                    ->sortable(),
                
                // Cell Leader (Yes/No)
                BadgeColumn::make('is_cell_leader')
                    ->label('Cell Leader')
                    ->formatStateUsing(fn($state) => $state ? 'Yes' : 'No')
                    ->color(fn($state) => $state ? 'success' : 'gray'),
                
                // Status (from sol_profiles status_id)
                TextColumn::make('status.name')
                    ->label('Status')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                
                // Graduation Date (from sol3_candidate record)
                TextColumn::make('sol3Candidate.graduation_date')
                    ->label('Graduation Date')
                    ->date('M d, Y')
                    ->sortable(),
            ])
            ->filters([
                // Filter by G12 Leader
                SelectFilter::make('g12_leader_id')
                    ->label('G12 Leader')
                    ->relationship('g12Leader', 'name')
                    ->searchable()
                    ->preload(),
                
                // Filter by Cell Leader status
                SelectFilter::make('is_cell_leader')
                    ->label('Cell Leader')
                    ->options([
                        '1' => 'Yes',
                        '0' => 'No',
                    ]),
                
                // Filter by Status
                SelectFilter::make('status_id')
                    ->label('Status')
                    ->relationship('status', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->defaultSort('first_name', 'asc')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }
}
