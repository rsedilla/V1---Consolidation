<?php

namespace App\Filament\Resources\SolProfiles\Pages;

use App\Filament\Resources\SolProfiles\SolProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSolProfile extends EditRecord
{
    protected static string $resource = SolProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
