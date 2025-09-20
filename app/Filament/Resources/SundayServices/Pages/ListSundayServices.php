<?php

namespace App\Filament\Resources\SundayServices\Pages;

use App\Filament\Resources\SundayServices\SundayServiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSundayServices extends ListRecords
{
    protected static string $resource = SundayServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
