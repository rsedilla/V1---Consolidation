<?php

namespace App\Filament\Traits;

use App\Models\SolProfile;
use App\Models\Sol1Candidate;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

/**
 * Trait HasSol1Promotion
 * 
 * Simplified trait for Life Class → SOL 1 promotions only.
 * Handles data transfer, validation, and notifications.
 */
trait HasSol1Promotion
{
    /**
     * Create the "Promote to SOL 1" action button
     */
    protected static function makeSol1PromotionAction(): Action
    {
        return Action::make('promote_to_sol1')
            ->label('Move to SOL 1')
            ->icon('heroicon-o-academic-cap')
            ->color('success')
            ->visible(fn($record) => $record->isCompleted() && !$record->isPromotedToSol1())
            ->action(fn($record) => self::promoteMemberToSol1($record));
    }

    /**
     * Perform the promotion with transaction safety
     */
    protected static function promoteMemberToSol1($lifeclassCandidate): void
    {
        try {
            DB::beginTransaction();
            
            $member = $lifeclassCandidate->member;
            
            if (!$member) {
                self::notifyError('Member not found');
                DB::rollBack();
                return;
            }

            // Check if already promoted
            if (self::isAlreadyInSol1($member->id)) {
                self::notifyAlreadyPromoted($member);
                DB::rollBack();
                return;
            }

            // Create SOL Profile and Sol1Candidate
            $solProfile = self::createSolProfile($member);
            self::createSol1Candidate($solProfile);
            
            DB::commit();
            self::notifySuccess($member);
            
        } catch (\Exception $e) {
            DB::rollBack();
            self::notifyError($e->getMessage());
        }
    }

    /**
     * Check if member already has SOL 1 profile
     */
    protected static function isAlreadyInSol1(int $memberId): bool
    {
        return SolProfile::where('member_id', $memberId)
            ->where('current_sol_level_id', 1)
            ->exists();
    }

    /**
     * Create SOL Profile from Member data
     */
    protected static function createSolProfile($member): SolProfile
    {
        return SolProfile::create([
            'first_name' => $member->first_name,
            'middle_name' => $member->middle_name,
            'last_name' => $member->last_name,
            'birthday' => $member->birthday,
            'wedding_anniversary_date' => $member->wedding_anniversary_date,
            'email' => $member->email,
            'phone' => $member->phone,
            'address' => $member->address,
            'status_id' => $member->status_id,
            'g12_leader_id' => $member->g12_leader_id, // Preserves RBAC hierarchy
            'current_sol_level_id' => 1,
            'is_cell_leader' => false,
            'member_id' => $member->id,
            'notes' => "Promoted from Life Class on " . now()->format('Y-m-d'),
        ]);
    }

    /**
     * Create Sol1Candidate for lesson tracking
     */
    protected static function createSol1Candidate(SolProfile $solProfile): void
    {
        Sol1Candidate::create([
            'sol_profile_id' => $solProfile->id,
            'enrollment_date' => now(),
            'notes' => "Promoted from Life Class (completed all 9 lessons)",
        ]);
    }

    /**
     * Get status badge for Life Class table
     */
    protected static function getSol1Status($record): array
    {
        if ($record->isPromotedToSol1()) {
            return ['label' => '✓ In SOL 1', 'color' => 'info'];
        }
        
        if ($record->isCompleted()) {
            return ['label' => 'Ready', 'color' => 'success'];
        }
        
        return [
            'label' => $record->getCompletionCount() . '/9',
            'color' => 'warning'
        ];
    }

    /**
     * Success notification
     */
    protected static function notifySuccess($member): void
    {
        $fullName = trim("{$member->first_name} {$member->last_name}");
        
        Notification::make()
            ->success()
            ->title('Successfully Promoted!')
            ->body("✓ {$fullName} has been promoted to SOL 1. You can now view them in SOL 1 Progress.")
            ->send();
    }

    /**
     * Already promoted notification
     */
    protected static function notifyAlreadyPromoted($member): void
    {
        $fullName = trim("{$member->first_name} {$member->last_name}");
        
        Notification::make()
            ->warning()
            ->title('Already Promoted')
            ->body("{$fullName} is already in SOL 1.")
            ->send();
    }

    /**
     * Error notification
     */
    protected static function notifyError(string $message): void
    {
        Notification::make()
            ->danger()
            ->title('Promotion Failed')
            ->body("An error occurred: {$message}")
            ->send();
    }
}

