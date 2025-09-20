<?php

namespace App\Filament\Resources\SundayServices;

use App\Filament\Resources\SundayServices\Pages\CreateSundayService;
use App\Filament\Resources\SundayServices\Pages\EditSundayService;
use App\Filament\Resources\SundayServices\Pages\ListSundayServices;
use App\Filament\Resources\SundayServices\Schemas\SundayServiceForm;
use App\Filament\Resources\SundayServices\Tables\SundayServicesTable;
use App\Models\SundayService;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SundayServiceResource extends Resource
{
    protected static ?string $model = SundayService::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return SundayServiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SundayServicesTable::configure($table);
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
            'index' => ListSundayServices::route('/'),
            'create' => CreateSundayService::route('/create'),
            'edit' => EditSundayService::route('/{record}/edit'),
        ];
    }
}
