<?php

namespace App\Filament\Resources\CellGroups\Pages;

use App\Filament\Resources\CellGroups\CellGroupResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateCellGroup extends CreateRecord
{
    protected static string $resource = CellGroupResource::class;

    protected function afterCreate(): void
    {
        // Clear navigation badge cache after creating new record
        $userId = Auth::id();
        CellGroupResource::clearNavigationBadgeCache($userId);
    }
}
