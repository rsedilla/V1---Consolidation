<?php

namespace App\Filament\Resources\LifeclassCandidates;

use App\Filament\Resources\LifeclassCandidates\Pages\CreateLifeclassCandidate;
use App\Filament\Resources\LifeclassCandidates\Pages\EditLifeclassCandidate;
use App\Filament\Resources\LifeclassCandidates\Pages\ListLifeclassCandidates;
use App\Filament\Resources\LifeclassCandidates\Schemas\LifeclassCandidateForm;
use App\Filament\Resources\LifeclassCandidates\Tables\LifeclassCandidatesTable;
use App\Models\LifeclassCandidate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LifeclassCandidateResource extends Resource
{
    protected static ?string $model = LifeclassCandidate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return LifeclassCandidateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LifeclassCandidatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLifeclassCandidates::route('/'),
            'create' => CreateLifeclassCandidate::route('/create'),
            'edit' => EditLifeclassCandidate::route('/{record}/edit'),
        ];
    }
}
