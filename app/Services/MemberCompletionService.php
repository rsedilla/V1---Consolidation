<?php

namespace App\Services;

use App\Models\Member;

class MemberCompletionService
{
    /**
     * Check if a VIP member has completed all requirements for Life Class
     * Requirements: 10/10 New Life Training + 4/4 Sunday Services + 4/4 Cell Groups
     */
    public static function isQualifiedForLifeClass(Member $member): bool
    {
        // Must be VIP first
        if (!$member->memberType || $member->memberType->name !== 'VIP') {
            return false;
        }

        return self::hasCompletedNewLifeTraining($member) && 
               self::hasCompletedSundayServices($member) && 
               self::hasCompletedCellGroups($member);
    }

    /**
     * Check if member completed all 10 New Life Training lessons
     */
    public static function hasCompletedNewLifeTraining(Member $member): bool
    {
        $newLifeRecord = $member->startUpYourNewLife()->first();
        
        if (!$newLifeRecord) {
            return false;
        }

        // Check at least 4 lessons are completed
        $completed = 0;
        for ($i = 1; $i <= 10; $i++) {
            if ($newLifeRecord->{"lesson_{$i}_completion_date"}) {
                $completed++;
            }
        }
        return $completed >= 4;
    }

    /**
     * Check if member completed all 4 Sunday Services
     */
    public static function hasCompletedSundayServices(Member $member): bool
    {
        $sundayServiceRecord = $member->sundayServices()->first();
        
        if (!$sundayServiceRecord) {
            return false;
        }

        // Check all 4 Sunday Services are completed
        for ($i = 1; $i <= 4; $i++) {
            if (!$sundayServiceRecord->{"sunday_service_{$i}_date"}) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if member completed all 4 Cell Groups
     */
    public static function hasCompletedCellGroups(Member $member): bool
    {
        $cellGroupRecord = $member->cellGroups()->first();
        
        if (!$cellGroupRecord) {
            return false;
        }

        // Check all 4 Cell Groups are completed
        for ($i = 1; $i <= 4; $i++) {
            if (!$cellGroupRecord->{"cell_group_{$i}_date"}) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get completion progress for a member
     * Returns array with completion counts for each module
     */
    public static function getCompletionProgress(Member $member): array
    {
        $progress = [
            'new_life_training' => 0,
            'sunday_services' => 0,
            'cell_groups' => 0,
            'total_completed' => 0,
            'is_qualified' => false
        ];

        // Count New Life Training completions
        $newLifeRecord = $member->startUpYourNewLife()->first();
        if ($newLifeRecord) {
            for ($i = 1; $i <= 10; $i++) {
                if ($newLifeRecord->{"lesson_{$i}_completion_date"}) {
                    $progress['new_life_training']++;
                }
            }
        }

        // Count Sunday Services completions
        $sundayServiceRecord = $member->sundayServices()->first();
        if ($sundayServiceRecord) {
            for ($i = 1; $i <= 4; $i++) {
                if ($sundayServiceRecord->{"sunday_service_{$i}_date"}) {
                    $progress['sunday_services']++;
                }
            }
        }

        // Count Cell Groups completions
        $cellGroupRecord = $member->cellGroups()->first();
        if ($cellGroupRecord) {
            for ($i = 1; $i <= 4; $i++) {
                if ($cellGroupRecord->{"cell_group_{$i}_date"}) {
                    $progress['cell_groups']++;
                }
            }
        }

        $progress['total_completed'] = $progress['new_life_training'] + $progress['sunday_services'] + $progress['cell_groups'];
        $progress['is_qualified'] = self::isQualifiedForLifeClass($member);

        return $progress;
    }

    /**
     * Get all VIP members who are qualified for Life Class
     * Excludes members already enrolled in Life Class or promoted to SOL 1+
     */
    public static function getQualifiedVipMembers()
    {
        return Member::vips()
            ->with(['memberType', 'startUpYourNewLife', 'sundayServices', 'cellGroups'])
            ->whereDoesntHave('lifeclassCandidates') // Not already in Life Class
            ->whereDoesntHave('solProfiles', function ($q) { // Not promoted to SOL 1 or higher
                $q->where('current_sol_level_id', '>=', 1);
            })
            ->get()
            ->filter(function ($member) {
                return self::isQualifiedForLifeClass($member);
            });
    }
}