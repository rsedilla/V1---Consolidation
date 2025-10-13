<?php

namespace App\Filament\Resources\Members\Tables;

use App\Filament\Traits\HasMemberTableColumns;
use App\Filament\Traits\HasMemberDeletionAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class ConsolidatorMembersTable
{
    use HasMemberTableColumns;
    use HasMemberDeletionAction;
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                self::makeFirstNameColumn(),
                self::makeLastNameColumn(),
                self::makeStatusColumn(),
                self::makeG12LeaderColumn(),
                self::makeCreatedAtColumn(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                self::makeMemberDeleteAction('Consolidator Member'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    self::makeMemberBulkDeleteAction('Consolidator Members'),
                ]),
            ])
            ->defaultSort('last_name', 'asc');
    }
}