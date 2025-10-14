<?php

namespace App\Traits;

use App\Services\MemberCompletionService;

trait HasMemberQualifications
{
    /**
     * Check if this member is qualified for Life Class
     * Uses MemberCompletionService for the logic
     */
    public function isQualifiedForLifeClass(): bool
    {
        return MemberCompletionService::isQualifiedForLifeClass($this);
    }

    /**
     * Get completion progress for this member
     */
    public function getCompletionProgress(): array
    {
        return MemberCompletionService::getCompletionProgress($this);
    }

    /**
     * Check if a member with the same name exists
     * This is useful for validation before creating new members
     */
    public static function nameExists($firstName, $lastName, $excludeId = null): bool
    {
        $query = static::where('first_name', $firstName)
                      ->where('last_name', $lastName);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }
}
