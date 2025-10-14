<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Remove the Life Class entry from sol_levels table
        DB::table('sol_levels')
            ->where('level_number', 0)
            ->where('level_name', 'Life Class')
            ->delete();
        
        // Note: No need to update sol_profiles as there are no profiles at Life Class level
        // If there were, they would have been set to NULL by the foreign key constraint
    }

    public function down(): void
    {
        // Restore Life Class entry
        DB::table('sol_levels')->insert([
            'level_number' => 0,
            'level_name' => 'Life Class',
            'description' => 'Life Class - Foundational training before entering School of Leaders',
            'lesson_count' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};
