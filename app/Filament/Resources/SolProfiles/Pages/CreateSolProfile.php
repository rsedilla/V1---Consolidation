<?php

namespace App\Filament\Resources\SolProfiles\Pages;

use App\Filament\Resources\SolProfiles\SolProfileResource;
use App\Filament\Traits\ClearsNavigationBadgeCache;
use App\Models\LifeclassCandidate;
use Filament\Resources\Pages\CreateRecord;

class CreateSolProfile extends CreateRecord
{
    use ClearsNavigationBadgeCache;
    
    protected static string $resource = SolProfileResource::class;
    
    /**
     * After creating a SOL Profile, automatically create a Life Class candidate
     * if the current_sol_level_id is 4 (Life Class, level_number = 0)
     */
    protected function afterCreate(): void
    {
        $solProfile = $this->record;
        
        // Get the Life Class level (level_number = 0)
        $lifeClassLevel = \App\Models\SolLevel::where('level_number', 0)->first();
        
        // Check if this SOL Profile is at Life Class level
        if ($lifeClassLevel && $solProfile->current_sol_level_id == $lifeClassLevel->id) {
            // Check if a Life Class candidate doesn't already exist for this SOL Profile
            $existingCandidate = LifeclassCandidate::where('sol_profile_id', $solProfile->id)->first();
            
            if (!$existingCandidate) {
                // Create a new Life Class candidate
                LifeclassCandidate::create([
                    'sol_profile_id' => $solProfile->id,
                    'member_id' => $solProfile->member_id, // Can be null
                    'notes' => 'Automatically created from SOL Profile',
                ]);
                
                // Send a notification
                \Filament\Notifications\Notification::make()
                    ->title('Life Class Progress Created')
                    ->body('A Life Class Progress record has been automatically created for this student.')
                    ->success()
                    ->send();
            }
        }
    }
}
