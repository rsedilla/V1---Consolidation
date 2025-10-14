<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Update existing level numbers to make room for Life Class (level 0)
        DB::table('sol_levels')
            ->where('level_number', 1)
            ->update(['level_number' => 1]);
        
        DB::table('sol_levels')
            ->where('level_number', 2)
            ->update(['level_number' => 2]);
        
        DB::table('sol_levels')
            ->where('level_number', 3)
            ->update(['level_number' => 3]);
        
        // Insert Life Class as level 0
        DB::table('sol_levels')->insert([
            'level_number' => 0,
            'level_name' => 'Life Class',
            'description' => 'Life Class - Foundational training before entering School of Leaders',
            'lesson_count' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Remove Life Class entry
        DB::table('sol_levels')
            ->where('level_number', 0)
            ->delete();
    }
};
