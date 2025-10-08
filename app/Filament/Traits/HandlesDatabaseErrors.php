<?php

namespace App\Filament\Traits;

use Illuminate\Validation\ValidationException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Database\QueryException;

/**
 * Trait for handling database constraint violations
 * Converts database errors into user-friendly field-level validation errors
 */
trait HandlesDatabaseErrors
{
    /**
     * Convert database constraint violations to field-level validation errors
     * 
     * @param \Exception $exception
     * @return void
     * @throws ValidationException
     */
    protected function handleDatabaseConstraintViolation($exception): void
    {
        $message = $exception->getMessage();
        $fieldErrors = [];

        // Handle email unique constraint
        if (str_contains($message, 'members_email_unique') || 
            (str_contains($message, 'Duplicate entry') && str_contains($message, 'email'))) {
            $fieldErrors['email'] = 'This email address is already in use.';
        }
        
        // Handle name unique constraint
        if (str_contains($message, 'members_name_unique') || 
            (str_contains($message, 'Duplicate entry') && 
            (str_contains($message, 'first_name') || str_contains($message, 'last_name')))) {
            $fieldErrors['first_name'] = 'A member with this name already exists.';
            $fieldErrors['last_name'] = 'A member with this name already exists.';
        }
        
        // Handle phone unique constraint
        if (str_contains($message, 'members_phone_unique') || 
            (str_contains($message, 'Duplicate entry') && str_contains($message, 'phone'))) {
            $fieldErrors['phone'] = 'This phone number is already in use.';
        }
        
        // If we can't identify the specific field, show general error
        if (empty($fieldErrors)) {
            $fieldErrors['email'] = 'This member already exists in the system. Please check for duplicates.';
        }
        
        throw ValidationException::withMessages($fieldErrors);
    }

    /**
     * Wrap record creation with database error handling
     * 
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        try {
            return parent::handleRecordCreation($data);
        } catch (UniqueConstraintViolationException|QueryException $exception) {
            $this->handleDatabaseConstraintViolation($exception);
            throw $exception; // This line won't be reached due to validation exception above
        }
    }

    /**
     * Wrap record update with database error handling
     * 
     * @param \Illuminate\Database\Eloquent\Model $record
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        try {
            return parent::handleRecordUpdate($record, $data);
        } catch (UniqueConstraintViolationException|QueryException $exception) {
            $this->handleDatabaseConstraintViolation($exception);
            throw $exception; // This line won't be reached due to validation exception above
        }
    }
}
