<?php

namespace App\Filament\Resources\Sol1\Pages;

use App\Filament\Resources\Sol1\Sol1CandidateResource;
use App\Filament\Traits\ClearsNavigationBadgeCache;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditSol1Candidate extends EditRecord
{
    use ClearsNavigationBadgeCache;
    
    protected static string $resource = Sol1CandidateResource::class;

    protected function getHeaderActions(): array
    {
        $user = Auth::user();
        $canEdit = $user instanceof User && ($user->isAdmin() || $user->isEquipping());
        
        return [
            Actions\DeleteAction::make()
                ->after(fn() => $this->clearResourceNavigationBadge())
                ->disabled(!$canEdit),
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
