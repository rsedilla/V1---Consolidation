<?php

namespace App\Filament\Resources\StartUpYourNewLives\Pages;

use App\Filament\Resources\StartUpYourNewLives\StartUpYourNewLifeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditStartUpYourNewLife extends EditRecord
{
    protected static string $resource = StartUpYourNewLifeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->after(function () {
                    // Clear navigation badge cache after deleting record
                    $userId = Auth::id();
                    StartUpYourNewLifeResource::clearNavigationBadgeCache($userId);
                }),
        ];
    }

    protected function afterSave(): void
    {
        // Clear navigation badge cache after saving changes
        $userId = Auth::id();
        StartUpYourNewLifeResource::clearNavigationBadgeCache($userId);
    }
}
