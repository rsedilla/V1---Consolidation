<?php

namespace App\Filament\Resources\StartUpYourNewLives\Pages;

use App\Filament\Resources\StartUpYourNewLives\StartUpYourNewLifeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStartUpYourNewLife extends CreateRecord
{
    protected static string $resource = StartUpYourNewLifeResource::class;

    protected static ?string $title = 'New Start Up Your New Life';
}
