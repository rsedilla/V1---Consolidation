<?php

namespace App\Filament\Resources\SolProfiles\Pages;

use App\Filament\Resources\SolProfiles\SolProfileResource;
use App\Filament\Traits\ClearsNavigationBadgeCache;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSolProfile extends EditRecord
{
    use ClearsNavigationBadgeCache;
    
    protected static string $resource = SolProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->after(fn() => $this->clearResourceNavigationBadge()),
        ];
    }
}
