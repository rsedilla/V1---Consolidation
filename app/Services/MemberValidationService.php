<?php

namespace App\Services;

use App\Models\Member;
use App\Models\MemberType;

class MemberValidationService
{
    /**
     * Check if creating this member would violate any business rules
     * Returns array of validation errors
     */
    public static function validateMemberCreation(array $memberData): array
    {
        $errors = [];
        
        // Check for existing consolidator with same name or email
        $existingConsolidator = self::checkExistingConsolidator($memberData);
        if ($existingConsolidator) {
            $errors[] = [
                'field' => 'consolidator_duplicate',
                'type' => 'existing_consolidator',
                'existing_member' => $existingConsolidator
            ];
        }

        // Check for email uniqueness across all members
        if (!empty($memberData['email'])) {
            $existingMemberWithEmail = Member::where('email', $memberData['email'])->first();
            if ($existingMemberWithEmail) {
                $errors[] = [
                    'field' => 'email',
                    'type' => 'duplicate_email',
                    'existing_member' => $existingMemberWithEmail
                ];
            }
        }

        return $errors;
    }

    /**
     * Check if a consolidator with similar details already exists
     */
    private static function checkExistingConsolidator(array $memberData): ?Member
    {
        $consolidatorTypeId = MemberType::where('name', 'Consolidator')->first()?->id;
        
        if (!$consolidatorTypeId) {
            return null;
        }

        // Check by email first (most reliable)
        if (!empty($memberData['email'])) {
            $existingMember = Member::where('email', $memberData['email'])
                ->where('member_type_id', $consolidatorTypeId)
                ->with(['g12Leader'])
                ->first();
                
            if ($existingMember) {
                return $existingMember;
            }
        }

        // Check by name combination (fallback)
        if (!empty($memberData['first_name']) && !empty($memberData['last_name'])) {
            $existingMember = Member::where('first_name', trim($memberData['first_name']))
                ->where('last_name', trim($memberData['last_name']))
                ->where('member_type_id', $consolidatorTypeId)
                ->with(['g12Leader'])
                ->first();
                
            if ($existingMember) {
                return $existingMember;
            }
        }

        return null;
    }
}