<?php

namespace App\Filament\Traits;

use App\Models\SolProfile;
use App\Models\Sol2Candidate;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

/**
 * Trait HasSol2Promotion
 * 
 * Simplified trait for SOL 1 → SOL 2 promotions only.
 * Handles data transfer, validation, and notifications.
 */
trait HasSol2Promotion
{
    /**
     * Create the "Promote to SOL 2" action button
     */
    protected static function makeSol2PromotionAction(): Action
    {
        return Action::make('promote_to_sol2')
            ->label('Move to SOL 2')
            ->icon('heroicon-o-academic-cap')
            ->color('success')
            ->visible(fn($record) => $record->isCompleted() && !$record->isPromotedToSol2())
            ->action(fn($record) => self::promoteMemberToSol2($record));
    }

    /**
     * Perform the promotion with transaction safety
     */
    protected static function promoteMemberToSol2($sol1Candidate): void
    {
        try {
            DB::beginTransaction();
            
            $solProfile = $sol1Candidate->solProfile;
            
            if (!$solProfile) {
                self::notifyError('SOL Profile not found');
                DB::rollBack();
                return;
            }

            // Check if already promoted
            if (self::isAlreadyInSol2($solProfile->id)) {
                self::notifyAlreadyPromoted($solProfile);
                DB::rollBack();
                return;
            }

            // Update SOL Profile level and create Sol2Candidate
            self::updateSolProfileLevel($solProfile);
            self::createSol2Candidate($solProfile, $sol1Candidate);
            self::graduateSol1Candidate($sol1Candidate);
            
            DB::commit();
            self::notifySuccess($solProfile);
            
        } catch (\Exception $e) {
            DB::rollBack();
            self::notifyError($e->getMessage());
        }
    }

    /**
     * Check if SOL Profile already has SOL 2 candidate record
     */
    protected static function isAlreadyInSol2(int $solProfileId): bool
    {
        return Sol2Candidate::where('sol_profile_id', $solProfileId)->exists();
    }

    /**
     * Update SOL Profile to level 2
     */
    protected static function updateSolProfileLevel(SolProfile $solProfile): void
    {
        $solProfile->update([
            'current_sol_level_id' => 2,
            'notes' => ($solProfile->notes ? $solProfile->notes . "\n" : '') . 
                       "Promoted to SOL 2 on " . now()->format('Y-m-d'),
        ]);
    }

    /**
     * Create Sol2Candidate for lesson tracking
     */
    protected static function createSol2Candidate(SolProfile $solProfile, $sol1Candidate): void
    {
        Sol2Candidate::create([
            'sol_profile_id' => $solProfile->id,
            'enrollment_date' => now(),
            'notes' => "Promoted from SOL 1 (completed all 10 lessons)",
        ]);
    }

    /**
     * Mark Sol1Candidate as graduated
     */
    protected static function graduateSol1Candidate($sol1Candidate): void
    {
        $sol1Candidate->update([
            'graduation_date' => now(),
        ]);
    }

    /**
     * Get status badge for SOL 1 table
     */
    protected static function getSol2Status($record): array
    {
        if ($record->isPromotedToSol2()) {
            return ['label' => '✓ In SOL 2', 'color' => 'info'];
        }
        
        if ($record->isCompleted()) {
            return ['label' => 'Ready', 'color' => 'success'];
        }
        
        return [
            'label' => $record->getCompletionCount() . '/10',
            'color' => 'warning'
        ];
    }

    /**
     * Success notification
     */
    protected static function notifySuccess($solProfile): void
    {
        $fullName = trim("{$solProfile->first_name} {$solProfile->last_name}");
        
        Notification::make()
            ->success()
            ->title('Successfully Promoted!')
            ->body("✓ {$fullName} has been promoted to SOL 2. You can now view them in SOL 2 Progress.")
            ->send();
    }

    /**
     * Already promoted notification
     */
    protected static function notifyAlreadyPromoted($solProfile): void
    {
        $fullName = trim("{$solProfile->first_name} {$solProfile->last_name}");
        
        Notification::make()
            ->warning()
            ->title('Already Promoted')
            ->body("{$fullName} is already in SOL 2.")
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

