<?php

namespace App\Filament\Resources\SundayServices\Pages;

use App\Filament\Resources\SundayServices\SundayServiceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditSundayService extends EditRecord
{
    protected static string $resource = SundayServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->after(function () {
                    // Clear navigation badge cache after deleting record
                    $userId = Auth::id();
                    SundayServiceResource::clearNavigationBadgeCache($userId);
                }),
        ];
    }

    protected function afterSave(): void
    {
        // Clear navigation badge cache after saving changes
        $userId = Auth::id();
        SundayServiceResource::clearNavigationBadgeCache($userId);
    }
}
