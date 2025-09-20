<?php

namespace App\Filament\Resources\LifeclassCandidates\Pages;

use App\Filament\Resources\LifeclassCandidates\LifeclassCandidateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLifeclassCandidates extends ListRecords
{
    protected static string $resource = LifeclassCandidateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
