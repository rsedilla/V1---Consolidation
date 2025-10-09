<?php

namespace App\Filament\Resources\SundayServices\Pages;

use App\Filament\Resources\SundayServices\SundayServiceResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateSundayService extends CreateRecord
{
    protected static string $resource = SundayServiceResource::class;

    protected function afterCreate(): void
    {
        // Clear navigation badge cache after creating new record
        $userId = Auth::id();
        SundayServiceResource::clearNavigationBadgeCache($userId);
    }
}
