<?php

namespace App\Filament\Resources\Sol3\Pages;

use App\Filament\Resources\Sol3\Sol3CandidateResource;
use App\Filament\Traits\ClearsNavigationBadgeCache;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSol3Candidate extends EditRecord
{
    use ClearsNavigationBadgeCache;
    
    protected static string $resource = Sol3CandidateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->after(fn() => $this->clearResourceNavigationBadge()),
        ];
    }
}
