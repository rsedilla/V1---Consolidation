<?php

namespace App\Filament\Resources\LifeclassCandidates\Pages;

use App\Filament\Resources\LifeclassCandidates\LifeclassCandidateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLifeclassCandidate extends EditRecord
{
    protected static string $resource = LifeclassCandidateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
