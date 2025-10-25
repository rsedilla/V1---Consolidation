<?php

namespace App\Filament\Resources\Members\VipMemberResource\Pages;

use App\Filament\Resources\Members\VipMemberResource;
use App\Filament\Traits\HandlesDatabaseErrors;
use App\Services\MemberValidationService;
use App\Livewire\StatsOverview;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class CreateVipMember extends CreateRecord
{
    use HandlesDatabaseErrors;
    
    protected static string $resource = VipMemberResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Auto-assign g12_leader_id for leaders if not provided
        $user = Auth::user();
        if ($user instanceof User && $user->isLeader() && $user->leaderRecord && empty($data['g12_leader_id'])) {
            $data['g12_leader_id'] = $user->leaderRecord->id;
        }
        
        // Simple validation for VIP members - just check for duplicates
        $validationErrors = MemberValidationService::validateMemberCreation($data);
        
        if (!empty($validationErrors)) {
            $fieldErrors = [];
            
            foreach ($validationErrors as $error) {
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
        
        return $data;
    }

    protected function afterCreate(): void
    {
        // Clear navigation badge cache for current user
        $userId = Auth::id();
        VipMemberResource::clearNavigationBadgeCache($userId);
        
        // Clear dashboard stats cache for current user
        StatsOverview::clearCache($userId);
    }
}