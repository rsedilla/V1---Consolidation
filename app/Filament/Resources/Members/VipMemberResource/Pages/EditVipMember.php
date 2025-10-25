<?php

namespace App\Filament\Resources\Members\VipMemberResource\Pages;

use App\Filament\Resources\Members\VipMemberResource;
use App\Filament\Traits\HandlesDatabaseErrors;
use App\Services\MemberValidationService;
use App\Livewire\StatsOverview;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class EditVipMember extends EditRecord
{
    use HandlesDatabaseErrors;
    
    protected static string $resource = VipMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
                ->after(function () {
                    // Clear caches after deletion
                    $userId = Auth::id();
                    VipMemberResource::clearNavigationBadgeCache($userId);
                    StatsOverview::clearCache($userId);
                }),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Auto-assign g12_leader_id for leaders if not provided
        $user = Auth::user();
        if ($user instanceof User && $user->isLeader() && $user->leaderRecord && empty($data['g12_leader_id'])) {
            $data['g12_leader_id'] = $user->leaderRecord->id;
        }
        
        // Only validate if critical fields have changed
        $currentRecord = $this->getRecord();
        $needsValidation = false;
        
        // Check if email changed
        if (isset($data['email']) && $data['email'] !== $currentRecord->email) {
            $needsValidation = true;
        }
        
        // Check if name changed
        if ((isset($data['first_name']) && $data['first_name'] !== $currentRecord->first_name) ||
            (isset($data['last_name']) && $data['last_name'] !== $currentRecord->last_name)) {
            $needsValidation = true;
        }
        
        if ($needsValidation) {
            $validationErrors = MemberValidationService::validateMemberCreation($data);
            
            if (!empty($validationErrors)) {
                $fieldErrors = [];
                
                foreach ($validationErrors as $error) {
                    // Skip validation if the existing member is the same record being edited
                    if (isset($error['existing_member']) && 
                        $error['existing_member']->id === $currentRecord->id) {
                        continue;
                    }
                    
                    if ($error['type'] === 'existing_consolidator') {
                        $fieldErrors['first_name'] = 'A member with this name already exists as a consolidator.';
                        $fieldErrors['last_name'] = 'A member with this name already exists as a consolidator.';
                    }
                    
                    if ($error['type'] === 'duplicate_email') {
                        $fieldErrors['email'] = 'This email address is already in use by another member.';
                    }
                }
                
                if (!empty($fieldErrors)) {
                    throw ValidationException::withMessages($fieldErrors);
                }
            }
        }
        
        return $data;
    }

    protected function afterSave(): void
    {
        // Clear navigation badge cache for current user
        $userId = Auth::id();
        VipMemberResource::clearNavigationBadgeCache($userId);
        
        // Clear dashboard stats cache for current user
        StatsOverview::clearCache($userId);
    }
}