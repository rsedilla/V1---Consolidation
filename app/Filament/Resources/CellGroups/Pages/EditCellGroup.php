<?php

namespace App\Filament\Resources\CellGroups\Pages;

use App\Filament\Resources\CellGroups\CellGroupResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditCellGroup extends EditRecord
{
    protected static string $resource = CellGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->after(function () {
                    // Clear navigation badge cache after deleting record
                    $userId = Auth::id();
                    CellGroupResource::clearNavigationBadgeCache($userId);
                }),
        ];
    }

    protected function afterSave(): void
    {
        // Clear navigation badge cache after saving changes
        $userId = Auth::id();
        CellGroupResource::clearNavigationBadgeCache($userId);
    }
}
