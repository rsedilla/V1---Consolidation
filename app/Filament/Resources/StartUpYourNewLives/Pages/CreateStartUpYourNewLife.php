<?php

namespace App\Filament\Resources\StartUpYourNewLives\Pages;

use App\Filament\Resources\StartUpYourNewLives\StartUpYourNewLifeResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateStartUpYourNewLife extends CreateRecord
{
    protected static string $resource = StartUpYourNewLifeResource::class;

    protected static ?string $title = 'New Start Up Your New Life';

    protected function afterCreate(): void
    {
        // Clear navigation badge cache after creating new record
        $userId = Auth::id();
        StartUpYourNewLifeResource::clearNavigationBadgeCache($userId);
    }
}
