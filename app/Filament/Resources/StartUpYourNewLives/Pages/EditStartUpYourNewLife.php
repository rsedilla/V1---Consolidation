<?php

namespace App\Filament\Resources\StartUpYourNewLives\Pages;

use App\Filament\Resources\StartUpYourNewLives\StartUpYourNewLifeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStartUpYourNewLife extends EditRecord
{
    protected static string $resource = StartUpYourNewLifeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
