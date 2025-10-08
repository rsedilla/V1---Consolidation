<?php

namespace App\Filament\Resources\Members\VipMemberResource\Pages;

use App\Filament\Resources\Members\VipMemberResource;
use App\Filament\Traits\HandlesDatabaseErrors;
use App\Services\MemberValidationService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateVipMember extends CreateRecord
{
    use HandlesDatabaseErrors;
    
    protected static string $resource = VipMemberResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
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
}