<?php

namespace App\Filament\Resources\StartUpYourNewLives\Pages;

use App\Filament\Resources\StartUpYourNewLives\StartUpYourNewLifeResource;
use App\Filament\Traits\ClearsNavigationBadgeCache;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStartUpYourNewLife extends EditRecord
{
    use ClearsNavigationBadgeCache;
    
    protected static string $resource = StartUpYourNewLifeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            $this->makeDeleteActionWithBadgeClear(DeleteAction::make()),
        ];
    }
}
