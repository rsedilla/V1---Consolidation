<?php

namespace App\Filament\Resources\Members\Tables;

use App\Filament\Traits\HasMemberTableColumns;
use App\Filament\Traits\HasMemberDeletionAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class VipMembersTable
{
    use HasMemberTableColumns;
    use HasMemberDeletionAction;
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                self::makeFirstNameColumn(),
                self::makeLastNameColumn(),
                self::makeConsolidationDateColumn(),
                self::makeG12LeaderColumn(),
                self::makeConsolidatorColumn(),
                self::makeVipStatusColumn(),
                self::makeCreatedAtColumn(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                self::makeMemberDeleteAction('VIP Member'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    self::makeMemberBulkDeleteAction('VIP Members'),
                ]),
            ])
            ->defaultSort('last_name', 'asc');
    }
}
