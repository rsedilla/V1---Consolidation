<?php

namespace App\Filament\Resources\LifeclassCandidates\Pages;

use App\Filament\Resources\LifeclassCandidates\LifeclassCandidateResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateLifeclassCandidate extends CreateRecord
{
    protected static string $resource = LifeclassCandidateResource::class;

    protected function afterCreate(): void
    {
        // Clear navigation badge cache after creating new record
        $userId = Auth::id();
        LifeclassCandidateResource::clearNavigationBadgeCache($userId);
    }
}
