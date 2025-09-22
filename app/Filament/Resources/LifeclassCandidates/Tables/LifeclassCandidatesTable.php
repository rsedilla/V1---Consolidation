<?php

namespace App\Filament\Resources\LifeclassCandidates\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class LifeclassCandidatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Delete Lifeclass Candidate')
                    ->modalDescription('Are you sure you want to permanently delete this lifeclass candidate? This action cannot be undone and will remove all associated data.')
                    ->modalSubmitActionLabel('Yes, Delete Permanently')
                    ->color('danger'),
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
