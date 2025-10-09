<?php

namespace App\Filament\Resources\LifeclassCandidates\Pages;

use App\Filament\Resources\LifeclassCandidates\LifeclassCandidateResource;
use App\Filament\Traits\ClearsNavigationBadgeCache;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLifeclassCandidate extends EditRecord
{
    use ClearsNavigationBadgeCache;
    
    protected static string $resource = LifeclassCandidateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            $this->makeDeleteActionWithBadgeClear(DeleteAction::make()),
        ];
    }
}
