<?php

namespace App\Filament\Resources\Members\VipMemberResource\Pages;

use App\Filament\Resources\Members\VipMemberResource;
use App\Services\MemberValidationService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Database\QueryException;

class CreateVipMember extends CreateRecord
{
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

    /**
     * Handle database exceptions gracefully
     */
    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        try {
            return parent::handleRecordCreation($data);
        } catch (UniqueConstraintViolationException|QueryException $exception) {
            $this->handleDatabaseConstraintViolation($exception);
            throw $exception; // This won't be reached
        }
    }

    /**
     * Convert database constraint violations to field-level validation errors
     */
    private function handleDatabaseConstraintViolation($exception): void
    {
        $message = $exception->getMessage();
        $fieldErrors = [];

        if (str_contains($message, 'members_email_unique')) {
            $fieldErrors['email'] = 'This email address is already in use.';
        } 
        
        if (str_contains($message, 'members_name_unique') || 
            (str_contains($message, 'Duplicate entry') && 
            (str_contains($message, 'first_name') || str_contains($message, 'last_name')))) {
            $fieldErrors['first_name'] = 'A member with this name already exists.';
            $fieldErrors['last_name'] = 'A member with this name already exists.';
        }
        
        // If we can't identify the specific field, show general error
        if (empty($fieldErrors)) {
            $fieldErrors['email'] = 'This member already exists in the system.';
        }
        
        throw ValidationException::withMessages($fieldErrors);
    }
}