<?php

namespace App\Filament\Resources\Members\ConsolidatorMemberResource\Pages;

use App\Filament\Resources\Members\ConsolidatorMemberResource;
use App\Filament\Traits\HandlesDatabaseErrors;
use App\Services\MemberValidationService;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditConsolidatorMember extends EditRecord
{
    use HandlesDatabaseErrors;
    
    protected static string $resource = ConsolidatorMemberResource::class;

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
        }
        
        return $data;
    }
}