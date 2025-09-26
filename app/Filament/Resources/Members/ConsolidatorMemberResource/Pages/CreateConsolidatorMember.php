<?php

namespace App\Filament\Resources\Members\ConsolidatorMemberResource\Pages;

use App\Filament\Resources\Members\ConsolidatorMemberResource;
use App\Services\MemberValidationService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Database\QueryException;

class CreateConsolidatorMember extends CreateRecord
{
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
            str_contains($message, 'Duplicate entry') && 
            (str_contains($message, 'first_name') || str_contains($message, 'last_name'))) {
            $fieldErrors['first_name'] = 'A consolidator with this name already exists.';
            $fieldErrors['last_name'] = 'A consolidator with this name already exists.';
        }
        
        // If we can't identify the specific field, show general error
        if (empty($fieldErrors)) {
            $fieldErrors['first_name'] = 'This consolidator member already exists in the system.';
        }
        
        throw ValidationException::withMessages($fieldErrors);
    }
}