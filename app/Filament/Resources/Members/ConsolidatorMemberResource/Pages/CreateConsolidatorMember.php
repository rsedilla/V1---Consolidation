<?php

namespace App\Filament\Resources\Members\ConsolidatorMemberResource\Pages;

use App\Filament\Resources\Members\ConsolidatorMemberResource;
use App\Filament\Traits\HandlesDatabaseErrors;
use App\Services\MemberValidationService;
use App\Livewire\StatsOverview;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class CreateConsolidatorMember extends CreateRecord
{
    use HandlesDatabaseErrors;
    
    protected static string $resource = ConsolidatorMemberResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Validate for duplicates before attempting creation
        $validationErrors = MemberValidationService::validateMemberCreation($data);
        
        if (!empty($validationErrors)) {
            $fieldErrors = [];
            
            foreach ($validationErrors as $error) {
                if ($error['type'] === 'existing_consolidator') {
                    $existingMember = $error['existing_member'];
                    $leaderName = $existingMember->g12Leader?->name ?? 'Unknown Leader';
                    
                    $fieldErrors['first_name'] = "This consolidator already exists under {$leaderName}'s leadership.";
                    $fieldErrors['last_name'] = "This consolidator already exists under {$leaderName}'s leadership.";
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
        ConsolidatorMemberResource::clearNavigationBadgeCache($userId);
        
        // Clear dashboard stats cache for current user
        StatsOverview::clearCache($userId);
    }
}