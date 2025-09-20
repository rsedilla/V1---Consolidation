<?php

namespace App\Filament\Resources\StartUpYourNewLives;

use App\Filament\Resources\StartUpYourNewLives\Pages\CreateStartUpYourNewLife;
use App\Filament\Resources\StartUpYourNewLives\Pages\EditStartUpYourNewLife;
use App\Filament\Resources\StartUpYourNewLives\Pages\ListStartUpYourNewLives;
use App\Filament\Resources\StartUpYourNewLives\Schemas\StartUpYourNewLifeForm;
use App\Filament\Resources\StartUpYourNewLives\Tables\StartUpYourNewLivesTable;
use App\Models\StartUpYourNewLife;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StartUpYourNewLifeResource extends Resource
{
    protected static ?string $model = StartUpYourNewLife::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'New Life Training';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return StartUpYourNewLifeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StartUpYourNewLivesTable::configure($table);
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
            'index' => ListStartUpYourNewLives::route('/'),
            'create' => CreateStartUpYourNewLife::route('/create'),
            'edit' => EditStartUpYourNewLife::route('/{record}/edit'),
        ];
    }
}
