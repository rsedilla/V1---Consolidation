<?php

namespace App\Filament\Resources\StartUpYourNewLives\Pages;

use App\Filament\Resources\StartUpYourNewLives\StartUpYourNewLifeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStartUpYourNewLives extends ListRecords
{
    protected static string $resource = StartUpYourNewLifeResource::class;

    protected static ?string $title = 'Start Up Your New Life List';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
