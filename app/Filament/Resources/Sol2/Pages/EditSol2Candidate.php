<?php

namespace App\Filament\Resources\Sol2\Pages;

use App\Filament\Resources\Sol2\Sol2CandidateResource;
use App\Filament\Traits\ClearsNavigationBadgeCache;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSol2Candidate extends EditRecord
{
    use ClearsNavigationBadgeCache;
    
    protected static string $resource = Sol2CandidateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->after(fn() => $this->clearResourceNavigationBadge()),
        ];
    }
}
