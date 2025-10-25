<?php

namespace App\Filament\Resources\LifeclassCandidates\Pages;

use App\Filament\Resources\LifeclassCandidates\LifeclassCandidateResource;
use App\Filament\Traits\ClearsNavigationBadgeCache;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditLifeclassCandidate extends EditRecord
{
    use ClearsNavigationBadgeCache;
    
    protected static string $resource = LifeclassCandidateResource::class;

    protected function getHeaderActions(): array
    {
        $user = Auth::user();
        $canEdit = $user instanceof User && ($user->isAdmin() || $user->isEquipping());
        
        return [
            $this->makeDeleteActionWithBadgeClear(
                DeleteAction::make()->disabled(!$canEdit)
            ),
        ];
    }
    
    /**
     * Get form actions with disabled state for Leaders
     */
    protected function getFormActions(): array
    {
        $user = Auth::user();
        $canEdit = $user instanceof User && ($user->isAdmin() || $user->isEquipping());
        
        return [
            $this->getSaveFormAction()->disabled(!$canEdit),
            $this->getCancelFormAction()->disabled(!$canEdit),
        ];
    }
}
