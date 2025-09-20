<?php

namespace App\Filament\Resources\SundayServices\Pages;

use App\Filament\Resources\SundayServices\SundayServiceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSundayService extends EditRecord
{
    protected static string $resource = SundayServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
