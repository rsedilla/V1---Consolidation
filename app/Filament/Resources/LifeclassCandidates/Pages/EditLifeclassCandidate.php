<?php

namespace App\Filament\Resources\LifeclassCandidates\Pages;

use App\Filament\Resources\LifeclassCandidates\LifeclassCandidateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditLifeclassCandidate extends EditRecord
{
    protected static string $resource = LifeclassCandidateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->after(function () {
                    // Clear navigation badge cache after deleting record
                    $userId = Auth::id();
                    LifeclassCandidateResource::clearNavigationBadgeCache($userId);
                }),
        ];
    }

    protected function afterSave(): void
    {
        // Clear navigation badge cache after saving changes
        $userId = Auth::id();
        LifeclassCandidateResource::clearNavigationBadgeCache($userId);
    }
}
