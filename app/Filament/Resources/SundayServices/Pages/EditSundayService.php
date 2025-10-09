<?php

namespace App\Filament\Resources\SundayServices\Pages;

use App\Filament\Resources\SundayServices\SundayServiceResource;
use App\Filament\Traits\ClearsNavigationBadgeCache;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSundayService extends EditRecord
{
    use ClearsNavigationBadgeCache;
    
    protected static string $resource = SundayServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            $this->makeDeleteActionWithBadgeClear(DeleteAction::make()),
        ];
    }
}
