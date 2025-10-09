<?php

namespace App\Filament\Resources\StartUpYourNewLives\Pages;

use App\Filament\Resources\StartUpYourNewLives\StartUpYourNewLifeResource;
use App\Filament\Traits\ClearsNavigationBadgeCache;
use Filament\Resources\Pages\CreateRecord;

class CreateStartUpYourNewLife extends CreateRecord
{
    use ClearsNavigationBadgeCache;
    
    protected static string $resource = StartUpYourNewLifeResource::class;

    protected static ?string $title = 'New Start Up Your New Life';
}
