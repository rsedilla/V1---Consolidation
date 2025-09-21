<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use App\Models\G12Leader;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('role')
                    ->label('Role')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'admin' => 'Administrator',
                        'leader' => 'Leader',
                        'user' => 'User',
                        default => 'User',
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'leader' => 'warning', 
                        'user' => 'secondary',
                        default => 'secondary',
                    })
                    ->sortable(),
                TextColumn::make('g12Leader.name')
                    ->label('G12 Leader')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Not assigned')
                    ->badge()
                    ->color('info'),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Role')
                    ->options([
                        'user' => 'User',
                        'leader' => 'Leader',
                        'admin' => 'Administrator',
                    ])
                    ->placeholder('All Roles'),
                SelectFilter::make('g12_leader_id')
                    ->label('G12 Leader')
                    ->options(G12Leader::orderBy('name')->pluck('name', 'id'))
                    ->placeholder('All G12 Leaders'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
