<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Get the Life Class level ID (level_number = 0)
        $lifeClassLevel = DB::table('sol_levels')->where('level_number', 0)->first();
        
        if (!$lifeClassLevel) {
            return;
        }
        
        // Get all SOL Profiles at Life Class level
        $lifeClassProfiles = DB::table('sol_profiles')
            ->where('current_sol_level_id', $lifeClassLevel->id)
            ->get();
        
        foreach ($lifeClassProfiles as $profile) {
            // Check if a Life Class candidate already exists for this SOL Profile
            $existingCandidate = DB::table('lifeclass_candidates')
                ->where('sol_profile_id', $profile->id)
                ->first();
            
            if (!$existingCandidate) {
                // Create a new Life Class candidate
                DB::table('lifeclass_candidates')->insert([
                    'sol_profile_id' => $profile->id,
                    'member_id' => $profile->member_id,
                    'notes' => 'Backfilled from existing SOL Profile',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        // Remove backfilled records
        DB::table('lifeclass_candidates')
            ->where('notes', 'Backfilled from existing SOL Profile')
            ->delete();
    }
};
