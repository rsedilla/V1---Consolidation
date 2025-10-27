<?php

namespace App\Filament\Traits;

use App\Models\SolProfile;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

/**
 * Trait HasSolGradPromotion
 *
 * Handles SOL 3 → SOL Grad (Graduate) promotions.
 * Marks the student as graduated when they complete all SOL 3 lessons.
 */
trait HasSolGradPromotion
{
    /**
     * Create the "Move to SOL Grad" action button
     */
    protected static function makeSolGradPromotionAction(): Action
    {
        return Action::make('promote_to_sol_grad')
            ->label('Move to SOL Grad')
            ->icon('heroicon-o-academic-cap')
            ->color('success')
            ->visible(fn($record) => $record->isQualifiedForGraduation())
            ->action(fn($record) => self::promoteToSolGrad($record));
    }

    /**
     * Perform the graduation with transaction safety
     */
    protected static function promoteToSolGrad($sol3Candidate): void
    {
        try {
            DB::beginTransaction();
            
            $solProfile = $sol3Candidate->solProfile;
            
            if (!$solProfile) {
                self::notifyError('SOL Profile not found');
                DB::rollBack();
                return;
            }

            // Check if already graduated
            if ($solProfile->isGraduated()) {
                self::notifyAlreadyGraduated($solProfile);
                DB::rollBack();
                return;
            }

            // Update SOL Profile to Graduate level
            self::updateSolProfileToGrad($solProfile);
            self::graduateSol3Candidate($sol3Candidate);
            
            DB::commit();
            self::notifySuccess($solProfile);
            
        } catch (\Exception $e) {
            DB::rollBack();
            self::notifyError($e->getMessage());
        }
    }

    /**
     * Update SOL Profile to Graduate level (level 4)
     */
    protected static function updateSolProfileToGrad(SolProfile $solProfile): void
    {
        $solProfile->update([
            'current_sol_level_id' => 4, // SOL Grad
            'notes' => ($solProfile->notes ? $solProfile->notes . "\n" : '') . 
                       "Graduated from School of Leaders on " . now()->format('Y-m-d'),
        ]);
    }

    /**
     * Mark Sol3Candidate as graduated
     */
    protected static function graduateSol3Candidate($sol3Candidate): void
    {
        $sol3Candidate->update([
            'graduation_date' => now(),
        ]);
    }

    /**
     * Get status badge for SOL 3 table
     */
    protected static function getSolGradStatus($record): array
    {
        if ($record->solProfile && $record->solProfile->isGraduated()) {
            return ['label' => '✓ In SOL Grad', 'color' => 'info'];
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
            ->body("✓ {$fullName} has been promoted to SOL Grad. You can now view them in SOL Graduate.")
            ->send();
    }

    /**
     * Already graduated notification
     */
    protected static function notifyAlreadyGraduated($solProfile): void
    {
        $fullName = trim("{$solProfile->first_name} {$solProfile->last_name}");
        
        Notification::make()
            ->warning()
            ->title('Already Promoted')
            ->body("{$fullName} is already in SOL Grad.")
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
