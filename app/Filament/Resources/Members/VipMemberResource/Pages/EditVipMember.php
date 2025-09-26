<?php

namespace App\Filament\Resources\Members\VipMemberResource\Pages;

use App\Filament\Resources\Members\VipMemberResource;
use App\Services\MemberValidationService;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Database\QueryException;

class EditVipMember extends EditRecord
{
    protected static string $resource = VipMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
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

    /**
     * Handle database exceptions gracefully
     */
    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        try {
            return parent::handleRecordUpdate($record, $data);
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