<?php

namespace App\Filament\Resources\G12Leaders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class G12LeadersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Leader Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make('parent.name')
                    ->label('Parent Leader')
                    ->searchable()
                    ->sortable()
                    ->placeholder('No Parent')
                    ->badge()
                    ->color('info'),

                TextColumn::make('user.name')
                    ->label('User Account')
                    ->searchable()
                    ->sortable()
                    ->placeholder('No Account')
                    ->badge()
                    ->color('success'),

                TextColumn::make('members_count')
                    ->label('Members')
                    ->counts('members')
                    ->badge()
                    ->color('warning')
                    ->sortable(),

                TextColumn::make('children_count')
                    ->label('Sub-Leaders')
                    ->counts('children')
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Delete G12 Leader')
                    ->modalDescription('Are you sure you want to delete this G12 leader? This will also remove their assignment from members and users.')
                    ->modalSubmitActionLabel('Yes, Delete')
                    ->color('danger'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected G12 Leaders')
                        ->modalDescription('Are you sure you want to delete the selected G12 leaders? This will also remove their assignments from members and users.')
                        ->modalSubmitActionLabel('Yes, Delete All'),
                ]),
            ])
            ->defaultSort('name');
    }
}