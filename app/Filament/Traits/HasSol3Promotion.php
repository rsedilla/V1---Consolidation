<?php

namespace App\Filament\Traits;

use App\Models\SolProfile;
use App\Models\Sol3Candidate;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

/**
 * Trait HasSol3Promotion
 *
 * Simplified trait for SOL 2 → SOL 3 promotions.
 * Handles data transfer, validation, and notifications.
 */
trait HasSol3Promotion
{
    /**
     * Create the "Promote to SOL 3" action button
     */
    protected static function makeSol3PromotionAction(): Action
    {
        return Action::make('promote_to_sol3')
            ->label('Move to SOL 3')
            ->icon('heroicon-o-academic-cap')
            ->color('success')
            ->visible(fn($record) => $record->isCompleted() && !$record->isPromotedToSol3())
            ->action(fn($record) => self::promoteMemberToSol3($record));
    }

    /**
     * Perform the promotion with transaction safety
     */
    protected static function promoteMemberToSol3($sol2Candidate): void
    {
        try {
            DB::beginTransaction();
            
            $solProfile = $sol2Candidate->solProfile;
            
            if (!$solProfile) {
                self::notifyError('SOL Profile not found');
                DB::rollBack();
                return;
            }

            // Check if already promoted
            if (self::isAlreadyInSol3($solProfile->id)) {
                self::notifyAlreadyPromoted($solProfile);
                DB::rollBack();
                return;
            }

            // Update SOL Profile level and create Sol3Candidate
            self::updateSolProfileLevel($solProfile);
            self::createSol3Candidate($solProfile, $sol2Candidate);
            self::graduateSol2Candidate($sol2Candidate);
            
            DB::commit();
            self::notifySuccess($solProfile);
            
        } catch (\Exception $e) {
            DB::rollBack();
            self::notifyError($e->getMessage());
        }
    }

    /**
     * Check if SOL Profile already has SOL 3 candidate record
     */
    protected static function isAlreadyInSol3(int $solProfileId): bool
    {
        return Sol3Candidate::where('sol_profile_id', $solProfileId)->exists();
    }

    /**
     * Update SOL Profile to level 3
     */
    protected static function updateSolProfileLevel(SolProfile $solProfile): void
    {
        $solProfile->update([
            'current_sol_level_id' => 3,
            'notes' => ($solProfile->notes ? $solProfile->notes . "\n" : '') . 
                       "Promoted to SOL 3 on " . now()->format('Y-m-d'),
        ]);
    }

    /**
     * Create Sol3Candidate for lesson tracking
     */
    protected static function createSol3Candidate(SolProfile $solProfile, $sol2Candidate): void
    {
        Sol3Candidate::create([
            'sol_profile_id' => $solProfile->id,
            'enrollment_date' => now(),
            'notes' => "Promoted from SOL 2 (completed all 10 lessons)",
        ]);
    }

    /**
     * Mark Sol2Candidate as graduated
     */
    protected static function graduateSol2Candidate($sol2Candidate): void
    {
        $sol2Candidate->update([
            'graduation_date' => now(),
        ]);
    }

    /**
     * Get status badge for SOL 2 table
     */
    protected static function getSol3Status($record): array
    {
        if ($record->isPromotedToSol3()) {
            return ['label' => '✓ In SOL 3', 'color' => 'info'];
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
            ->body("✓ {$fullName} has been promoted to SOL 3. You can now view them in SOL 3 Progress.")
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
            ->body("{$solProfile} is already in SOL 3.")
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
